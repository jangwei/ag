<?
if($_GET['type']==''){
    echo '<script> window.location="404"; </script>';
}
if($_GET['type']!='agent' && $_GET['type']!="member"){
    echo '<script> window.location="404"; </script>';
}
?>
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
		setPlugin('jquery,alert,hrefDefault');
		checkLogin('user_create?type='.$_GET['type']);
		
		HtmlCore::getTitle();
        
        $query = new DBControl();

        $user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        if($user_type=='assistan'){
            $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
        }
        else{
            $user_id = decode($_COOKIE["EASYLOTSID"]);
        }

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
						HtmlCore::getMenu($_GET['type']);
					?>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>
                        <?
                            if($_GET['type']=='agent'){
                                echo 'เพิ่มเอเย่น';
                            }
                            else{
                                echo 'เพิ่มเมมเบอร์';
                            }
                        ?>
						<? HtmlCore::getNickName(); ?>
					</h1>
					<ol class="breadcrumb">
						<li><a href="index"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">จัดการสมาชิก</li>
                        <?
                            if($_GET['type']=='agent'){
                                echo '<li class="active">เพิ่มเอเย่น</li>';
                            }
                            else{
                                echo '<li class="active">เพิ่มเมมเบอร์</li>';
                            }
                        ?>
						
					</ol>
				</section>

				<section class="content" style="font-family: 'Kanit'">
					
					<div class="row">
						<div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <b>ข้อมูลผู้ใช้</b>
                                    </h3>
                                </div>
								<div class="box-body" id="show">
                                     <form id="user_form">
                                     <div class="row p-2">
                                        <input type="hidden" name="user_type" value="<? echo $_GET['type']; ?>">									
                                        
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="form-group" style="padding-right:10px;">
                                                <label>ชื่อผู้ใช้ *<code><small>รหัสผ่านตั้งต้น 123456</small></code></label>
                                            <? if($user_data['user_type']=='admin' || $_GET['type']=='member'){ ?>
                                                <input type="text" class="form-control" placeholder="Username ..." name="user_username" id="user_username" required>
                                            <? 
                                            } 
                                            else{ 
                                            ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><? echo $user_data['user_username'];?></span>
                                                    <input type="hidden" name="user_username_add" value="<? echo $user_data['user_username'];?>">
                                                    <input type="text" class="form-control" placeholder="Username" name="user_username" id="user_username" required>
                                                </div>
                                            <? } ?>
                                            </div>
										</div>

                                        <div class="col-md-5 col-sm-5 col-xs-12">
											<div class="form-group" style="padding-right:10px;">
												<label>ชื่อ *</label>
												<input type="text" class="form-control" placeholder="ชื่อ ..." name="user_name" id="fuser_name" required>
											</div>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="form-group" style="padding-right:10px;">
												<label>นามสกุล</label>
												<input type="text" class="form-control" placeholder="นามสกุล ..." name="user_lastname">
											</div>
                                        </div>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="form-group" style="padding-right:10px;">
												<label>เบอร์โทร</label>
												<input type="text" class="form-control" placeholder="เบอร์โทร ..." name="user_phone">
											</div>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="form-group" style="padding-right:10px;">
												<label>Line id</label>
												<input type="text" class="form-control" placeholder="line id ..." name="user_line_id">
											</div>
										</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 pb-4 pt-4">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h4 class="box-title"><b>ตั้งค่าเริ่มต้น</b></h4>
                                                    <button type="button" id="bf1" class="btn p-2 m-1 mb-2 btn-outline-primary btn-primary btn-lg"><? if($_GET['type']=='member'){ echo '1. ถือหุ้น'; }  else{ echo '1. ส่วนแบ่งหุ้น'; } ?></button>
                                                    <button type="button" id="bf2" class="btn p-2 m-1 mb-2 btn-outline-primary btn-lg">2. คอมมิชชั่น</button>
                                                    <button type="button" id="bf3" class="btn p-2 m-1 mb-2 btn-outline-primary btn-lg">3. อัตราจ่าย</button>
                                                    <button type="button" id="bf4" class="btn p-2 m-1 mb-2 btn-outline-primary btn-lg">4. แทงสูงสุด</button>
                                                </div>
                                                <div class="col-md-3 mt-1 pt-4 text-right">
                                                    <label>ตัดลอกจากสมาชิก</label>
                                                    <select class="form-control" id="user_copy">
                                                        <option value="0">ค่าตั้งต้น</option>
                                                        <?
                                                            $data = $query->queryDB_to_array('SELECT * FROM user WHERE head_id = '.$user_id.' AND user_type="'.$_GET['type'].'"');
                                                            foreach($data as $key => $val){
                                                                echo '<option value="'.$val['user_id'].'">'.$val['user_name'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
										<div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="form1">
                                            <h4 class="box-title"><b><? if($_GET['type']=='member'){ echo 'ถือหุ้น'; }  else{ echo 'ส่วนแบ่งหุ้น'; } ?></b></h4>
                                            <table class="table table-bordered table-sm table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" rowspan="2">#</th>
                                                        <th class="text-center" rowspan="2">กลุ่มหวย</th>
                                                        <th class="text-center" rowspan="2">หวย</th>
                                                        <th class="text-center" rowspan="2">ที่ได้รับมา</th>
                                                    <?
                                                    if($_GET['type']=='member'){
                                                    echo '
                                                        <th class="text-center">เก็บไว้ (เข้าตัวเรา)</th>
                                                        <th class="text-center">ผลักขึ้นสายบน</th>
                                                    ';
                                                    }
                                                    else{
                                                    echo '
                                                        <th class="text-center">แบ่งหุ้น (ให้เอเยนต์)</th>
                                                        <th class="text-center">เก็บไว้ (เข้าตัวเรา)</th>
                                                    ';
                                                    }
                                                    ?>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center"><input type="number" class="form-control" id="share_all" min="0" max="100" step="0.5"></th>
                                                        <th class="text-center"><input type="number" class="form-control" max="100" step="0.5" disabled></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                    $count=0; $i=1;
                                                    $data = $query->queryDB_to_array("SELECT * FROM lotto INNER JOIN lotto_type ON lotto.lotto_type_id = lotto_type.lotto_type_id  ORDER BY lotto.lotto_type_id ");
                                                    foreach($data as $key => $val){
                                                        $user_share = $query->queryDB_to_string("SELECT share FROM lotto_user_share WHERE lotto_id=".$val['lotto_id']."  AND user_id=".$user_id);
                                                        if($user_share==0 && $user_share==''){
                                                            if($user_data['user_type']=='admin' ){
                                                                $query->queryDB('INSERT INTO lotto_user_share (lotto_id,user_id,share) VALUES ('.$val['lotto_id'].','.$user_id.',100)');
                                                                $user_share = 100;
                                                            }
                                                            else{
                                                                $user_share = 0;
                                                            }
                                                        }
                                                        echo '
                                                            <tr>
                                                                <th class="text-center">'.$i.'</th>
                                                                <td class="text-center">'.$val['lotto_type_name'].'</td>
                                                                <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>
                                                                <td class="text-center">'.$user_share.' %</td>
                                                                <td>
                                                                    <input type="hidden" name="lotto_id[]" value="'.$val['lotto_id'].'">
                                                                    <input type="hidden" name="lotto_head_share[]" id="owner_'.$val['lotto_id'].'" value="'.$user_share.'">
                                                                    <input type="number" name="lotto_user_share[]" id="share_'.$val['lotto_id'].'" class="form-control share" min="0" max="'.$user_share.'" step="0.5" value="'.$user_share.'" required>
                                                                </td>
                                                                <td><input type="number" id="keep_'.$val['lotto_id'].'" class="form-control" min="0" max="100" step="0.5" value="0" disabled></td>
                                                            </tr>
                                                        ';
                                                        $i++; $count++;
                                                    }
                                                ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </form>
                                    <form id="user_form2">
                                        <input type="hidden" id="user_id2" name="user_id2">
                                        <div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="form2">
                                            <h4 class="box-title"><b>คอมมิชชั่น</b></h4>
                                            <table class="table table-bordered table-sm table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" rowspan="2">#</th>
                                                        <th class="text-center" rowspan="2">กลุ่มหวย</th>
                                                        <th class="text-center" rowspan="2">หวย</th>
                                                        <th class="text-center">2 ตัวบน</th>
                                                        <th class="text-center">2 ตัวล่าง</th>
                                                        <th class="text-center">3 ตัวบน</th>
                                                        <th class="text-center">3 ตัวล่าง</th>
                                                        <th class="text-center">3 ตัวโต๊ด</th>
                                                        <th class="text-center">วิ่งบน</th>
                                                        <th class="text-center">วิ่งล่าง</th>
                                                    </tr>
                                                    <tr>
                                                        <th><input type="number" class="form-control" min="0" max="100" step="0.5" onKeyup="setAll('c_top2')" id="c_top2_all"></th>
                                                        <th><input type="number" class="form-control" min="0" max="100" step="0.5" onKeyup="setAll('c_bottom2')" id="c_bottom2_all"></th>
                                                        <th><input type="number" class="form-control" min="0" max="100" step="0.5" onKeyup="setAll('c_top3')" id="c_top3_all"></th>
                                                        <th><input type="number" class="form-control" min="0" max="100" step="0.5" onKeyup="setAll('c_toad3')" id="c_toad3_all"></th>
                                                        <th><input type="number" class="form-control" min="0" max="100" step="0.5" onKeyup="setAll('c_bottom3')" id="c_bottom3_all"></th>
                                                        <th><input type="number" class="form-control" min="0" max="100" step="0.5" onKeyup="setAll('c_top1')" id="c_top1_all"></th>
                                                        <th><input type="number" class="form-control" min="0" max="100" step="0.5" onKeyup="setAll('c_bottom1')" id="c_bottom1_all"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                    $i=1;
                                                    foreach($data as $key => $val){
                                                        $head_val = $query->queryDB_to_row("SELECT * FROM lotto_user_commission WHERE lotto_id=".$val['lotto_id']."  AND user_id=".$user_id);
                                                        if(!$head_val){
                                                            if($user_data['user_type']=='admin' ){
                                                                $query->queryDB('INSERT INTO lotto_user_commission (lotto_id,user_id,top2,bottom2,top3,toad3,bottom3,top1,bottom1) VALUES ('.$val['lotto_id'].','.$user_id.',4,4,15,15,15,12,12)');
                                                            }
                                                        }
                                                        if($head_val['top2']==''){
                                                            $head_val['top2'] = 0;
                                                        }
                                                        if($head_val['bottom2']==''){
                                                            $head_val['bottom2'] = 0;
                                                        }
                                                        if($head_val['top3']==''){
                                                            $head_val['top3'] = 0;
                                                        }
                                                        if($head_val['toad3']==''){
                                                            $head_val['toad3'] = 0;
                                                        }
                                                        if($head_val['bottom3']==''){
                                                            $head_val['bottom3'] = 0;
                                                        }
                                                        if($head_val['top1']==''){
                                                            $head_val['top1'] = 0;
                                                        }
                                                        if($head_val['bottom1']==''){
                                                            $head_val['bottom1'] = 0;
                                                        }
                                                        echo '
                                                        <tr>
                                                            <th class="text-center"><input type="hidden" name="lotto_id2[]" value="'.$val['lotto_id'].'">'.$i.'</th>
                                                            <td class="text-center">'.$val['lotto_type_name'].'</td>
                                                            <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>
                                                            <td><input type="number" class="form-control c_top2" name="c_top2[]" id="c_top2_'.$val['lotto_id'].'" min="0" max="'.$head_val['top2'].'" step="0.5" value="'.$head_val['top2'].'" required></td>
                                                            <td><input type="number" class="form-control c_bottom2" name="c_bottom2[]" id="c_bottom2_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom2'].'" step="0.5" value="'.$head_val['bottom2'].'" ></td>
                                                            <td><input type="number" class="form-control c_top3" name="c_top3[]" id="c_top3_'.$val['lotto_id'].'" min="0" max="'.$head_val['top3'].'" step="0.5" value="'.$head_val['top3'].'" required></td>
                                                            <td><input type="number" class="form-control c_toad3" name="c_toad3[]" id="c_toad3_'.$val['lotto_id'].'" min="0" max="'.$head_val['toad3'].'" step="0.5" value="'.$head_val['toad3'].'" required></td>
                                                            <td><input type="number" class="form-control c_bottom3" name="c_bottom3[]" id="c_bottom3_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom3'].'" step="0.5" value="'.$head_val['bottom3'].'" required></td>
                                                            <td><input type="number" class="form-control c_top1" name="c_top1[]" id="c_top1_'.$val['lotto_id'].'" min="0" max="'.$head_val['top1'].'" step="0.5" value="'.$head_val['top1'].'" required></td>
                                                            <td><input type="number" class="form-control c_bottom1" name="c_bottom1[]" id="c_bottom1_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom1'].'" step="0.5" value="'.$head_val['bottom1'].'" required></td>
                                                        </tr>
                                                        ';
                                                        $i++;
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <form id="user_form3">
                                        <input type="hidden" id="user_id3" name="user_id3">
										<div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="form3">
                                            <h4 class="box-title"><b>อัตราจ่าย</b></h4>
                                            <table class="table table-bordered table-sm table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" rowspan="2">#</th>
                                                        <th class="text-center" rowspan="2">กลุ่มหวย</th>
                                                        <th class="text-center" rowspan="2">หวย</th>
                                                        <th class="text-center">2 ตัวบน</th>
                                                        <th class="text-center">2 ตัวล่าง</th>
                                                        <th class="text-center">3 ตัวบน</th>
                                                        <th class="text-center">3 ตัวล่าง</th>
                                                        <th class="text-center">3 ตัวโต๊ด</th>
                                                        <th class="text-center">วิ่งบน</th>
                                                        <th class="text-center">วิ่งล่าง</th>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="number" class="form-control" min="0" max="1000" step="1" onKeyup="setAll('r_top2')" id="r_top2_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="1000" step="1" onKeyup="setAll('r_bottom2')" id="r_bottom2_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="1000" step="1" onKeyup="setAll('r_top3')" id="r_top3_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="1000" step="1" onKeyup="setAll('r_toad3')" id="r_toad3_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="1000" step="1" onKeyup="setAll('r_bottom3')" id="r_bottom3_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="1000" step="1" onKeyup="setAll('r_top1')" id="r_top1_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="1000" step="1" onKeyup="setAll('r_bottom1')" id="r_bottom1_all"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                    $i=1;
                                                    foreach($data as $key => $val){
                                                        $head_val = $query->queryDB_to_row("SELECT * FROM lotto_user_rate WHERE lotto_id=".$val['lotto_id']."  AND user_id=".$user_id);
                                                        if(!$head_val){
                                                            if($user_data['user_type']=='admin' ){
                                                                $query->queryDB('INSERT INTO lotto_user_rate (lotto_id,user_id,top2,bottom2,top3,toad3,bottom3,top1,bottom1) VALUES ('.$val['lotto_id'].','.$user_id.',96,96,800,125,125,3,4)');
                                                            }
                                                        }
                                                        if($head_val['top2']==''){
                                                            $head_val['top2'] = 0;
                                                        }
                                                        if($head_val['bottom2']==''){
                                                            $head_val['bottom2'] = 0;
                                                        }
                                                        if($head_val['top3']==''){
                                                            $head_val['top3'] = 0;
                                                        }
                                                        if($head_val['toad3']==''){
                                                            $head_val['toad3'] = 0;
                                                        }
                                                        if($head_val['bottom3']==''){
                                                            $head_val['bottom3'] = 0;
                                                        }
                                                        if($head_val['top1']==''){
                                                            $head_val['top1'] = 0;
                                                        }
                                                        if($head_val['bottom1']==''){
                                                            $head_val['bottom1'] = 0;
                                                        }
                                                        echo '
                                                        <tr>
                                                            <th class="text-center"><input type="hidden" name="lotto_id3[]" value="'.$val['lotto_id'].'">'.$i.'</th>
                                                            <td class="text-center">'.$val['lotto_type_name'].'</td>
                                                            <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>
                                                            <td><input type="number" class="form-control r_top2" name="r_top2[]" id="r_top2_'.$val['lotto_id'].'" min="0" max="'.$head_val['top2'].'" step="1" value="'.$head_val['top2'].'" required></td>
                                                            <td><input type="number" class="form-control r_bottom2" name="r_bottom2[]" id="r_bottom2_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom2'].'" step="1" value="'.$head_val['bottom2'].'" required></td>
                                                            <td><input type="number" class="form-control r_top3" name="r_top3[]" id="r_top3_'.$val['lotto_id'].'" min="0" max="'.$head_val['top3'].'" step="1" value="'.$head_val['top3'].'" required></td>
                                                            <td><input type="number" class="form-control r_toad3" name="r_toad3[]" id="r_toad3_'.$val['lotto_id'].'" min="0" max="'.$head_val['toad3'].'" step="1" value="'.$head_val['toad3'].'" required></td>
                                                            <td><input type="number" class="form-control r_bottom3" name="r_bottom3[]" id="r_bottom3_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom3'].'" step="1" value="'.$head_val['bottom3'].'" required></td>
                                                            <td><input type="number" class="form-control r_top1" name="r_top1[]" id="r_top1_'.$val['lotto_id'].'" min="0" max="'.$head_val['top1'].'" step="1" value="'.$head_val['top1'].'" required></td>
                                                            <td><input type="number" class="form-control r_bottom1" name="r_bottom1[]" id="r_bottom1_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom1'].'" step="1" value="'.$head_val['bottom1'].'" required></td>
                                                        </tr>
                                                        ';
                                                        $i++;
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <form id="user_form4">
                                        <input type="hidden" id="user_id4" name="user_id4">
                                        <div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="form4">
                                            <h4 class="box-title"><b>แทงสูงสุด</b></h4>
                                            <table class="table table-bordered table-sm table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" rowspan="2">#</th>
                                                        <th class="text-center" rowspan="2">กลุ่มหวย</th>
                                                        <th class="text-center" rowspan="2">หวย</th>
                                                        <th class="text-center">2 ตัวบน</th>
                                                        <th class="text-center">2 ตัวล่าง</th>
                                                        <th class="text-center">3 ตัวบน</th>
                                                        <th class="text-center">3 ตัวล่าง</th>
                                                        <th class="text-center">3 ตัวโต๊ด</th>
                                                        <th class="text-center">วิ่งบน</th>
                                                        <th class="text-center">วิ่งล่าง</th>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="1000" onKeyup="setAll('l_top2')" id="l_top2_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="1000" onKeyup="setAll('l_bottom2')" id="l_bottom2_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="1000" onKeyup="setAll('l_top3')" id="l_top3_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="1000" onKeyup="setAll('l_toad3')" id="l_toad3_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="1000" onKeyup="setAll('l_bottom3')" id="l_bottom3_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="1000" onKeyup="setAll('l_top1')" id="l_top1_all"></td>
                                                        <td><input type="number" class="form-control" min="0" max="100000" step="1000" onKeyup="setAll('l_bottom1')" id="l_bottom1_all"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                    $i=1;
                                                    foreach($data as $key => $val){
                                                        $head_val = $query->queryDB_to_row("SELECT * FROM lotto_user_limit WHERE lotto_id=".$val['lotto_id']."  AND user_id=".$user_id);
                                                        if(!$head_val){
                                                            if($user_data['user_type']=='admin' ){
                                                                $query->queryDB('INSERT INTO lotto_user_limit (lotto_id,user_id,top2,bottom2,top3,toad3,bottom3,top1,bottom1) VALUES ('.$val['lotto_id'].','.$user_id.',10000,10000,10000,10000,10000,10000,10000)');
                                                            }
                                                        }
                                                        if($head_val['top2']==''){
                                                            $head_val['top2'] = 0;
                                                        }
                                                        if($head_val['bottom2']==''){
                                                            $head_val['bottom2'] = 0;
                                                        }
                                                        if($head_val['top3']==''){
                                                            $head_val['top3'] = 0;
                                                        }
                                                        if($head_val['toad3']==''){
                                                            $head_val['toad3'] = 0;
                                                        }
                                                        if($head_val['bottom3']==''){
                                                            $head_val['bottom3'] = 0;
                                                        }
                                                        if($head_val['top1']==''){
                                                            $head_val['top1'] = 0;
                                                        }
                                                        if($head_val['bottom1']==''){
                                                            $head_val['bottom1'] = 0;
                                                        }
                                                        echo '
                                                        <tr>
                                                            <th class="text-center"><input type="hidden" name="lotto_id4[]" value="'.$val['lotto_id'].'">'.$i.'</th>
                                                            <td class="text-center">'.$val['lotto_type_name'].'</td>
                                                            <td><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</td>
                                                            <td><input type="number" class="form-control l_top2" name="l_top2[]" id="l_top2_'.$val['lotto_id'].'" min="0" max="'.$head_val['top2'].'" step="1000" value="'.$head_val['top2'].'"></td>
                                                            <td><input type="number" class="form-control l_bottom2" name="l_bottom2[]" id="l_bottom2_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom2'].'" step="1000" value="'.$head_val['bottom2'].'"></td>
                                                            <td><input type="number" class="form-control l_top3" name="l_top3[]" id="l_top3_'.$val['lotto_id'].'" min="0" max="'.$head_val['top3'].'" step="1000" value="'.$head_val['top3'].'"></td>
                                                            <td><input type="number" class="form-control l_toad3" name="l_toad3[]" id="l_toad3_'.$val['lotto_id'].'" min="0" max="'.$head_val['toad3'].'" step="1000" value="'.$head_val['toad3'].'"></td>
                                                            <td><input type="number" class="form-control l_bottom3" name="l_bottom3[]" id="l_bottom3_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom3'].'" step="1000" value="'.$head_val['bottom3'].'"></td>
                                                            <td><input type="number" class="form-control l_top1" name="l_top1[]" id="l_top1_'.$val['lotto_id'].'" min="0" max="'.$head_val['top1'].'" step="1000" value="'.$head_val['top1'].'"></td>
                                                            <td><input type="number" class="form-control l_bottom1" name="l_bottom1[]" id="l_bottom1_'.$val['lotto_id'].'" min="0" max="'.$head_val['bottom1'].'" step="1000" value="'.$head_val['bottom1'].'"></td>
                                                        </tr>
                                                        ';
                                                        $i++;
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
								</div>
                                <div class="box-footer text-center box_table">
                                    <button type="button" class="btn btn-primary p-2" id="bt_sent_user"><i class="fas fa-save"></i> บันทึก</button>
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
    $(function(){
        $('#form2').hide();
        $('#form3').hide();
        $('#form4').hide();

        $("#bf1").click(function(event){
            $('#bf1').addClass('btn-primary');
            $('#bf2').removeClass('btn-primary');
            $('#bf3').removeClass('btn-primary');
            $('#bf4').removeClass('btn-primary');
            $('#form2').hide();
            $('#form3').hide();
            $('#form4').hide();
            $('#form1').fadeIn();
        });
        $("#bf2").click(function(event){
            $('#bf2').addClass('btn-primary');
            $('#bf1').removeClass('btn-primary');
            $('#bf3').removeClass('btn-primary');
            $('#bf4').removeClass('btn-primary');
            $('#form1').hide();
            $('#form3').hide();
            $('#form4').hide();
            $('#form2').fadeIn();
        });
        $("#bf3").click(function(event){
            $('#bf3').addClass('btn-primary');
            $('#bf1').removeClass('btn-primary');
            $('#bf2').removeClass('btn-primary');
            $('#bf4').removeClass('btn-primary');
            $('#form1').hide();
            $('#form2').hide();
            $('#form4').hide();
            $('#form3').fadeIn();
        });
        $("#bf4").click(function(event){
            $('#bf4').addClass('btn-primary');
            $('#bf1').removeClass('btn-primary');
            $('#bf2').removeClass('btn-primary');
            $('#bf3').removeClass('btn-primary');
            $('#form1').hide();
            $('#form2').hide();
            $('#form3').hide();
            $('#form4').fadeIn();
        });

        $("#user_copy").change(function(event){
            $.ajax({
                type: "POST",
                url: "api/get_user_copy",
                data: {
                    id : $("#user_copy").val()
                },
                success: function(result){
                    $("#show_error").html(result);
                }
            });	
        });

        $("#share_all").keyup(function(event){
            if(parseFloat($("#share_all").val())>=0){
                $('.share').val($("#share_all").val());
                setShareAll();
            }
            else{
                $("#share_all").val('');
            }
        });

        
        $("#user_username").change(function(event){
            if($('#user_username').val()==''){
                $('#user_username').addClass('error_input');
                alertError('ชื่อต้องไม่เป็นค่าว่าง');
            }
            <? if($user_data['user_type']=='admin' && $_GET['type']!='member') { ?>
            else if($('#user_username').val().length!=4){
                $('#user_username').addClass('error_input');
                alertError('username ต้องมีความยาว<br> 4 ตัวอักษร');
            }
            <? } ?>
            else{
                $('#user_username').removeClass('error_input');
            }
                
        });

        $("#fuser_name").change(function(event){
            if($('#fuser_name').val()==''){
                alertError('ชื่อต้องไม่เป็นค่าว่าง');
                $('#fuser_name').addClass('error_input');
            }
            else{
                $('#fuser_name').removeClass('error_input');
            }
                
        });

        $("#bt_sent_user").click(function(event){
            event.preventDefault();
            var chk = true;

            if($('#fuser_name').val()==''){
                alertError('ชื่อต้องไม่เป็นค่าว่าง');
                $('#fuser_name').addClass('error_input');
                $('#fuser_name').focus();
                chk = false;
            }
            if($('#user_username').val()==''){
                alertError('username ต้องไม่เป็นค่าว่าง');
                $('#user_username').addClass('error_input');
                $('#user_username').focus();
                chk = false;
            }
            // if($('#user_username').val().length<6){
            //     alertError('username ต้องมีความยาว<br>ตั้งแต่ 4 ตัวอักษรขึ้นไป');
            //     $('#user_username').addClass('error_input');
            //     $('#user_username').focus();
            //     chk = false;
            // }
            <? if($user_data['user_type']=='admin' && $_GET['type']!='member') { ?>
            if($('#user_username').val().length!=4){
                alertError('username ต้องมีความยาว<br> 4 ตัวอักษร');
                $('#user_username').addClass('error_input');
                $('#user_username').focus();
                chk = false;
            }
            <? } ?>

            if(chk){
                $.ajax({
                    type: "POST",
                    url: "api/insert_user",
                    data: $("#user_form").serialize(),
                    beforeSend: function() {
                        $("#bt_sent_user").prop('disabled', true);
				        $("#bt_sent_user").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> รอการประมวลผล');
                    },
                    success: function(result){
                        $("#show_error").html(result);
                    }
                });	
            }
        });

    });

    function setShareAll(){
        <? 
            $str = '';
            foreach($data as $key => $val){ $str .= $val['lotto_id'].','; } 
        // $str = substr($str,0,-1);
        ?>
        var lottos = [<? echo $str.'"-"'; ?>]; 
        lottos.forEach(setShare);
       
    }
    function setShare(i,id){
        if( parseFloat($('#share_'+id).val()) > parseFloat($('#owner_'+id).val()) ){
           $('#share_'+id).val( $('#owner_'+id).val() );
        }
        $('#keep_'+id).val( $('#owner_'+id).val() - $('#share_'+id).val() );
    }
    function setAll(id){
        if(parseFloat($('#'+id+'_all').val())>=0){
            $('.'+id).val($('#'+id+'_all').val());
        }
        else{
            $('#'+id+'_all').val('');
            $('.'+id).val(0);
        }
    }
    function alertSuccess(str){
        Message.add(str, {
            type: 'success',
            vertical:'top',
            horizontal:'right'
        }); 
    }
    function alertError(str,life=4000){
        Message.add(str, {
            type: 'error',
            vertical:'top',
            horizontal:'right',
            life: life
        });
    }
</script>

