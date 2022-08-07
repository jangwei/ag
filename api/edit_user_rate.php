<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$lotto_id = $_POST['lotto_id'];
$lotto_type_id = $_POST['lotto_type_id'];
$user_id = $_POST['user_id'];

$top2 = $_POST['top2'];
$bottom2 = $_POST['bottom2'];
$top3 = $_POST['top3'];
$toad3 = $_POST['toad3'];
$bottom3 = $_POST['bottom3'];
$top1 = $_POST['top1'];
$bottom1 = $_POST['bottom1'];

if($lotto_id!=0 && $lotto_id !=''){
    foreach($user_id as $i => $val){
        $chk =  $query->queryDB_to_string('SELECT COUNT(lotto_user_rate_id) FROM lotto_user_rate WHERE lotto_id = '.$lotto_id.' AND user_id ='.$user_id[$i]);
        if($chk!=0){
            $sql = '
                UPDATE lotto_user_rate SET 
                    top2 = '.$top2[$i].',
                    bottom2 = '.$bottom2[$i].',
                    top3 = '.$top3[$i].',
                    toad3 = '.$toad3[$i].',
                    bottom3 = '.$bottom3[$i].',
                    top1 = '.$top1[$i].',
                    bottom1 = '.$bottom1[$i].'
                WHERE lotto_id = '.$lotto_id.' AND user_id ='.$user_id[$i].'
            ';
        }
        else{
            $sql = '
                INSERT INTO lotto_user_rate (
                    lotto_id,user_id,top2,bottom2,top3,toad3,bottom3,top1,bottom1
                )
                VALUES (
                    '.$lotto_id.','.$user_id[$i].','.$top2[$i].','.$bottom2[$i].','.$top3[$i].','.$toad3[$i].','.$bottom3[$i].','.$top1[$i].','.$bottom1[$i].'
                )
            ';
        }
        $query->queryDB($sql);
    }
}
else{
    $lottos = $query->queryDB_to_array('SELECT lotto_id FROM lotto WHERE lotto_type_id='.$lotto_type_id);
    foreach($lottos as $index => $value){
        foreach($user_id as $i => $val){
            $chk = $query->queryDB_to_string('SELECT COUNT(lotto_user_rate_id) FROM lotto_user_rate WHERE lotto_id = '.$value['lotto_id'].' AND user_id ='.$user_id[$i]);
            if($chk!=0){
                $sql = '
                    UPDATE lotto_user_rate SET 
                        top2 = '.$top2[$i].',
                        bottom2 = '.$bottom2[$i].',
                        top3 = '.$top3[$i].',
                        toad3 = '.$toad3[$i].',
                        bottom3 = '.$bottom3[$i].',
                        top1 = '.$top1[$i].',
                        bottom1 = '.$bottom1[$i].'
                    WHERE lotto_id = '.$value['lotto_id'].' AND user_id ='.$user_id[$i].'
                ';
            }
            else{
                $sql = '
                    INSERT INTO lotto_user_rate (
                        lotto_id,user_id,top2,bottom2,top3,toad3,bottom3,top1,bottom1
                    )
                    VALUES (
                        '.$value['lotto_id'].','.$user_id[$i].','.$top2[$i].','.$bottom2[$i].','.$top3[$i].','.$toad3[$i].','.$bottom3[$i].','.$top1[$i].','.$bottom1[$i].'
                    )
                ';
            }
            $query->queryDB($sql);
        }
    }
}

$query->closeDB();

echo '
    <script>
        editSuccess("แก้ไขข้อมูลเรียบร้อยแล้ว");
    </script>
';
?>