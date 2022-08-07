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
    <style>
        .menubg {
            width: 100%;
            height: 100vh;
            z-index:99990;
            position:fixed;
            top:0px;
            left:0px;
            background-color: #000;
            opacity: 0.7;
            filter: alpha(opacity=70);
            display:none;
            padding-top:200px; 
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
						HtmlCore::getMenu('re_process');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
					 	ประมวลผลรายการหวยใหม่
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">รายการหวย</li>
						<li class="active">ประมวลผลรายการหวยใหม่</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
                                    <h3 class="box-title"><b>รายการหวยที่ประมวลผลแล้ว</b></h3>
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
                                                <th>ประมวลบิล</th>
                                                <th>จ่ายเงิน</th>
                                                <th>รายงาน</th>
                                                <th>backup</th>
                                                <th>ประมวลผล</th>
                                                
                                            </tr>
										</thead>
										<tbody>
                                            <?
                                                $now = date('Y-m-d H:i:s');
                                                $date = date('Y-m-d');
												$sql = "SELECT * FROM lotto_list WHERE lotto_list_check=1 ORDER BY lotto_list_end DESC LIMIT 0,50";	
												//$sql = "SELECT * FROM lotto_list WHERE lotto_list_date ='2022-01-17'";	
                                                $lotto_data = $query->queryDB_to_array($sql);
                                                foreach($lotto_data as $key => $val){
													$lotto = $query->queryDB_to_row("SELECT * FROM lotto WHERE lotto_id=".$val['lotto_id']);
													$lotto_type = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$lotto['lotto_type_id']);
													echo '
														<tr>
															<td class="text-center">#'.str_pad($val['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($val['lotto_list_id'],4,'0',STR_PAD_LEFT).'<br><small>[ '.number_format($val['lotto_list_record']).' : '.number_format($val['lotto_list_process_time'],2).' ]</samll></td>
															<td>'.$lotto_type.'</td>
															<td><img src="'.$lotto['lotto_img'].'" class="lotimg"> '.$lotto['lotto_name'].'</td>
															<td class="text-center">'.getTextDateTH2($val['lotto_list_date']).'</td>
															<td class="text-center"><small>'.getTextDate($val['lotto_list_end'],'/').'<br>'.getTextTime($val['lotto_list_end']).'</small></td>
															<td class="text-center">'.getTextProcess($val['lotto_list_process_bill']).'</td>
															<td class="text-center">'.getTextProcess($val['lotto_list_process_pay']).'</td>
															<td class="text-center">'.getTextProcess($val['lotto_list_process_summary']).'</td>
															<td class="text-center">'.getTextProcess($val['lotto_list_process_backup']).'</td>
															<td><a href="#" onClick="sentProcess('.$val['lotto_list_id'].')"><button class="btn btn-block btn-danger" title="ประมวลผลใหม่"><i class="fa fa-cogs"></i>&nbsp;&nbsp;ประมวลผลใหม่</button></a></td>
														</tr>
													';
                                                }

                                                function getTextProcess($stat){
                                                    if($stat==1){
                                                        return '<span class="label label-success"> <i class="fa fa-check"></i> ผ่าน</span>';
                                                    }
                                                    else{
                                                        return '<span class="label label-warning"><i class="fa fa-times"></i> ไม่ผ่าน</span>';
                                                    }
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
                                        function getStrDate($date){
                                            return str_replace("-","/",$date);
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

    <div class="menubg text-center">
        <div class="loading">
            <h2>ระบบกำลังประมวลผล</h2><h3>อย่าทำการปิดหรือรีเฟรชหน้านี้ !</h3>
            <div class="loader">Loading...</div>
        </div>
        
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

function sentProcess(id){
    Swal.fire({
        html: 'แน่ใจหรือไม่ที่จะประมวลผลใหม่ ?',
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#CB4335',
        cancelButtonText: 'ยกเลิก',
    }).then((result) => {
        if (result.value) {
            $(".menubg").fadeIn();
            $.ajax({
                type: "POST",
                url: "api/reprocess_lotto",
                data: { 
                    id:id,
                },
                success: function(result){
                    $("#show_error").html(result);
                }
            });	
        } 
    });
}

function dbTable(){
    $("#data_table").dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 100,
        "order": [ [ 4, 'desc' ] ],
        "language": {
            "emptyTable": "ไม่พบข้อมูล",
            "search": "ค้าหา :"
        }
    });
}
</script>

