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
		setPlugin('jquery,alert,hrefDefault');
		checkLogin('lotto_list_end');
		
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
						HtmlCore::getMenu('lotto_list_end');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
                        ประมวลผลรายการหวย
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li>รายการหวย</li>
						<li class="active">ประมวลผลรายการหวย</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					<div class="row">
						
						<div class="col-md-12">
                            <?
                                $lotto_list_id = $_GET['id'];
                                $aid = $query->queryDB_to_string("SELECT lotto_announce_id FROM lotto_announce WHERE lotto_list_id=".$lotto_list_id);
                                
                                $max = intval($query->queryDB_to_string("SELECT COUNT(bill_detail_id) FROM bill_detail WHERE lotto_list_id=".$lotto_list_id));
                                $query->queryDB('UPDATE lotto_list SET lotto_list_record='.$max.' WHERE lotto_list_id='.$lotto_list_id); 

                                if($aid==''){
                                    $page_type = 'insert';
                                }
                                else{
                                    $page_type = 'edit';
                                    $data = $query->queryDB_to_row('SELECT * FROM lotto_announce WHERE lotto_announce_id='.$aid);
                                }
                            ?>
                            <form id="lotto_form" class="form-horizontal form-label-left">
                                <div class="box box-primary">
                                    <div class="box-header pb-0 mb-0">
                                        <?
                                            $lotto_lists = $query->queryDB_to_row('SELECT * FROM lotto_list WHERE lotto_list_id='.$lotto_list_id);
                                            $lotto = $query->queryDB_to_row('SELECT * FROM lotto WHERE lotto_id='.$lotto_lists['lotto_id']);
                                        ?>
                                        <div class="list-huay" style="background-color:<? echo $lotto['lotto_color3']; ?>;">
                                            <div class="alert alert-secondary d-flex justify-content-between" style="background-color:<? echo $lotto['lotto_color2']; ?>; color:#333;">
                                                <div>
                                                    <img src="<? echo $lotto['lotto_img']; ?>" height="25px"> 
                                                    <b class="pl-2"><? echo $lotto['lotto_name']; ?></b>
                                                </div>
                                                <div>
                                                    <b>งวดวันที่ <? echo getTextDateTH($lotto_lists['lotto_list_end']); ?></b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body pt-0 mt-0">
                                        <h4 class="box-title"><b>ประกาศรางวัล</b></h4>
                                        <input type="hidden" name="lotto_announce_id" value="<? echo $aid; ?>">
                                        <input type="hidden" name="lotto_list_id" value="<? echo $lotto_list_id; ?>">
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group has-success"  style="padding-right:10px;">
                                                <label>3 ตัวบน</label>
                                                <input type="number" class="form-control" placeholder="3 ตัวบน ..." name="top3" id="top3" onKeyup="checkNum('top3')" value="<? echo $data['top3'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group has-success"  style="padding-right:10px;">
                                                <label>2 ตัวล่าง</label>
                                                <input type="number" class="form-control" placeholder="2 ตัวล่าง ..." name="bottom2" id="bottom2" onKeyup="checkNum('bottom2')" value="<? echo $data['bottom2'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group"  style="padding-right:10px;">
                                                <label>3 ตัวโต๊ด</label>
                                                <input type="text" class="form-control idis" placeholder="3 ตัวโต๊ด ..." name="toad3" id="toad3" value="<? echo $data['toad3']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group"  style="padding-right:10px;">
                                                <label>2 ตัวบน</label>
                                                <input type="text" class="form-control idis" placeholder="2 ตัวบน ..." name="top2" id="top2" value="<? echo $data['top2'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group"  style="padding-right:10px;">
                                                <label>วิ่งบน</label>
                                                <input type="text" class="form-control idis" placeholder="วิ่งบน ..." name="top1" id="top1" value="<? echo $data['top1'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group"  style="padding-right:10px;">
                                                <label>วิ่งล่าง</label>
                                                <input type="text" class="form-control idis" placeholder="วิ่งล่าง ..." name="bottom1" id="bottom1" value="<? echo $data['bottom1'];?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group"  style="padding-right:10px;">
                                                <label>3 ตัวหน้า</label>
                                                <input type="text" class="form-control" placeholder="3 ตัวหน้า ..." name="front3" id="front3" value="<? echo $data['front3'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-xs-12">
                                            <div class="form-group"  style="padding-right:10px;">
                                                <label>3 ตัวล่าง</label>
                                                <input type="text" class="form-control" placeholder="3 ตัวล่าง ..." name="bottom3" id="bottom3" value="<? echo $data['bottom3'];?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <?
                                            $n_bill = intval($query->queryDB_to_string("SELECT COUNT(bill_id) FROM bill WHERE lotto_list_id=".$lotto_list_id));
                                            echo '<div><small><span id="process_type1">ประมวลผลรายการหวย</span> : <span id="max">'.number_format($max).'</span> หมายเลข <br> ประมวลรายการจ่ายเงิน : <span id="max">'.number_format($n_bill).'</span> บิล</small></div>';
                                        ?>
                                        <div id="show_stat"></div>
                                        <div class="form-group text-center">
                                            <button id="bt" type="button" class="btn btn-primary"><i class="fa fa-cogs"></i> ประมวลผล</button>
										</div>	
                                        
                                    </div>
                                </div>
                            </form>
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
        getProcessStat();

        $("#top3").change(function() {
            var val = $("#top3").val();
            var n1 = val.substr(0,1);
            var n2 = val.substr(1,1);
            var n3 = val.substr(2,1);

            var str1 = '';
            var str2 = '';
            var str = '';
            if(n1!=n2 && n1!=n3 && n2!=n3){
                str += (n1+n2+n3+' '); 
                str += (n1+n3+n2+' '); 
                str += (n2+n1+n3+' '); 
                str += (n2+n3+n1+' '); 
                str += (n3+n1+n2+' '); 
                str += (n3+n2+n1); 
                str2 += (n2+''+n3); 
                str1 = n1+' '+n2+' '+n3;
            }
            else if(n1==n2 && n1!=n3){
                str += (n1+n2+n3+' ');
                str += (n1+n3+n2+' ');
                str += (n3+n1+n2);
                str2 += (n2+n3);
                str1 = n1+' '+n3;
            }
            else if(n1==n3 && n1!=n2){
                str += (n1+n2+n3+' ');
                str += (n1+n3+n2+' ');
                str += (n2+n1+n3);
                str2 += (n2+''+n3);
                str1 = n1+' '+n2;
            }
            else if(n1!=n2 && n1!=n3 && n3==n2){
                str += (n1+n2+n3+' ');
                str += (n3+n1+n2+' ');
                str += (n3+n2+n1);
                str2 += (n2+''+n3);
                str1 = n1+' '+n2;
            }
            else if(n1==n2 && n1==n3){
                str += (n1+n1+n1+' ');
                str2 += (n1+''+n1);
                str1 = n1+' '+n1;
            }
            $("#top1").val(str1);
            $("#top2").val(str2);
            $("#toad3").val(str);
        });

        $("#bottom2").change(function() {
            var val = $("#bottom2").val();
            var n1 = val.substr(0,1);
            var n2 = val.substr(1,1);

            var str = '';
            if(n1!=n2){
                str = n1+' '+n2;
            }
            else{
                str = n1;
            }
            $("#bottom1").val(str);
        });
        

		$("#bt").click(function(event){
            if($("#top3").val()!='' && $("#bottom2").val()!=''){
                if($("#top3").val().length==3 && $("#bottom2").val().length==2){
                    event.preventDefault();
                    $("#bt").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> รอการประมวลผล');
                    $('#bt').addClass('disabled');
                    $('#bt').prop('disabled',true);
                    $.ajax({
                        type: "POST",
                        url: "api/set_lotto_announce",
                        data: $("#lotto_form").serialize(),
                        success: function(result){
                            $("#show_error").html(result);
                        }
                    });	
                }
                else{
                    if($("#top3").val().length!=3){
                        Message.add("ข้อมูลสามตัวบน ไม่ถูกต้อง !", {
                            type: "error",
                            vertical:"top",
                            horizontal:"right"
                        }); 
                        $("#top3").focus();
                    }
                    else if($("#bottom2").val().length!=2){
                        Message.add("ข้อมูลสองตัวล่าง ไม่ถูกต้อง !", {
                            type: "error",
                            vertical:"top",
                            horizontal:"right"
                        }); 
                        $("#bottom2").focus();
                    }
                }
            }
            else{
                Message.add("กรุณาใส่ข้อมูลให้ครบ !", {
                    type: "warning",
                    vertical:"top",
                    horizontal:"right"
                }); 
                if($("#top3").val()==''){
                    $("#top3").focus();
                }
                else if($("#bottom2").val()==''){
                    $("#bottom2").focus();
                }
            }
		});
		
    });

    function checkNum(type){
        if(isNaN(parseFloat($('#'+type).val()))){
            $('#'+type).val('');
        }
    }
    function getProcessStat(){
        $.ajax({
            type: "POST",
            url: "api/get_process_stat",
            data: { 
                id:<? echo $lotto_list_id; ?>,
            },
            success: function(result){
                $("#show_stat").html(result);
            }
        });	
    }
    function sentProcess(){
        $.ajax({
            type: "POST",
            url: "api/process",
            data: { 
                id:<? echo $lotto_list_id; ?>,
            },
            beforeSend: function() {
				setInterval(getProcessStat, 1000);
			},
            success: function(result){
                if(result=='false'){
                    endProcess();
                }
                else{
                    $("#show_error").html(result);
                    setTimeout(processSuccess, 500);
                }
            }
        });	
    }
    function processSuccess(){
        Swal.fire({
            html: 'ประมวลผลเรียบร้อย !',
            type: 'success',
            confirmButtonText: ' ตกลง ',
            timer: 5000, 
            onClose: () => {
                window.location='lotto_list_end';
            }
        });
        $('#bt').html('<i class=\"fas fa-check\"></i> ประมวลผลเสร็จแล้ว');
        $('#bt').removeClass('disabled');
        $('#bt').prop('disabled',false);
    }
    
    function endProcess(){
        $('#process').hide();
        Swal.fire({
            html: 'มีผู้กำลังประมวลรายงานหวยนี้แล้ว !',
            type: 'error',
            confirmButtonText: ' ตกลง ',
            confirmButtonColor: '#CB4335',
            timer: 5000, 
            onClose: () => {
                window.location='lotto_list_end';
            }
        });
        $('#bt').removeClass('disabled');
        $('#bt').prop('disabled',false);
    }
</script>

