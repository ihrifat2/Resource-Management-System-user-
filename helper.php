<?php
//get first word of a string
function getFirstWord($value) {
	$firstWord = "";
	$firstCharacter = explode(" ", $value);
	for ($i=0; $i < count($firstCharacter); $i++) { 
		$temp = substr($firstCharacter[$i], 0, 1);
		$firstWord .= ucfirst($temp);
	}
	return $firstWord;
}
//count time 
function momentAgo($start, $expired) {
    $startDate = new DateTime($start);
    $expirDate = new DateTime($expired);
    $interval = $startDate->diff($expirDate);
    $year   = $interval->format('%Y'); 
    $month  = $interval->format('%m'); 
    $day    = $interval->format('%d');
    if($year!=0){ 
        $ago = $year.' year(s) ago'; 
    }elseif($month!=0){ 
        $ago = $month.' month(s) ago'; 
    } else { 
        $ago = $day.' day(s) ago'; 
    }
    return $ago;
}
//get random number
function createRandomPassword() { 
    $chars = "abcdefghijkmnopqrstuvwxyz0123456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 
    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 
    return $pass;
} 

?>