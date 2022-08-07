<?
include_once('../indyEngine/dbControl.php');
include_once('get_html.php');
$query = new DBControl();

$now = date('H:i:s');
if($now>'06:00:00'){
    $start = date('Y-m-d');
    // $start = date('Y-m-d').' 00:00:00';
    // $end = date('Y-m-d').' 23:59:59';
}
else{
    $start = date('Y-m-d',strtotime("-1 days"));
    // $start = date('Y-m-d',strtotime("-1 days")).' 00:00:00';
    // $end = date('Y-m-d',strtotime("-1 days")).' 23:59:59';
}
$lotto_ids = $_POST['lotto_id'];

if($_POST['user_id']==''){
    $user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
    if($user_type=='assistan'){
        $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
    }
    else{
        $user_id = decode($_COOKIE["EASYLOTSID"]);
    }
}
else{
    $user_id = $_POST['user_id'];
}

$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
if($user_type=='assistan'){
    $real_user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
}
else{
    $real_user_id = decode($_COOKIE["EASYLOTSID"]);
}

function getUserChild($user_id,$chk_id,$query){
    $username = $query->queryDB_to_string('SELECT user_name FROM user WHERE user_id='.$user_id);
    $head_id = $query->queryDB_to_string('SELECT head_id FROM user WHERE user_id='.$user_id);
    if($head_id!=''){
        if($user_id!=$GLOBALS['real_user_id']){
            getUserChild($head_id,$chk_id,$query);
        }
        if($user_id!=$chk_id){
            echo '
            <li class="breadcrumb-item">
                <a href="#" onclick="getReport('.$user_id .')">'.$username.'</a>
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

$usertype = $query->queryDB_to_string('SELECT user_type FROM user WHERE user_id='.$user_id);
$username = $query->queryDB_to_string('SELECT user_name FROM user WHERE user_id='.$user_id);

echo '
<div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">';
                getUserChild($user_id,$user_id,$query);
            echo '
            </ol>
        </nav>
    </div>
</div>
<div class="table-responsive">
<table id="db_table" class="table table-bordered table-hover table-striped tdetail">
    <thead>
        <tr class="bg-navy">
            <th rowspan="2" class="text-center" style="min-width:140px">รายการหวย</th>
            <th rowspan="2" class="text-center">ยอดพนัน</th>
            <th colspan="3" class="text-center" style="border-left: 2px solid #2E4053;">สมาชิก</th>
            <th colspan="3" class="text-center" style="border-left: 2px solid #2E4053;">'.$username.'</th>
        ';
        if($usertype!='admin'){
        echo '
            <th colspan="3" class="text-center" style="border-left: 2px solid #2E4053;">บริษัท</th>
        ';
        }
        echo '
        </tr>
        <tr class="bg-navy">
            <th class="text-center" style="border-left: 2px solid #2E4053;">ยอดส่งออก</th>
            <th class="text-center">ส่วนลด</th>
            <th class="text-center">รวม</th>
            <th class="text-center" style="border-left: 2px solid #2E4053;">ยอดถือสู้</th>
            <th class="text-center">ส่วนลด</th>
            <th class="text-center">รวม</th>
        ';
        if($usertype!='admin'){
        echo '
            <th class="text-center" style="border-left: 2px solid #2E4053;">ยอดถือสู้</th>
            <th class="text-center">ส่วนลด</th>
            <th class="text-center">รวม</th>
        ';
        }
        echo '
        </tr>
    </thead>
';

if($lotto_ids){
echo '<tbody>';
    $lists = '';
    foreach($lotto_ids as $key => $lotto_id){
        $sql = 'SELECT lotto_list_id FROM lotto_list WHERE lotto_id='.$lotto_id.' AND lotto_list_check=0 AND lotto_list_date >= "'.$start.'"';
        $lotto_lists = $query->queryDB_to_array($sql);
        foreach($lotto_lists as $k => $l){
            $lists .= $l['lotto_list_id'].',';
        }
    }
    $lists = substr($lists,0,-1);
    if($lists!=''){
        $sql = '
            SELECT 
                user_id,lotto_id,lotto_list_id,SUM(bill_price) AS price,
                SUM(downline_amount) AS a1 , SUM(downline_commission) AS c1  ,
                SUM(user_amount) AS a2 , SUM(user_commission) AS c2 ,
                SUM(upline_amount) AS a3 , SUM(upline_commission) AS c3
            FROM bill_detail WHERE lotto_list_id IN ('.$lists.') AND user_id='.$user_id.' GROUP BY lotto_id
        ';
        $sum_p =0;
        $sum_a1=0; $sum_c1=0;
        $sum_a2=0; $sum_c2=0;
        $sum_a3=0; $sum_c3=0;
        $bill_details = $query->queryDB_to_array($sql);
        foreach($bill_details as $key => $val){
            $lottos = $query->queryDB_to_row('SELECT * FROM lotto WHERE lotto_id='.$val['lotto_id']);
            echo '
            <tr>
                <td class="text-left" onClick="getReportB('.$val['lotto_list_id'].','.$val['user_id'].')" style="cursor:pointer"><span style="display:none">'.$lottos['lotto_time_end'].'</span><img src="'.$lottos['lotto_img'].'" class="lotimg"> '.$lottos['lotto_name'].'</td>
                <td class="text-right">'.getNumber($val['price']).'</td>
                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($val['a1']*-1).'</td>
                <td class="text-right">'.getNumber($val['c1']).'</td>
                <td class="text-right"><b>'.getNumber($val['c1']+$val['r1']-$val['a1']).'</b></td>
            ';
            $a = $val['a2']-$val['c2']-$val['r2'];
            $b = $val['a3']-$val['c3']-$val['r3'];
            if($usertype!='admin'){
            echo '
                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($val['a2']).'</td>
                <td class="text-right">'.getNumber($val['c2']*-1).'</td>
                <td class="text-right"><b>'.getNumber($a).'</b></td>

                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($val['a3']).'</td>
                <td class="text-right">'.getNumber($val['c3']*-1).'</td>
                <td class="text-right"><b>'.getNumber($b).'</b></td>
            ';
            $ncol = 14;
            }
            else{
            echo '
                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($val['a2']+$val['a3']).'</td>
                <td class="text-right">'.getNumber(($val['c2']+$val['c3'])*-1).'</td>
                <td class="text-right"><b>'.getNumber($a+$b).'</b></td>
            ';   
            $ncol = 14;
            }
            $sum_p += $val['price'];
            $sum_a1 += $val['a1']; $sum_c1 += $val['c1']; 
            $sum_a2 += $val['a2']; $sum_c2 += $val['c2'];
            $sum_a3 += $val['a3']; $sum_c3 += $val['c3'];
        }
    }
    echo '
    </tbody>
';
}
echo '
    <tfoot>
        <tr class="bg-navy-active">
            <th class="text-center">รวม</th>
            <td class="text-right">'.getNumber($sum_p).'</td>
            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a1*-1).'</td>
            <td class="text-right">'.getNumber($sum_c1).'</td>
            <td class="text-right"><b>'.getNumber($sum_c1-$sum_a1).'</b></td>

        ';
        $a = $sum_a2-$sum_c2;
        $b = $sum_a3-$sum_c3;
        if($usertype!='admin'){
        echo '
            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a2).'</td>
            <td class="text-right">'.getNumber($sum_c2*-1).'</td>
            <td class="text-right"><b>'.getNumber($a).'</b></td>

            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a3).'</td>
            <td class="text-right">'.getNumber($sum_c3*-1).'</td>
            <td class="text-right"><b>'.getNumber($b).'</b></td>
        ';
        }
        else{
        echo '
            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a2+$sum_a3).'</td>
            <td class="text-right">'.getNumber(($sum_c2+$sum_c3)*-1).'</td>
            <td class="text-right"><b>'.getNumber($a+$b).'</b></td>
        ';
        }
        echo '
        </tr>
    </tfoot>
    </table>
</div>
';

echo '
<div class="col-12">
    <div class="pt-2 f-16">แยกตามสมาชิก</div>
</div>
<div class="row pt-2">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">';
                getUserChild($user_id,$user_id,$query);
            echo '
            </ol>
        </nav>
    </div>
</div>
';

echo '
<div class="table-responsive">
<table id="db_table2" class="table table-bordered table-hover table-striped tdetail">
    <thead>
        <tr class="bg-navy">
            <th rowspan="2" class="text-center" style="min-width:140px">ชื่อผู้ใช้</th>
            <th rowspan="2" class="text-center">ยอดรวม</th>
            <th colspan="3" class="text-center" style="border-left: 2px solid #2E4053;">สมาชิก</th>
            <th colspan="3" class="text-center" style="border-left: 2px solid #2E4053;">'.$username.'</th>
        ';
        if($usertype!='admin'){
        echo '
            <th colspan="3" class="text-center">บริษัท</th>
        ';
        }
        echo '
        </tr>
        <tr class="bg-navy">
            <th class="text-center" style="border-left: 2px solid #2E4053;">ยอดส่งออก</th>
            <th class="text-center">ส่วนลด</th>
            <th class="text-center">รวม</th>
            <th class="text-center" style="border-left: 2px solid #2E4053;">ยอดถือสู้</th>
            <th class="text-center">ส่วนลด</th>
            <th class="text-center">รวม</th>
        ';
        if($usertype!='admin'){
        echo '
            <th class="text-center" style="border-left: 2px solid #2E4053;">ยอดถือสู้</th>
            <th class="text-center">ส่วนลด</th>
            <th class="text-center">รวม</th>
        ';
        }
        echo '
        </tr>
    </thead>
';
    echo '<tbody>';
    $sql = 'SELECT * FROM user WHERE head_id='.$user_id;
    $user_data = $query->queryDB_to_array($sql);
    $sum_p =0;
    $sum_a1=0; $sum_c1=0;
    $sum_a2=0; $sum_c2=0;
    $sum_a3=0; $sum_c3=0;
    foreach($user_data as $key => $val){
        $str = '';
        $child_id = $query->queryDB_to_string('SELECT user_id FROM user WHERE head_id='.$val['user_id']);
        $user_type = $query->queryDB_to_string('SELECT user_type FROM user WHERE user_id='.$val['user_id']); 
        if($child_id!=''){
            $str = '<a href="#" onclick="getReport('.$val['user_id'] .')">'.$val['user_name'].' '.$val['user_lastname'].'</a> <small>('.$val['user_username'].')</small> <span class="label label-primary pull-right" style="min-width:25px">Agent</span>';
        }
        else{
            if($user_type=='member'){
                $str = '<a href="#" onclick="getReportMember('.$val['user_id'] .')">'.$val['user_name'].' '.$val['user_lastname'].'</a> <small>('.$val['user_username'].')</small> <span class="label label-success pull-right" style="min-width:25px">Member</span>';
            }
            else{
                $str = $val['user_name'];
            }
        }

        $bill_data = $query->queryDB_to_row('SELECT SUM(bill_price) AS price ,SUM(downline_amount) AS a1,SUM(downline_commission) AS c1,SUM(user_amount) AS a2,SUM(user_commission) AS c2,SUM(upline_amount) AS a3,SUM(upline_commission) AS c3 FROM bill_detail WHERE child_id='.$val['user_id'].' AND lotto_list_id IN ('.$lists.')');
        if($bill_data['price']>0){
            echo '
            <tr>
                <td class="text-left">'.$str.'</td>
                <td class="text-right">'.getNumber($bill_data['price']).'</td>
                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($bill_data['a1']*-1).'</td>
                <td class="text-right">'.getNumber($bill_data['c1']).'</td>
                <td class="text-right"><b>'.getNumber(($bill_data['a1']-$bill_data['c1']-$bill_data['r1'])*-1).'</b></td>
            ';
            $a = $bill_data['a2']-$bill_data['c2'];
            $b = $bill_data['a3']-$bill_data['c3'];
            if($usertype!='admin'){
            echo '    
                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($bill_data['a2']).'</td>
                <td class="text-right">'.getNumber($bill_data['c2']*-1).'</td>
                <td class="text-right"><b>'.getNumber($bill_data['a2']-$bill_data['c2']).'</b></td>

                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($bill_data['a3']).'</td>
                <td class="text-right">'.getNumber($bill_data['c3']*-1).'</td>
                <td class="text-right"><b>'.getNumber($bill_data['a3']-$bill_data['c3']).'</b></td>
            ';
            }
            else{
            echo '    
                <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($bill_data['a2']+$bill_data['a3']).'</td>
                <td class="text-right">'.getNumber(($bill_data['c2']+$bill_data['c3'])*-1).'</td>
                <td class="text-right"><b>'.getNumber($a+$b).'</b></td>
            ';
            }
            echo '
            </tr>
            ';
            $sum_p += $bill_data['price'];
            $sum_a1 += $bill_data['a1']; $sum_c1 += $bill_data['c1'];
            $sum_a2 += $bill_data['a2']; $sum_c2 += $bill_data['c2'];
            $sum_a3 += $bill_data['a3']; $sum_c3 += $bill_data['c3'];
        }
    }
    echo '
    </tbody>
    <tfoot>
        <tr class="bg-navy-active">
            <th class="text-center">รวม</th>
            <td class="text-right">'.getNumber($sum_p).'</td>
            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a1*-1).'</td>
            <td class="text-right">'.getNumber($sum_c1).'</td>
            <td class="text-right"><b>'.getNumber($sum_c1-$sum_a1).'</b></td>

        ';
        $a = $sum_a2-$sum_c2;
        $b = $sum_a3-$sum_c3;
        if($usertype!='admin'){
        echo ' 
            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a2).'</td>
            <td class="text-right">'.getNumber($sum_c2*-1).'</td>
            <td class="text-right"><b>'.getNumber($a).'</b></td>

            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a3).'</td>
            <td class="text-right">'.getNumber($sum_c3*-1).'</td>
            <td class="text-right"><b>'.getNumber($b).'</b></td>
        ';
        }
        else{
        echo '
            <td class="text-right" style="border-left: 2px solid #2E4053;">'.getNumber($sum_a3+$sum_a2).'</td>
            <td class="text-right">'.getNumber(($sum_c3+$sum_c2)*-1).'</td>
            <td class="text-right"><b>'.getNumber($a+$b).'</b></td>
        ';
        }
        echo '
        </tr>
    </tfoot>
 </table>
 </div>
 ';

function getNumber($num){
    if($num>=0){
        return '<p class="text-green">'.number_format($num,2).'</p>';
    }
    else{
        return '<p class="text-danger">'.number_format($num,2).'</p>';
    }
}
function getUserType($type){
    if($type=='agent'){
        return '<span class="badge bg-primary">Agent</span>';
    }
    else{
        return '<span class="badge bg-success">Member</span>';
    }
}

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
?>