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
		checkLogin('finance_report');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();
		$user_id = decode($_COOKIE['EASYLOTSID']);
		$sql = "SELECT * FROM user WHERE user_id = ".$user_id;
		
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
						HtmlCore::getMenu('finance_report');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						รายงานการเงิน
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">รายงาน</li>
						<li class="active">รายงานการเงิน</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-body">
                                    <div class="row p-3 pt-2">
                                    <form id="search_form">
                                        <? $today = date('Y-m-d');	 ?>
                                        <div class="col-md-4 col-sm-4 col-xs-6 ">
                                            <label>ตั้งแต่วันที่</label>
                                            <input type="text" class="form-control" id="start" name="start" placeholder="ตั้งแต่วันที่" value="<? echo $today; ?>">
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <label>ถึงวันที่</label>
                                            <input type="text" class="form-control" id="end" name="end" placeholder="ถึงวันที่" value="<? echo $today; ?>">
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group" style="padding-top:24px">
                                                <input type="hidden" name="user_id" id="user_id">
                                                <button type="botton" class="btn btn-primary" onclick="getReport()"> <i class="fas fa-search"></i> ค้นหา </button>
                                            </div>	
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 p-1 tb-3 pt-0">
                                            <button type="button" onclick="setDate('today')" class="btn btn-primary mt-1 ">วันนี้</button>
                                            <button type="button" onclick="setDate('lastday')" class="btn btn-primary mt-1 ">เมื่อวาน</button>
                                            <button type="button" onclick="setDate('thisweek')" class="btn btn-primary mt-1 ">สัปดาห์นี้</button>
                                            <button type="button" onclick="setDate('lastweek')" class="btn btn-primary mt-1 ">สัปดาห์ที่แล้ว</button>
                                            <button type="button" onclick="setDate('thismonth')" class="btn btn-primary mt-1 ">เดือนนี้</button>
                                            <button type="button" onclick="setDate('lastmonth')" class="btn btn-primary mt-1 ">เดือนที่แล้ว</button>
                                        </div>
                                    </form>
                                    </div>

                                    <div id="show_report"></div>
                                   
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
  </body>
</html>

<script>
$( function() {
    $("#start").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#end").datepicker({ dateFormat: 'yy-mm-dd' });

    getReport();

});
function setDate(type){
    if(type=='today'){
        $("#start").val("<? echo $today; ?>");
        $("#end").val("<? echo $today; ?>");
    }
    else if(type=='lastday'){
        $("#start").val("<? echo date('Y-m-d',strtotime("-1 days")); ?>");
        $("#end").val("<? echo date('Y-m-d',strtotime("-1 days")); ?>");
    }
    else if(type=='thisweek'){
        $("#start").val("<? echo date('Y-m-d',strtotime("monday this week")); ?>");
        $("#end").val("<? echo $today; ?>");
    }
    else if(type=='lastweek'){
        $("#start").val("<? echo date('Y-m-d',strtotime("monday previous week")); ?>");
        $("#end").val("<? echo date('Y-m-d',strtotime("sunday previous week")); ?>");
    }
    else if(type=='thismonth'){
        $("#start").val("<? echo date("Y-m-d", strtotime("first day of this month")); ?>");
        $("#end").val("<? echo date('Y-m-d', strtotime("last day of this month")); ?>");
    }
    else if(type=='lastmonth'){
        $("#start").val("<? echo date("Y-m-d", strtotime("first day of previous month")); ?>");
        $("#end").val("<? echo date("Y-m-d", strtotime("last day of previous month")); ?>");
    }
    getReport();
}
function getReport(){
    event.preventDefault();
    $.ajax({
    	type: "POST",
    	url: "api/get_finance_report",
    	data: $("#search_form").serialize(),
    	beforeSend: function() {
            $("#show_report").html('<div class="loading"><div class="loader">Loading...</div></div>');
    	},
    	success: function(result){
            $("#show_report").hide();
    		$("#show_report").html(result);
            $("#show_report").fadeIn();
    	}
    });
}
</script>

