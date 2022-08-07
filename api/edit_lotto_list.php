<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$lotto_id = $_POST['lotto_id_edit'];
$lotto_list_id = $_POST['lotto_list_id_edit'];
$date_start = $_POST['date_start_edit'];
$time_start = $_POST['time_start_edit'];
$date_end = $_POST['date_end_edit'];
$time_end = $_POST['time_end_edit'];

$lotto_list_start = $date_start.' '.$time_start.':00';
$lotto_list_end = $date_end.' '.$time_end.':00';

$chk_input = 1;
if($lotto_id==0){
echo '
    <script>
        Message.add("กรุณาเลือกประเทภหวย !", {
            type: "error",
            vertical:"top",
            horizontal:"right",
            life: 3000
        }); 
        $("#lotto_id_edit").focus();
    </script>
';
$chk_input++;
}
else if($date_start=="" || $date_start=="0000-00-00"){
echo '
    <script>
        Message.add("กรุณาเลือกวันที่เปิดหวย !", {
            type: "error",
            vertical:"top",
            horizontal:"right",
            life: 3000
        }); 
        $("#datepicker3").focus();
    </script>
';
$chk_input++;
}
else if($date_end=="" || $date_end=="0000-00-00"){
echo '
    <script>
        Message.add("กรุณาเลือกวันที่ปิดหวย !", {
            type: "error",
            vertical:"top",
            horizontal:"right",
            life: 3000
        }); 
        $("#datepicker4").focus();
    </script>
';
$chk_input++;
}

if($chk_input==1){
    $sql = '
        UPDATE lotto_list SET 
            lotto_id = '.$lotto_id.',
            lotto_list_start = "'.$lotto_list_start.'",
            lotto_list_end = "'.$lotto_list_end.'"
        WHERE lotto_list_id='.$lotto_list_id.'
    ';
    $chk = $query->queryDB($sql);
    if($chk){
    echo '
    <script>
        Swal.fire({
            html: "แก้ไขรายการหวยเรียนร้อยแล้ว",
            type: "success",
            confirmButtonText: " ตกลง ",
            confirmButtonColor: "#3085d6",
            timer: 3000, 
        }).then((result) => {
            location.reload();
        });
    </script>
    ';
    }
}
$query->closeDB();
?>