<? ob_start(); ?>

<!DOCTYPE html>

<html class="lockscreen">

    <head>

        <meta charset="UTF-8">

        

		<link rel="shortcut icon" type="image/jpg" href="img/icon.png" />

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

		

        <!-- Ionicons -->

        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />

		

        <!-- Theme style -->

        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

		

		<style>

			.lockscreen {

				background: url(images/background.jpg) repeat center center fixed;

				-webkit-background-size: cover;

				-moz-background-size: cover;

				-o-background-size: cover;

				background-size: cover;

			}

			

			.lockscreen > body {

				background: transparent;

			}

			

			.lockscreen .headline {

				color: #fff;

				text-shadow: 1px 3px 5px rgba(0, 0, 0, 0.5);

				font-weight: 300;

				-webkit-font-smoothing: antialiased !important;

				opacity: 0.8;

				margin: 10px 0 30px 0;

				font-size: 90px;

			}

			@media screen and (max-width: 480px) {

				.lockscreen .headline {

					font-size: 60px;

					margin-bottom: 40px;

				}

			}

			

			.lockscreen .lockscreen-name {

				text-align: center;

				font-weight: 600;

				font-size: 16px;

			}

			

			.lockscreen-item {

				padding: 0;

				background: #fff;

				position: relative;

				-webkit-border-radius: 4px;

				-moz-border-radius: 4px;

				border-radius: 4px;

				margin: 10px auto;

				width: 290px;

			}

			.lockscreen-item:before,.lockscreen-item:after {

				display: table;

				content: " ";

			}

			.lockscreen-item:after {

				clear: both;

			}

			

			.lockscreen-item > .lockscreen-image {

				position: absolute;

				left: -10px;

				top: -30px;

				background: #fff;

				padding: 10px;

				-webkit-border-radius: 50%;

				-moz-border-radius: 50%;

				border-radius: 50%;

				z-index: 10;

			}

			.lockscreen-item > .lockscreen-image > img {

				width: 70px;

				height: 70px;

				-webkit-border-radius: 50%;

				-moz-border-radius: 50%;

				border-radius: 50%;

			}

			

			.lockscreen-item > .lockscreen-credentials {

				margin-left: 80px;

			}

			.lockscreen-item > .lockscreen-credentials input {

				border: 0 !important;

			}

			.lockscreen-item > .lockscreen-credentials .btn {

				background-color: #fff;

				border: 0;

			}

			

			.lockscreen-link {

				margin-top: 30px;

				text-align: center;

			}

		</style>

		<link href="https://fonts.googleapis.com/css?family=Quicksand|Kanit" rel="stylesheet">

		<?

			include_once("api/core.php");

			include_once('indyEngine/engineControl.php');

			setInclude('htmlControl,dbControl,sessionControl');

			setPlugin('jquery,alert,hrefDefault');

			

			HtmlCore::getTitle();

			

			$query = new DBControl();

			

			if(isset($_COOKIE["EASYLOTSID"])){

			echo '

				<script>

					window.location="index";

				</script>

			';

			}

		?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>

          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>

        <![endif]-->

    </head>

    <body>

        <!-- Automatic element centering using js -->

        <div class="center">

			<div  class="headline text-center">

				<img src="img/icon.png" alt="Smiley face" height="150xp" style="margin-top:30vh;">

			</div>

           

			<div style="padding:0px; ">	

				<form id="login_form">

				

					<!-- START LOCK SCREEN ITEM -->

					<div class="lockscreen-item" >

						<div class="lockscreen-credentials">

							<div class="input-group">

								<input name="username" type="text" class="form-control" placeholder="username" />

							</div>

						</div><!-- /.lockscreen credentials -->

					</div><!-- /.lockscreen-item -->

					

					<!-- START LOCK SCREEN ITEM -->

					<div class="lockscreen-item">

						

				

				

					<!-- lockscreen credentials (contains the form) -->

					<div class="lockscreen-credentials">

						<div class="input-group">

							<input id="device" name="device" type="hidden"/>

							<input id="url" name="url" type="hidden" value="<? echo $_GET['url']; ?>"/>

							<input name="password" type="password" class="form-control" placeholder="password" />

							<div class="input-group-btn">

								<button type="submit" class="btn btn-flat"><i class="fa fa-sign-in text-muted"></i></button>

							</div>

						</div>

					</div><!-- /.lockscreen credentials -->

				</div><!-- /.lockscreen-item -->

				</form>

			

				<div class="lockscreen-link">

					<div id="alertlogin" style="color:#fff"></div>

				</div>

			

			</div><!-- /.center -->

		</div>

		

		<!-- bootstrap -->

        <script src="js/bootstrap.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->

        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

		

        <!-- page script -->

        <script type="text/javascript">

            $(function(){

				$('#device').val(getDeviceType());

				

				$("#login_form").submit(function(event){

					event.preventDefault();

					$.ajax({

						type: "POST",

						url: "indyEngine/sessionControl",

						data: $("#login_form").serialize(),

						success: function(result){

							$("#alertlogin").html(result);

						}

					});		

				});

				

            });



            function getDeviceType(){

				var ua = navigator.userAgent;

				if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {

					return "tablet";

				}

				if (

					/Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(

					ua

					)

				) {

					return "mobile";

				}

				return "desktop";

			}

				

        </script>

    </body>

</html>

