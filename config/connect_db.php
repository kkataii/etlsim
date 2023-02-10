<?php
	session_start();
	date_default_timezone_set('Asia/Vientiane');
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$dsn ="mysql:host=103.13.90.25;dbname=db_etlsimshop";
	$dbuser ="shopNiceNumber";
	$dbpass ="Nicenumber@2023";
	$options =array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4');

	try {
		$dbh = new PDO($dsn, $dbuser, $dbpass, $options);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "Connected to database successfully";
	} catch (PDOException $e) {
		$SysConnectError = "Connection failed: ".$e->getMessage();
		print_r($e);
	}

	/*
	session_start();
	date_default_timezone_set('Asia/Vientiane');
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$bsddev = "&#83;&#87;&#68;&#66;&#83;&#68;"; 
	$dsn ="mysql:host=172.19.23.26;dbname=etl_simcard_kyc_db";
	$dbuser ="etlkycweb";
	$dbpass ="ETLkyc@2210";
	$options =array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

	try {
		$dbh = new PDO($dsn, $dbuser, $dbpass, $options);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
	} catch (PDOException $e) {
		$SysConnectError = "Connection failed: ".$e->getMessage();
		print_r($e);
	}
	///// echo "<br>end";
	define('ETLKYC', 1);
	/////////////
	define('bsddev', $bsddev);*/
	////   
?>