<?
include_once('../indyEngine/dbControl.php');
include_once('get_html.php');
$query = new DBControl();

$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
if($user_type=='assistan'){
    $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
}
else{
    $user_id = decode($_COOKIE["EASYLOTSID"]);
}

$lotto_list_id = $_POST['id'];

$lotto_list = $query->queryDB_to_row('SELECT * FROM lotto_list WHERE lotto_list_id='.$lotto_list_id);  
$lotto = $query->queryDB_to_row('SELECT * FROM lotto WHERE lotto_id='.$lotto_list['lotto_id']);  
$lotto_type = $query->queryDB_to_string('SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id='.$lotto['lotto_type_id']);  
$lotto_list_end = $lotto_list['lotto_list_end'];

echo '
<div class="d-flex justify-content-between pb-2">
    <div>
        <img src="'.$lotto['lotto_img'].'" height="20px"> <b>'.$lotto['lotto_name'].'</b>
    </div>
    <div>
        <i class="fa fa-calendar" aria-hidden="true"></i> งวดวันที่ '.getTextDateTH($lotto_list['lotto_list_end']).'
    </div>
</div>
<div class="table-responsive">
    <table id="db_table2" class="table table-striped table-hover bdetail">
        <thead>
            <tr class="text-center bg-navy" style="">
                <th class="text-center" scope="col">หวย</th>
                <th class="text-center" scope="col">เลข</th>
                <th class="text-center" scope="col">เรท</th>
                <th class="text-center" scope="col">ถูกรางวัล</th>
                <th class="text-center" scope="col">ยอด</th>
                <th class="text-center" scope="col">ส่วนลด</th>
                <th class="text-center" scope="col">รางวัล</th>
                <th class="text-center" scope="col">คงเหลือ</th>
            </tr>
        </thead>
        <tbody>
';
$sum_com = 0; $sum_reward = 0; $sum_total = 0; $sum_price=0;
$bills_detail = $query->queryDB_to_array('SELECT huay_type,huay_value,huay_rate,bill_check,SUM(huay_price) AS huay_price,SUM(huay_commission) AS huay_commission FROM bill_detail_checked WHERE user_id='.$user_id.' AND lotto_list_id='.$lotto_list_id.' GROUP BY huay_value,huay_type');
foreach($bills_detail as $key => $val){
    $str = ''; $reward = 0;
    if($val['bill_check']==1){
		$str = 'style="color:#E74C3C; background-color:#d9edf7;"';
        $reward = $val['huay_price']*$val['huay_rate'];
    }
    echo '
        <tr '.$str.'>
            <td><p>'.getTextType($val['huay_type']).'</p></td>
            <td class="text-center">'.$val['huay_value'].'</td>
            <td class="text-right">'.$val['huay_rate'].' ฿</td>
            <td class="text-right text-center">'.getCheck($val['bill_check']).'</td>
            <td class="text-right text-green">'.getNumbero($val['huay_price']).'</td>
            <td class="text-right text-red">'.getNumbero($val['huay_commission']*-1).'</td>
            <td class="text-right text-red">'.getNumbero($reward*-1).'</td>
            <td class="text-right">'.getNumber($val['huay_price']-$val['huay_commission']-$reward).'</td>
        </tr>
    ';
	$sum_price += $val['huay_price'];
	$sum_com += $val['huay_commission'];
	$sum_reward += $reward;
	$sum_total += $val['huay_price']-$val['huay_commission']-$reward;
}    
echo '
        </tbody>
        <tfoot class="table-warning">
            <tr class="bg-navy-active">
                <td class="text-center" colspan="4"><p><b>รวม</b></p></td>
                <td class="text-right">'.getNumber($sum_price).'</td>
                <td class="text-right">'.getNumber($sum_com*-1).'</td>
                <td class="text-right">'.getNumber($sum_reward*-1).'</td>
                <td class="text-right">'.getNumber($sum_total).'</td>
            </tr>
        </tfoot>
    </table>
</div>
';


function getCheck($check){
    if($check==1){
        return '<span class="label label-danger">ถูกรางวัล</span>';
    }
    else{
        return '<span class="label label-success">ไม่ถูก</span>';
    }
}
function getNumber($num){
    if($num>=0){
        return '<p class="text-green">'.number_format($num,2).'</p>';
    }
    else{
        return '<p class="text-danger">'.number_format($num,2).'</p>';
    }
}
function getNumbero($num){
    if($num==0){
        return 0;
    }
    else{
        return number_format($num,2);
    }
}
function getHtmlStatus($stat){
    if($stat=='รอออกรางวัล'){
        return  '<div class="credit bg2">รอออกรางวัล</div>';
    }
    else if($stat=='ออกรางวัลแล้ว'){
        return  '<div class="credit bg1">ออกรางวัลแล้ว</div>';
    }
}
function getHtmlReward($stat,$bill_reward){
    if($stat=='ออกรางวัลแล้ว'){
		return  '
		<div class="d-flex justify-content-between" style="color:#F1C40F;">
			<small>เงินรางวัล</small> '.number_format($bill_reward).' ฿
		</div>
		';
    }
}

function getTextType($type){
    if($type=='bottom2'){
        return '2 ตัวล่าง';
    }
    else if($type=='top2'){
        return '2 ตัวบน';
    }
    else if($type=='top3'){
        return '3 ตัวบน';
    }
    else if($type=='toad3'){
        return '3 ตัวโต๊ด';
    }
    else if($type=='front3'){
        return '3 ตัวหน้า';
    }
    else if($type=='bottom3'){
        return '3 ตัวล่าง';
    }
    else if($type=='top1'){
        return 'วิ่งบน';
    }
    else if($type=='bottom1'){
        return 'วิ่งล่าง';
    }
}
?>