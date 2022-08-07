<?
include_once('../indyEngine/dbControl.php');
include_once('get_html.php');
$query = new DBControl();

$lotto_list_id = $_POST["id"];
$data = $query->queryDB_to_row("SELECT * FROM lotto_list WHERE lotto_list_id=".$lotto_list_id);

$date_start = substr($data['lotto_list_start'],0,10);
$time_start = substr($data['lotto_list_start'],-8);
$date_end = substr($data['lotto_list_end'],0,10);
$time_end = substr($data['lotto_list_end'],-8);

echo '
<script>
    $("#lotto_list_id_edit").val("'.$data['lotto_list_id'].'");
    $("#lotto_id_edit").val("'.$data['lotto_id'].'");
    $("#datepicker3").val("'.$date_start.'");
    $("#datepicker4").val("'.$date_end.'");
    $("#time_start_edit").val("'.$time_start.'");
    $("#time_end_edit").val("'.$time_end.'");

</script>
';
?>