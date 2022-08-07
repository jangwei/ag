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

		setPlugin('jquery,jquery-ui,alert,hrefDefault');

		checkLogin('open_lotto_list');

		

		HtmlCore::getTitle();

        

        $query = new DBControl();

		$user_id = decode($_COOKIE['EASYLOTSID']);

		$sql = "SELECT * FROM user WHERE user_id = ".$user_id;

		$user_data = $query->queryDB_to_row($sql);

        

		$today = date('Y-m-d');	

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

						HtmlCore::getMenu('open_lotto_list');

					?>

				</section>

			</aside>



			<div class="content-wrapper">

				<section class="content-header">

					<h1>

                        เพิ่มรายการหวยรายวัน

						<? HtmlCore::getNickName(); ?>

					</h1>

					<ol class="breadcrumb">

						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>

						<li class="active">รายการหวย</li>

						<li class="active">เพิ่มรายการหวยรายวัน</li>

					</ol>

				</section>



				<section class="content" style="font-family: 'Kanit'">

					

					<div class="row">

						  <div class="col-md-12">

							  <div class="box box-primary">

								<div class="box-body table-responsive">

									<form id="form">

										<div class="row">

											<div class="col-md-4 col-sm-4 col-xs-6 pb-4">

												<label>รายการหวยวันที่</label>

												<input type="text" class="form-control" id="date" name="lotto_list_date" placeholder="วันที่" value="<? echo $today; ?>">

											</div>

										</div>

										<div class="row">

											<div class="col-md-12">

												<table class="table table-bordered table-striped table-hover" id="data_table">

													<thead>

														<tr class="bg-navy">

															<th class="text-center">#</th>

															<th class="text-center">ประเภทหวย</th>

															<th class="text-center">หวย</th>

															<th class="text-center">เวลาเปิดรับ</th>

															<th class="text-center">เวลาปิดรับ</th>

														</tr>

													</thead>

													<tbody>

													<?

														$sql = "SELECT * FROM lotto WHERE lotto_auto=1 ORDER BY lotto_type_id,lotto_id";	

														$lotto_data = $query->queryDB_to_array($sql);

														$count = 0; $i = 1;

														foreach($lotto_data as $key => $val){

															$lotto_type = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$val['lotto_type_id']);

															$receive = $query->queryDB_to_row('SELECT * FROM lotto_receive WHERE lotto_id='.$val['lotto_id'].' AND user_id='.$user_id);

															echo '

																<tr>

																	<td class="text-center">#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).'</td>

																	<td class="text-center">'.$lotto_type.'</td>

																	<td>

																		<img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'

																		<input type="hidden" value="'.$val['lotto_id'].'" name="lotto_id[]">

																	</td>

																	<td><input type="time" class="form-control" value="'.$val['lotto_time_start'].'" name="lotto_time_start[]"></td>

																	<td><input type="time" class="form-control" value="'.$val['lotto_time_end'].'" name="lotto_time_end[]"></td>

																</tr>

															';

															$count++; $i++;

														}

													?>

													</tbody>

												</table>

											</div>

										</div>

									</form>

								</div>

                                <div class="box-footer text-center">

                                    <button type="button" class="btn btn-primary p-2" id="bt_edit"><i class="fas fa-save"></i> บันทึก</button>

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



	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

	<script src="plugins/datatables/jquery.dataTables.min.js"></script>

	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>



  </body>

</html>



<script>

$(function () {

    $("#date").datepicker({ dateFormat: 'yy-mm-dd' });



	dbTable();



	$("#bt_edit").click(function(event){

		event.preventDefault();

		$.ajax({

			type: "POST",

			url: "api/open_lotto_list",

			data: $("#form").serialize(),

			beforeSend: function() {

				$("#bt_edit").prop('disabled', true);

				$("#bt_edit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> รอการประมวลผล');

			},

			success: function(result){

				$("#show_error").html(result);

				$("#bt_edit").prop('disabled', false);

				$("#bt_edit").html('<i class="fas fa-save"></i> บันทึก');

			}

		});	

	});



});



function dbTable(){

    $("#data_table").dataTable({

        "bPaginate": false,

        "bLengthChange": false,

        "bFilter": false,

        "bSort": true,

        "bInfo": false,

        "bAutoWidth": false,

        "pageLength": 100,

        "order": [ [ 1, 'asc' ] ],

        "language": {

            "emptyTable": "ไม่พบข้อมูล",

            "search": "ค้าหา :"

        }

    });

}

</script>



