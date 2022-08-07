<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$user_id = $_POST['datauser_id'];
$user_name = $_POST['datauser_name'];
$user_lastname = $_POST['datauser_lastname'];
$user_phone = $_POST['datauser_phone'];
$user_line_id = $_POST['datauser_line_id'];


$sql = "
    UPDATE user 
    SET 
        user_name = '".$user_name."' ,
        user_lastname = '".$user_lastname."' ,
        user_phone = '".$user_phone."' ,
        user_line_id = '".$user_line_id."'
    WHERE user_id = ".$user_id."
";
$chk = $query->queryDB($sql);
if($chk){
    getSuccess();
}


function getSuccess(){
    echo '
    <script> 
        Message.add("บันทึกการแก้ไขข้อมูลสมาชิกแล้ว", {
            type: "success",
            vertical:"top",
            horizontal:"right"
        }); 
        $("#user_data").modal("hide");
    </script>
    ';
}

?>