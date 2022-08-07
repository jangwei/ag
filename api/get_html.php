<?

function getHtmlUser($name,$lastname){
	if($name!=''){
		return $name.' '.$lastname;
	}
	else return '&nbsp;';
}
function cutText($text,$str){
	$lenText = strlen($text);
	$lenStr = strlen($str);
	$posStr = strpos($text,$str,0);
	return substr($text,-1*($lenText-($lenStr+$posStr)));
}

function getTextTime($date){
	if($date!=""){
		return substr($date,-8,5);
	}
	else{
		return "-";
	}
}
function getTextDateTime($date,$br=true){
	if($date!="" && $date!="0000-00-00 00:00:00"){
		list($year, $month, $day)= explode("-",$date);
		$time = substr($date,-8,5);
		$year = substr(intval($year)+543,-2);
		$day = substr($day,0,2);
		if(substr($day,0,1)=='0'){
			$day = substr($day,1);
		}
		if($br){
			$newdate = $day ." ". getMonthShot($month)." ".$year."<br><small>".$time." น</small>";
		}
		else{
			$newdate = $day ." ". getMonthShot($month)." ".$year." <small>เวลา ".$time." น</small>";
		}
		return $newdate;
	}
	else{
		return "-";
	}

}			
function getTextDateTH2($date){
	list($year, $month, $day)= explode("-",$date);
	$year = intval($year)+543;
	$day = substr($day,0,2);
	if(substr($day,0,1)=='0'){
		$day = substr($day,1);
	}
	$newdate = $day ." ". getMonthShot($month)." ".$year ;
	return $newdate;
}
function getMonthFull($mou){
	if($mou=="01"){
		$mou = "มกราคม";
	}
	else if($mou=="02"){
		$mou = "กุมภาพันธ์";
	}
	else if($mou=="03"){
		$mou = "มีนาคม";
	}
	else if($mou=="04"){
		$mou = "เมษายน";
	}
	else if($mou=="05"){
		$mou = "พฤษภาคม";
	}
	else if($mou=="06"){
		$mou = "มีถุนายน";
	}
	else if($mou=="07"){
		$mou = "กรกฎาคม";
	}
	else if($mou=="08"){
		$mou = "สิงหาคม";
	}
	else if($mou=="09"){
		$mou = "กันยายน";
	}
	else if($mou=="10"){
		$mou = "ตุลาคม";
	}
	else if($mou=="11"){
		$mou = "พฤศจิกายน";
	}
	else if($mou=="12"){
		$mou = "ธันวาคม";
	}
	return $mou;
}
function getMonthShot($mou){
	if($mou=="01"){
		$mou = "ม.ค.";
	}
	else if($mou=="02"){
		$mou = "ก.พ.";
	}
	else if($mou=="03"){
		$mou = "มี.ค.";
	}
	else if($mou=="04"){
		$mou = "เม.ย.";
	}
	else if($mou=="05"){
		$mou = "พ.ค.";
	}
	else if($mou=="06"){
		$mou = "มี.ย.";
	}
	else if($mou=="07"){
		$mou = "ก.ค.";
	}
	else if($mou=="08"){
		$mou = "ส.ค.";
	}
	else if($mou=="09"){
		$mou = "ก.ย.";
	}
	else if($mou=="10"){
		$mou = "ต.ค.";
	}
	else if($mou=="11"){
		$mou = "พ.ย.";
	}
	else if($mou=="12"){
		$mou = "ธ.ค.";
	}
	return $mou;
}
function getPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function getTextTime2($date){
	if($date!="" && $date!="0000-00-00 00:00:00"){
		return substr($date,-8,5);
	}
	else{
		return "-";
	}
}
function getTextDate($date,$str){
	if($date!="" && $date!="0000-00-00 00:00:00"){
		list($year, $month, $day)= explode("-",$date);
		$year = intval($year)+543;
		$day = substr($day,0,2);
		if(substr($day,0,1)=='0'){
			$day = substr($day,1);
		}
		$newdate = $day.$str.$month.$str.$year ;
		return $newdate;
	}
	else{
		return "-";
	}
}
function getTextDateIos($date){
	if($date!="" && $date!="0000-00-00 00:00:00"){
		list($year, $month, $day)= explode("-",$date);
		$time = getTextTime($date);
		$day = substr($day,0,2);
		return $year.'-'.$month.'-'.$day.'T'.$time.':00';
	}
	else{
		return "-";
	}
}
function getTextDateFull($date){
	if($date!="" && $date!="0000-00-00 00:00:00"){
		list($year, $month, $day)= explode("-",$date);
		$year = substr(intval($year)+543,-2);
		$day = substr($day,0,2);
		if(substr($day,0,1)=='0'){
			$day = substr($day,1);
		}
		$newdate = $day ." ". getMonthUpdate($month)." ".$year ;
		return $newdate;
	}
	else{
		return "-";
	}

}
function getTextFullDateTH($date){
	if($date!="" && $date!="0000-00-00 00:00:00"){
		list($year, $month, $day)= explode("-",$date);
		$year = substr(intval($year)+543,-2);
		$day = substr($day,0,2);
		if(substr($day,0,1)=='0'){
			$day = substr($day,1);
		}
		$newdate = $day ." ". getMonthFull($month)." ".$year ;
		return $newdate;
	}
	else{
		return "-";
	}

}
function getTextDateTH($date){
	if($date!="" && $date!="0000-00-00 00:00:00"){
		list($year, $month, $day)= explode("-",$date);
		$year = substr(intval($year)+543,-2);
		$day = substr($day,0,2);
		if(substr($day,0,1)=='0'){
			$day = substr($day,1);
		}
		$newdate = $day ." ". getMonthUpdate($month)." ".$year ;
		return $newdate;
	}
	else{
		return "-";
	}

}
function getMonthUpdate($mou){
	if($mou=="01"){
		$mou = "ม.ค.";
	}
	else if($mou=="02"){
		$mou = "ก.พ.";
	}
	else if($mou=="03"){
		$mou = "มี.ค.";
	}
	else if($mou=="04"){
		$mou = "เม.ย.";
	}
	else if($mou=="05"){
		$mou = "พ.ค.";
	}
	else if($mou=="06"){
		$mou = "มี.ย.";
	}
	else if($mou=="07"){
		$mou = "ก.ค.";
	}
	else if($mou=="08"){
		$mou = "ส.ค.";
	}
	else if($mou=="09"){
		$mou = "ก.ย.";
	}
	else if($mou=="10"){
		$mou = "ต.ค.";
	}
	else if($mou=="11"){
		$mou = "พ.ย.";
	}
	else if($mou=="12"){
		$mou = "ธ.ค.";
	}
	return $mou;
}
?>