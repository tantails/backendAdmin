<?php
	$dsn="mysql:host=".$sql_ip.";charset=utf8;";
	$pdo=new PDO($dsn,$sql_user,$sql_pass);
	
	//檢查資料庫是否存在
	$stmt = $pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$sql_db."'");
	$dbexists = $stmt->fetchColumn();
	
	if ($dbexists=="0"){
		//echo "匯入並建立資料庫<br>";
		$filename = 'db.sql';

		$templine = '';
		$lines = file($filename);

		foreach ($lines as $line) {
			if (substr($line, 0, 2) == '--' || $line == ''){
				continue;
			}

			$templine .= $line;

			if (substr(trim($line), -1, 1) == ';') {
				$pdo->query($templine);
				$templine = '';
			}
		}
		//echo "資料庫匯入完成<br>";
	}
?>