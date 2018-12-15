<?php
	//資料庫設定
	$sql_ip="127.0.0.1";
	$sql_user="root";
	$sql_pass="";
	$sql_db="backendadmin_dev";

	//檢查資料庫, 如果不存在就自動匯入資料庫內容
	include_once "checkdb.php";

	$dsn="mysql:host=".$sql_ip.";charset=utf8;dbname=".$sql_db;
	$pdo=new PDO($dsn,$sql_user,$sql_pass);

	$link=mysqli_connect($sql_ip,$sql_user,$sql_pass,$sql_db) or die("connect error");
	mysqli_query($link,"SET NAMES UTF8");

	include_once "include/session.php";

	include_once "include/function.php";
?>