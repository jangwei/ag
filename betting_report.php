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
	<link rel="stylesheet" href="css/all.css">

	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">

	<?
		include_once("api/core.php");
		include_once('indyEngine/engineControl.php');
		setInclude('dbControl');
		setPlugin('jquery,alert,hrefDefault');
		checkLogin('betting_report');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();
        
        $user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        if($user_type=='assistan'){
            $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        }
        else{
            $user_id = decode($_COOKIE["EASYLOTSID"]);
        }
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
						HtmlCore::getMenu('betting_report');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
                        รายงานยอดเดิมพัน
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="">รายการหวย</li>
						<li class="active">รายงานยอดเดิมพัน</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					<?
                        $now = date('Y-m-d H:i:s');
                        $sql = "SELECT * FROM lotto_list INNER JOIN lotto ON lotto.lotto_id = lotto_list.lotto_id WHERE lotto_list.lotto_list_status=1 AND lotto_list.lotto_list_end>'".$now."' AND lotto_list.lotto_list_start<'".$now."'";	
                        $lotto_data = $query->queryDB_to_array($sql);

                    ?>
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-body"> 
                                    <div class="box-body table-responsive ">
                                        <table class="table table-hover table-striped" id="data_table">
                                            <thead>
                                                <tr class="bg-navy">
                                                    <th>#</th>
                                                    <th>ประเภทหวย</th>
                                                    <th>หวย</th>
                                                    <th>งวด</th>
                                                    <th>วันปิด</th>
                                                    <th>เวลาปิด</th>
                                                    <th>ยอดเข้า</th>
                                                    <th>ส่งออก</th>
                                                    <th><small>รายงาน<br>ยอดเดิมพัน ( 1 )</small></th>
                                                    <th><small>รายงาน<br>ยอดเดิมพัน ( 2 )</small></th>
                                                    <th><small>รายงาน<br>ยอดเดิมพัน ( 3 )</small></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                    foreach($lotto_data as $key => $val){
                                                    $lotto_type = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$val['lotto_type_id']);
                                                    $sum_recive = $query->queryDB_to_row("SELECT SUM(user_amount) AS sum_user,SUM(downline_amount) AS sum_child,SUM(upline_amount) AS sum_head  FROM bill_detail WHERE user_id=".$user_id." AND lotto_list_id=".$val['lotto_list_id']);
                                                    echo '
                                                        <tr>
                                                            <td>#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($val['lotto_list_id'],4,'0',STR_PAD_LEFT).'</td>
                                                            <td>'.$lotto_type.'</td>
                                                            <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>
                                                            <td class="text-center">'.getTextDateTH($val['lotto_list_date']).'</td>
                                                            <td class="text-center">'.getTextDate($val['lotto_list_end'],'/').'</td>
                                                            <td class="text-center">'.getTextTime($val['lotto_list_end']).'</td>
                                                            <td class="text-center">'.number_format($sum_recive['sum_user'],2).'</td>
                                                            <td class="text-center">'.number_format($sum_recive['sum_head'],2).'</td>
                                                            <th><button type="button" class="btn btn-block btn-primary" onClick="getReportA('.$val['lotto_list_id'].')"><i class="fas fa-chart-bar"></i> ตามประเภท</button></th>
                                                            <th><button type="button" class="btn btn-block btn-success" onClick="getReportB('.$val['lotto_list_id'].')"><i class="fas fa-user-check"></i> ตามสมาชิก</button></th>
                                                            <th><button type="button" class="btn btn-block btn-warning" onClick="getReportC('.$val['lotto_list_id'].')"><i class="fas fa-search"></i> ตามหมายเลข</button></th>
                                                        </tr>
                                                    ';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> 
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
    <div class="modal fade" id="reportA" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin-top:20px"><i class="fa fa-times"></i></span>
                    </button>
                    <h4 class="modal-title"><b>ยอดเดิมพันตามประเภท</b></h4>
                </div>
                <div class="modal-body">
                    <div id="table_reportA"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fas fa-undo-alt"></i> ย้อนกลับ</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reportB" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin-top:20px"><i class="fa fa-times"></i></span>
                    </button>
                    <h4 class="modal-title"><b>ยอดเดิมพันตามสมาชิก</b></h4>
                </div>
                <div class="modal-body">
                    <div id="table_reportB"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fas fa-undo-alt"></i> ย้อนกลับ</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="reportC" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin-top:20px"><i class="fa fa-times"></i></span>
                    </button>
                    <h4 class="modal-title"><b>ยอดเดิมพันตามหมายเลข</b></h4>
                </div>
                <div class="modal-body">
                    <form id="list_receive">
                        <div id="table_reportC"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fas fa-undo-alt"></i> ย้อนกลับ</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/js/app.min.js"></script>

	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>     

  </body>
</html>  

<script>
cid = 0;
$(function () {
	dbTable();

});

function getReportA(id,uid=0){
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "api/get_reportA",
        data:{ 
            id:id,
            uid:uid
        },
        beforeSend: function() {
            $("#table_reportA").html('<div class="loading"><div class="loader">Loading...</div></div>');
            $('#reportA').appendTo("body").modal('show');
            $("#reportA").css("z-index", "9999");
        },
        success: function(result){
            $("#table_reportA").hide();
            $("#table_reportA").html(result);
            $("#table_reportA").fadeIn();
        }
    });
}
function getReportB(id,uid=0){
    event.preventDefault();
	$.ajax({
        type: "POST",
        url: "api/get_reportB",
        data:{ 
            id:id,
            uid:uid
        },
        beforeSend: function() {
            $("#table_reportB").html('<div class="loading"><div class="loader">Loading...</div></div>');
            $('#reportB').appendTo("body").modal('show');
            $("#reportB").css("z-index", "9999");
        },
        success: function(result){
            $("#table_reportB").hide();
            $("#table_reportB").html(result);
            $("#table_reportB").fadeIn();
        }
    });
}
function getReportMemberB(id,uid=0){
    event.preventDefault();
	$.ajax({
        type: "POST",
        url: "api/get_reportB_member",
        data:{ 
            id:id,
            uid:uid
        },
        beforeSend: function() {
            $("#table_reportB").html('<div class="loading"><div class="loader">Loading...</div></div>');
            $('#reportB').appendTo("body").modal('show');
            $("#reportB").css("z-index", "9999");
        },
        success: function(result){
            $("#table_reportB").hide();
            $("#table_reportB").html(result);
            $("#table_reportB").fadeIn();
        }
    });
}
function getReportC(id){
    event.preventDefault();
    setReportC(id);

    setTimeout(function() {
        setReportC(id);
    }, 10000);
    cid = id;
}

function setReportC(id){
    $.ajax({
        type: "POST",
        url: "api/get_reportC",
        data:{ 
            id:id
        },
        beforeSend: function() {
            $("#table_reportC").html('<div class="loading"><div class="loader">Loading...</div></div>');
            $('#reportC').appendTo("body").modal('show');
            $("#reportC").css("z-index", "9999");
        },
        success: function(result){
            $("#table_reportC").hide();
            $("#table_reportC").html(result);
            $("#table_reportC").fadeIn();
        }
    });
}
function sentReceive(){
    event.preventDefault();
    $.ajax({
    	type: "POST",
    	url: "api/set_lotto_receive",
    	data: $("#list_receive").serialize(),
    	beforeSend: function() {
            
    	},
    	success: function(result){
    		$("#show_error").html(result);
    	}
    });	
}
function getBillDetail(id){
    event.preventDefault();
    var chk = $('#b_'+id).data("hidden");
    if(chk){
        $.ajax({
            type: "POST",
            url: "api/get_bill_detail",
            data:{ 
                id:id
            },
            beforeSend: function() {
                $('#s_'+id).html('<div class="loading"><div class="loader">Loading...</div></div>');
                $('#b_'+id).fadeIn();
            },
            success: function(result){
                $('#s_'+id).html(result);
                $('#b_'+id).data("hidden",false);
            }
        });
    }
    else{
        $('#b_'+id).fadeOut('fast');
        $('#b_'+id).data("hidden",true);
    }
}
function dbTable(){
    $("#data_table").dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 100,
        "order": [ [ 4, 'asc' ],[ 5, 'asc' ] ],
        "language": {
            "emptyTable": "ไม่พบข้อมูล",
            "search": "ค้าหา :"
        }
    });
}
</script>

