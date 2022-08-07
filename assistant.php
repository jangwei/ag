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

		setPlugin('jquery,jquery-ui,alert,hrefDefault');

		checkLogin('assistant');

		

		HtmlCore::getTitle();

        

        $query = new DBControl();

		$user_id = decode($_COOKIE['EASYLOTSID']);

		

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

						HtmlCore::getMenu('assistant');

					?>

				</section>

			</aside>



			<div class="content-wrapper">

				<section class="content-header">

					<h1>

                        ผู้ช่วย

						<? HtmlCore::getNickName(); ?>

					</h1>

					<ol class="breadcrumb">

						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>

					</ol>

				</section>



				<section class="content" style="font-family: 'Kanit'">

					

					<div class="row">

						<div class="col-md-12">

							<div class="box box-primary">

								<div class="box-header">

									<h3 class="box-title">

										<b>รายชื่อผู้ช่วย</b>

									</h3>

                                    <div class="box-tools pull-right">

                                        <button class="btn btn-primary " onClick="getAddUser()" id="bt_get_insert"><i class="fa fa-plus"></i> เพิ่มผู้ช่วย</button>

                                    </div>

                                </div>

								<div class="box-body">

                                    <div class="table-responsive">

                                        <table class="table table-sm table-striped table-hover" id="data_table">

                                        <thead>

                                            <tr class="bg-navy">

                                                <th>#</th>

                                                <th>สถาณะ</th>

                                                <th>ชื่อผู้ใช้</th>

                                                <th>สมัครเมื่อ</th>

                                                <th>เข้าใช้ล่าสุด</th>

                                                <th>สิทธิการใช้งาน</th>

                                                <th>แก้ไขข้อมูล</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                    <?

                                        $data = $query->queryDB_to_array("SELECT * FROM user WHERE head_id=".$user_id." AND user_type='assistan'");

                                        foreach($data as $key => $val){

                                            $access = $query->queryDB_to_row("SELECT * FROM user_access WHERE user_id=".$val['user_id']);

                                            echo '

                                                <tr>

                                                    <td>#'.str_pad($val['head_id'],2,'0',STR_PAD_LEFT).str_pad($val['user_id'],4,'0',STR_PAD_LEFT).'</td>

                                                    <td>'.getBT($val['user_id'],$val['user_status']).'</td>

                                                    <td><b>'.$val['user_username'].'</b> : '.$val['user_name'].' '.$val['user_lastname'].'</td>

                                                    <td class="text-center">'.getTextDateTime($val['user_date_regis']).'</td>

                                                    <td class="text-center">'.getTextDateTime($val['user_date_update']).'</td>

                                                    <td class="text-left">'.getUserAccess($access).'</td>

                                                    <td><a href="#" onClick="getDataUser('.$val['user_id'].')"><button class="btn btn-block btn-success" title="แก้ไขข้อมูล"><i class="fas fa-edit"></i> แก้ไข</button></a></td>

                                                </tr>

                                                ';

                                        }



                                        function getUserAccess($access){

                                            $str = '';

                                            if($access['menu_1']==1){

                                                $str .= ' <span class="badge bg-purple">รายการหวย</span>';

                                            }

                                            if($access['menu_2']==1){

                                                $str .= ' <span class="badge bg-purple">รายงานผลหวย</span>';

                                            }

                                            if($access['menu_3']==1){

                                                $str .= ' <span class="badge bg-purple">จัดการสมาชิก</span>';

                                            }

                                            if($access['menu_4']==1){

                                                $str .= ' <span class="badge bg-purple">ตั้งค่าสมาชิก</span>';

                                            }

                                            if($access['menu_5']==1){

                                                $str .= ' <span class="badge bg-purple">รายงานการเงิน</span>';

                                            }

                                            if($access['menu_6']==1){

                                                $str .= ' <span class="badge bg-purple">ประวัติการใช้งาน</span>';

                                            }

                                            return $str;

                                        }

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

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>ชื่อ</label>

								<input type="text" class="form-control" placeholder="ชื่อ ..." id="datauser_name" name="datauser_name"/>

							</div>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>นามสกุล</label>

								<input type="text" class="form-control" placeholder="นามสกุล ..." id="datauser_lastname"  name="datauser_lastname"/>

							</div>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>เบอร์โทร</label>

								<input type="text" class="form-control" placeholder="เบอร์โทร ..." id="datauser_phone"  name="datauser_phone"/>

							</div>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>Line id</label>

								<input type="text" class="form-control" placeholder="line id ..." id="datauser_line_id"  name="datauser_line_id"/>

							</div>

						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 p-1">

                            <label>สิทธิการใช้งาน</label>

                            <div class="row p-3 pt-0">

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" id="emenu_1" name="emenu_1"> <span class="checkboxtext">รายการหวย</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" id="emenu_2" name="emenu_2"> <span class="checkboxtext">รายงานผลหวย</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" id="emenu_3" name="emenu_3"> <span class="checkboxtext">จัดการสมาชิก</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" id="emenu_4" name="emenu_4"> <span class="checkboxtext">ตั้งค่าสมาชิก</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" id="emenu_5" name="emenu_5"> <span class="checkboxtext">รายงานการเงิน</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" id="emenu_6" name="emenu_6"> <span class="checkboxtext">ประวัติการใช้งาน</span>

                                        </label>

                                    </div>

                                </div>

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

	<div class="modal fade" id="add_data" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

		<div class="modal-dialog modal-dialog-scrollable">

			<div class="modal-content">

				<div class="modal-header d-flex justify-content-between">

					<h3 class="modal-title">เพิ่มผู้ช่วย</h3>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true"><i class="fas fa-times"></i></span></button>

				</div>

				<div class="modal-body">

					<form id="adduser_form">

					<div class="row p-2">

						<div class="col-md-12 col-sm-12 col-xs-12 p-1">

							<div class="d-flex justify-content-between">

								<label>Username</label>

								<code><small>รหัสผ่านตั้งต้น 123456</small></code>

							</div>

							<input type="text" class="form-control" placeholder="Username ..." id="adduser_username" name="adduser_username"/>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>ชื่อ</label>

								<input type="text" class="form-control" placeholder="ชื่อ ..." id="adduser_name" name="adduser_name"/>

							</div>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>นามสกุล</label>

								<input type="text" class="form-control" placeholder="นามสกุล ..." id="adduser_lastname"  name="adduser_lastname"/>

							</div>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>เบอร์โทร</label>

								<input type="text" class="form-control" placeholder="เบอร์โทร ..." id="adduser_phone"  name="adduser_phone"/>

							</div>

						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 p-1">

							<div class="form-group"  style="padding-right:10px;">

								<label>Line id</label>

								<input type="text" class="form-control" placeholder="line id ..." id="addauser_line_id"  name="addauser_line_id"/>

							</div>

						</div>

                        <div class="col-md-12 col-sm-12 col-xs-12 p-1">

                            <label>สิทธิการใช้งาน</label>

                            <div class="row p-3 pt-0">

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" name="menu_1"> <span class="checkboxtext">รายการหวย</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" name="menu_2"> <span class="checkboxtext">รายงานผลหวย</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" name="menu_3"> <span class="checkboxtext">จัดการสมาชิก</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" name="menu_4"> <span class="checkboxtext">ตั้งค่าสมาชิก</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" name="menu_5"> <span class="checkboxtext">รายงานการเงิน</span>

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">

                                    <div class="checkbox">

                                        <label>

                                            <input type="checkbox" class="checktext" name="menu_6"> <span class="checkboxtext">ประวัติการใช้งาน</span>

                                        </label>

                                    </div>

                                </div>

                            </div>

						</div>

					</div>

					</form>

				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-undo"></i> ย้อนกลับ</button>

					<button type="button" class="btn btn-primary" onClick="addDataUser()"> <i class="fas fa-save"></i> เพิ่มผู้ช่วย</button>

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

	

function updateStatus(id,stat){

    event.preventDefault();

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

function getAddUser(){

    event.preventDefault();

	$('#add_data').appendTo("body").modal('show');

    //$(".checktext").prop("checked", false);

}

function addDataUser(){

    event.preventDefault();

	$.ajax({

		type: "POST",

		url: "api/insert_user_assistant",

		data: $("#adduser_form").serialize(),

		success: function(result){

			$('#show_error').html(result);

		}

	});

}



function getDataUser(id){

	event.preventDefault();

	$.ajax({

		type: "POST",

		url: "api/get_user_assistant",

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

		url: "api/edit_user_assistant",

		data: $("#userdata_form").serialize(),

		success: function(result){

			$('#show_error').html(result);

		}

	});

}

</script>



