<?
include_once('indyEngine/dbControl.php');
include_once('indyEngine/sessionControl.php');

include_once('get_html.php');

class HtmlCore{
	
	private static function getMenuActive($page,$activeName){
		if($page == $activeName){
			return 'class="active"';
		}
	}
	
	private static function getMenuDropdownActive($page,$activeName){
		if($page == $activeName){
			return ' active';
		}
	}
	private static function getTreeMenuActive($page,$activeName){
		for($a=0;$a<count($activeName);$a++)
		{
			if($page == $activeName[$a])
			{
				return 'active';
			}
		}
	}
	
	public static function getTitle(){
		echo '<title> BB888Lotto Agent </title>';
	}
	
	public static function getTextHeader()
	{
		echo '
			<a href="index" class="logo">
				<span class="logo-mini"><img src="img/logo.png" height="40px"></span>
				<span class="logo-lg"><img src="img/logo.png" height="40px"></span>
			</a>
		';
	}
	public static function getMenuHeader()
	{
		$query = new DBControl();
		$user_id = decode($_COOKIE["EASYLOTSID"]);
		$sql = "SELECT * FROM user WHERE user_id = ".$user_id;
		$user_data = $query->queryDB_to_row($sql);
		
		echo'	
		<div class="navbar-custom-menu">			
            <ul class="nav navbar-nav">	
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="img/usercogs.png" class="user-image">
                  	<span class="hidden-xs">'.getHtmlUser($user_data['user_name'],$user_data['user_lastname']).'</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
				  	<img src="img/logo.png" height="40px">
					<p>
						'.getHtmlUser($user_data['user_name'],$user_data['user_lastname']).'<br>
						<small>'.$user_data['user_type'].'</small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" id="bt_edit_user" class="btn btn-default btn-flat"> <i class="fas fa-user-cog"></i> ข้อมูลผู้ใช้</a>
                    </div>
                    <div class="pull-right">
                      <a href="indyEngine/sessionControl?logout=true" class="btn btn-default btn-flat"> <i class="fas fa-sign-out-alt"></i> ลงชื่อออก</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
		</div>
		
		<!-- REQUIRED JS SCRIPTS -->
        <div class="modal fade" id="edit_user" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
						<h3 class="modal-title">แก้ไขข้อมูลสมาชิก</h3>
						<div class="pt-1">
							<b>'.$user_data['user_username'].'</b>
						</div>
                    </div>
                    <div class="modal-body">
						<div class="row p-2">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="form-group"  style="padding-right:10px;">
									<label>รหัสผ่าน</label>
									<input type="password" class="form-control" placeholder="password ..." id="password" value=""/>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="form-group"  style="padding-right:10px;">
									<label>ยืนยันรหัสผ่าน</label>
									<input type="password" class="form-control" placeholder="repassword ..." id="repassword" value=""/>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<hr>
							</div>
							<div class="col-md-3 col-sm-6 col-xs-12 p-1">
								<div class="form-group"  style="padding-right:10px;">
									<label>ชื่อ</label>
									<input type="text" class="form-control" placeholder="ชื่อ ..." id="user_name" value="'.$user_data['user_name'].'"/>
								</div>
							</div>
							<div class="col-md-3 col-sm-6 col-xs-12 p-1">
								<div class="form-group"  style="padding-right:10px;">
									<label>นามสกุล</label>
									<input type="text" class="form-control" placeholder="นามสกุล ..." id="user_lastname" value="'.$user_data['user_lastname'].'"/>
								</div>
							</div>
							<div class="col-md-3 col-sm-6 col-xs-12 p-1">
								<div class="form-group"  style="padding-right:10px;">
									<label>เบอร์โทร</label>
									<input type="text" class="form-control" placeholder="เบอร์โทร ..." id="user_phone" value="'.$user_data['user_phone'].'"/>
								</div>
							</div>
							<div class="col-md-3 col-sm-6 col-xs-12 p-1">
								<div class="form-group"  style="padding-right:10px;">
									<label>Line id</label>
									<input type="text" class="form-control" placeholder="line id ..." id="user_line_id" value="'.$user_data['user_line_id'].'"/>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 pt-1" style="height:25px">
								<div class="w-100 text-center" id="show_edit_error"></div>
							</div>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-undo"></i> ย้อนกลับ</button>
                        <button type="button" class="btn btn-primary" onClick="editUserData()"> <i class="fas fa-save"></i> บันทึก</button>
                    </div>
                </div>
            </div>
		</div>
		';
	}
	public static function getNickName(){
		echo '<small>BB888Lotto</small>';
	}
	public static function getMenuFooter(){
		$query = new DBControl();
		$user_id = decode($_COOKIE["EASYLOTSID"]);
		$sql = "SELECT user_type FROM user WHERE user_id = ".$user_id;
		$user_type = $query->queryDB_to_string($sql);
		
		echo '
			<div class="pull-right hidden-xs">
				 <strong>'.$user_type.'</strong></a>
			</div>
			<strong> BB888Lotto v1.1 </strong>
			<span id="show_error"></span>
		
			<script>
				NProgress.start();
				setTimeout(function() { NProgress.done(); $(".fade").removeClass("out"); }, 1000);

				$(function () {
					$("a[href=#]").click(function(event){
						event.preventDefault();
					});	
				});
				
				$("#bt_edit_user").click(function() {
					$("#password").val("");
					$("#repassword").val("");
					$("#edit_user").appendTo("body").modal("show");
				});

				function editUserData(){
					$.ajax({
						type: "POST",
						url: "api/set_user_data",
						data: { 
							password:$("#password").val(), 
							repassword:$("#repassword").val(), 
							user_name:$("#user_name").val(), 
							user_lastname:$("#user_lastname").val(), 
							user_phone:$("#user_phone").val(), 
							user_line_id:$("#user_line_id").val()
						},
						success: function(result){
							$("#show_edit_error").html(result);
						}
					});	
				}

				function alertSuccess(str){
					Message.add(str, {
						type: "success",
						vertical: "top",
						horizontal: "right"
					}); 
				}
				
				function alertError(str,life=2000){
					Message.add(str, {
						type: "warning",
						vertical:"top",
						horizontal:"right",
						life: life
					});
				}

			</script>
		';
	}
	
	public static function getMenu($page){
		$query = new DBControl();
		$user_id = decode($_COOKIE["EASYLOTSID"]);
		$sql = "SELECT * FROM user WHERE user_id = ".$user_id;
		$user_data = $query->queryDB_to_row($sql);
		$user_type = $user_data['user_type'];

		$today = date('Y-m-d')." 00:00:00";	
		$now = date('Y-m-d H:i:s');

		echo '
		<ul class="sidebar-menu">
			<li class="header">
				<div class="d-flex justify-content-between">
					<div><i class="fa fa-user"></i> ชื่อผู้ใช้ </div><div class="user_profile">'.$user_data['user_username'].' </div>
				</div>
			</li>
			<li class="header">
				<div class="d-flex justify-content-between">
					<div><i class="fa fa-id-card"></i> ระดับ </div><div class="user_profile">'.$user_type.' </div>
				</div>
			</li>
		';
		if($user_type=='admin' || $user_type=='agent'){
			echo '
			<li class="header">
				<div class="d-flex justify-content-between">
					<div><i class="fa fa-credit-card"></i> ยอดเงิน </div><div id="user_balance" class="highlight f-14" style="font-family:\'Orbitron\'; margin-top:-2px;">'.number_format($user_data['user_balance']).' ฿</div>
				</div>
			</li>
			';
		}
		echo '
		</ul>
		<ul class="sidebar-menu">
		';

		if($user_type=='assistan'){
			$access = $query->queryDB_to_row("SELECT * FROM user_access WHERE user_id=".$user_id);
			if($access['menu_1']==1){
				$menu_1_chk = true;
			}
			if($access['menu_2']==1){
				$menu_2_chk = true;
			}
			if($access['menu_3']==1){
				$menu_3_chk = true;
			}
			if($access['menu_4']==1){
				$menu_4_chk = true;
			}
			if($access['menu_5']==1){
				$menu_5_chk = true;
			}
			if($access['menu_6']==1){
				$menu_6_chk = true;
			}

		}
		else if($user_type=='admin' || $user_type=='agent'){
			$menu_1_chk = true; $menu_2_chk = true; $menu_3_chk = true;
			$menu_4_chk = true; $menu_5_chk = true; $menu_6_chk = true;
		}
		
		if($menu_1_chk){
            $n_betting = $query->queryDB_to_string("SELECT COUNT(lotto_list_id) FROM lotto_list INNER JOIN lotto ON lotto.lotto_id = lotto_list.lotto_id WHERE lotto_list.lotto_list_status=1 AND lotto_list.lotto_list_end>'".$now."' AND lotto_list.lotto_list_start<'".$now."'");
            $n_ending = $query->queryDB_to_string("SELECT COUNT(lotto_list_id) FROM lotto_list INNER JOIN lotto ON lotto.lotto_id = lotto_list.lotto_id WHERE lotto_list.lotto_list_status=1 AND lotto_list.lotto_list_end<'".$now."' AND lotto_list.lotto_list_start<'".$now."' AND lotto_list_check=0");
			echo '
				<li class="treeview '.self::getTreeMenuActive($page,array('betting_report','lotto_receive','lotto_list_limit','forecast_report','ending_report')).'">
					<a href="#"><i class="fa fas fa-receipt"></i> <span>รายการหวย</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li '.self::getMenuActive($page,"betting_report").'>
							<a href="betting_report">
								<i class="fa fa-angle-double-right"></i>รายงานยอดเดิมพัน
								<span class="pull-right-container">
									<span class="label label-primary pull-right" style="min-width:25px">'.$n_betting.'</span>
								</span>
							</a>
						</li>
						<li '.self::getMenuActive($page,"ending_report").'>
							<a href="ending_report">
								<i class="fa fa-angle-double-right"></i>รายงานผลเดิมพัน
								<span class="pull-right-container">
									<span class="label label-danger pull-right" style="min-width:25px">'.$n_ending.'</span>
								</span>
							</a>
						</li>
						<li '.self::getMenuActive($page,"forecast_report").'><a href="forecast_report"><i class="fa fa-angle-double-right"></i>รอผลเดิมพัน</a></li>
						<li '.self::getMenuActive($page,"lotto_receive").'><a href="lotto_receive"><i class="fa fa-angle-double-right"></i>รายการตั้งรับ</a></li>
						<li '.self::getMenuActive($page,"lotto_list_limit").'><a href="lotto_list_limit"><i class="fa fa-angle-double-right"></i>รายการเลขอั้น</a></li>
					
					</ul>
				</li>
			';
		}
		if($menu_2_chk){
			echo '
				<li class="treeview '.self::getTreeMenuActive($page,array('trading_report','summary_report','reward_report','summary_report_test')).'">
					<a href="#"><i class="fa far fa-chart-bar"></i> <span>รายงานผลหวย</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li '.self::getMenuActive($page,"trading_report").'><a href="trading_report"><i class="fa fa-angle-double-right"></i>รายงานผล แพ้-ชนะ</a></li>
						<li '.self::getMenuActive($page,"summary_report").'><a href="summary_report"><i class="fa fa-angle-double-right"></i>รายงานผล แพ้-ชนะ สุทธิ</a></li>
						<li '.self::getMenuActive($page,"reward_report").'><a href="reward_report"><i class="fa fa-angle-double-right"></i>ผลการออกรางวัล</a></li>
						
					</ul>
				</li>
			';
		}
		if($menu_3_chk){
			echo '	
				<li class="treeview '.self::getTreeMenuActive($page,array('user_manage','member','agent','user_tree')).'">
					<a href="#"><i class="fa fas fa-user-cog"></i> <span>จัดการสมาชิก</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li '.self::getMenuActive($page,"member").'><a href="user_create?type=member"><i class="fa fa-angle-double-right"></i>เพิ่มเมมเบอร์</a></li>	
						<li '.self::getMenuActive($page,"agent").'><a href="user_create?type=agent"><i class="fa fa-angle-double-right"></i>เพิ่มเอเย่น</a></li>	
						<li '.self::getMenuActive($page,"user_manage").'><a href="user_manage"><i class="fa fa-angle-double-right"></i>รายชื่อสมาชิก</a></li>			
						<li '.self::getMenuActive($page,"user_tree").'><a href="user_tree"><i class="fa fa-angle-double-right"></i>แผนผังสายงาน</a></li>			
						
					</ul>
				</li>
			';
		}
		if($menu_4_chk){
			echo '	
				<li class="treeview '.self::getTreeMenuActive($page,array('limit_setting','rate_setting','share_setting','commission_setting','keep_setting','my_info')).'">
					<a href="#"><i class="fa fas fa-sliders-h"></i> <span>ตั้งค่าสมาชิก</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li '.self::getMenuActive($page,"my_info").'><a href="my_info"><i class="fa fa-angle-double-right"></i>ส่วนแบ่งที่ได้รับ</a></li>		
						<li '.self::getMenuActive($page,"share_setting").'><a href="share_setting"><i class="fa fa-angle-double-right"></i>ส่วนแบ่งหุ้น <small>(เอเย่น)</small></a></li>		
						<li '.self::getMenuActive($page,"keep_setting").'><a href="keep_setting"><i class="fa fa-angle-double-right"></i>ถือหุ้น <small>(เมมเบอร์)</small></a></li>		
						<li '.self::getMenuActive($page,"commission_setting").'><a href="commission_setting"><i class="fa fa-angle-double-right"></i>คอมมิชชั่น</a></li>	
						<li '.self::getMenuActive($page,"rate_setting").'><a href="rate_setting"><i class="fa fa-angle-double-right"></i>อัตราจ่าย</a></li>
						<li '.self::getMenuActive($page,"limit_setting").'><a href="limit_setting"><i class="fa fa-angle-double-right"></i>แทงสูงสุด</a></li>		
					</ul>
				</li>
			';
		}

		if($user_type=='admin' || $user_type=='agent'){
			echo '
				<li '.self::getMenuActive($page,"assistant").'><a href="assistant"><i class="fa fas fa-user-friends"></i></i> <span>ผู้ช่วย</span></a></li>
			';
		}
		else{
			echo '
				<li '.self::getMenuActive($page,"reward_report").'><a href="reward_report"><i class="fa fas fa-chart-bar"></i></i> <span>ผลการออกรางวัล</span></a></li>
			';
		}

		if($menu_5_chk){
			echo '
				<li '.self::getMenuActive($page,"finance_report").'><a href="finance_report"><i class="fa fa-line-chart"></i> <span>รายงานการเงิน</span></a></li>
			';
		}
		if($menu_6_chk){
			echo '		
				<li '.self::getMenuActive($page,"user_log").'><a href="user_log"><i class="fa fa-history"></i> <span>ประวัติการใช้งาน</span></a></li>
			';
		}
		
		echo '<li '.self::getMenuActive($page,"links").'><a href="links"><i class="fas fa fa-link"></i> <span> ลิงก์ดูผล</span></a></li>';

		$nlist = $query->queryDB_to_string("SELECT COUNT(lotto_list_id) FROM lotto_list WHERE lotto_list.lotto_list_status=1 AND lotto_list.lotto_list_end>'".$now."' AND lotto_list.lotto_list_start<'".$now."'"); 
		$nlist_end = $query->queryDB_to_string("SELECT COUNT(lotto_list_id) FROM lotto_list WHERE lotto_list.lotto_list_check=0 AND lotto_list.lotto_list_end<'".$now."'"); 
		$nlist_future = $query->queryDB_to_string("SELECT COUNT(lotto_list_id) FROM lotto_list WHERE lotto_list.lotto_list_start>'".$now."'"); 
		
		if($user_type=='assistan'){
			$head_id = $user_data['head_id'];
			$head_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".$head_id);
		}

		if($user_type=='admin' || $head_type=='admin'){
			echo '
				<li class="header">ส่วนผู้ดูแลระบบ : Administrator</li>
				
				<li class="treeview '.self::getTreeMenuActive($page,array('lotto_list','lotto_list_end','open_lotto_list','re_process')).'">
					<a href="#"><i class="fa fas fa-clipboard-list"></i> <span>รายการหวย</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li '.self::getMenuActive($page,"open_lotto_list").'><a href="open_lotto_list"><i class="fa fa-angle-double-right"></i>เพิ่มรายการหวยรายวัน</a></li>
						<li '.self::getMenuActive($page,"lotto_list").'>
							<a href="lotto_list"><i class="fa fa-angle-double-right"></i>รายการหวย
								<span class="pull-right-container">
									<span class="label label-success pull-right" style="min-width:25px">'.$nlist_future.'</span>
								</span>
								<span class="pull-right-container">
									<span class="label label-primary pull-right" style="min-width:25px">'.$nlist.'</span>
								</span>
							</a> 
						</li>	
						<li '.self::getMenuActive($page,"lotto_list_end").'>
							<a href="lotto_list_end"><i class="fa fa-angle-double-right"></i>ประมวลรายการหวย
								<span class="pull-right-container">
									<span class="label label-danger pull-right" style="min-width:25px">'.$nlist_end.'</span>
								</span>
							</a> 
						</li>	

						<li '.self::getMenuActive($page,"re_process").'><a href="re_process"><i class="fa fa-angle-double-right"></i>reprocess</a></li>
						<li '.self::getMenuActive($page,"cancel_bill").'><a href="cancel_bill"><i class="fa fa-angle-double-right"></i>คืนบิล</a></li>
					</ul>
				</li>

				<!-- <li '.self::getMenuActive($page,"daily_process").'><a href="daily_process"><i class="fa fa-calendar-check-o"></i> <span>สรุปยอดรายวัน</span></a></li> -->


				<li '.self::getMenuActive($page,"announce").'><a href="announce"><i class="fa fa-bullhorn"></i> <span>ประกาศ</span></a></li>
			';
		}
		echo '</ul>';
	}
	
}

function checkLogin($url){
	if(!isset($_COOKIE["EASYLOTSID"])){
		echo '
			<script>
				window.location="login?url='.$url.'";
			</script>
		';
	}
	else{
		$query = new DBControl();
		$user_id = decode($_COOKIE["EASYLOTSID"]);
		$sql = "SELECT COUNT(user_id) FROM user WHERE user_id = ".$user_id;
		$chk = $query->queryDB_to_string($sql);
		if(!$chk){
			echo '
				<script>
					window.location="indyEngine/sessionControl?logout=true";
				</script>
			';
		}
	}
}
function checkPermissio(){
	if(!isset($_COOKIE["EASYLOTSID"])){
	echo '
		<script>
			window.location="indyEngine/sessionControl?logout=true";
		</script>
	';
	}
}
?>
