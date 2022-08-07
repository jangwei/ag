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
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">รายการหวย</li>
						<li class="active">ประมวลผลรายการหวย</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
                                    <h3 class="box-title"><b>รายการหวยที่ปิดรับแล้ว</b></h3>
								</div>
								<div class="box-body table-responsive ">
                                	<table class="table table-hover table-striped"  id="data_table">
                                        <thead>
                                            <tr class="bg-navy">
                                                <th>#</th>
                                                <th>ประเภทหวย</th>
                                                <th>หวย</th>
                                                <th>งวด</th>
                                                <th>วันที่ปิดรับ</th>
                                                <th>เวลาปิดรับ</th>
                                                <th>ประมวลผล</th>
                                                
                                            </tr>
										</thead>
										<tbody>
                                            <?
                                                $now = date('Y-m-d H:i:s');
												$sql = "SELECT * FROM lotto_list WHERE lotto_list_check=0 AND lotto_list_end<'".$now."'";	
                                                $lotto_data = $query->queryDB_to_array($sql);
                                                foreach($lotto_data as $key => $val){
													$lotto = $query->queryDB_to_row("SELECT * FROM lotto WHERE lotto_id=".$val['lotto_id']);
													$lotto_type = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$lotto['lotto_type_id']);
													echo '
														<tr>
															<td>#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($val['lotto_list_id'],4,'0',STR_PAD_LEFT).'</td>
															<td>'.$lotto_type.'</td>
															<td><img src="'.$lotto['lotto_img'].'" class="lotimg"> '.$lotto['lotto_name'].'</td>
															<td class="text-center">'.getTextDateTH($val['lotto_list_date']).'</td>
															<td class="text-center">'.getTextDateTH($val['lotto_list_end']).'</td>
															<td class="text-center">'.getTextTime($val['lotto_list_end']).'</td>
															<td><a href="lotto_list_process?id='.$val['lotto_list_id'].'"><button class="btn btn-block btn-primary" title="ประมวลผล"><i class="fa fa-cogs"></i>&nbsp;&nbsp;ประมวลผล</button></a></td>
														</tr>
													';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?
                                        function getBT($id,$chk){
                                            if($chk==1){
                                                return  '
                                                    <label class="switch">
                                                        <input id="sys_pincode" type="checkbox" onChange="updateStatus('.$id.',0)" checked>
                                                        <span class="slider round"></span>
                                                    </label>
                                                ';
                                            }
                                            else{
                                                return  '
                                                    <label class="switch">
                                                        <input id="sys_pincode" type="checkbox" onChange="updateStatus('.$id.',1)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                ';
                                            }
                                        }
                                    ?>
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
	
  </body>
</html>

<script>
$( function() {
	dbTable();
});

function dbTable(){
    $("#data_table").dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 100,
        "order": [ [ 4, 'asc' ],[ 5, 'asc' ] ],
        "language": {
            "emptyTable": "ไม่พบข้อมูล",
            "search": "ค้าหา :"
        }
    });
}
</script>

