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
	<link href="css/all.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">

	<?
		include_once("api/core.php");
		include_once('indyEngine/engineControl.php');
		setInclude('dbControl');
		setPlugin('jquery,alert,hrefDefault');
		checkLogin('lotto_list');
		
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
						HtmlCore::getMenu('lotto_list');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						ตัด อั้น
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">รายการหวย</li>
						<li class="active">ตัด อั้น</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
                    <div class="row">
						<div class="col-md-12">
                            <form id="form" class="form-horizontal form-label-left">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <?
											$id = $_GET['lid'];
											$lotto_lists = $query->queryDB_to_row('SELECT * FROM lotto_list WHERE lotto_list_id='.$id);
											$lotto = $query->queryDB_to_row('SELECT * FROM lotto WHERE lotto_id='.$lotto_lists['lotto_id']);
										?>
										<div class="list-huay" style="background-color:<? echo $lotto['lotto_color3']; ?>;">
											<div class="alert alert-secondary d-flex justify-content-between" style="background-color:<? echo $lotto['lotto_color2']; ?>; color:#333;">
												<div>
													<img src="<? echo $lotto['lotto_img']; ?>" height="25px"> 
													<b class="pl-2"><? echo $lotto['lotto_name']; ?></b>
												</div>
												<div>
													<b>งวดวันที่ <? echo getTextDateTH($lotto_lists['lotto_list_end']); ?></b>
												</div>
											</div>
										</div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body p-3 pt-0">
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <div class="form-group" style="padding-right:10px;">
                                                <input type="hidden" name="lotto_list_id" value="<? echo $lotto_lists['lotto_list_id']; ?>">
                                                <label>ประเภทหวย</label>
                                                <label class="inputcheckbok">2 ตัวบน
                                                    <input type="checkbox" name="huay_type[]" value="top2">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="inputcheckbok">2 ตัวล่าง
                                                    <input type="checkbox" name="huay_type[]" value="bottom2">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="inputcheckbok">3 ตัวบน
                                                    <input type="checkbox" name="huay_type[]" value="top3">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="inputcheckbok">3 ตัวโต๊ด
                                                    <input type="checkbox" name="huay_type[]" value="toad3">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="inputcheckbok">3 ตัวล่าง
                                                    <input type="checkbox" name="huay_type[]" value="bottom3">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="inputcheckbok">วิ่งบน
                                                    <input type="checkbox" name="huay_type[]" value="top1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="inputcheckbok">วิ่งล่าง
                                                    <input type="checkbox" name="huay_type[]" value="bottom1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <label>รูปแบบการจ่าย</label>

                                            <label class="inputradio">ปิดรับ
                                                <input type="radio" checked="checked" name="huay_limit" value="ปิดรับ">
                                                <span class="checkmarkr"></span>
                                            </label>
                                            <label class="inputradio">จ่ายครึ่งราคา
                                                <input type="radio" name="huay_limit" value="ครึ่งราคา">
                                                <span class="checkmarkr"></span>
                                            </label>
                                            <!-- 
                                            <div class="form-group" style="padding-right:10px;">
                                                <label>เรทการจ่าย <small style="color:#666"> 0 = ปิดรับ</small></label>
                                                <input type="number" class="form-control" placeholder="เรทการจ่าย ..." name="huay_pay" id="huay_pay" required=""/>
                                            </div> -->
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group" style="padding-right:10px;">
                                                <label>เลขหวย <small style="color:#666">กด shift เพื่อกลับตัวเลข</small></label>
                                                <input type="text" class="form-control" placeholder="เลขหวย ..." name="huay_value" id="huay_value" required=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <div class="form-group" style="padding-top:25px;">
                                                <button type="submit" class="btn btn-primary" id="bt_submit"><i class="fa fa-plus"></i> เพิ่มรายการตัด/อั้น</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
						</div>
                        
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><b>รายการตัด อั้น</b></h3>
                                </div>
                                <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="data_table">
                                        <thead>
                                        <tr>
                                            <th>ประเภทหวย</th>
                                            <th>เลขหวย</th>
                                            <th>เรทจ่าย</th>
                                            <th>ยกเลิก</th>
                                        </tr>
                                        </thead>
                                        <body>
                                        <?
                                            $now = date('Y-m-d H:i:s');
                                            $sql = "SELECT * FROM lotto_limit WHERE lotto_list_id=".$_GET['lid']." ORDER BY lotto_limit_date DESC";	
                                            $data = $query->queryDB_to_array($sql);
                                            foreach($data as $key => $val){
                                                echo '
                                                <tr id="lm_'.$val['lotto_limit_id'].'">
                                                    <td>'.getTextType($val['huay_type']).'</td>
                                                    <td>'.getSort($val['huay_value']).'</td>
                                                    <td class="text-center">'.getLimitType($val['huay_limit']).'</td>
                                                    <td><button type="button" title="ยกเลิก" class="btn btn-block btn-danger" onClick="deleteLottoLimit('.$val['lotto_limit_id'].')"><i class="fa fa-trash"></i>&nbsp;&nbsp;ยกเลิก</button></td>
                                                </tr>
                                                ';
                                            }

                                            function getSort($str){
                                                $array_str = explode(" ",$str);
                                                sort($array_str);
                                                return implode(" ",$array_str);
                                            }

                                            function getBT($id,$chk){
                                                if($chk==1){
                                                    return  '<button type="button" class="btn btn-block btn-default" onClick="updateStatus('.$id.',0)"> <i class="fa fa-check-square-o" aria-hidden="true"></i> เปิดรับ </button>';
                                                }
                                                else{
                                                    return  '<button type="button" class="btn btn-block btn-warning" onClick="updateStatus('.$id.',1)"> <i class="fa fa-times" aria-hidden="true"></i> ปิดรับ </button>';
                                                }
                                            }
    
                                            function getLimitType($type){
                                                if($type=='ปิดรับ'){
                                                    return '<span class="text-red">ปิดรับ</span>';
                                                }
                                                else if($type=='ครึ่งราคา'){
                                                    return '<span class="text-green">ครึ่งราคา</span>';
                                                }
                                            }
                                            function getTextType($type){
                                                if($type=='bottom2'){
                                                    return 'สองตัวล่าง';
                                                }
                                                else if($type=='top2'){
                                                    return 'สองตัวบน';
                                                }
                                                else if($type=='top3'){
                                                    return 'สามตัวบน';
                                                }
                                                else if($type=='toad3'){
                                                    return 'สามตัวโต๊ด';
                                                }
                                                else if($type=='front3'){
                                                    return 'สามตัวหน้า';
                                                }
                                                else if($type=='bottom3'){
                                                    return 'สามตัวล่าง';
                                                }
                                                else if($type=='top1'){
                                                    return 'วิ่งบน';
                                                }
                                                else if($type=='bottom1'){
                                                    return 'วิ่งล่าง';
                                                }
                                            }
                                        ?>
                                        </body>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    
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

    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/js/app.min.js"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/heatmap.js"></script>

    <!-- DATA TABES SCRIPT -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>  

  </body>
</html>

<script>
$( function() {
    $("#data_table").dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
		"pageLength": 50,
        "language": {
            "emptyTable": "ไม่พบข้อมูล",
            "search": "ค้าหา :",
        }
    });

    $("#huay_value").keyup(function(e) {
        if(e.keyCode == 16){
            getNumberSW();
        }
    });
    
    $("#bt_submit").click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "api/insert_lotto_limit",
			data: $("#form").serialize(),
			beforeSend: function() {

			},
			success: function(result){
				$("#show_error").html(result);
			}
		});	
	});
});
function getNumberSW(){
    var number_lists = $("#huay_value").val().split(" ");;
    var dg1 = []; var dg2 = []; var dg3 = []; 
    var numbers = '';
    $.each(number_lists, function(index,value){
        if(value.length==2){
            dg2.push(value);
        }
        else if(value.length==3){
            dg3.push(value);
        }
        else if(value.length==1){
            dg1.push(value);
        }
        numbers += value+' ';
    });
    
    if(number_lists.length>0){
        $.each(dg2, function(i,val){
            var n1 = val.substr(0,1);
            var n2 = val.substr(1,1);
            if(n1!=n2){
                numbers += (n2 + n1)+' '; 
            }
        });
    }

    if(number_lists.length>0){
        $.each(dg3, function(i,val){
            var n1 = val.substr(0,1);
            var n2 = val.substr(1,1);
            var n3 = val.substr(2,1);
            if(n1!=n2 && n1!=n3 && n2!=n3){
                numbers += (n1 + n3 + n2)+' '; 
                numbers += (n2 + n1 + n3)+' '; 
                numbers += (n2 + n3 + n1)+' '; 
                numbers += (n3 + n1 + n2)+' '; 
                numbers += (n3 + n2 + n1)+' '; 
            }
            else if(n1==n2 && n1!=n3){
                numbers += (n1 + n3 + n2)+' ';
                numbers += (n3 + n1 + n2)+' ';
            }
            else if(n1==n3 && n1!=n2){
                numbers += (n1 + n3 + n2)+' ';
                numbers += (n2 + n1 + n3)+' ';
            }
            
            else if(n1!=n2 && n1!=n3 && n3==n2){
                numbers += (n3 + n1 + n2)+' ';
                numbers += (n3 + n2 + n1)+' ';
            }
        });
    }

    $("#huay_value").val(numbers);
}
function deleteLottoLimit(id){
    event.preventDefault();
    Swal.fire({
        html: 'คุณต้องการลบ<br>รายการตัด อั้นนี้หรือไม ?',
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#CB4335',
        cancelButtonText: 'ยกเลิก',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "api/delete_lotto_limit",
                data: { id:id },
                success: function(result){
                    $('#show_error').html(result);
                }
            });
        } 
    });
}
</script>

