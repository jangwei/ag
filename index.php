<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<link rel="shortcut icon" type="image/png" href="img/icon.png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="BB888Lotto เว็บเอเย่นหวยออนไลน์  หวยรัฐบาล  หวยหุ้น หวยต่างประเทศ">
    <meta property="og:image" content="img/icon.png">
    
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.css?1">
    <link rel="stylesheet" href="dist/css/skins/skin-black.css">
	<link href="css/all.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">

	<?
		include_once("api/core.php");
		include_once('indyEngine/engineControl.php');
		setInclude('dbControl');
		setPlugin('jquery,alert,hrefDefault');
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
		
		$query->queryDB_to_string('UPDATE user SET user_date_update="'.date('Y-m-d H:i:s').'" WHERE user_id='.decode($_COOKIE["EASYLOTSID"]));  
		
	?>
  </head>
  <body class="hold-transition skin-black" style="font-family: 'Kanit', sans-serif;">
		<img src="img/icon.png" style="display:none" alt="Meta tag picture">
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
						HtmlCore::getMenu('index');getNickName
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						รายงานผลประจำวัน
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<?
									$now = date('Y-m-d H:i:s');
									$today = date('Y-m-d');
									$lotto_lists = $query->queryDB_to_array("SELECT lotto_list_id FROM lotto_list WHERE lotto_list.lotto_list_date='".$today."'");
									$lists = '';
									foreach($lotto_lists as $key => $val){
										$lists .= $val['lotto_list_id'].',';
									}
									$lists = substr($lists,0,-1);
									$sum_recive = $query->queryDB_to_row('SELECT SUM(user_amount) AS sum_user , SUM(upline_amount) AS sum_head  FROM summary WHERE user_id='.$user_id.' AND lotto_list_id IN ('.$lists.')');
								?>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
								  	<div class="small-box bg-light-blue">
										<div class="inner">
											<h3 class="numberfm"><? echo number_format($sum_recive['sum_user']); ?> ฿</h3>
											<p>ยอดเข้า</p>
										</div>
										<div class="icons">
											<i class="fas fa-donate"></i>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
								  	<div class="small-box bg-green">
										<div class="inner">
											<h3 class="numberfm"><? echo number_format($sum_recive['sum_head']); ?> ฿</h3>
											<p>ยอดส่งออก</p>
										</div>
										<div class="icons">
										 	<i class="fas fa-share-square"></i>
										</div>
									</div>
								</div>
								<?
									$time_chk = date('Y-m-d H:i:s', strtotime('-10 minute'));
									countUser($user_id,$time_chk,$query);

									$count_user;
									$count_online;
									function countUser($user_id,$time_chk,$query){
										$GLOBALS['count_user'] += intval($query->queryDB_to_string('SELECT COUNT(user_id) FROM user WHERE head_id='.$user_id));
										$GLOBALS['count_online'] += intval($query->queryDB_to_string('SELECT COUNT(user_id) FROM user WHERE head_id='.$user_id.' AND user_date_update>"'.$time_chk.'"'));
										$users = $query->queryDB_to_array('SELECT user_id FROM user WHERE head_id='.$user_id);
										foreach($users as $key => $val){
											$chk = $query->queryDB_to_string('SELECT COUNT(user_id) FROM user WHERE head_id='.$val['user_id']);
											if($chk){
												countUser($val['user_id'],$time_chk,$query);
											}
										}
									}
								?>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
								  	<div class="small-box bg-yellow">
										<div class="inner">
											<h3 class="numberfm"><? echo number_format($count_user); ?> คน</h3>
											<p>สมาชิกในสาย</p>
										</div>
										<div class="icons">
											<i class="fas fa-users"></i>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
								  	<div class="small-box bg-purple">
										<div class="inner">
											<h3 class="numberfm"><? echo number_format($count_online); ?> คน</h3>
											<p>online</p>
										</div>
										<div class="icons">
											<i class="fas fa-laptop"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="box box box-solid">
								<div class="box-header text-center">
									<h3 class="box-title">
										<h2>ประกาศ‼️</h2>
									</h3>
								</div>
								<div class="box-body">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12 p-5">
											<?
												echo $query->queryDB_to_string('SELECT announce_detail FROM announce WHERE announce_name="agent"');
											?>
										</div>
									</div>
								</div>
							</div> 
						</div>
						<div class="col-md-8">
							<div class="box box box-solid">
								<div class="box-header">
									<h3 class="box-title">
										<b>รายงานผลงวดหวยวันนี้</b>
									</h3>
									<div class="box-tools pull-right p-1">
										<a href="reward_report">ดูผลทั้งหมด</a>
									</div>
								</div>
								<div class="box-body table-responsive ">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<?
												echo '
													<table class="table table-hover" id="db_table">
														<thead>
															<tr class="bg-navy">
																<th>#</th>
																<th>ประเภทหวย</th>
																<th>หวย</th>
																<th>สถานะ</th>
																<th>สามตัวบน</th>
																<th>สองตัวล่าง</th>
																<th>ตรวจบิล</th>
															</tr>
														</thead>
														<tbody>
													';
													$today = date("Y-m-d");
													$now = date('Y-m-d H:i:s');
													$time_chk = date('Y-m-d H:i:s', strtotime('-3 hour'));
													$sql = 'SELECT * FROM lotto_list WHERE lotto_list_date = "'.$today.'" AND lotto_list_end>"'.$time_chk.'"ORDER BY lotto_list_check DESC,lotto_list_end';
													$data = $query->queryDB_to_array($sql);
													foreach($data as $key => $val){
														$lotto = $query->queryDB_to_row('SELECT * FROM lotto WHERE lotto_id='.$val['lotto_id']);  
														$lotto_type = $query->queryDB_to_string('SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id='.$lotto['lotto_type_id']);  
														$no = str_pad($lotto['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($val['lotto_list_id'],3,'0',STR_PAD_LEFT); 
														$lotto_list_end = $val['lotto_list_end'];
														$chk=0;
														if($lotto_list_end<$now){
															$chk=1;
														}

														$announce = $query->queryDB_to_row('SELECT * FROM lotto_announce WHERE lotto_list_id='.$val['lotto_list_id']);
														if(!$announce){
															$str_td = '
																<td class="text-center">-</td>
																<td class="text-center">-</td>
																<td class="text-center"><button type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button></td>
															';
														}
														else{
															$str_td = '
																<td class="text-center"><span class="badge bg-maroon p-1 pl-3 pr-3 f-16"><b>'.$announce['top3'].'</b></span></td>
																<td class="text-center"><span class="badge bg-maroon p-1 pl-3 pr-3 f-16"><b>'.$announce['bottom2'].'</b></span></td>
																<td class="text-center"><button type="button" class="btn btn-primary" onClick="getBillReward('.$val['lotto_list_id'].')"><i class="fa fa-search"></i></button></td>
															';
														}
														echo '
															<tr>
																<td class="text-center">#'.$no.'</td>
																<td class="text-center">'.$lotto_type.'</td>
																<td class="text-left"><img src="'.$lotto['lotto_img'].'" class="lotimg"> '.$lotto['lotto_name'].'</td>
																<td class="text-center">'.getTextCheck($val['lotto_list_check'],$chk).'</td>
																'.$str_td.'
															</tr>
														';
													}
													echo '
														</tbody>
													</table>
													';

													function getTextCheck($type,$chk){
														if($type==1){
															return '<span class="label label-success">ออกรางวัลแล้ว</span>';
														}
														else{
															if($chk==1){
																return '<span class="label label-primary">รอออกรางวัล</span>';
															} 
															else{   
																return '<span class="label label-warning">ยังไม่ปิดรับ</span>';
															}
														}
													}	
											?>
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
                <div class="modal-body">
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
    dbTable();
});	

function getBillReward(id){
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
        "pageLength": 10,
        "order": [ [ 3, 'desc' ] ],
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

