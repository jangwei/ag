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

		checkLogin('my_info');

		

		HtmlCore::getTitle();

        

        $query = new DBControl();



        $user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));

        if($user_type=='assistan'){

            $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));

        }

        else{

            $user_id = decode($_COOKIE["EASYLOTSID"]);

        }



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

						HtmlCore::getMenu('my_info');

					?>

				</section>

			</aside>



			<div class="content-wrapper">

				<section class="content-header">

					<h1>

                        ส่วนแบ่งที่ได้รับ

						<? HtmlCore::getNickName(); ?>

					</h1>

					<ol class="breadcrumb">

						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>

						<li class="active">ตั้งค่าสมาชิก</li>

						<li class="active">ส่วนแบ่งที่ได้รับ</li>

					</ol>

				</section>



				<section class="content" style="font-family: 'Kanit'">

					

                    <div class="row">

                        <div class="col-md-12">

                            <div class="nav-tabs-custom">

                                <ul class="nav nav-tabs">

                                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><b>ส่วนแบ่งหุ้น</b></a></li>

                                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><b>คอมมิชชั่น</b></a></li>

                                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b>อัตราจ่าย</b></a></li>

                                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><b>แทงสูงสุด</b></a></li>

                                </ul>

                                <div class="tab-content">

                                    <div class="tab-pane active table-responsive" id="tab_1">

                                        <table class="table table-bordered table-sm table-striped table-hover">

                                            <thead>

                                                <tr class="bg-navy">

                                                    <th class="text-center">#</th>

                                                    <th class="text-center">กลุ่มหวย</th>

                                                    <th class="text-center">หวย</th>

                                                    <th class="text-center">ที่ได้รับมา</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?

                                                $data = $query->queryDB_to_array("SELECT lotto_user_share.share,lotto.lotto_id,lotto.lotto_name,lotto.lotto_img,lotto.lotto_type_id FROM lotto_user_share INNER JOIN lotto ON lotto_user_share.lotto_id = lotto.lotto_id  WHERE lotto_user_share.user_id=".$user_id." GROUP BY lotto.lotto_id ORDER BY lotto.lotto_type_id,lotto.lotto_id ");

                                                foreach($data as $key => $val){

                                                    $lotto_type_name = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$val['lotto_type_id']);

                                                    echo '

                                                        <tr>

                                                            <td class="text-center">#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).'</td>

                                                            <td class="text-center">'.$lotto_type_name.'</td>

                                                            <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>

                                                            <td class="text-center">'.$val['share'].' %</td>

                                                        </tr>

                                                    ';

                                                }

                                            ?>

                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="tab-pane table-responsive" id="tab_2">

                                        <table class="table table-bordered table-sm table-striped table-hover">

                                            <thead>

                                                <tr class="bg-navy">

                                                    <th class="text-center">#</th>

                                                    <th class="text-center">กลุ่มหวย</th>

                                                    <th class="text-center">หวย</th>

                                                    <th class="text-center">2 ตัวบน</th>

                                                    <th class="text-center">2 ตัวล่าง</th>

                                                    <th class="text-center">3 ตัวบน</th>

                                                    <th class="text-center">3 ตัวล่าง</th>

                                                    <th class="text-center">3 ตัวโต๊ด</th>

                                                    <th class="text-center">วิ่งบน</th>

                                                    <th class="text-center">วิ่งล่าง</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?

                                                $data = $query->queryDB_to_array("SELECT top2,bottom2,top3,toad3,bottom3,top1,bottom1,lotto.lotto_id,lotto.lotto_name,lotto.lotto_img,lotto.lotto_type_id FROM lotto_user_commission INNER JOIN lotto ON lotto_user_commission.lotto_id = lotto.lotto_id  WHERE lotto_user_commission.user_id=".$user_id." GROUP BY lotto.lotto_id ORDER BY lotto.lotto_type_id,lotto.lotto_id ");

                                                foreach($data as $key => $val){

                                                    $lotto_type_name = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$val['lotto_type_id']);

                                                    echo '

                                                    <tr>

                                                        <td class="text-center">#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).'</td>

                                                        <td class="text-center">'.$lotto_type_name.'</td>

                                                        <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>

                                                        <td class="text-center">'.$val['top2'].'</td>

                                                        <td class="text-center">'.$val['bottom2'].'</td>

                                                        <td class="text-center">'.$val['top3'].'</td>

                                                        <td class="text-center">'.$val['toad3'].'</td>

                                                        <td class="text-center">'.$val['bottom3'].'</td>

                                                        <td class="text-center">'.$val['top1'].'</td>

                                                        <td class="text-center">'.$val['bottom1'].'</td>

                                                    </tr>

                                                    ';

                                                }

                                            ?>

                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="tab-pane table-responsive" id="tab_3">

                                        <table class="table table-bordered table-sm table-striped table-hover">

                                            <thead>

                                                <tr class="bg-navy">

                                                    <th class="text-center">#</th>

                                                    <th class="text-center">กลุ่มหวย</th>

                                                    <th class="text-center">หวย</th>

                                                    <th class="text-center">2 ตัวบน</th>

                                                    <th class="text-center">2 ตัวล่าง</th>

                                                    <th class="text-center">3 ตัวบน</th>

                                                    <th class="text-center">3 ตัวล่าง</th>

                                                    <th class="text-center">3 ตัวโต๊ด</th>

                                                    <th class="text-center">วิ่งบน</th>

                                                    <th class="text-center">วิ่งล่าง</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?

                                                $data = $query->queryDB_to_array("SELECT top2,bottom2,top3,toad3,bottom3,top1,bottom1,lotto.lotto_id,lotto.lotto_name,lotto.lotto_img,lotto.lotto_type_id FROM lotto_user_rate INNER JOIN lotto ON lotto_user_rate.lotto_id = lotto.lotto_id  WHERE lotto_user_rate.user_id=".$user_id." GROUP BY lotto.lotto_id ORDER BY lotto.lotto_type_id,lotto.lotto_id ");

                                                foreach($data as $key => $val){

                                                    $lotto_type_name = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$val['lotto_type_id']);

                                                    echo '

                                                    <tr>

                                                        <td class="text-center">#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).'</td>

                                                        <td class="text-center">'.$lotto_type_name.'</td>

                                                        <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>

                                                        <td class="text-center">'.$val['top2'].'</td>

                                                        <td class="text-center">'.$val['bottom2'].'</td>

                                                        <td class="text-center">'.$val['top3'].'</td>

                                                        <td class="text-center">'.$val['toad3'].'</td>

                                                        <td class="text-center">'.$val['bottom3'].'</td>

                                                        <td class="text-center">'.$val['top1'].'</td>

                                                        <td class="text-center">'.$val['bottom1'].'</td>

                                                    </tr>

                                                    ';

                                                }

                                            ?>

                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="tab-pane table-responsive" id="tab_4">

                                    <table class="table table-bordered table-sm table-striped table-hover">

                                            <thead>

                                                <tr class="bg-navy">

                                                    <th class="text-center">#</th>

                                                    <th class="text-center">กลุ่มหวย</th>

                                                    <th class="text-center">หวย</th>

                                                    <th class="text-center">2 ตัวบน</th>

                                                    <th class="text-center">2 ตัวล่าง</th>

                                                    <th class="text-center">3 ตัวบน</th>

                                                    <th class="text-center">3 ตัวล่าง</th>

                                                    <th class="text-center">3 ตัวโต๊ด</th>

                                                    <th class="text-center">วิ่งบน</th>

                                                    <th class="text-center">วิ่งล่าง</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?

                                                $data = $query->queryDB_to_array("SELECT top2,bottom2,top3,toad3,bottom3,top1,bottom1,lotto.lotto_id,lotto.lotto_name,lotto.lotto_img,lotto.lotto_type_id FROM lotto_user_limit INNER JOIN lotto ON lotto_user_limit.lotto_id = lotto.lotto_id  WHERE lotto_user_limit.user_id=".$user_id." GROUP BY lotto.lotto_id ORDER BY lotto.lotto_type_id,lotto.lotto_id ");

                                                foreach($data as $key => $val){

                                                    $lotto_type_name = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$val['lotto_type_id']);

                                                    echo '

                                                    <tr>

                                                        <td class="text-center">#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).'</td>

                                                        <td class="text-center">'.$lotto_type_name.'</td>

                                                        <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>

                                                        <td class="text-center">'.$val['top2'].'</td>

                                                        <td class="text-center">'.$val['bottom2'].'</td>

                                                        <td class="text-center">'.$val['top3'].'</td>

                                                        <td class="text-center">'.$val['toad3'].'</td>

                                                        <td class="text-center">'.$val['bottom3'].'</td>

                                                        <td class="text-center">'.$val['top1'].'</td>

                                                        <td class="text-center">'.$val['bottom1'].'</td>

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

	



</script>



