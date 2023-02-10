<?php
date_default_timezone_set('Asia/Vientiane');
include('./config/connect_db.php');
function getRealIpAddr(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) // CHECK IP FROM SHARE INTERNET
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  //  TO  CHECK IP IS PASS FROM PROXY
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
$ClientIP 	= getRealIpAddr();


				
		$filename = "index";

		if (isset($_GET['d'])) $filename = $_GET['d'];

		$slashpos = stripos($filename, "/");
		if ($slashpos != false){
			$mfilename = substr($filename, 0, $slashpos+1) . "m_" . substr($filename, $slashpos+1) . ".php";
			$vfilename = substr($filename, 0, $slashpos+1) . "v_" . substr($filename, $slashpos+1) . ".php";
			$cfilename = substr($filename, 0, $slashpos+1) . "c_" . substr($filename, $slashpos+1) . ".php";
		} else {
			$mfilename = "m_$filename.php";
			$vfilename = "v_$filename.php";
			$cfilename = "c_$filename.php";
		}

		if (file_exists($mfilename)) include($mfilename);
		if (file_exists($cfilename)) include($cfilename);



?>