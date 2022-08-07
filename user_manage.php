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
	<link rel="stylesheet" href="css/all.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">

	<?
		include_once("api/core.php");
		include_once('indyEngine/engineControl.php');
		setInclude('dbControl');
		setPlugin('jquery,alert,hrefDefault');
		checkLogin('user_manage');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();
		
		$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE['EASYLOTSID']));
		if($user_type=='assistan'){
			$user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE['EASYLOTSID']));
			$user_data = $query->queryDB_to_row("SELECT * FROM user WHERE user_id = ".$user_id);
		}
		else{
			$user_id = decode($_COOKIE['EASYLOTSID']);
			$user_data = $query->queryDB_to_row("SELECT * FROM user WHERE user_id = ".$user_id);
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
						HtmlCore::getMenu('user_manage');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						รายชื่อสมาชิก
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">จัดการสมาชิก</li>
						<li class="active">รายชื่อสมาชิก</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
                                <div class="box-body">
									<div id="user_table"></div>
								</div>
                                <div class="box-footer">
                                    <div class="form-group">
                                    
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

		<!-- REQUIRED JS SCRIPTS -->
        <div class="modal fade" id="deposit_box" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
						<h3 class="modal-title">ฝากเงินเข้าระบบ</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  		<span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="modal-body">
						<div class="row p-2">
							<div class="col-md-6 p-1">
								<div class="small-box bg-green">
									<div class="inner2">
										<h3 class="numberfm" id="user_balance_d">0</h3>
										<p>ยอดคงเหลือของคุณ</p>
									</div>
									<div class="icons">
										<i class="fas fa-credit-card"></i>
									</div>
								</div>
							</div>
							<div class="col-md-6 p-1">
								<div class="small-box bg-aqua">
									<div class="inner2">
										<h3 class="numberfm" id="child_balance_d">0</h3>
										<p>ยอดคงเหลือสมาชิก</p>
									</div>
									<div class="icons">
										<i class="fas fa-money-check-alt"></i>
									</div>
								</div>
							</div>
							<div class="col-md-12 p-1">
								<div class="form-group"  style="padding-right:10px;">
									<label>จำนวนเงินฝาก</label>
									<input type="hidden" id="md_user" value="0">
									<input type="hidden" id="md_child" value="0">
									<input type="number" id="deposit" min="0" class="form-control" placeholder="จำนวนเงินฝาก ..."/>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 pt-1" style="height:25px">
								<div class="w-100 text-center" id="show_deposit_error"></div>
							</div>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-undo"></i> ย้อนกลับ</button>
                        <button type="button" class="btn btn-primary" onClick="editUserBalance('dep')"> <i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </div>
            </div>
		</div>

		<!-- REQUIRED JS SCRIPTS -->
        <div class="modal fade" id="withdraw_box" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
						<h3 class="modal-title">ถอนเงินออกจากระบบ</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  		<span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="modal-body">
						<div class="row p-2">
							<div class="col-md-6 p-1">
								<div class="small-box bg-green">
									<div class="inner2">
										<h3 class="numberfm" id="user_balance_w">0</h3>
										<p>ยอดคงเหลือของคุณ</p>
									</div>
									<div class="icons">
										<i class="fas fa-credit-card"></i>
									</div>
								</div>
							</div>
							<div class="col-md-6 p-1">
								<div class="small-box bg-aqua">
									<div class="inner2">
										<h3 class="numberfm" id="child_balance_w">0</h3>
										<p>ยอดคงเหลือสมาชิก</p>
									</div>
									<div class="icons">
										<i class="fas fa-money-check-alt"></i>
									</div>
								</div>
							</div>
							<div class="col-md-12 p-1">
								<div class="form-group"  style="padding-right:10px;">
									<label>จำนวนเงินถอน</label>
									<input type="hidden" id="mw_user">
									<input type="hidden" id="mw_child">
									<input type="number" id="withdraw" min="0" max="999" class="form-control" placeholder="จำนวนเงินถอน ..."/>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 pt-1" style="height:25px">
								<div class="w-100 text-center" id="show_withdraw_error"></div>
							</div>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-undo"></i> ย้อนกลับ</button>
                        <button type="button" class="btn btn-primary"  onClick="editUserBalance('wd')"> <i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </div>
            </div>
		</div>

	<!-- REQUIRED JS SCRIPTS -->
	<div class="modal fade" id="user_data" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header d-flex justify-content-between">
					<h3 class="modal-title">แก้ไขข้อมูลสมาชิก</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fas fa-times"></i></span></button>
				</div>
				<div class="modal-body">
					<form id="userdata_form">
					<div class="row p-2">
						<div class="col-md-12 col-sm-12 col-xs-12 p-1">
							<div class="d-flex justify-content-between">
								<label>Username</label>
								<code><small>ตั้งรหัสผ่านเป็นค่าตั้งต้น 123456</small></code>
							</div>
							<div class="input-group input-group-sm">
								<input type="hidden" id="datauser_id" name="datauser_id"/>
								<input type="text" class="form-control" placeholder="Username ..." id="datauser_username" disabled/>
								<span class="input-group-btn">
									<button type="button" class="btn btn-danger btn-flat" onClick="rePassword()"><i class="fas fa-unlock-alt"></i> Re-Password !</button>
								</span>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-1">
							<div class="form-group"  style="padding-right:10px;">
								<label>ชื่อ</label>
								<input type="text" class="form-control" placeholder="ชื่อ ..." id="datauser_name" name="datauser_name"/>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-1">
							<div class="form-group"  style="padding-right:10px;">
								<label>นามสกุล</label>
								<input type="text" class="form-control" placeholder="นามสกุล ..." id="datauser_lastname"  name="datauser_lastname"/>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-1">
							<div class="form-group"  style="padding-right:10px;">
								<label>เบอร์โทร</label>
								<input type="text" class="form-control" placeholder="เบอร์โทร ..." id="datauser_phone"  name="datauser_phone"/>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 p-1">
							<div class="form-group"  style="padding-right:10px;">
								<label>Line id</label>
								<input type="text" class="form-control" placeholder="line id ..." id="datauser_line_id"  name="datauser_line_id"/>
							</div>
						</div>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-undo"></i> ย้อนกลับ</button>
					<button type="button" class="btn btn-primary" onClick="editDataUser()"> <i class="fas fa-save"></i> บันทึก</button>
				</div>
			</div>
		</div>
	</div>

	<!-- REQUIRED JS SCRIPTS -->
	<div class="modal fade" id="user_info" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header d-flex justify-content-between">
					<h3 class="modal-title">
						ข้อมูลส่วนแบ่ง
						<small id="user_info_detail"></small>
					</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fas fa-times"></i></span></button>
				</div>
				<div class="modal-body">
					<div id="show_user_info"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-undo"></i> ย้อนกลับ</button>
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
var child_id;
$(function(){

	getUserTable("<? echo encode($user_id); ?>");

	$("#deposit").keyup(function(e) {
		if($("#deposit").val()!=''){
			if(parseInt($("#deposit").val()) >= 0){
				if( parseInt($("#deposit").val()) > parseInt($("#md_user").val()) ){
					$("#deposit").val($("#md_user").val());
				}
				$("#child_balance_d").html( numberFormat(parseInt($("#md_child").val()) + parseInt($("#deposit").val())) );
				$("#user_balance_d").html( numberFormat(parseInt($("#md_user").val()) - parseInt($("#deposit").val())) );
			}
			else{
				$("#deposit").val(0);
			}
		}
		else{
			$("#child_balance_d").html( numberFormat(parseInt($("#md_child").val())) );
			$("#user_balance_d").html( numberFormat(parseInt($("#md_user").val())) );
		}
	});

	$("#withdraw").keyup(function(e) {
		if($("#withdraw").val()!=''){
			if(parseInt($("#withdraw").val()) >= 0){
				if( parseInt($("#withdraw").val()) > parseInt($("#mw_child").val()) ){
					$("#withdraw").val($("#mw_child").val());
				}
				$("#child_balance_w").html( numberFormat(parseInt($("#mw_child").val()) - parseInt($("#withdraw").val())) );
				$("#user_balance_w").html( numberFormat(parseInt($("#mw_user").val()) + parseInt($("#withdraw").val())) );
			}
			else{
				$("#withdraw").val(0);
			}
		}
		else{
			$("#child_balance_w").html( numberFormat(parseInt($("#mw_child").val())) );
			$("#user_balance_w").html( numberFormat(parseInt($("#mw_user").val())) );
		}

	});



});

function numberFormat(num) {
	if(isFloat(num)){
		num = num.toFixed(2);
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	}
	else{
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	}
}
function isInt(n){
	return Number(n) === n && n % 1 === 0;
}

function isFloat(n){
	return Number(n) === n && n % 1 !== 0;
}

function getUserTable(id){
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "api/get_user_detail",
		data:{ id : id },
		success: function(result){
			$('#user_table').html(result);
			dbTable();
		}
	});
}

function getUserInfo(id){
	event.preventDefault();
	$('#user_info').appendTo("body").modal('show');
	$.ajax({
		type: "POST",
		url: "api/get_user_info",
		data:{ id : id },
		beforeSend: function() {
            $("#show_user_info").html('<div class="loading"><div class="loader">Loading...</div></div>');
    	},
		success: function(result){
			$('#show_user_info').html(result);
		}
	});
}
function getDataUser(id){
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "api/get_user_data",
		data:{ id : id },
		success: function(result){
			$('#show_error').html(result);
			$('#user_data').appendTo("body").modal('show');
		}
	});
}
function editDataUser(id){
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "api/edit_user_data",
		data: $("#userdata_form").serialize(),
		success: function(result){
			$('#show_error').html(result);
		}
	});
}
function rePassword(){
	Swal.fire({
		html: 'คุณต้องการตั้งค่าระหัสผ่าน<br>ของสมาชิกเป็นค่าตั้งต้นหรือไม่ ?',
		type: 'question',
		showCancelButton: true,
		confirmButtonText: 'ตกลง',
		confirmButtonColor: '#CB4335',
		cancelButtonText: 'ยกเลิก',
	}).then((result) => {
		if (result.value) {
			$.ajax({
				type: "POST",
				url: "api/edit_user_password",
				data: $("#userdata_form").serialize(),
				success: function(result){
					$('#show_error').html(result);
				}
			});
		} 
	});
}

function setDeposit(id){
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "api/get_user_balance",
		data: {
			id : id,
			deposit : $("#deposit").val()
		},
		beforeSend: function() {
			child_id = id;
			$("#deposit").val('');
		},
		success: function(result){
			$("#show_error").html(result);
			$('#deposit_box').appendTo("body").modal('show');
		}
	});	
}
function setWithdraw(id){
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "api/get_user_balance",
		data: {
			id : id,
			withdraw : $("#withdraw").val()
		},
		beforeSend: function() {
			child_id = id;
			$("#withdraw").val('');
		},
		success: function(result){
			$("#show_error").html(result);
			$('#withdraw_box').appendTo("body").modal('show');
		}
	});	
}
function editUserBalance(type){
	event.preventDefault();
	if(type=='dep'){
		var balance =$("#deposit").val(); 
	}
	else{
		var balance =$("#withdraw").val(); 
	}
	$.ajax({
		type: "POST",
		url: "api/set_user_balance",
		data: {
			id : child_id,
			type : type,
			balance : balance
		},
		beforeSend: function() {
			
		},
		success: function(result){
			$("#show_error").html(result);
		}
	});	
}
function getValChk(id){
	if($("#u_"+id).is(":checked")){
		return true;
	}
	else{
		return false;
	}
}
function updateStatus(id){
	event.preventDefault();
	if(!getValChk(id)){
		Swal.fire({
			html: 'แน่ใจหรือไม่ที่จะปิดสถาณะผู้ใช้นี้ ?',
			type: 'question',
			showCancelButton: true,
			confirmButtonText: 'ตกลง',
			confirmButtonColor: '#CB4335',
			cancelButtonText: 'ยกเลิก',
		}).then((result) => {
			if (result.value) {
				setUseStat(id,0);
			} 
			else{
				$("#u_"+id).prop('checked', true);
			}
		});  
	}
	else{
		setUseStat(id,1);
	}
}
function setUseStat(id,stat){
	$.ajax({
		type: "POST",
		url: "api/set_user_status",
		data: { 
			id:id,
			stat:stat
		},
		success: function(result){
			$("#show_error").html(result);
		}
	});	
}

function dbTable(){
    $("#data_table").dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 100,
        "order": [ [ 3, 'asc' ],[ 5, 'desc' ]],
        "language": {
            "emptyTable": "ไม่พบข้อมูล",
            "search": "ค้าหา :"
        }
    });
}
</script>

