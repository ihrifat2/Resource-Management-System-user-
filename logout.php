<?php
session_start();
if (isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_role"])) {
	session_destroy();
	header('Location: index.php');
}else{
	header('Location: index.php');
}
?>