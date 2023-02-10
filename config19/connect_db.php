<?php
	session_start();
	date_default_timezone_set('Asia/Vientiane');
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
		$bsddev = "&#83;&#87;&#68;&#66;&#83;&#68;"; 
	$dsn ="mysql:host=localhost;dbname=db_etlsimshop";
	$dbuser ="root";
	$dbpass ="ETLtest@2022";
	$options =array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

	try {
		$dbh = new PDO($dsn, $dbuser, $dbpass, $options);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
	} catch (PDOException $e) {
		$SysConnectError = "Connection failed: ".$e->getMessage();
		print_r($e);
	}

?>