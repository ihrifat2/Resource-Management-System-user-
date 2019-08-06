<?php

/*
Script for force user to download file
*/

//get filename
$file = $_GET['filename'];
//set file name with path
$download_path = 'assets/post/'.$file;
// file to be downloaded
$file_to_download = $download_path;
//set header
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");  header("Content-type: application/file");
header('Content-length: '.filesize($file_to_download));
header('Content-disposition: attachment; filename='.basename($file_to_download));
//download file
readfile($file_to_download);
exit;
?>