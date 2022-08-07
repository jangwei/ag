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
<table class="table table-hover" id="data_table">
    <thead>
        <tr class="bg-navy">
            <th>#</th>
            <th>ประเภทหวย</th>
            <th>หวย</th>
            <th>งวด</th>
            <th>เวลา ตัด-อั้น</th>
            <th>ประเภท</th>
            <th>รายการเลขอั้น</th>
            <th>อัตราจ่าย</th>
        </tr>
    </thead>
    <tbody>
';

$lists = '';
$sql = 'SELECT lotto_list_id FROM lotto_list WHERE lotto_list_date BETWEEN "'.$start.'" AND "'.$end.'"';
$data = $query->queryDB_to_array($sql);
foreach($data as $key => $val){
    $lists .= $val['lotto_list_id'].',';
}
$lists = substr($lists,0,-1);

$sql = 'SELECT * FROM lotto_limit WHERE lotto_list_id IN ('.$lists.')';	
$lotto_limits = $query->queryDB_to_array($sql);
foreach($lotto_limits as $key => $val){
    $lotto_list = $query->queryDB_to_row('SELECT * FROM lotto_list WHERE lotto_list_id='.$val['lotto_list_id']);  
    $lotto = $query->queryDB_to_row('SELECT * FROM lotto WHERE lotto_id='.$lotto_list['lotto_id']);  
    $lotto_type = $query->queryDB_to_string('SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id='.$lotto['lotto_type_id']);  
    $no = str_pad($lotto['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($val['lotto_list_id'],3,'0',STR_PAD_LEFT); 
    $lotto_list_end = $lotto_list['lotto_list_end'];
        
    echo '
        <tr>
            <td class="text-center">#'.$no.'</td>
            <td class="text-center">'.$lotto_type.'</td>
            <td class="text-center"><img src="'.$lotto['lotto_img'].'" class="lotimg"> '.$lotto['lotto_name'].'</td>
            <td class="text-center">'.getTextDateTime($lotto_list_end,false).'</td>
            <td class="text-center">'.getTextDateTime($val['lotto_limit_date'],false).'</td>
            <td class="text-center">'.getTextType($val['huay_type']).'</td>
            <td class="text-left">'.getSort($val['huay_value']).'</td>
            <td class="text-center">'.getLimitType($val['huay_limit']).'</td>
        </tr>
    ';
}
echo '
    </tbody>
</table>
</div>
';

function getSort($str){
    $array_str = explode(" ",$str);
    sort($array_str);
    return implode(" ",$array_str);
}
function getLimitType($type){
    if($type=='ปิดรับ'){
        return '<span class="text-red">ปิดรับ</span>';
    }
    else if($type=='ครึ่งราคา'){
        return '<span class="text-green">ครึ่งราคา</span>';
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