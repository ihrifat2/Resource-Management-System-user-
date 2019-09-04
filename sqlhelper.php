<?php

function getFacultyUsername($value) {
	require 'dbconnect.php';
	$sql 	= "SELECT `userinfo_uname` FROM `tbl_userinfo` WHERE `userinfo_role` = 1 AND `userinfo_id` = '$value'";
	$rslt 	= mysqli_query($dbconnect, $sql);
	$row 	= mysqli_fetch_assoc($rslt);
	$data 	= ucfirst($row['userinfo_uname']);
	return $data;
}

function getFacultyFullname($value) {
	require 'dbconnect.php';
	$sql 	= "SELECT `userinfo_name` FROM `tbl_userinfo` WHERE `userinfo_role` = 1 AND `userinfo_id` = '$value'";
	$rslt 	= mysqli_query($dbconnect, $sql);
	$row 	= mysqli_fetch_assoc($rslt);
	$data 	= ucfirst($row['userinfo_name']);
	return $data;
}

function getCourseRegCode($value) {
	require 'dbconnect.php';
	$sql 	= "SELECT `course_regcode` FROM `tbl_course` WHERE `course_id` = '$value'";
	$rslt 	= mysqli_query($dbconnect, $sql);
	$row 	= mysqli_fetch_assoc($rslt);
	$data 	= $row['course_regcode'];
	return $data;
}

function getCourseName($value) {
	require 'dbconnect.php';
	$sql 	= "SELECT `course_title` FROM `tbl_course` WHERE `course_id` = '$value'";
	$rslt 	= mysqli_query($dbconnect, $sql);
	$row 	= mysqli_fetch_assoc($rslt);
	$data 	= $row['course_title'];
	return $data;
}

function getCourseCode($value) {
	require 'dbconnect.php';
	$sql 	= "SELECT `course_code` FROM `tbl_course` WHERE `course_id` = '$value'";
	$rslt 	= mysqli_query($dbconnect, $sql);
	$row 	= mysqli_fetch_assoc($rslt);
	$data 	= $row['course_code'];
	return $data;
}

function getCourseFollower($value) {
	require 'dbconnect.php';
	$sql 	= "SELECT COUNT(`enroll_id`) FROM `tbl_enrollinfo` WHERE `enroll_cid` = '$value'";
	$rslt 	= mysqli_query($dbconnect, $sql);
	$row 	= mysqli_fetch_assoc($rslt);
	$data 	= $row['COUNT(`enroll_id`)'];
	return $data;
}

function checkEmail($value) {
	require 'dbconnect.php';
	$sql 	= "SELECT COUNT(`userinfo_id`) FROM `tbl_userinfo` WHERE `userinfo_email` = '$value'";
	$rslt 	= mysqli_query($dbconnect, $sql);
	$row 	= mysqli_fetch_assoc($rslt);
	$data 	= $row['COUNT(`userinfo_id`)'];
	return $data;
}

?>