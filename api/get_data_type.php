<?
include_once('../indyEngine/dbControl.php');
include_once('get_html.php');
$query = new DBControl();

$lotto_type_id = $_POST["type"];
$data = $query->queryDB_to_array("SELECT * FROM lotto WHERE lotto_type_id=".$lotto_type_id." ORDER BY lotto_id");
$lotto_type_name = $query->queryDB_to_string("SELECT lotto_type_name FROM lotto_type WHERE lotto_type_id=".$lotto_type_id);
$first = 0; $i = 0;
// if($data){
    echo '<button type="button" id="bl_0" class="btn m-1 mb-3 btn-outline-primary bl" onClick="getDataTable(0,'.$lotto_type_id.')"> <i class="fas fa-sync-alt"></i> '.$lotto_type_name.'ทั้งหมด </button>';
    foreach($data as $key => $val){
        echo '<button type="button" id="bl_'.$val['lotto_id'].'" class="btn m-1 mb-3 btn-outline-primary bl" onClick="getDataTable('.$val['lotto_id'].')"><img src="'.$val['lotto_img'].'" class="lotimg"> '.$val['lotto_name'].'</button>';
        if($i==0){
            $first = $val['lotto_id'];
        }
        $i++;
    }
// }
//if($first!=0){
	echo '
    <script> 
        getDataTable(0,'.$lotto_type_id.'); 

        $("#data_copy").val(0);
    </script>';
//}
?>