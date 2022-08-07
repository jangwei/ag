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
		checkLogin('reward_report');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();
	?>
  </head>
	<body class="hold-transition skin-black"  style="font-family: 'Kanit', sans-serif;">
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
						HtmlCore::getMenu('reward_report');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
                        ตรวจรางวัล
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="">รายงานผลหวย</li>
						<li class="active">ตรวจรางวัล</li>
					</ol>
				</section>
				<section class="content" style="font-family: 'Kanit'">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12 p-5 pt-2">

                                            <div id="searchbox" class="">
                                                <form id="search_form">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <? 
                                                                    $today = date('Y-m-d');	 
                                                                    $now = date('H:i:s');
                                                                    // if($now>'06:00:00'){
                                                                    //     $today = date('Y-m-d');	
                                                                    // }
                                                                    // else{
                                                                    //     $today = date('Y-m-d',strtotime("-1 days"));
                                                                    // }
                                                                ?>
                                                                <div class="col-md-4 col-sm-4 col-xs-6 p-1 pb-0">
                                                                    <label>ตั้งแต่วันที่</label>
                                                                    <input type="text" class="form-control" id="start" name="start" placeholder="ตั้งแต่วันที่" value="<? echo $today; ?>">
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-6 p-1 pb-0">
                                                                    <label>ถึงวันที่</label>
                                                                    <input type="text" class="form-control" id="end" name="end" placeholder="ถึงวันที่" value="<? echo $today; ?>">
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-12 p-1 pb-0">
                                                                    <div class="form-group" style="padding-top:24px">
                                                                        <input type="hidden" name="user_id" id="user_id">
                                                                        <button type="botton" class="btn btn-primary" onclick="getReport()"> <i class="fas fa-search"></i> ค้นหา </button>
                                                                    </div>	
                                                                </div>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 p-1 tb-3 pt-0">
                                                                    <button type="button" onclick="setDate('today')" class="btn btn-primary mt-1 btn-xs">วันนี้</button>
                                                                    <button type="button" onclick="setDate('lastday')" class="btn btn-primary mt-1 btn-xs">เมื่อวาน</button>
                                                                    <button type="button" onclick="setDate('thisweek')" class="btn btn-primary mt-1 btn-xs">สัปดาห์นี้</button>
                                                                    <button type="button" onclick="setDate('lastweek')" class="btn btn-primary mt-1 btn-xs">สัปดาห์ที่แล้ว</button>
                                                                    <button type="button" onclick="setDate('thismonth')" class="btn btn-primary mt-1 btn-xs">เดือนนี้</button>
                                                                    <button type="button" onclick="setDate('lastmonth')" class="btn btn-primary mt-1 btn-xs">เดือนที่แล้ว</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div id="bt_show_select"><label class="pointer">รายละเอียด</label> <span class="pointer" id="fa"><i class="fa fa-caret-down"></i></span></div>
                                                            <?
                                                                echo '<div id="show_select" class="pl-1">';
                                                                $types = $query->queryDB_to_array('SELECT * FROM lotto_type ORDER BY lotto_type_id');
                                                                foreach($types as $i => $v){
                                                                    $lottos = $query->queryDB_to_array('SELECT * FROM lotto WHERE lotto_type_id='.$v['lotto_type_id'].' ORDER BY lotto_id');
                                                                    if($lottos){
                                                                        echo '<div class="p-0">';
                                                                    }
                                                                    foreach($lottos as $j => $val){
                                                                        echo '<label style="padding-right:10px;"><input name="lotto_id[]" value="'.$val['lotto_id'].'" type="checkbox" class="type_'.$v['lotto_type_id'].' check-mini"> <span class="checkboxtext">'.$val['lotto_name'].'</span></label> ';
                                                                    }
                                                                    if($lottos){
                                                                        echo '</div><hr>';
                                                                    }
                                                                }
                                                                echo '</div>';
                                                                echo '<button type="button" onclick="setCheck(\'all\')" class="btn btn-success m-1"><i class="fa fa-check"></i> เลือกทั้งหมด</button>';
                                                                echo '<button type="button" onclick="setCheck(\'remove\')" class="btn btn-warning m-1"><i class="fa fa-close"></i> เอาออกทั้งหมด</button>';
                                                                foreach($types as $i => $v){
                                                                    echo '<input type="hidden" id="chkt_'.$v['lotto_type_id'].'" class="chkt" value="0">';
                                                                    echo '<button type="button" id="btt_'.$v['lotto_type_id'].'" onclick="setCheck('.$v['lotto_type_id'].')" class="btn btn-info m-1 bt_type">'.$v['lotto_type_name'].'</button>';
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="table-responsive " id="show_report" class="pt-3"></div>

                                        </div>
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

	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>                                       

     <!-- Modal -->
     <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                    <h4 class="modal-title"><b>ตรวจรางวัล</b></h4>
                </div>
                <div class="modal-body table-responsive ">
                    <div id="table_list"></div>
                </div>
                <div class="modal-footer">
                    <span id="bt_line_share"></span>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-undo-alt" aria-hidden="true"></i> ย้อนกลับ</button>
                </div>
            </div>
        </div>
    </div>

  </body>
</html>

<script>
$(function(){
    $("#start").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#end").datepicker({ dateFormat: 'yy-mm-dd' });
    setCheck('all');
    getReport();

    $('#show_select').hide();

    var chk = true;
    $("#bt_show_select").click(function(){
        $("#show_select").slideToggle();
        if(chk){
            $("#fa").html('<span id="fa"><i class="fa fa-caret-up"></i></span>');
            chk = false;
        }
        else{
            $("#fa").html('<span id="fa"><i class="fa fa-caret-down"></i></span>');
            chk = true;
        }
    });
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
function getReport(re=false){
    event.preventDefault();
    $.ajax({
    	type: "POST",
    	url: "api/get_reward_list",
    	data: $("#search_form").serialize(),
    	beforeSend: function() {
            if(!re){  $("#show_report").html('<div class="loading"><div class="loader">Loading...</div></div>'); }
    	},
    	success: function(result){
            if(!re){  $("#show_report").hide(); }
    		$("#show_report").html(result);
            if(!re){  $("#show_report").fadeIn(); }
            dbTable();
    	}
    });	
}
function setCheck(type){
    if(type=='all'){
        $(".check-mini").prop('checked', true);
        $('.bt_type').addClass('active');
        $('.chkt').val(1);
    }
    else if(type=='remove'){
        $(".check-mini").prop('checked', false);
        $('.bt_type').removeClass('active');
        $('.chkt').val(0);
    }
    else{
        if($('#chkt_'+type).val()==0){
            $(".type_"+type).prop('checked', true);
            $('#chkt_'+type).val(1);
            $('#btt_'+type).addClass('active');
        }
        else{
            $(".type_"+type).prop('checked', false);
            $('#chkt_'+type).val(0);
            $('#btt_'+type).removeClass('active');
        }
    }
}
function getBillReward(id){
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "api/get_bill_reward",
        data: { id:id },
        success: function(result){
            $('#table_list').html(result);
            $('#staticBackdrop').appendTo("body").modal('show');
            $("#staticBackdrop").css("z-index", "9999");
            dbTable2();
        }
    });
}
function dbTable(){
    $("#db_table").dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 100,
        "order": [ [ 4, 'asc' ],[ 5, 'asc' ] ],
        "language": {
            "emptyTable": "ไม่พบข้อมูล",
            "search": "ค้าหา :",
            "paginate": {
                "previous": "ก่อนหน้า",
                "next": "ถัดไป",
            }
        }
    });
}
function dbTable2(){
    $("#db_table2").dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 100,
        "order": [ [ 6, 'asc' ],[ 0, 'asc' ] ],
        "language": {
            "emptyTable": "ไม่พบข้อมูล",
            "search": "ค้าหา :",
            "paginate": {
                "previous": "ก่อนหน้า",
                "next": "ถัดไป",
            }
        },
    });
}

</script>