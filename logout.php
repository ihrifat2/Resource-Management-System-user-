<?php
session_start();
if (isset($_SESSION["sdt_id"]) && isset($_SESSION["sdt_name"]) && isset($_SESSION["sdt_role"])) {
	session_destroy();
	header('Location: index.php');
}else{
	header('Location: index.php');
}
?>