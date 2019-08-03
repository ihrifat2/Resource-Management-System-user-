<?php

if(!isset($_SESSION["sdt_id"]) && !isset($_SESSION["sdt_name"]) && !isset($_SESSION["sdt_role"])){
	header("Location: login.php");
}

?>