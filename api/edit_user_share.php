<?
include_once('../indyEngine/dbControl.php');
$query = new DBControl();

$user_type = $query->queryDB_to_string("SELECT user_type FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
if($user_type=='assistan'){
    $login_id = $query->queryDB_to_string("SELECT head_id FROM user WHERE user_id = ".decode($_COOKIE["EASYLOTSID"]));
}
else{
    $login_id = decode($_COOKIE["EASYLOTSID"]);
}

$lotto_id = $_POST['lotto_id'];
$lotto_type_id = $_POST['lotto_type_id'];
$user_id = $_POST['user_id'];
$lotto_user_share = $_POST['lotto_user_share'];
if($lotto_user_share){
    if($lotto_id!=0 && $lotto_id !=''){
        foreach($user_id as $i => $val){
            $chk =  $query->queryDB_to_string('SELECT COUNT(lotto_user_share_id) FROM lotto_user_share WHERE lotto_id = '.$lotto_id.' AND user_id ='.$user_id[$i]);
            if($chk!=0){
                $sql = '
                    UPDATE lotto_user_share SET share = '.$lotto_user_share[$i].' 
                    WHERE lotto_id = '.$lotto_id.' AND user_id ='.$user_id[$i].'
                ';
            }
            else{
                $sql = '
                    INSERT INTO lotto_user_share (lotto_id,user_id,share)
                    VALUES ('.$lotto_id.','.$user_id[$i].','.$lotto_user_share[$i].')
                ';
            }
            $query->queryDB($sql);
        }
    }
    else{
        $lottos = $query->queryDB_to_array('SELECT lotto_id FROM lotto WHERE lotto_type_id='.$lotto_type_id);
        foreach($lottos as $index => $value){
            foreach($user_id as $i => $val){
                $chk = $query->queryDB_to_string('SELECT COUNT(lotto_user_share_id) FROM lotto_user_share WHERE lotto_id = '.$value['lotto_id'].' AND user_id ='.$user_id[$i]);
                if($chk!=0){
                    $sql = '
                        UPDATE lotto_user_share SET share = '.$lotto_user_share[$i].' 
                        WHERE lotto_id = '.$value['lotto_id'].' AND user_id ='.$user_id[$i].'
                    ';
                }
                else{
                    $sql = '
                        INSERT INTO lotto_user_share (lotto_id,user_id,share)
                        VALUES ('.$value['lotto_id'].','.$user_id[$i].','.$lotto_user_share[$i].')
                    ';
                }
                $query->queryDB($sql);
            }
        }
    }

    $lotto_ids = $query->queryDB_to_array('SELECT lotto_id FROM lotto');
    checkUserShare($login_id,$query);

    echo '
        <script>
            Swal.fire({
                html: "แก้ไขข้อมูลเรียบร้อยแล้ว",
                type: "success",
                confirmButtonText: " ตกลง ",
                confirmButtonColor: "#3085d6",
                timer: 3000, 
            });
        </script>
    ';
}
else{
   echo '
        <script>
            Swal.fire({
                html: "ไม่มีรายการแก้ไข",
                type: "error",
                confirmButtonText: " ตกลง ",
                confirmButtonColor: "#3085d6",
                timer: 3000, 
            });
        </script>
    '; 
}
$query->closeDB();

function checkUserShare($head_id,$query){
    $user_ids = $query->queryDB_to_array('SELECT user_id FROM user WHERE head_id='.$head_id);
    foreach($user_ids as $key => $user){
        foreach($GLOBALS['lotto_ids'] as $index => $lotto){
            $head_share = doubleval($query->queryDB_to_string('SELECT share FROM lotto_user_share WHERE lotto_id = '.$lotto['lotto_id'].' AND user_id ='.$head_id));
            $user_share = doubleval($query->queryDB_to_string('SELECT share FROM lotto_user_share WHERE lotto_id = '.$lotto['lotto_id'].' AND user_id ='.$user['user_id']));
            if($user_share>$head_share){
                $sql = 'UPDATE lotto_user_share SET share = '.$head_share.' WHERE lotto_id = '.$lotto['lotto_id'].' AND user_id ='.$user['user_id'];
                $query->queryDB($sql);
            }
        }
        checkUserShare($user['user_id'],$query);
    }
}
?>