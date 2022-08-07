<?
include_once('../indyEngine/dbControl.php');
include_once('get_html.php');
$query = new DBControl();

$bill_id = $_POST['id'];

$bill = $query->queryDB_to_row('SELECT * FROM bill WHERE bill_id='.$bill_id);
$lotto_lists = $query->queryDB_to_row('SELECT * FROM lotto_list WHERE lotto_list_id='.$bill['lotto_list_id']);
if($lotto_lists['lotto_list_check']==1){
    $table = 'bill_detail_checked';
}
else{
    $table = 'bill_detail';
}
$lotto = $query->queryDB_to_row('SELECT * FROM lotto WHERE lotto_id='.$lotto_lists['lotto_id']);
$bills_detail = $query->queryDB_to_array('SELECT huay_type,huay_value,huay_rate,bill_check,bill_price AS huay_price,downline_commission AS huay_commission FROM '.$table.' WHERE bill_id='.$bill_id.' AND child_id='.$bill['user_id'].' ORDER BY bill_check DESC');
$no = str_pad($lotto['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($bill['lotto_list_id'],3,'0',STR_PAD_LEFT).str_pad($bill_id,4,'0',STR_PAD_LEFT) ;

$strnote = '';
if($bill['bill_note']!=''){	
	$strnote = '<div class="text-left"><b>note :</b> '.$bill['bill_note'].'</td></div>';
}
$strreward = getHtmlReward($bill['bill_status'],$bill['bill_reward']);
$type = '';
$html = '
<div class="d-flex justify-content-between pb-2">
	<div>
        '.$strnote.'
    </div>
	<div>
		<small>
			<i class="fa fa-calendar" aria-hidden="true"></i> '.getTextDateTH($bill['bill_date']).'
			<i class="fa fa-clock-o" aria-hidden="true"></i> '.getTextTime($bill['bill_date']).'
		</small>
	</div>
</div>
<div>
<table id="db_table" class="table table-hover table-striped bdetail" style="font-size:12px;">
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
$i = 0; $sum_com = 0; $sum_reward = 0; $sum_total = 0;
foreach($bills_detail as $key => $val){
    $str = ''; $reward = 0;
    if($val['bill_check']==1){
		$str = 'style="color:#E74C3C; background-color:#d9edf7;"';
        $reward = $val['huay_price']*$val['huay_rate'];
    }

    $html .='
        <tr '.$str.'>
            <td><p>'.getTextType($val['huay_type']).'</p></td>
            <td class="text-center">'.$val['huay_value'].'</td>
            <td class="text-right">'.$val['huay_rate'].' ฿</td>
            <td class="text-right text-center">'.getCheck($val['bill_check']).'</td>
            <td class="text-right">'.getNumbero($val['huay_price']).'</td>
            <td class="text-right text-red">'.getNumbero($val['huay_commission']*-1).'</td>
            <td class="text-right">'.getNumbero($reward*-1).'</td>
            <td class="text-right">'.getNumber($val['huay_price']-$val['huay_commission']-$reward).'</td>
        </tr>
	';
    $i++;
	
	$sum_com += $val['huay_commission'];
	$sum_reward += $reward;
	$sum_total += $val['huay_price']-$val['huay_commission']-$reward;
}

$html .= $strd.'
</tbody>
<tfoot>
<tr class="bg-navy-active">
    <td class="text-center" colspan="4"><p><b>รวม '.$i.' รายการ</b></p></td>
	<th class="text-right">'.getNumber($bill['bill_total']).'</th>
	<th class="text-right">'.getNumber($sum_com*-1).'</th>
	<th class="text-right">'.getNumber($sum_reward*-1).'</th>
	<th class="text-right">'.getNumber($sum_total).'</th>
</tr>
';
$html .= '
</tfoot>
</table>
</div>
';


echo $html;

echo '
<script>
	$("#modal_bill_id").html("<b>เลขที่บิล #'.$no.'</b>");
	//$("#bt_line_share").html("<a href=\"https://social-plugins.line.me/lineit/share?url=https://easylots-vip.com/admin/bill_detail?id='.encode($val['bill_id']).'\"  target=\"_blank\"><img src=\"img/wide-default.png\" height=\"34\"></a>");
</script>
';

function getCheck($check){
    if($check==1){
        return '<span class="label label-success">ถูกรางวัล</span>';
    }
    else{
        return '<span class="label label-danger">ไม่ถูก</span>';
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