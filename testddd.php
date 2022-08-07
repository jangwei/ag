<?
include_once("api/core.php");
include_once('indyEngine/engineControl.php');
setInclude('dbControl');
setPlugin('jquery,alert,hrefDefault');
checkLogin('index');

HtmlCore::getTitle();

$query = new DBControl();
$user_id = decode($_COOKIE["EASYLOTSID"]);

//$date = $_GET['date'];

$dates = array('2022-01-17');
foreach($dates as $index => $date){
    $sql = 'SELECT user.user_type ,summary.*FROM summary INNER JOIN user ON user.user_id = summary.child_id WHERE lotto_list_date="'.$date.'" ORDER BY lotto_list_id,user_type DESC,child_id DESC';
    $summary_data = $query->queryDB_to_array($sql);
    
    $chk_id = '';
    $sql = '
        UPDATE 
            summary 
        SET 
            downline_amount = 0 ,
            downline_commission = 0 ,
            downline_reward = 0
        WHERE 
            lotto_list_date="'.$date.'"
    ';
    $query->queryDB($sql);

    foreach($summary_data as $key => $val){
        if($val['user_type']=='member'){
            echo $sql = '
                UPDATE 
                    summary 
                SET 
                    downline_amount = user_amount + upline_amount ,
                    downline_commission = user_commission + upline_commission ,
                    downline_reward = user_reward + upline_reward
                WHERE 
                    summary_id = '.$val['summary_id'].'
            ';
            $query->queryDB($sql);
        }
        echo '<br>';

        echo $sql = '
            UPDATE 
                summary 
            SET 
                downline_amount = downline_amount + '.$val['upline_amount'].' ,
                downline_commission = downline_commission + '.$val['upline_commission'].' ,
                downline_reward = downline_reward + '.$val['upline_reward'].'
            WHERE 
                child_id ='.$val['user_id'].' AND lotto_list_id = '.$val['lotto_list_id'].'
        ';
        $query->queryDB($sql);
        echo '<br>';
        echo $sql = '
            UPDATE 
                summary 
            SET 
                upline_amount = downline_amount-user_amount ,
                upline_commission = downline_commission-user_commission ,
                upline_reward = downline_reward-user_reward
            WHERE 
                child_id ='.$val['user_id'].' AND lotto_list_id = '.$val['lotto_list_id'].'
        ';
        $query->queryDB($sql);
        echo '<br><br><br><br>';
    }
}
// $sql = '
//     UPDATE 
//         summary 
//     SET 
//         upline_amount = downline_amount-user_amount ,
//         upline_commission = downline_commission-user_commission ,
//         upline_reward = downline_reward-user_reward
//     WHERE 
//         lotto_list_date="'.$date.'"
// ';
// $query->queryDB($sql);


?>