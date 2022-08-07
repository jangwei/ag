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


$lotto_id = $_POST['lotto_id'];
$top2 = $_POST['top2'];
$bottom2 = $_POST['bottom2'];
$top3 = $_POST['top3'];
$toad3 = $_POST['toad3'];
$bottom3 = $_POST['bottom3'];
$top1 = $_POST['top1'];
$bottom1 = $_POST['bottom1'];

//var_dump($_POST);

foreach($lotto_id as $i => $val){
    $lotto_receive_id = $query->queryDB_to_string('SELECT lotto_receive_id FROM lotto_receive WHERE lotto_id='.$lotto_id[$i].' AND user_id='.$user_id);
    if($lotto_receive_id!=''){
        $sql = "
            UPDATE lotto_receive 
            SET 
                top2 = ".intval($top2[$i])." ,
                bottom2 = ".intval($bottom2[$i])." ,
                top3 = ".intval($top3[$i])." ,
                toad3 = ".intval($toad3[$i])." ,
                bottom3 = ".intval($bottom3[$i])." ,
                top1 = ".intval($top1[$i])." ,
                bottom1 = ".intval($bottom1[$i])."
            WHERE lotto_receive_id = ".$lotto_receive_id.";
        ";
        $chk = $query->queryDB($sql);
        if($chk){
            getSuccess();
        }
    }
    else{
        $sql = '
            INSERT INTO lotto_receive (
                lotto_id,user_id,top2,bottom2,top3,toad3,bottom3,top1,bottom1
            ) VALUES (
                '.$lotto_id[$i].','.$user_id.','.intval($top2[$i]).','.intval($bottom2[$i]).','.intval($top3[$i]).','.intval($toad3[$i]).','.intval($bottom3[$i]).','.intval($top1[$i]).','.intval($bottom1[$i]).'
            );
        ';
        $chk = $query->queryDB($sql);
        if($chk){
            getSuccess();
        }
    }
}
$query->closeDB();

function getSuccess(){
echo '
    <script>
        editSuccess("บันทึกรายการตั้งรับของท่านแล้ว");
    </script>
';
}
?>