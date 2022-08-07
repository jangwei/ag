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

		setPlugin('jquery,jquery-ui,alert,hrefDefault,ckeditor');

		checkLogin('announce');

		

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

						HtmlCore::getMenu('announce');

					?>

				</section>

			</aside>



			<div class="content-wrapper">

				<section class="content-header">

					<h1>

                        ประกาศ

						<? HtmlCore::getNickName(); ?>

					</h1>

					<ol class="breadcrumb">

						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>

					</ol>

				</section>



				<section class="content" style="font-family: 'Kanit'">

					<?

                        $agent_detail = $query->queryDB_to_string('SELECT announce_detail FROM announce WHERE announce_name="agent"');

                        $member_detail = $query->queryDB_to_string('SELECT announce_detail FROM announce WHERE announce_name="member"');

                    ?>

					<div class="row">

						<div class="col-md-6">

							<div class="box box-primary">

								<div class="box-body">

                                    <label>ประกาศแจ้งเอเย่น</label>

                                    <textarea class="form-control" id="agent_announce">

                                        <? 

                                            echo $agent_detail;

                                        ?>

                                    </textarea>

								</div>

                                <div class="box-footer text-center">

                                    <div class="form-group">

                                        <button type="submit" class="btn btn-primary set_announce"> <i class="fa fa-save"></i> บันทึก</button>

                                    </div>								

                                </div>

							</div> 

						</div>

						<div class="col-md-6">

							<div class="box box-primary">

								<div class="box-body">

                                    <label>ประกาศแจ้งเมมเบอร์</label>

                                    <textarea class="form-control" id="member_announce">

                                        <? 

                                            echo $member_detail;

                                        ?>

                                    </textarea>

								</div>

                                <div class="box-footer text-center">

                                    <div class="form-group">

                                        <button type="submit" class="btn btn-primary set_announce"> <i class="fa fa-save"></i> บันทึก</button>

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

$(function () {

    agent = CKEDITOR.replace('agent_announce',{

        language: 'th',

        height: 350,

    });	



    member = CKEDITOR.replace('member_announce',{

        language: 'th',

        height: 350,

    });	



    CKEDITOR.config.toolbar = [

        ['Source'],

        ['NumberedList','BulletedList','-','Outdent','Indent'],

        ['FontSize'],

        ['Bold','Italic','Underline'],

        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],

        ['Link','Unlink'],

    ] ;	



    $(".set_announce").click(function(event){

        var agent_detail = agent.getData();

        agent_detail = agent_detail.split(',').join('&#44;');

        agent_detail = agent_detail.split('+').join('&#43;');



        var member_detail = member.getData();

        member_detail = member_detail.split(',').join('&#44;');

        member_detail = member_detail.split('+').join('&#43;');

        $.ajax({

            type: "POST",

            url: "api/set_announce",

            data:{

                agent_detail : agent_detail,

                member_detail : member_detail

            },

            beforeSend: function(){



            },

            success: function(result){

                $('#show_error').html(result);

            }

        });

    });

    



});		

</script>



