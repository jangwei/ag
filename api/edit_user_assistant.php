<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$user_id = $_POST['datauser_id'];
$user_name = $_POST['datauser_name'];
$user_lastname = $_POST['datauser_lastname'];
$user_phone = $_POST['datauser_phone'];
$user_line_id = $_POST['datauser_line_id'];

$menu_1 = getCheck($_POST['emenu_1']);
$menu_2 = getCheck($_POST['emenu_2']);
$menu_3 = getCheck($_POST['emenu_3']);
$menu_4 = getCheck($_POST['emenu_4']);
$menu_5 = getCheck($_POST['emenu_5']);
$menu_6 = getCheck($_POST['emenu_6']);

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';

$sql = "
    UPDATE user SET 
        user_name = '".$user_name."' ,
        user_lastname = '".$user_lastname."' ,
        user_phone = '".$user_phone."' ,
        user_line_id = '".$user_line_id."'
    WHERE user_id = ".$user_id."
";
$chk = $query->queryDB($sql);

$sql = "
    UPDATE user_access SET 
        menu_1 = ".$menu_1." ,
        menu_2 = ".$menu_2." ,
        menu_3 = ".$menu_3." ,
        menu_4 = ".$menu_4." ,
        menu_5 = ".$menu_5." ,
        menu_6 = ".$menu_6." 
    WHERE user_id = ".$user_id."
";
$query->queryDB($sql);


echo '
    <script> 
        Swal.fire({
            html: "แก้ไขข้อมูลผู้ช่วยเรียนร้อยแล้ว",
            type: "success",
            confirmButtonText: " ตกลง ",
            timer: 3000, 
        }).then((result) => {
            $("#user_data").modal("hide");
            location.reload();
        });
    </script>
';


function getCheck($chk){
    if($chk=='on'){
        return 1;
    }
    else{
        return 0;
    }
}

?>