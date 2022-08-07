<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$starttime = microtime(true);

// เช็ดไม่ให้ส่งบิลเข้ามา
$query->queryDB('UPDATE web_status SET lotto_processing=1');

$lids = '';
$lotto_lists = $query->queryDB_to_array("SELECT lotto_list_id FROM lotto_list WHERE lotto_list_check=0");
foreach($lotto_lists as $key => $val){
    $lids .= $val['lotto_list_id'].',';
}
$lids = substr($lids,0,-1);


if($lids!=""){
    echo "INSERT INTO bill_detail_hold (SELECT * FROM bill_detail WHERE lotto_list_id IN (".$lids."));";
    echo "<br><br><br><br>";
    echo "INSERT INTO bill_detail (SELECT * FROM bill_detail_hold)";


    // $query->queryDB("TRUNCATE bill_detail");
    // $query->queryDB("INSERT INTO bill_detail (SELECT * FROM bill_detail_hold)");
    // $query->queryDB("TRUNCATE bill_detail_hold");
}

// คืนค่าการส่งบิล
$query->queryDB('UPDATE web_status SET lotto_processing=0');

// $endtime = microtime(true);
// echo $duration = $endtime - $starttime;
?>