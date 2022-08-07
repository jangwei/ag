<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$lotto_limit_id = $_POST['id'];
if($lotto_limit_id!=''){
    $sql = 'DELETE FROM lotto_limit WHERE lotto_limit_id ='.$lotto_limit_id;
    $chk = $query->queryDB($sql);
    if($chk){
    echo '
        <script>
            Message.add("ลบรายการตัดอั้นของท่านเรียนร้อยแล้ว !", {
                type: "success",
                vertical:"top",
                horizontal:"right"
            }); 

            Swal.fire({
                html: "ลบรายการตัดอั้นของท่านเรียนร้อยแล้ว !",
                type: "success",
                confirmButtonText: " ตกลง ",
                confirmButtonColor: "#3085d6",
                timer: 3000, 
            }).then((result) => {
                //location.reload();
                $("#lm_'.$_POST['id'].'").hide();
            });
        </script>
        ';
    }
}

$query->closeDB();
?>