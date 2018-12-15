<?php
	include_once "include/base.php";
	include_once "include/auth.php";
?>
<?php
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or (@$act="");
	$sql="";

	switch ($act){
		case "insert":
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");
			(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);
			(@$path=$_POST["path"]) or (@$path=$_GET["path"]) or (@$path="");
			(@$price=$_POST["price"]) or (@$price=$_GET["price"]) or (@$price=0);
			(@$spec=$_POST["spec"]) or (@$spec=$_GET["spec"]) or (@$spec="");
			(@$stock=$_POST["stock"]) or (@$stock=$_GET["stock"]) or (@$stock=0);
			(@$description=$_POST["description"]) or (@$description=$_GET["description"]) or (@$description="");
			(@$status=$_POST["status"]) or (@$status=$_GET["status"]) or (@$status=0);
			(@$itemno=$_POST["itemno"]) or (@$itemno=$_GET["itemno"]) or (@$itemno="");

			if ($name!=""){
				//檔案上傳
				if(!empty($_FILES) && !empty($_FILES['storefile']) ){
					$tmpPath = uploadFile($_FILES['storefile'],"storeitemimg");
					if ($tmpPath){
						$path = 'file/store/'. $tmpPath[0];
					}
				}
				//檔案上傳

				$sql="INSERT INTO `store_item` (`no`, `name`, `ingroup`, `path`, `price`, `spec`, `stock`, `status`, `itemno`, `description`) VALUES (NULL, '".$name."', '".$group."', '".$path."', '".$price."', '".$spec."', '".$stock."', '".$status."', '".$itemno."', '".$description."');";
				$ro=mysqli_query($link,$sql);

				//取得寫入後產品的no,ingroup
				$sql="SELECT * FROM `store_item` WHERE `name`='".$name."' AND `ingroup`='".$group."'";
				$row=$pdo->query($sql)->fetch();
				
				//產生產品編號
				$sql_topgroup="SELECT * FROM `store_itemgroup` WHERE `no` = '".$group."'";
				$row_topgroup=$pdo->query($sql_topgroup)->fetch();
				$itemno=substr( '00'.$row_topgroup['ingroup'],-3,3 ) . substr( '00'.$group,-3,3 ) . substr( '0'.$row['no'],-3,3 );
				//寫入產品編號
				$sql="UPDATE `store_item` SET `itemno` = '". $itemno ."' WHERE `no` = '". $row['no'] ."';";
				$row=$pdo->query($sql);
			}

			redirect('?&fn='.$_GET['fn']);
			break;
		case "insertgroup":
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");
			(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);

			if ($name!=""){
				$sql="INSERT INTO `store_itemgroup` (`no`, `name`, `ingroup`) VALUES (NULL, '".$name."', '".$group."');";
				$ro=mysqli_query($link,$sql);
			}
			
			redirect('?&fn='.$_GET['fn']);
			break;
		case "editsubmit":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");
			(@$path=$_POST["path"]) or (@$path=$_GET["path"]) or (@$path="");
			(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);
			(@$price=$_POST["price"]) or (@$price=$_GET["price"]) or (@$price=0);
			(@$spec=$_POST["spec"]) or (@$spec=$_GET["spec"]) or (@$spec="");
			(@$stock=$_POST["stock"]) or (@$stock=$_GET["stock"]) or (@$stock=0);
			(@$description=$_POST["description"]) or (@$description=$_GET["description"]) or (@$description="");
			(@$status=$_POST["status"]) or (@$status=$_GET["status"]) or (@$status=0);
			//(@$itemno=$_POST["itemno"]) or (@$itemno=$_GET["itemno"]) or (@$itemno="");

			//產生產品編號
			$sql_topgroup="SELECT * FROM `store_itemgroup` WHERE `no` = '".$group."'";
			$row_topgroup=$pdo->query($sql_topgroup)->fetch();
			$itemno=substr( '00'.$row_topgroup['ingroup'],-3,3 ) . substr( '00'.$group,-3,3 ) . substr( '0'.$no,-3,3 );

			$sql_page="SELECT * FROM `store_item` WHERE `no` = '".$no."'";
			$row_page=$pdo->query($sql_page)->fetch();
			//修改頁面路徑('path')前先把頁面檔名變更
			if ($row_page['path']!="" && $row_page['path']!=$path){
				if (file_exists($row_page['path'])){
					rename ($row_page['path'], $path);
				}
			}

			//檔案上傳
			if(!empty($_FILES) && !empty($_FILES['storefile']) && $_FILES['storefile']['size']>0 ){
				$tmpPath = uploadFile($_FILES['storefile'],"storeitemimg");
				if ($tmpPath){
					$path = 'file/store/'. $tmpPath[0];
				}
			}
			//檔案上傳

			$sql="UPDATE
						`store_item`
					SET 
						`name` = '". $name ."', 
						`path` = '". $path ."', 
						`ingroup` = '". $group ."', 
						`price` = '". $price ."', 
						`spec` = '". $spec ."', 
						`stock` = '". $stock ."', 
						`status` = '". $status ."', 
						`itemno` = '". $itemno ."', 
						`description` = '". $description ."' 
					WHERE 
						`no` = '". $no ."'
				;";
			$ro=mysqli_query($link,$sql);
			redirect('?&fn='.$_GET['fn']);
			break;
		case "editgroupsubmit":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");
			(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);

			$sql="UPDATE `store_itemgroup` SET `name` = '". $name ."', `ingroup` = '". $group ."' WHERE `no` = '". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('?&fn='.$_GET['fn']);
			break;
		case "del":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			$sql_del="SELECT * FROM `store_item` WHERE `no`='" . $no . "';";
			$row_del=$pdo->query($sql_del)->fetch();

			$sql_find="SELECT * FROM `store_item` WHERE `no`='" . $no . "' AND `path` <> '".$row_del['path']."';";
			if ($sql_find){
				unlink($row_del['path']);
			}

			$sql="DELETE FROM `store_item` WHERE `no`='". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('?&fn='.$_GET['fn']);
			break;
		case "delgroup":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			$sql="DELETE FROM `store_itemgroup` WHERE `no`='". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('?&fn='.$_GET['fn']);
			break;
	}

	$igroup_array=[];
	$sql_pgroup="SELECT * FROM `store_itemgroup`";
	$rows_pgroup=$pdo->query($sql_pgroup)->fetchAll();
	foreach($rows_pgroup as $row_pgroup){
		$igroup_array[$row_pgroup['no']]=[
			'name' => $row_pgroup['name'],
			'ingroup' => $row_pgroup['ingroup']
		];
	}

	//echo "頁面管理";
	//外層陰影
	echo '<div class="col shadow">';

    echo '<div class="row">';

	//新增資料
	echo 	'<div class="col-sm tNewBackground">
				<b>新增商品</b>
				<form action="?fn='.$_GET['fn'].'&act=insert" method="post" enctype="multipart/form-data">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品編號</span>
								</div>
								<input type=text value="系統自動產生" class="form-control bg-white" readonly>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品名稱</span>
								</div>
								<input type=text name="name" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text">商品分類</label>
								</div>
								<select name="group" class="custom-select">';
								foreach ($igroup_array as $tmpidx => $igroup){
	if ($igroup['ingroup']==0){
		echo						'<option value='.$tmpidx.' style="font-weight:bolder;" disabled>--'.$igroup_array[$tmpidx]['name'].'--</option>';
		foreach ($igroup_array as $tmpidx2 => $igroup2){
			if ($igroup2['ingroup']==$tmpidx){
				echo				'<option value='.$tmpidx2.'>'.$igroup_array[$tmpidx2]['name'].'</option>';
			}
		}
	}
								}
	echo						'</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">價錢</span>
								</div>
								<input type=text name="price" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">規格</span>
								</div>
								<input type=text name="spec" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">庫存量</span>
								</div>
								<input type=text name="stock" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品狀態</span>
								</div>
								<select name="status" class="custom-select">
									<option value=0>下架</option>
									<option value=1>上架</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品詳細介紹</span>
								</div>
								<textarea name="description" class="form-control"></textarea>
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
									<input id=fileNew1 name="storefile" type="file" class="custom-file-input" id="inputGroupFile01">
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

				<b>新增分類</b>
				<form action="?fn='.$_GET['fn'].'&act=insertgroup" method="post">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">分類名稱</span>
								</div>
								<input type=text name="name" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">上層分類</span>
								</div>
								<select name="status" class="custom-select">
									<option value=0 >新增為主分類</option>';
foreach ($igroup_array as $tmpidx => $igroup){
	if ($igroup['ingroup']==0){
		echo						'<option value='.$tmpidx.' style="font-weight:bolder;">--'.$igroup_array[$tmpidx]['name'].'--</option>';
		foreach ($igroup_array as $tmpidx2 => $igroup2){
			if ($igroup2['ingroup']==$tmpidx){
				echo				'<option value='.$tmpidx2.'>'.$igroup_array[$tmpidx2]['name'].'</option>';
			}
		}
	}
}								
echo							'</select>
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
		echo 	'<b>修改商品</b>';
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

		$sql="select * from `store_item` where `no`=" . $no;
		$ro=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($ro);

		//echo " 要修改的頁面編號為:" . $no;
		echo	'<form action="?fn='.$_GET['fn'].'&act=editsubmit" method="post" enctype="multipart/form-data">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品編號</span>
								</div>
								<input type=text value="'. $row['itemno'] .'" class="form-control bg-white" readonly>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品名稱</span>
								</div>
								<input type=text name="name"  value="'. $row['name'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品分類</span>
								</div>
								<select name="group" class="custom-select">';
		foreach ($igroup_array as $tmpidx => $igroup){
			if ($igroup['ingroup']==0){
				echo				'<option value='.$tmpidx.' style="font-weight:bolder;" disabled>--'.$igroup_array[$tmpidx]['name'].'--</option>';
				foreach ($igroup_array as $tmpidx2 => $igroup2){
					if ($igroup2['ingroup']==$tmpidx){
						echo		'<option value='.$tmpidx2.' '.($tmpidx2==$row['ingroup']?' selected':'').'>'.$igroup_array[$tmpidx2]['name'].'</option>';
					}
				}
			}
		}
		echo					'</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">價錢</span>
								</div>
								<input type=text name="price"  value="'. $row['price'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">規格</span>
								</div>
								<input type=text name="spec"  value="'. $row['spec'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">庫存量</span>
								</div>
								<input type=text name="stock"  value="'. $row['stock'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品狀態</span>
								</div>
								<select name="status" class="custom-select">
									<option value=0>下架</option>
									<option value=1 '.($row['status']==1?' selected':'').'>上架</option>';
		echo					'</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">商品詳細介紹</span>
								</div>
								<textarea name="description" class="form-control">'. $row['description'] .'</textarea>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">檔案路徑</span>
								</div>
								<input type=text name="path"  value="'. $row['path'] .'" class="form-control">
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
									<input id=fileEdit1 name="storefile" type="file" class="custom-file-input" id="inputGroupFile01">
									<label id=filepathEdit1 class="custom-file-label" for="inputGroupFile01">選擇檔案</label>
								</div>
								<script>
									$("#fileEdit1").change(function() {
										$("#filepathEdit1").text( $("#fileEdit1").val() );
									});
								</script>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<img src="'. $row['path'] .'" style="height:200px;">
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


	////
	if ($act=="editgroup") {
		echo 	'<b>修改分類</b>';
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

		$sql="select * from `store_itemgroup` where `no`=" . $no;
		$ro=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($ro);

		//echo " 要修改的頁面編號為:" . $no;
		echo	'<form action="?fn='.$_GET['fn'].'&act=editgroupsubmit" method="post">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">分類名稱</span>
								</div>
								<input type=text name="name"  value="'. $row['name'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">上層分類</span>
								</div>
								<select name="group" class="custom-select">
									<option value=0 style="font-weight:bolder">主分類</option>';
		foreach ($igroup_array as $index1 => $igroup){
			if ($igroup['ingroup']==0){
				echo				'<option value="'.$index1.'" '.($row['ingroup']==$index1?' selected':'').' style="font-weight:bolder;">--'.$igroup_array[$index1]['name'].'--</option>';
				foreach ($igroup_array as $index2 => $igroup2){
					if ($igroup2['ingroup']==$index1){
						echo		'<option value="'.$index2.'" '.($row['ingroup']==$index2?' selected':'').'>'.$igroup_array[$index2]['name'].'</option>';
					}
				}
			}
		}
		echo					'</select>
							</div>
						</div>
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
				<b>查詢商品</b>
				<table style="margin:0 auto;width:100%;">
					<tr>
						<th>商品編號</th>
						<th>商品名稱</th>
						<th>商品分類</th>
						<th>價錢</th>
						<th>規格</th>
						<th>庫存量</th>
						<th>上架</th>
						<th>商品詳細介紹</th>
						<th>商品圖片</th>
						<th style="width:5%;">no</th>
						<th style="width:10%;">操作</th>
					</tr>';

	$sql="SELECT * FROM `store_item`";
	$ro=mysqli_query($link,$sql);
	while ($row=mysqli_fetch_array($ro)){
		echo 		'<tr>
						<td>'. $row['itemno'] .'</td>
						<td>'. $row['name'] .'</td>
						<td>'. $igroup_array[$row['ingroup']]['name'] .'</td>
						<td>'. $row['price'] .'</td>
						<td>'. $row['spec'] .'</td>
						<td>'. $row['stock'] .'</td>
						<td>'. ($row['status']==1?'上架':'<span style="color:#f00;">下架</span>') .'</td>
						<td>'. (mb_strlen( $row['description'], "utf-8")>5?mb_substr($row['description'], 0, 5,"utf-8").'...':$row['description']).'</td>
						<td><a href="'. $row['path'] .'" target=_blank><img src="'. $row['path'] .'" style="height:20px;"></a></td>
						<td>'. $row['no'] .'</td>
						<td>
							<a href="?fn='.$_GET["fn"].'&act=edit&no='.$row['no'].'">
								<button type="button" class="'.$tbutton_default.'" >修改</button>
							</a>';
	//	if ($row['no']<30){
	//		echo			'<button type="button" class="'.$tbutton_light.'" >刪除</button>';
	//	}else{
			echo 			'<a href="?fn='.$_GET["fn"].'&act=del&no='.$row['no'].'">
								<button type="button" class="'.$tbutton_danger.'" >刪除</button>
							</a>';
	//	}
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
				<b>查詢分類</b>
				<table style="margin:0 auto;width:100%;">
					<tr>
						<th>分類名稱</th>
						<th>上層分類名稱</th>
						<th style="width:5%;">no</th>
						<th style="width:10%;">操作</th>
					</tr>';

	foreach ($igroup_array as $tmpidx => $igroup){
		if ($igroup['ingroup']==0){
			//echo					'<option value='.$tmpidx.' style="font-weight:bolder;" disabled>--'.$igroup_array[$tmpidx]['name'].'--</option>';
			echo 	'<tr style="background-color:#ffff88;font-weight:bolder;">
						<td>'. $igroup_array[$tmpidx]['name'] .'</td>
						<td>'. ($igroup_array[$tmpidx]['ingroup']==0?'主分類':$igroup_array[$igroup_array[$tmpidx]['ingroup']]['name']) .'</td>
						<td>'. $tmpidx .'</td>
						<td>
							<a href="?fn='.$_GET["fn"].'&act=editgroup&no='.$tmpidx.'">
								<button type="button" class="'.$tbutton_default.'" >修改</button>
							</a>
							<a href="?fn='.$_GET["fn"].'&act=delgroup&no='.$tmpidx.'">
								<button type="button" class="'.$tbutton_danger.'" >刪除</button>
							</a>';

			echo 			'</td>
					</tr>';

			foreach ($igroup_array as $tmpidx2 => $igroup2){
				if ($igroup2['ingroup']==$tmpidx){
					//echo			'<option value='.$tmpidx2.'>'.$igroup_array[$tmpidx2]['name'].'</option>';
					echo 	'<tr>
								<td>'. $igroup_array[$tmpidx2]['name'] .'</td>
								<td>'. $igroup_array[$igroup_array[$tmpidx2]['ingroup']]['name'] .'</td>
								<td>'. $tmpidx2 .'</td>
								<td>
									<a href="?fn='.$_GET["fn"].'&act=editgroup&no='.$tmpidx2.'">
										<button type="button" class="'.$tbutton_default.'" >修改</button>
									</a>
									<a href="?fn='.$_GET["fn"].'&act=delgroup&no='.$tmpidx2.'">
										<button type="button" class="'.$tbutton_danger.'" >刪除</button>
									</a>';

					echo 			'</td>
							</tr>';
				}
			}
		}
	}

	echo 		"</table>";
	echo 	"</div>";
	//查詢資料
	
	echo "</div>";
	
	//外層陰影
	echo '</div>';
?>