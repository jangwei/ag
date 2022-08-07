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
		checkLogin('index');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();
        
        $user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        if($user_type=='assistan'){
            $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        }
        else{
            $user_id = decode($_COOKIE["EASYLOTSID"]);
        }

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
						HtmlCore::getMenu('daily_process');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						ปิดยอดรายวัน
						<small>EasyLots</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="active">ปิดยอดรายวัน</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-body">
                                <form id="form">
										<div class="row">
											<div class="col-md-4 col-sm-4 col-xs-6 pb-4">
												<label>วันที่ปิดยอด</label>
												<input type="text" class="form-control" id="date" name="lotto_list_date" placeholder="วันที่" value="<? echo $todayd; ?>">
											</div>
										</div>
										<div class="row">
                                            <div class="col-md-12">
                                                <?
                                                    echo '<div><small>จำนวน <span id="num">0</span>/<span id="max">0</span> หมายเลข</small></div>';
                                                ?>
                                                <div id="progress1" class="progress active">
                                                    <div id="progressbar" class="progress-bar progress-bar-primary progress-bar-striped vertical" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        <span class="sr-only">0% Complete (success)</span>
                                                    </div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button id="bt" type="button" class="btn btn-primary"><i class="fa fa-cogs"></i> ประมวลผล</button>
                                                </div>			
                                            </div>
										</div>
									</form>
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
    $("#date").datepicker({ dateFormat: 'yy-mm-dd' });

    $('#bt').addClass('disabled');
    $('#bt').prop('disabled',true);

    $("#date").change(function(){
        $.ajax({
            type: "POST",
            url: "api/get_nprocess_daily",
            data: { 
                date: $('#date').val(),
            },
            success: function(result){
                $("#show_error").html(result);
            }
        });	
    });
    
    $("#bt").click(function(event){
        if($("#date").val()!=''){
            sentProcess();
        }
        else{
            Message.add("กรุณาใส่ข้อมูลวันที่ !", {
                type: "error",
                vertical:"top",
                horizontal:"right"
            }); 
        }
    });
});

function sentProcess(){
    $('#bt').addClass('disabled'); 
    $('#bt').prop('disabled',true);
    $("#bt").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> รอการประมวลผล');
    $.ajax({
        type: "POST",
        url: "api/process_daily",
        data: { 
            date: $('#date').val(),
        },
        success: function(result){
            $("#show_error").html(result);
        }
    });	
    $('#progressbar').attr('aria-valuenow',".$count.").css('width','0%');
    myCal = setInterval(function(){ getProcess(); }, 500);
}
function getProcess(){
    $.ajax({
        type: "POST",
        url: "api/get_process_daily",
        data: { 
            date: $('#date').val(),
        },
        success: function(result){
            $("#show_error").html(result);
        }
    });	
}
function stopProcess(){
    clearInterval(myCal);
}
</script>

