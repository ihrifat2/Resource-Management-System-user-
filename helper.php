<?php

function getFirstWord($value) {
	$firstWord = "";
	$firstCharacter = explode(" ", $value);
	for ($i=0; $i < count($firstCharacter); $i++) { 
		$temp = substr($firstCharacter[$i], 0, 1);
		$firstWord .= ucfirst($temp);
	}
	return $firstWord;
}

?>