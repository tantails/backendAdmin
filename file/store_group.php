<?php
	include_once "include/base.php";
	include_once "include/auth.php";
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

			if ($id!="" && $title!=""){
				//檔案上傳
				if(!empty($_FILES) && !empty($_FILES['pagefile']) ){
					$tmpPath = uploadFile($_FILES['pagefile'],"file");
					if ($tmpPath){
						$path = 'file/page/'. $tmpPath[0];
					}
				}
				//檔案上傳

				$sql="INSERT INTO `page` (`no`, `id`, `title`, `path`, `pgroup`) VALUES (NULL, '".$id."', '".$title."', '".$path."', '".$group."');";
				$ro=mysqli_query($link,$sql);
			}

			redirect('backend.php?&fn='.$_GET['fn']);
			break;
		case "insertgroup":
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");

			if ($name!=""){
				$sql="INSERT INTO `store_itemgroup` (`no`, `name`) VALUES (NULL, '".$name."');";
				$ro=mysqli_query($link,$sql);
			}
			
			redirect('backend.php?&fn='.$_GET['fn']);
			break;
		case "editsubmit":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
			(@$title=$_POST["title"]) or (@$title=$_GET["title"]) or (@$title="");
			(@$path=$_POST["path"]) or (@$path=$_GET["path"]) or (@$path="");
			(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);

			$sql_page="SELECT * FROM `page` WHERE `no` = '".$no."'";
			$row_page=$pdo->query($sql_page)->fetch();
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


			$sql="UPDATE `page` SET `id` = '". $id ."', `title` = '". $title ."', `path` = '". $path ."', `pgroup` = '". $group ."' WHERE `no` = '". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('backend.php?&fn='.$_GET['fn']);
			break;
		case "editgroupsubmit":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");

			$sql="UPDATE `store_itemgroup` SET `name` = '". $name ."' WHERE `no` = '". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('backend.php?&fn='.$_GET['fn']);
			break;
		case "del":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			$sql_del="SELECT * FROM `page` WHERE `no`='" . $no . "';";
			$row_del=$pdo->query($sql_del)->fetch();

			$sql_find="SELECT * FROM `page` WHERE `no`='" . $no . "' AND `path` <> '".$row_del['path']."';";
			if ($sql_find){
				unlink($row_del['path']);
			}

			$sql="DELETE FROM `page` WHERE `no`='". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('backend.php?&fn='.$_GET['fn']);
			break;
		case "delgroup":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			$sql="DELETE FROM `store_itemgroup` WHERE `no`='". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('backend.php?&fn='.$_GET['fn']);
			break;
	}

	$pgroup_array=[];
	$sql_pgroup="SELECT * FROM `store_itemgroup`";
	$rows_pgroup=$pdo->query($sql_pgroup)->fetchAll();
	foreach($rows_pgroup as $row_pgroup){
		$pgroup_array[$row_pgroup['no']]=$row_pgroup['name'];
	}

	//echo "頁面管理";
	//外層陰影
	echo '<div class="col shadow">';

    echo '<div class="row">';

	//新增資料
	echo 	'<div class="col-sm tNewBackground">
				<b>新增頁面</b>
				<form action="backend.php?fn='.$_GET['fn'].'&act=insert" method="post" enctype="multipart/form-data">
					<table>
						<tr>
							<td>頁面ID：</td>
							<td>
								<input type=text name="id" class="'.$tInput1.'">
							</td>
						</tr>
						<tr>
							<td>頁面標題：</td>
							<td>
								<input type=text name="title" class="'.$tInput1.'">
							</td>
						</tr>
						<tr>
							<td>頁面群組：</td>
							<td>';
	echo 						'<select name="group" class="'.$tSelect1.'">';
	foreach ($pgroup_array as $tmpidx => $tmpname){
		echo 						'<option value='.$tmpidx.'>'.$tmpname.'</option>';
	}
	echo 						'</select>';
	echo 					'</td>
						</tr>
						<!--tr>
							<td>檔案路徑：</td>
							<td>
								<input type=text name="path" class="'.$tInput1.'">
							</td>
						</tr-->
						<tr>
							<td>檔案上傳：</td>
							<td>
								<div class="input-group">
									<div class="custom-file">
										<input id=fileNew name=pagefile type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
										<label id=filepathNew class="custom-file-label" for="inputGroupFile01">選擇檔案</label>
									</div>
								</div>
								<script>
									$("#fileNew").change(function() {
										$("#filepathNew").text( $("#fileNew").val() );
									});
								</script>
							</div>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<button type="submit" class="'.$tbutton_default.'" >送出</button>
							<td>
						</tr>
					</table>
				</form>

				<b>新增群組</b>
				<form action="backend.php?fn='.$_GET['fn'].'&act=insertgroup" method="post">
					<table>
						<tr>
							<td>群組名稱：</td>
							<td>
								<input type=text name="name" class="'.$tInput1.'">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<button type="submit" class="'.$tbutton_default.'" >送出</button>
							<td>
						</tr>
					</table>
				</form>


	 		</div>';
	//新增資料

	//修改資料
	echo 	'<div class="col-sm tEditBackground">';
	
	if ($act=="edit") {
		echo 	'<b>修改頁面</b>';
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

		$sql="select * from `page` where `no`=" . $no;
		$ro=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($ro);

		//echo " 要修改的頁面編號為:" . $no;
		echo	'<form action="backend.php?fn='.$_GET['fn'].'&act=editsubmit" method="post" enctype="multipart/form-data">
					<table>
						<tr>
							<td>頁面ID：</td>
							<td>
								<input type=text name="id" value="'. $row['id'] .'" class="'.$tInput1.'">
							</td>
						</tr>
						<tr>
							<td>頁面標題：</td>
							<td>
								<input type=text name="title" value="'. $row['title'] .'" class="'.$tInput1.'">
							</td>
						</tr>
						<tr>
							<td>頁面群組：</td>
							<td>';
		echo 					'<select name="group" class="'.$tSelect1.'">';
		foreach ($pgroup_array as $tmpidx => $tmpname){
			echo 					'<option value='.$tmpidx.' '.($tmpidx==$row['pgroup']?' selected':'').'>'.$tmpname.'</option>';
		}
		echo 					'</select>';
		echo 				'</td>
						</tr>
						<tr>
							<td>檔案路徑：</td>
							<td>
								<input type=text name="path" value="'. $row['path'] .'" class="'.$tInput1.'">
							</td>
						</tr>
						<tr>
							<td>檔案上傳：</td>
							<td>

								<div class="input-group">
									<div class="custom-file">
										<input id=fileEdit name=pagefile type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
										<label id=filepathEdit class="custom-file-label" for="inputGroupFile01">選擇檔案</label>
									</div>
								</div>
								<script>
									$("#fileEdit").change(function() {
										$("#filepathEdit").text( $("#fileEdit").val() );
									});
								</script>

							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type=hidden name="no" value="'. $row['no'] .'">
								<button type="submit" class="'.$tbutton_default.'" >送出</button>
							</td>
						</tr>
			 		</table>
				</form>';
	}


	////
	if ($act=="editgroup") {
		echo 	'<b>修改群組</b>';
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

		$sql="select * from `store_itemgroup` where `no`=" . $no;
		$ro=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($ro);

		//echo " 要修改的頁面編號為:" . $no;
		echo	'<form action="backend.php?fn='.$_GET['fn'].'&act=editgroupsubmit" method="post">
					<table>
						<tr>
							<td>群組標題：</td>
							<td>
								<input type=text name="name" value="'. $row['name'] .'" class="'.$tInput1.'">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type=hidden name="no" value="'. $row['no'] .'">
								<button type="submit" class="'.$tbutton_default.'" >送出</button>
							</td>
						</tr>
			 		</table>
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
						<th>頁面ID</th>
						<th>頁面標題</th>
						<th>頁面群組</th>
						<th>檔案路徑</th>
						<th style="width:5%;">no</th>
						<th style="width:10%;">操作</th>
					</tr>';

	$sql="SELECT * FROM `page`";
	$ro=mysqli_query($link,$sql);
	while ($row=mysqli_fetch_array($ro)){
		echo 		'<tr>
						<td>'. $row['id'] .'</td>
						<td>'. $row['title'] .'</td>
						<td>'. $pgroup_array[$row['pgroup']] .'</td>
						<td>'. $row['path'] .'</td>
						<td>'. $row['no'] .'</td>
						<td>
							<a href="?fn='.$_GET["fn"].'&act=edit&no='.$row['no'].'">
								<button type="button" class="'.$tbutton_default.'" >修改</button>
							</a>';
		if ($row['no']<30){
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
	
	echo "</div>";

	//修改群組
	echo '<div class="row">';
	//查詢資料
	echo 	'<div class="col-sm tQueryBackground2">
				<b>查詢群組</b>
				<table style="margin:0 auto;width:100%;">
					<tr>
						<th>群組名稱</th>
						<th style="width:5%;">no</th>
						<th style="width:10%;">操作</th>
					</tr>';

	$sql="SELECT * FROM `store_itemgroup`";
	$ro=mysqli_query($link,$sql);
	while ($row=mysqli_fetch_array($ro)){
		echo 		'<tr>

						<td>'. $row['name'] .'</td>
						<td>'. $row['no'] .'</td>
						<td>
							<a href="?fn='.$_GET["fn"].'&act=editgroup&no='.$row['no'].'">
								<button type="button" class="'.$tbutton_default.'" >修改</button>
							</a>';
		if ($row['no']<4){
			echo			'<button type="button" class="'.$tbutton_light.'" >刪除</button>';
		}else{
			echo 			'<a href="?fn='.$_GET["fn"].'&act=delgroup&no='.$row['no'].'">
								<button type="button" class="'.$tbutton_danger.'" >刪除</button>
							</a>';
		}
		echo 			'</td>
					</tr>';
	}
	echo 		"</table>";
	echo 	"</div>";
	//查詢資料
	
	echo "</div>";
	
	//外層陰影
	echo '</div>';
?>