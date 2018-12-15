<?php
	include_once "include/base.php";
	//檢查是否有登入及是否從backend.php引用
//	include_once "include/auth.php";
?>

<?php
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or (@$act="");
	$sql="";

	switch ($act){
		case "insert":
			(@$id=$_POST["id"]) or (@$id=$_GET["id"]) or (@$id="");
			(@$title=$_POST["title"]) or (@$title=$_GET["title"]) or (@$title="");
			(@$path=$_POST["path"]) or (@$path=$_GET["path"]) or (@$path="");
			(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);
			(@$guest=$_POST["guest"]) or (@$guest=$_GET["guest"]) or (@$guest=0);
			(@$type=$_POST["type"]) or (@$type=$_GET["type"]) or (@$type=0);

			if ($id!="" && $title!=""){
				//檔案上傳
				if(!empty($_FILES) && !empty($_FILES['pagefile']) ){
					$tmpPath = uploadFile($_FILES['pagefile'],"file");
					if ($tmpPath){
						$path = 'file/page/'. $tmpPath[0];
					}
				}
				//檔案上傳

				$row_page=$pdo->query(
					"INSERT INTO `page` (`no`, `id`, `title`, `path`, `pgroup`, `guest`, `type`) VALUES (NULL, '".$id."', '".$title."', '".$path."', '".$group."', '".$guest."', '".$type."');"
					);
			}

			redirect('?&fn='.$_GET['fn']);
			break;
		case "insertgroup":
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");

			if ($name!=""){
				$row_page=$pdo->query(
					"INSERT INTO `page_group` (`no`, `name`) VALUES (NULL, '".$name."');"
					);
			}
			
			redirect('?&fn='.$_GET['fn']);
			break;
		case "editsubmit":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
			(@$title=$_POST["title"]) or (@$title=$_GET["title"]) or (@$title="");
			(@$path=$_POST["path"]) or (@$path=$_GET["path"]) or (@$path="");
			(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);
			(@$guest=$_POST["guest"]) or (@$guest=$_GET["guest"]) or (@$guest=0);
			(@$type=$_POST["type"]) or (@$type=$_GET["type"]) or (@$type=0);

			$row_page=$pdo->query(
				"SELECT * FROM `page` WHERE `no` = '".$no."'"
				)->fetch();
			//修改頁面路徑('path')前先把頁面檔名變更
			if ($row_page['path']!="" && $row_page['path']!=$path){
				if (file_exists($row_page['path'])){
					rename ($row_page['path'], $path);
				}
			}

			//檔案上傳
			if(!empty($_FILES) && !empty($_FILES['pagefile']) && $_FILES['pagefile']['size']>0 ){
				$tmpPath = uploadFile($_FILES['pagefile'],"file");
				if ($tmpPath){
					$path = 'file/page/'. $tmpPath[0];
				}
			}
			//檔案上傳

			$ro=$pdo->query(
				"UPDATE `page` SET `id` = '". $id ."', `title` = '". $title ."', `path` = '". $path ."', `pgroup` = '". $group ."', `guest` = '". $guest ."', `type` = '". $type ."' WHERE `no` = '". $no ."';"
				);

			redirect('?&fn='.$_GET['fn']);
			break;
		case "editgroupsubmit":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");

			$ro=$pdo->query(
				"UPDATE `page_group` SET `name` = '". $name ."' WHERE `no` = '". $no ."';"
				);

			redirect('?&fn='.$_GET['fn']);
			break;
		case "del":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			$row=$pdo->query(
				"SELECT * FROM `page` WHERE `no` = '".$no."'"
				)->fetch();
			if (strpos($row['path'],'/')==0){
				$rtn=[
					"status"=>"false",
					"sql"=>"del protect"
				];	
			}else{
				//尋找重複被使用的路徑
				$row_del=$pdo->query(
					"SELECT * FROM `page` WHERE `no`='" . $no . "';"
					)->fetch();

				$rows_find=$pdo->query(
					"SELECT * FROM `page` WHERE `no` <> '" . $no . "' AND `path` = '".$row_del['path']."';"
					);
				if ($rows_find){
					$rows_find=$rows_find->fetchAll();
					//如果路徑沒有重複被使用則刪除檔案
					if (!$rows_find){
						unlink($row_del['path']);
					}
				}

				$ro=$pdo->query(
					"DELETE FROM `page` WHERE `no`='". $no ."';"
					);

				$rtn=[
					"status"=>"ok",
					"sql"=>"$sql"
				];		
			}

			echo json_encode($rtn);
			break;
		case "delgroup":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			$rows_find=$pdo->query(
				"SELECT * FROM `page` WHERE `pgroup` = '".$no."'"
				)->fetchAll();

			//群組保護
			if (count($rows_find)>0){
				$rtn=[
					"status"=>"false",
					"sql"=>"del protect"
				];	
			}else{
				$sql="DELETE FROM `page_group` WHERE `no`='". $no ."';";
				$ro=mysqli_query($link,$sql);

				$rtn=[
					"status"=>"ok",
					"sql"=>"$sql"
				];
			}

			echo json_encode($rtn);
			break;
	}
?>