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
		checkLogin('commission_setting');
		
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
						HtmlCore::getMenu('commission_setting');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						คอมมิชชั่น
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">ตั้งค่าสมาชิก</li>
						<li class="active">คอมมิชชั่น</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<form id="user_form" class="form-horizontal form-label-left">
									<div class="box-body">
										<div class="col-md-10 pb-4">
											<?
												$data = $query->queryDB_to_array("SELECT * FROM lotto_type ORDER BY lotto_type_id");
												$first_id = 0; $i = 0;
												foreach($data as $key => $val){
													echo '<button type="button" id="bf'.$val['lotto_type_id'].'" class="btn btn-lg p-2 m-1 btn-outline-primary bf" onClick="getDataType('.$val['lotto_type_id'].')">'.$val['lotto_type_name'].'</button>';
													if($i==0){
														$first_id = $val['lotto_type_id'];
													}
													$i++;
												}
											?>
											<div id="data_type"></div>
										</div>
										
										<div class="col-md-2 mt-1 pb-2 text-right">
											<label>ตัดลอกจากหวยอื่น</label>
											<select class="form-control" id="data_copy">
												<option value="0">ค่าตั้งต้น</option>
												<?
													$data = $query->queryDB_to_array('SELECT * FROM lotto ORDER BY lotto_type_id');
													foreach($data as $key => $val){
														echo '<option value="'.$val['lotto_id'].'">'.$val['lotto_name'].'</option>';
													}
												?>
											</select>
										</div>
										
										<div class="col-md-12 box_table">
											<div id="data_table" class="table-responsive"></div>
										</div>
									</div>
									<div class="box-footer text-center box_table">
										<button type="button" class="btn btn-primary p-2" id="bt_edit"><i class="fas fa-save"></i> บันทึก</button>
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

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/heatmap.js"></script>

  </body>
</html>

<script>
$(function () {
	$('.box_table').hide();   

	getDataType(<? echo $first_id; ?>);

	$("#bt_edit").click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "api/edit_user_commission",
			data: $("#user_form").serialize(),
			beforeSend: function() {
				$("#bt_edit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> รอการประมวลผล');
				$('#bt_edit').addClass('disabled');
				$('#bt_edit').prop('disabled',true);
			},
			success: function(result){
				$("#show_error").html(result);
				$("#bt_edit").html('<i class="fas fa-save"></i> บันทึก');
				$('#bt_edit').removeClass('disabled');
				$('#bt_edit').prop('disabled',false);
			}
		});	
	});

	$("#data_copy").change(function(event){
		$.ajax({
			type: "POST",
			url: "api/get_data_copy",
			data: {
				id : $("#data_copy").val(),
				type : "commission"
			},
			success: function(result){
				$("#show_error").html(result);
			}
		});	
	});
});

function setAll(type){	if(parseFloat($('#'+type+'_all').val())>=0){		$('.'+type).val($('#'+type+'_all').val());	}	else{		$('#'+type+'_all').val('');	}}

function getDataType(type){
	$('.bf').removeClass('btn-primary');
	$('#bf'+type).addClass('btn-primary');
	$.ajax({
		type: "POST",
		url: "api/get_data_type",
		data:{
			type : type
		},
		beforeSend: function(){
			$('.box_table').fadeOut(100); 
        },
		success: function(result){
			$('#data_type').html(result);
			$('#data_type').fadeIn();
		}
	});
}
function getDataTable(id,type=0){
	$('.bl').removeClass('btn-info');
	$('#bl_'+id).addClass('btn-info');
	$.ajax({
		type: "POST",
		url: "api/get_user_commission",
		data:{
			id : id,
			type : type
		},
		beforeSend: function() {  
			//$('#data_table').html('<div class="loading"><div class="loader">Loading...</div></div>');
			$('.box_table').fadeOut(100);        
        },
		success: function(result){
			$('#data_table').html(result);
			$('.box_table').fadeIn(); 
		}
	});
}

function editSuccess(str){
	Swal.fire({
		html: str,
		type: "success",
		confirmButtonText: " ตกลง ",
		confirmButtonColor: "#3085d6",
		timer: 3000, 
	});
}
</script>

