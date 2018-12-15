<?php 
	(@$fn=$_POST["fn"]) or (@$fn=$_GET["fn"]) or ($fn="none");

	//使用者檢查
	if (empty($_SESSION['admin'])) {

		$allowGuest=false;
		$sql_guestpage="SELECT * FROM `page` WHERE `id`='".$fn."'";
		$row_guestpage=$pdo->query($sql_guestpage);
		if ($row_guestpage){
			$row_guestpage=$row_guestpage->fetch();
			if ($row_guestpage['guest']==1){
				$allowGuest=true;
				$_SESSION['admin']='guest';
			}
		}
		if (!$allowGuest){
			header("location:?fn=login");
			exit();
		}
	}
	//使用者檢查

	
	//頁面名稱檢查
	$page=explode( '/' , $_SERVER['SCRIPT_NAME'] );
	//echo $page[count($page)-1];
	if ($page[count($page)-1]!='backend.php' && $page[count($page)-1]!='api.php'){
		header("location:backend.php?fn=home");
	}
	//頁面名稱檢查

	
	//admin default permission
	$page_array=[];
	$rows_page=$pdo->query(
		"SELECT * FROM `page`"
		)->fetchAll();
	foreach($rows_page as $row_page){
		$page_array[$row_page['id']]=1;
	}
	$row_permission=$pdo->query(
		"UPDATE `user` SET `permission` = '".serialize($page_array)."' WHERE `user`.`id` = 1"
		);
	//admin default permission

	
	if ($fn!="none"){
		if ($_SESSION['admin']=='guest'){
			//if allowguest
			$row=$pdo->query(
				"SELECT * FROM `page` WHERE `id` = '". $fn."'"
				)->fetch();
			if ($row['guest']==0){
				redirect("?fn=home");
				exit();
			}
		}else{
			$row_permission=$pdo->query(
				"SELECT * FROM `user` WHERE `acc`='".$_SESSION['admin']."'"
				)->fetch();
			$permission = unserialize($row_permission['permission']);
			if (array_key_exists($fn, $permission)){
				if ($permission[$fn]==0){
					header("location:backend.php?fn=home");
				}
			}else{
				header("location:backend.php?fn=home");
			}
		}

	}
?>