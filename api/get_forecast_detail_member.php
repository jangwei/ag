<?
include_once('../indyEngine/dbControl.php');
include_once('get_html.php');
$query = new DBControl();

$start = $_POST['start'].' 00:00:00';
$end = $_POST['end'].' 23:59:59';
$lotto_list_id = $_POST['lotto_list_id'];

if($_POST["uid"]==0){
    $user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
    if($user_type=='assistan'){
        $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
    }
    else{
        $user_id = decode($_COOKIE["EASYLOTSID"]);
    }
}
else{
    $user_id = $_POST["uid"];
}

$head_id = $query->queryDB_to_string('SELECT head_id FROM user WHERE head_id='.$user_id);

function getUserChild($user_id,$chk_id,$lotto_list_id,$query){
    $username = $query->queryDB_to_string('SELECT user_name FROM user WHERE user_id='.$user_id);
    $head_id = $query->queryDB_to_string('SELECT head_id FROM user WHERE user_id='.$user_id);
    if($head_id!=''){
        if($user_id!=decode($_COOKIE["EASYLOTSID"])){
            getUserChild($head_id,$chk_id,$lotto_list_id,$query);
        }
        if($user_id!=$chk_id){
            echo '
            <li class="breadcrumb-item">
                <a href="#" onclick="getReportB('.$lotto_list_id.','.$user_id .')">'.$username.'</a>
            </li>
            ';
        }
        else{
            echo '
            <li class="breadcrumb-item">
                '.$username.'
            </li>
            ';
        }
    }
}


$lotto_id = $query->queryDB_to_string("SELECT lotto_id FROM lotto_list WHERE lotto_list_id=".$lotto_list_id);  
$lotto_list_date = $query->queryDB_to_string("SELECT lotto_list_date FROM lotto_list WHERE lotto_list_id=".$lotto_list_id);  
$lotto = $query->queryDB_to_row("SELECT * FROM lotto WHERE lotto_id=".$lotto_id);  

echo '
<script>
    $("#lotto_detail").html(\'<img src="'.$lotto['lotto_img'].'" class="lotimg"> <b>'.$lotto['lotto_name'].'</b><small class="pl-2"> งวดวันที่ '.getTextFullDateTH($lotto_list_date).'</small> \');
</script>
<div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">';
                getUserChild($user_id,$user_id,$lotto_list_id,$query);
            echo '
            </ol>
        </nav>
    </div>
</div>
';

echo '
<div class="table-responsive">
    <table id="db_table" class="table table-bordered table-hover table-striped bdetail">
        <thead>
            <tr class="bg-navy">
                <th class="text-center">#</th>
                <th class="text-center">ประเภทหวย</th>
                <th class="text-center">หวย</th>
                <th class="text-center">งวด</th>
                <th class="text-center">ยอดรวม</th>
                <th class="text-center">ส่วนลด</th>
                <th class="text-center">คงเหลือ</th>
                <th class="text-center">Note</th>
            </tr>
        </thead>
        <tbody>
        ';
        
        $sum_price = 0; $sum_commission = 0; $sum_total = 0; $sum_reward = 0;
        $bill_data = $query->queryDB_to_array('SELECT * FROM bill WHERE lotto_list_id = '.$lotto_list_id.' AND user_id='.$user_id);
        foreach($bill_data as $key => $val){
            $no = str_pad($lotto['lotto_id'],2,'0',STR_PAD_LEFT).str_pad($val['lotto_list_id'],3,'0',STR_PAD_LEFT).str_pad($val['bill_id'],4,'0',STR_PAD_LEFT) ;
            $lotto_list_date = $query->queryDB_to_string('SELECT lotto_list_date FROM lotto_list WHERE lotto_list_id='.$val['lotto_list_id']);  
            $lotto_type = $query->queryDB_to_string('SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id='.$lotto['lotto_type_id']);  
            echo '
                <tr>
                    <td class="text-center"><a href="#" onClick="getBillDetail('.$val['bill_id'].')">#'.$no.'</a></td>
                    <td class="text-center"><p>'.$lotto_type.'</p></td>
                    <td class="text-left"><img src="'.$lotto['lotto_img'].'" class="lotimg"> '.$lotto['lotto_name'].'</td>
                    <td class="text-center">'.getTextDateTH($lotto_list_date).'</td>
                    <td class="text-right">'.getNumber($val['bill_total']).'</td>
                    <td class="text-right text-danger">'.getNumber($val['bill_commission']*-1).'</td>
                    <td class="text-right">'.getNumber($val['bill_total']-$val['bill_commission']-$val['bill_reward']).'</td>
                    <td class="text-left">'.$val['bill_note'].'</td>
                </tr>
                <tr id="b_'.$val['bill_id'].'" data-hidden="true" class="tr_hidden text-center">
                    <td colspan="8" id="s_'.$val['bill_id'].'" class="text-center" style="padding-left:15%; padding-right:15%;"></td>
                <tr>
            '; 
            $sum_price += $val['bill_total']; 
            $sum_commission += $val['bill_commission']; 
            $sum_total += $val['bill_total']-$val['bill_commission']-$val['bill_reward']; 
            $sum_reward += $val['bill_reward'];
        }
        echo '
        </tbody>
        <tfoot class="table-warning">
            <tr class="bg-navy-active">
                <td class="text-center" colspan="4">รวม</td>
                <td class="text-right">'.getNumber($sum_price).'</td>
                <td class="text-right">'.getNumber($sum_commission*-1).'</td>
                <td class="text-right">'.getNumber($sum_total).'</td>
                <td class="text-left"></td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(".tr_hidden").hide();
</script>
';
function getBillStat($stat){
    if($stat=='รอออกรางวัล'){
        return '<span class="badge bg-blue">'.$stat.'</span>';
    }
    else{
        return '<span class="badge bg-green">'.$stat.'</span>';
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