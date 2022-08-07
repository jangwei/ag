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
		checkLogin('lotto_receive');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();

		$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        if($user_type=='assistan'){
            $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        }
        else{
            $user_id = decode($_COOKIE["EASYLOTSID"]);
        }
		$user_data = $query->queryDB_to_row("SELECT * FROM user WHERE user_id = ".$user_id);
		
	?>
	<style>
		.input_box{
			min-width: 90px;
		}
	</style>
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
						HtmlCore::getMenu('lotto_receive');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						รายการตั้งรับ
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="">รายการหวย</li>
						<li class="active">รายการตั้งรับ</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						  <div class="col-md-12">
							  <div class="box box-primary">
								<div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">#</th>
                                                <th class="text-center" rowspan="2">ประเภทหวย</th>
                                                <th class="text-center" rowspan="2">หวย</th>
                                                <th class="text-center" rowspan="2" width="10%"><input type="checkbox" class="check" id="check_all"><br>ทั้งหมด </th>
                                                <th class="text-center">2 ตัวบน</th>
                                                <th class="text-center">2 ตัวล่าง</th>
                                                <th class="text-center">3 ตัวบน</th>
                                                <th class="text-center">3 ตัวโต๊ด</th>
                                                <th class="text-center">3 ตัวล่าง</th>
                                                <th class="text-center">วิ่งบน</th>
                                                <th class="text-center">วิ่งล่าง</th>
                                            </tr>
                                            <tr>
                                                <td><input type="number" class="form-control input_all input_box" min="0" max="100000" value="" id="top2"></td>
                                                <td><input type="number" class="form-control input_all input_box" min="0" max="100000" value="" id="bottom2"></td>
                                                <td><input type="number" class="form-control input_all input_box" min="0" max="100000" value="" id="top3"></td>
                                                <td><input type="number" class="form-control input_all input_box" min="0" max="100000" value="" id="toad3"></td>
                                                <td><input type="number" class="form-control input_all input_box" min="0" max="100000" value="" id="bottom3"></td>
                                                <td><input type="number" class="form-control input_all input_box" min="0" max="100000" value="" id="top1"></td>
                                                <td><input type="number" class="form-control input_all input_box" min="0" max="100000" value="" id="bottom1"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <form id="share_form">
                                        <?
											$sql = "SELECT * FROM lotto ORDER BY lotto_type_id,lotto_id" ;	
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
                                                        <td class="text-center"><input type="checkbox" class="check check_input" id="chk_'.$i.'"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="100" value="'.intval($receive['top2']).'" name="top2[]" id="top2_'.$i.'"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="100" value="'.intval($receive['bottom2']).'" name="bottom2[]" id="bottom2_'.$i.'"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="100" value="'.intval($receive['top3']).'" name="top3[]" id="top3_'.$i.'"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="100" value="'.intval($receive['toad3']).'" name="toad3[]" id="toad3_'.$i.'"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="100" value="'.intval($receive['bottom3']).'" name="bottom3[]" id="bottom3_'.$i.'"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="100" value="'.intval($receive['top1']).'" name="top1[]" id="top1_'.$i.'"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="100" value="'.intval($receive['bottom1']).'" name="bottom1[]" id="bottom1_'.$i.'"></td>
                                                    </tr>
                                                ';
												$count++; $i++;
                                            }
                                        ?>
                                        </form>
                                        </tbody>
                                    </table>
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

  </body>
</html>

<script>
$(function () {
	var count = <? echo $count; ?>;
	$(".input_all").keyup(function(e) {
        for(var i=1;i<=count;i++){
			if($("#chk_"+i).is(':checked')){
				$("#"+$(this).attr('id')+"_"+i).val($(this).val());
			}
		}
    });

	// $("#check_all").prop('checked', true);
	// $(".check_input").prop('checked', true);

 	$("#check_all").click(function(event){
		if($(this).is(':checked')){
			$(".check_input").prop('checked', true);
		}
		else{
			$(".check_input").prop('checked', false);
		}
	});

	$("#bt_edit").click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "api/edit_lotto_receive",
			data: $("#share_form").serialize(),
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

