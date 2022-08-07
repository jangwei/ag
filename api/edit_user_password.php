<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$user_id = $_POST['datauser_id'];

$chk = $query->queryDB("UPDATE user SET user_password = MD5('123456') WHERE user_id = ".$user_id);
if($chk){
    getSuccess();
}

function getSuccess(){
    echo '
    <script> 
        Message.add("ตั้งค่าระหัสผ่านตั้งต้นของสมาชิกแล้ว", {
            type: "success",
            vertical:"top",
            horizontal:"right"
        }); 
        $("#user_data").modal("hide");
    </script>
    ';
}

?>