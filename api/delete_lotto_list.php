<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$lotto_list_id = $_POST['id'];

if($lotto_list_id!=''){
    $sql = 'DELETE FROM lotto_list WHERE lotto_list_id ='.$lotto_list_id;
    $chk = $query->queryDB($sql);
    if($chk){
    echo '
    <script>
        Message.add("ลบรายการตัดอั้นของท่านเรียนร้อยแล้ว !", {
            type: "success",
            vertical:"top",
            horizontal:"right"
        }); 
        $("#l_'.$lotto_list_id.'").fadeOut();
    </script>
    ';
    }
}
$query->closeDB();
?>