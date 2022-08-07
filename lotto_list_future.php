<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<link rel="shortcut icon" type="image/png" href="img/icon.png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <link rel="stylesheet" href="dist/css/skins/skin-black.css">

	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b68f3ac064.js" crossorigin="anonymous"></script>

	<?
		include_once("api/core.php");
		include_once('indyEngine/engineControl.php');
		setInclude('dbControl');
		setPlugin('jquery,jquery-ui,alert,hrefDefault');
		checkLogin('login');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();
		$user_id = decode($_COOKIE['EASYLOTSID']);
		$sql = "SELECT * FROM user WHERE user_id = ".$user_id;
		$user_data = $query->queryDB_to_row($sql);
		
	?>
  </head>
  <body class="hold-transition skin-black" style="font-family: 'Kanit', sans-serif;">
		<div class="wrapper">
			<header class="main-header">
				<?
					HtmlCore::getTextHeader();
				?>
				<nav class="navbar navbar-static-top" role="navigation">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<?
						HtmlCore::getMenuHeader();
					?>
				</nav>
			</header>

			<aside class="main-sidebar">
				<section class="sidebar">
					<?
						HtmlCore::getMenu('lotto_list_future');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
                        รายการหวย
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">รายการหวย</li>
						<li class="active">รายการหวยที่ยังไม่เปิดรับ</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
                                    <h3 class="box-title"><b>รายการหวยที่ยังไม่เปิดรับ</b></h3>
                                    <div style="float: right;">
                                        <button class="btn btn-primary p-2" id="bt_get_insert"><i class="fa fa-plus"></i> เพิ่มรายการหวย</button>
                                    </div>
								</div>
								<div class="box-body table-responsive">
                                <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <th>#</th>
                                                <th>ประเภทหวย</th>
                                                <th>หวย</th>
                                                <th>เปิดรับ</th>
                                                <th>ปิดรับ</th>
                                                <th>แก้ไข</th>
                                                
                                            </tr>
                                            <?
                                                $now = date('Y-m-d H:i:s');
                                                $sql = "SELECT * FROM lotto_list INNER JOIN lotto ON lotto.lotto_id = lotto_list.lotto_id WHERE lotto_list.lotto_list_start>'".$now."'";	
                                                $lotto_data = $query->queryDB_to_array($sql);
                                                foreach($lotto_data as $key => $val){
                                                $lotto_type = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$val['lotto_type_id']);
                                                echo '
                                                    <tr>
                                                        <td>#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($val['lotto_list_id'],4,'0',STR_PAD_LEFT).'</td>
                                                        <td>'.$lotto_type.'</td>
                                                        <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>
                                                        <td class="text-center">'.getTextDateTime($val['lotto_list_start']).'</td>
                                                        <td class="text-center">'.getTextDateTime($val['lotto_list_end']).'</td>
                                                        <td><button class="btn btn-block btn-success" title="แก้ไข" onClick="getEdit('.$val['lotto_list_id'].')"><i class="fa fa-edit"></i>&nbsp;&nbsp;แก้ไข</button></td>
                                                    </tr>
                                                ';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?
                                        function getBT($id,$chk){
                                            if($chk==1){
                                                return  '
                                                    <label class="switch">
                                                        <input id="sys_pincode" type="checkbox" onChange="updateStatus('.$id.',0)" checked>
                                                        <span class="slider round"></span>
                                                    </label>
                                                ';
                                            }
                                            else{
                                                return  '
                                                    <label class="switch">
                                                        <input id="sys_pincode" type="checkbox" onChange="updateStatus('.$id.',1)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                ';
                                            }
                                        }
                                    ?>
								</div>
							</div> 
						</div>
					</div>

				</section>
			</div>

		<footer class="main-footer">
		<?
			HtmlCore::getMenuFooter();
		?>
		</footer>

	</div>

    <!-- Modal -->
    <div class="modal fade" id="lotto_list_insert" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin-top:20px"><i class="fa fa-times"></i></span>
                    </button>
                    <h4 class="modal-title"><b>เพิ่มรายการหวย</b></h4>
                </div>
                <div class="modal-body">
                    <form id="insert_lotto_form">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group"  style="padding-right:10px;" placeholder="ประเภทหวย ...">
                                <label>หวย</label>
                                <select class="form-control" name="lotto_id" id="lotto_id">
                                    <option value="0">=== เลือกหวย ===</option>
                                    <?
                                        $sql = "SELECT * FROM lotto ORDER BY lotto_id";	
                                        $raw_data = $query->queryDB_to_array($sql);
                                        foreach($raw_data as $key => $val){
                                            $str = '';
                                            if($val['lotto_id']==$data['lotto_id']){
                                                $str = ' selected';                                                                
                                            }
                                            echo ' <option value="'.$val['lotto_id'].'" '.$str.'>'.$val['lotto_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?
                                $date_start = date('Y-m-d');
                                $time_start = "00:00:00";
                                $date_end = date('Y-m-d');
                                $time_end = "00:00:00";
                            ?>
                            <div class="form-group"  style="padding-right:10px;">
                                <label>กำหนดวันเปิด</label>
                                <input type="text" id="datepicker1" class="form-control" placeholder="วันเปิด ..." name="date_start" value="<? echo $date_start; ?>"/>
                                <label>เวลา</label>
                                <input type="time" class="form-control" placeholder="เวลาเปิด ..." name="time_start" value="<? echo $time_start; ?>"/>
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group"  style="padding-right:10px;">
                                <label>กำหนดเวลาปิด</label>
                                <input type="text" id="datepicker2" class="form-control" placeholder="วันปิดรับ ..." name="date_end" value="<? echo $date_end; ?>"/>
                                <label>เวลา</label>
                                <input type="time" class="form-control" placeholder="เวลาเปิดรับ ..." name="time_end" value="<? echo $time_end; ?>"/>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal"> <i class="fas fa-undo-alt"></i> ย้อนกลับ</button>
                    <button type="button" class="btn btn-primary" id="bt_insert"> <i class="fas fa-save"></i> เพิ่มรายการวย</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="lotto_list_edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin-top:20px"><i class="fa fa-times"></i></span>
                    </button>
                    <h4 class="modal-title"><b>แก้ไขรายการหวย</b></h4>
                </div>
                <div class="modal-body">
                    <form id="edit_lotto_form">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group"  style="padding-right:10px;" placeholder="ประเภทหวย ...">
                                <label>หวย</label>
                                <input type="hidden" name="lotto_list_id_edit" id="lotto_list_id_edit">
                                <select class="form-control" name="lotto_id_edit" id="lotto_id_edit">
                                    <option value="0">=== เลือกหวย ===</option>
                                    <?
                                        $sql = "SELECT * FROM lotto ORDER BY lotto_id";	
                                        $raw_data = $query->queryDB_to_array($sql);
                                        foreach($raw_data as $key => $val){
                                            $str = '';
                                            if($val['lotto_id']==$data['lotto_id']){
                                                $str = ' selected';                                                                
                                            }
                                            echo ' <option value="'.$val['lotto_id'].'" '.$str.'>'.$val['lotto_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group"  style="padding-right:10px;">
                                <label>กำหนดวันเปิด</label>
                                <input type="text" id="datepicker3" class="form-control" placeholder="วันเปิด ..." name="date_start_edit"/>
                                <label>เวลา</label>
                                <input type="time" class="form-control" placeholder="เวลาเปิด ..." name="time_start_edit" id="time_start_edit"/>
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group"  style="padding-right:10px;">
                                <label>กำหนดเวลาปิด</label>
                                <input type="text" id="datepicker4" class="form-control" placeholder="วันปิดรับ ..." name="date_end_edit"/>
                                <label>เวลา</label>
                                <input type="time" class="form-control" placeholder="เวลาเปิดรับ ..." name="time_end_edit" id="time_end_edit"/>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal"> <i class="fas fa-undo-alt"></i> ย้อนกลับ</button>
                    <button type="button" class="btn btn-primary" id="bt_edit"> <i class="fas fa-save"></i> แก้ไขรายการวย</button>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/js/app.min.js"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/heatmap.js"></script>

  </body>
</html>

<script>
$( function() {
	$( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });

	$("#bt_get_insert").click(function(event){
        $('#lotto_list_insert').appendTo("body").modal('show');
	});
	$("#bt_insert").click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "api/insert_lotto_list",
			data: $("#insert_lotto_form").serialize(),
			beforeSend: function() {
				
			},
			success: function(result){
				$("#show_error").html(result);
			}
		});	
	});
    $("#bt_edit").click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "api/edit_lotto_list",
			data: $("#edit_lotto_form").serialize(),
			beforeSend: function() {
				
			},
			success: function(result){
				$("#show_error").html(result);
			}
		});	
	});
});

function getEdit(id){
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "api/get_lotto_list",
        data: { id:id },
        beforeSend: function() {
            $('#lotto_list_edit').appendTo("body").modal('show');
        },
        success: function(result){
            $("#show_error").html(result);
        }
    });	
}
</script>

