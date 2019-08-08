<?php
if(!isset($_SESSION["user_id"]) && !isset($_SESSION["user_name"]) && !isset($_SESSION["user_role"])){
	header("Location: login.php");
}

?>