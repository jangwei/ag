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

    <style>
        .treeviews .btn-default {
	 border-color: #e3e5ef;
}
 .treeviews .btn-default:hover {
	 background-color: #f7faea;
	 color: #bada55;
}
 .treeviews ul {
	 list-style: none;
	 padding-left: 32px;
}
 .treeviews ul li {
	 padding: 50px 0px 0px 35px;
	 position: relative;
}
 .treeviews ul li:before {
	 content: "";
	 position: absolute;
	 top: -26px;
	 left: -31px;
	 border-left: 2px dashed #a2a5b5;
	 width: 1px;
	 height: 100%;
}
 .treeviews ul li:after {
	 content: "";
	 position: absolute;
	 border-top: 2px dashed #a2a5b5;
	 top: 70px;
	 left: -30px;
	 width: 65px;
}
 .treeviews ul li:last-child:before {
	 top: -22px;
	 height: 90px;
}
 .treeviews > ul > li:after, .treeviews > ul > li:last-child:before {
	 content: unset;
}
 .treeviews > ul > li:before {
	 top: 90px;
	 left: 36px;
}
 .treeviews > ul > li:not(:last-child) > ul > li:before {
	 content: unset;
}
 .treeviews > ul > li > .treeviews__level:before {
	 height: 60px;
	 width: 60px;
	 top: -9.5px;
	 border: 7.5px solid #b3e6b3;
	 background-color: #66cc66;
	 font-size: 22px;
}
 .treeviews > ul > li > ul {
	 padding-left: 34px;
}
 .treeviews__level {
	 padding: 7px;
	 padding-left: 42.5px;
	 display: inline-block;
	 border-radius: 5px;
	 font-weight: 700;
	 border: 1px solid #e3e5ef;
	 position: relative;
	 z-index: 1;
}
 .treeviews__level:before {
	 content: attr(data-level);
	 position: absolute;
	 left: -27.5px;
	 top: -6.5px;
	 display: flex;
	 align-items: center;
	 justify-content: center;
	 height: 55px;
	 width: 55px;
	 border-radius: 50%;
	 background-color: #54a6d9;
	 border: 7.5px solid #d5e9f6;
	 color: #fff;
	 font-size: 20px;
}
 .treeviews__level-btns {
	 margin-left: 15px;
	 display: inline-block;
	 position: relative;
}
 .treeviews__level .level-same, .treeviews__level .level-sub {
	 position: absolute;
	 display: none;
	 transition: opacity 250ms cubic-bezier(0.7, 0, 0.3, 1);
}
 .treeviews__level .level-same.in, .treeviews__level .level-sub.in {
	 display: block;
}
 .treeviews__level .level-same.in .btn-default, .treeviews__level .level-sub.in .btn-default {
	 background-color: #faeaea;
	 color: #da5555;
}
 .treeviews__level .level-same {
	 top: 0;
	 left: 45px;
}
 .treeviews__level .level-sub {
	 top: 42px;
	 left: 0px;
}
 .treeviews__level .level-remove {
	 display: none;
}
 .treeviews__level.selected {
	 background-color: #f9f9fb;
	 box-shadow: 0px 3px 15px 0px rgba(0, 0, 0, 0.10);
}
 .treeviews__level.selected .level-remove {
	 display: inline-block;
}
 .treeviews__level.selected .level-add {
	 display: none;
}
 .treeviews__level.selected .level-same, .treeviews__level.selected .level-sub {
	 display: none;
}
 .treeviews .level-title {
	 user-select: none;
}
 .treeviews .level-title:hover {
}
 .treeviews--mapview ul {
	 justify-content: center;
	 display: flex;
}
 .treeviews--mapview ul li:before {
	 content: unset;
}
 .treeviews--mapview ul li:after {
	 content: unset;
}
 
    </style>
	<?
		include_once("api/core.php");
		include_once('indyEngine/engineControl.php');
		setInclude('dbControl');
		setPlugin('jquery,alert,hrefDefault');
		checkLogin('user_tree');
		
		HtmlCore::getTitle();
        
        $query = new DBControl();
		$user_id = decode($_COOKIE['EASYLOTSID']);
		$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".$user_id);

		if($user_type=='assistan'){
			$head_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".$user_id);
			$user_data = $query->queryDB_to_row("SELECT * FROM user WHERE user_id = ".$head_id);
			$user_id = $user_data['user_id'];
		}
		else{
			$user_data = $query->queryDB_to_row("SELECT * FROM user WHERE user_id = ".$user_id);
		}
		
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
						HtmlCore::getMenu('user_tree');
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						แผนผังสายงาน
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">จัดการสมาชิก</li>
						<li class="active">แผนผังสายงาน</li>
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-body table-responsive">
                                    <div class="treeviews js-treeviews pb-4">
                                        <?
                                            $c = $query->queryDB_to_string("SELECT COUNT(user_id) FROM user WHERE head_id=".$user_data['user_id']);
                                            getTree(1,$c,1,$user_data['user_id'],$query);
                                        
                                            function getTree($i,$n,$m,$user_id,$query){
                                                $udata = $query->queryDB_to_row("SELECT * FROM user WHERE user_id=".$user_id.' ORDER BY user_type');
												if($udata['user_type']!='assistan'){
													if($m==1){
														echo '<ul>';
													}
													echo '<li>';
													echo '<div class="treeviews__level" data-level="'.$i.'">'.getUserType($udata['user_type']).' <span class="level-title">'.$udata['user_username'].' <small>( '.$udata['user_name'].' '.$udata['user_lastname'].' )</small></span></div>';
												}
												$chk = $query->queryDB_to_string("SELECT COUNT(user_id) FROM user WHERE head_id=".$user_id);
                                                if($chk){
                                                    $i++;
													$j=1;
                                                    $cdata = $query->queryDB_to_array("SELECT * FROM user WHERE head_id=".$user_id." ORDER BY user_type");
                                                    foreach($cdata as $key => $val){
														$c = $query->queryDB_to_string("SELECT COUNT(user_id) FROM user WHERE head_id=".$val['head_id']);
                                            			getTree($i,$c,$j,$val['user_id'],$query);
														$j++;
                                                    }
                                                }
												echo '</li>';
												if($m==$n){
													echo '</ul>';
												}
                                            }

											function getUserType($type){
												if($type=='agent'){
													return '<span class="badge bg-primary">Agent</span>';
												}
												else if($type=='admin'){
													return '<span class="badge bg-navy">Admin</span>';
												}
												else if($type=='member'){
													return '<span class="badge bg-success">Member</span>';
												}
											}
                                        ?>
                                        
										
                                        
                                        

                                    </div>
							    </div> 
                                <div class="box-footer">
                                    
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
	

</script>

