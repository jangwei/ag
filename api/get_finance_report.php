<?
include_once('../indyEngine/dbControl.php');
include_once('get_html.php');
$query = new DBControl();

$start = $_POST['start'].' 00:00:00';
$end = $_POST['end'].' 23:59:59';

$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
if($user_type=='assistan'){
    $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
}
else{
    $user_id = decode($_COOKIE["EASYLOTSID"]);
}


echo '
<div class="col-12"><div class="mb-4 f-16">
    ข้อมูลตั้งแต่วันที่ <span class="text-primary pl-2 pr-2">'.getTextFullDateTH($start).'</span>
    ถึง <span class="text-primary pl-2">'.getTextFullDateTH($end).'</span>
</div>
<div class="table-responsive">
<table class="table table-hover table-striped" id="data_table">
    <thead>
        <tr class="bg-navy">
            <th>เมื่อ</th>
            <th>รายละเอียด</th>
            <th>เงินเข้า</th>
            <th>เงินออก</th>
            <th>คงเหลือ</th>
            
        </tr>
    </thead>
    <tbody>
';

$sql = 'SELECT * FROM statement WHERE statement_date BETWEEN "'.$start.'" AND "'.$end.'" AND user_id='.$user_id;	
$lotto_data = $query->queryDB_to_array($sql);
$amount = 0; $sum_in = 0; $sum_out = 0;
foreach($lotto_data as $key => $val){
    $str_in = '';
    $str_out = '';
    if($val['statement_type']=='เงินเข้า'){
        $str_in = number_format($val['statement_amount'],2);
        $str_out = '-';
        $amount += $val['statement_amount'];
        $sum_in += $val['statement_amount'];
    }
    else if($val['statement_type']=='เงินออก'){
        $str_out = '-'.number_format($val['statement_amount'],2);
        $str_in = '-';
        $amount -= $val['statement_amount'];
        $sum_out += $val['statement_amount'];
    }
    echo '
        <tr>
            <td class="text-center">'.getTextDateTime($val['statement_date'],false).'</td>
            <td>'.$val['statement_detail'].'</td>
            <td class="text-right text-green">'.$str_in.'</td>
            <td class="text-right text-red">'.$str_out.'</td>
            <td class="text-right">'.number_format($amount,2).'</td>
        </tr>
    ';
}
echo '
    <tr class="bg-navy-active">
        <td colspan="2" class="text-center">รวม</td>
        <td class="text-right">'.number_format($sum_in,2).'</td>
        <td class="text-right">-'.number_format($sum_out,2).'</td>
        <td class="text-right">'.number_format($sum_in-$sum_out,2).'</td>
    </tr>
';

echo '
    </tbody>
</table>
</div>
';

function getStatementType($type){
    if($type=="ฝากเงิน"){
        return '<span class="label badge label-success">ฝากเงิน</span>';
    }
    else{
        return '<span class="label badge bg-yellow">ถอนเงิน</span>';
    }
}
?>