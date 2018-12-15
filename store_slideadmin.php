<?php
	include_once "include/base.php";
	include_once "include/auth.php";
?>

<?php
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or (@$act="");
	$sql="";

	switch ($act){
		case "insert":
			(@$path=$_POST["path"]) or (@$path=$_GET["path"]) or (@$path="");

	
			//檔案上傳
			if(!empty($_FILES) && !empty($_FILES['pagefile']) ){
				$tmpPath = uploadFile($_FILES['pagefile'],"slideimage");
				if ($tmpPath){
					$path = 'file/slide/'. $tmpPath[0];
				}
			}
			//檔案上傳

			$sql="INSERT INTO `store_slide` (`no`, `path`) VALUES (NULL, '".$path."');";
			$ro=mysqli_query($link,$sql);

			redirect('?&fn='.$_GET['fn']);
			break;
		case "editsubmit":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
			(@$path=$_POST["path"]) or (@$path=$_GET["path"]) or (@$path="");

			$sql_slide="SELECT * FROM `store_slide` WHERE `no` = '".$no."'";
			$row_slide=$pdo->query($sql_slide)->fetch();
			//修改頁面路徑('path')前先把頁面檔名變更
			if ($row_slide['path']!="" && $row_slide['path']!=$path){
				if (file_exists($row_slide['path'])){
					rename ($row_slide['path'], $path);
				}
			}

			//檔案上傳
			if(!empty($_FILES) && !empty($_FILES['pagefile']) && $_FILES['pagefile']['size']>0 ){
				$tmpPath = uploadFile($_FILES['pagefile'],"slideimage");
				if ($tmpPath){
					$path = 'file/slide	/'. $tmpPath[0];
				}
			}
			//檔案上傳


			$sql="UPDATE `store_slide` SET `path` = '". $path ."' WHERE `no` = '". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('?&fn='.$_GET['fn']);
			break;
		case "del":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			//尋找重複被使用的路徑
			$sql_del="SELECT * FROM `store_slide` WHERE `no`='" . $no . "';";
			$row_del=$pdo->query($sql_del)->fetch();

			$sql_find="SELECT * FROM `store_slide` WHERE `no` <> '" . $no . "' AND `path` = '".$row_del['path']."';";
			$rows_find=$pdo->query($sql_find);
			if ($rows_find){
				$rows_find=$rows_find->fetchAll();
				//如果路徑沒有重複被使用則刪除檔案
				if (!$rows_find){
					unlink($row_del['path']);
				}
			}

			$sql="DELETE FROM `store_slide` WHERE `no`='". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('?&fn='.$_GET['fn']);
			break;
	}

	//echo "頁面管理";
	//外層陰影
	echo '<div class="col shadow">';

    echo '<div class="row">';

	//新增資料
	echo 	'<div class="col-sm tNewBackground">
				<b>新增頁面</b>
				<form action="?fn='.$_GET['fn'].'&act=insert" method="post" enctype="multipart/form-data">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">檔案上傳</span>
								</div>
								<div class="custom-file">
									<input id=fileNew1 name=pagefile type="file" class="custom-file-input" id="inputGroupFile01">
									<label id=filepathNew1 class="custom-file-label" for="inputGroupFile01">選擇檔案</label>
								</div>
								<script>
									$("#fileNew1").change(function() {
										$("#filepathNew1").text( $("#fileNew1").val() );
									});
								</script>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
							<button type="submit" class="'.$tbutton_default.'" >送出</button>
						</div>
					</div>
				</form>
	 		</div>';
	//新增資料

	//修改資料
	echo 	'<div class="col-sm tEditBackground">';
	
	if ($act=="edit") {
		echo 	'<b>修改頁面</b>';
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

		$sql="select * from `store_slide` where `no`=" . $no;
		$ro=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($ro);

		//echo " 要修改的頁面編號為:" . $no;
		echo	'<form action="?fn='.$_GET['fn'].'&act=editsubmit" method="post" enctype="multipart/form-data">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">檔案路徑</span>
								</div>
								<input type=text name="path" value="'. $row['path'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">檔案上傳</span>
								</div>
								<div class="custom-file">
									<input id=fileEdit1 name=pagefile type="file" class="custom-file-input" id="inputGroupFile01">
									<label id=filepathEdit1 class="custom-file-label" for="inputGroupFile01">選擇檔案</label>
								</div>
								<script>
									$("#fileNew1").change(function() {
										$("#filepathEdit1").text( $("#fileEdit1").val() );
									});
								</script>
							</div>
						</div>
					</div>
					<div class="col-12 col-xl-7 p-0">
						<img src="'. $row['path'] .'" style="width:100%;">
					</div>
					<div class="row-sm">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
							<input type=hidden name="no" value="'. $row['no'] .'">
							<button type="submit" class="'.$tbutton_default.'" >送出</button>
						</div>
					</div>
				</form>';
	}
	echo 	"</div>";
	//修改資料
	echo "</div>";


	//--Debug
	if ($sql!=""){
		echo '<div class="row">';
		
		echo 	'<div class="col-sm tDebug">';
		echo $sql;
		echo 	"</div>";
			
		echo "</div>";
	}
	//--Debug


	echo '<div class="row">';
	//查詢資料
	echo 	'<div class="col-sm tQueryBackground">
				<b>查詢頁面</b>
				<table style="margin:0 auto;width:100%;">
					<tr>
						<th>檔案路徑</th>
						<th>圖片預覽</th>
						<th style="width:5%;">no</th>
						<th style="width:10%;">操作</th>
					</tr>';

	$sql="SELECT * FROM `store_slide`";
	$ro=mysqli_query($link,$sql);
	while ($row=mysqli_fetch_array($ro)){
		echo 		'<tr>
						<td>'. $row['path'] .'</td>
						<td><img src="'. $row['path'] .'" style="height:20px;"></td>
						<td>'. $row['no'] .'</td>
						<td>
							<a href="?fn='.$_GET["fn"].'&act=edit&no='.$row['no'].'">
								<button type="button" class="'.$tbutton_default.'" >修改</button>
							</a>';
		if (strpos($row['path'],'/')==0){
			echo			'<button type="button" class="'.$tbutton_light.'" >刪除</button>';
		}else{
			echo 			'<a href="?fn='.$_GET["fn"].'&act=del&no='.$row['no'].'">
								<button type="button" class="'.$tbutton_danger.'" >刪除</button>
							</a>';
		}
		echo 			'</td>
					</tr>';
	}
	echo 		"</table>";
	echo 	"</div>";
	//查詢資料
	
	//外層陰影
	echo '</div>';
?>