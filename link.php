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

		setPlugin('jquery,jquery-ui,alert,hrefDefault');

		checkLogin('links');

		

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

						HtmlCore::getMenu('links');

					?>

				</section>

			</aside>



			<div class="content-wrapper">

				<section class="content-header">

					<h1>

                        ???????????????????????????

						<? HtmlCore::getNickName(); ?>

					</h1>

					<ol class="breadcrumb">

						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>

						<li class="active">???????????????????????????</li>

					</ol>

				</section>



				<section class="content" style="font-family: 'Kanit'">

					

					<div class="row">

						<div class="col-md-12">

							<div class="box box-primary">

								<div class="box-body">

                                    <div class="table-responsive">

                                        <table class="table table-hover" id="data_table">

                                            <thead>

                                                <tr class="bg-navy">

                                                    <th>#</th>

                                                    <th>???????????????????????????</th>

                                                    <th>?????????</th>

                                                    <th>?????????????????????????????????</th>

                                                    <th>??????????????????????????????</th>

                                                    <th>??????????????????????????????????????????</th>

                                                    <th>??????????????????????????????</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?

                                                    $lotto_data = $query->queryDB_to_array('SELECT * FROM lotto INNER JOIN lotto_type ON lotto.lotto_type_id=lotto_type.lotto_type_id WHERE lotto.lotto_link!="" ORDER BY lotto.lotto_type_id,lotto.lotto_id');

                                                    foreach($lotto_data as $key => $val){

                                                        echo '

                                                            <tr>

                                                                <td class="text-center">#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).'</td>

                                                                <td class="text-center">'.$val['lotto_type_name'].'</td>

                                                                <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>

                                                                <td class="text-center">'.substr($val['lotto_time_start'],0,5).' ???.</td>

                                                                <td class="text-center">'.substr($val['lotto_time_end'],0,5).' ???.</td>

                                                                <td class="text-center"><a href="#" onClick="getHowto()"> <i class="fas fa-book"></i> ?????????????????????????????????????????? </a></td>

                                                                <td class="text-center"><a href="'.$val['lotto_link'].'" target="_blank"> <i class="fas fa-search"></i> ?????????????????????????????? </a></td>

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

    <div class="modal fade" id="howto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-scrollable modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true" style="margin-top:20px"><i class="fa fa-times"></i></span>

                    </button>

                    <h4 class="modal-title"><b>??????????????????????????????????????????</b></h4>

                </div>

                <div class="modal-body">

                    <img src="img/howto/1.jpg">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn" data-dismiss="modal"> <i class="fas fa-undo-alt"></i> ????????????????????????</button>

                </div>

            </div>

        </div>

    </div>



    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="dist/js/app.min.js"></script>

  </body>

</html>



<script>

$( function() {

    



});

function getHowto(){

    // $.ajax({

    //     type: "POST",

    //     url: "api/insert_lotto_list",

    //     data: $("#insert_lotto_form").serialize(),

    //     beforeSend: function() {

            

    //     },

    //     success: function(result){

    //         $("#show_error").html(result);

    //     }

    // });	

    $('#howto').appendTo("body").modal('show');

}

</script>



