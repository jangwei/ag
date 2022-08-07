<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
if($user_type=='assistan'){
    $user_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
}
else{
    $user_id = decode($_COOKIE["EASYLOTSID"]);
}

$lotto_id = $_POST['id'];
$type = $_POST['type'];
$lotto_type_id = $query->queryDB_to_string('SELECT lotto_type_id FROM lotto WHERE lotto_id='.$lotto_id);
$user_data = $query->queryDB_to_array("SELECT * FROM user WHERE head_id=".$user_id);
echo '<script>';
foreach($user_data as $key => $val){
    $coms = $query->queryDB_to_row("SELECT * FROM lotto_user_".$type." WHERE lotto_id=".$lotto_id." AND user_id=".$val['user_id']);
    echo '
        $("#top2_'.$val['user_id'].'").val('.$coms['top2'].'); 
        $("#bottom2_'.$val['user_id'].'").val('.$coms['bottom2'].'); 
        $("#top3_'.$val['user_id'].'").val('.$coms['top3'].'); 
        $("#toad3_'.$val['user_id'].'").val('.$coms['toad3'].'); 
        $("#bottom3_'.$val['user_id'].'").val('.$coms['bottom3'].'); 
        $("#top1_'.$val['user_id'].'").val('.$coms['top1'].'); 
        $("#bottom1_'.$val['user_id'].'").val('.$coms['bottom1'].'); 
    ';
}
echo '
Message.add("คัดลอกข้อมูล<br>จากสมาชิกแล้ว", {
    type: "success",
    vertical:"top",
    horizontal:"right"
}); 
</script>';
?>