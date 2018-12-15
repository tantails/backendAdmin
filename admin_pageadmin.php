<?php
	include_once "include/base.php";
	//檢查是否有登入及是否從backend.php引用
	include_once "include/auth.php";
?>

<?php
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or (@$act="");

	//功能區
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

				$ro=$pdo->query(
					"INSERT INTO `page` (`no`, `id`, `title`, `path`, `pgroup`, `guest`, `type`) VALUES (NULL, '".$id."', '".$title."', '".$path."', '".$group."', '".$guest."', '".$type."');"
					);
			}

			redirect('?&fn='.$_GET['fn']);
			break;
		case "insertgroup":
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or (@$name="");

			if ($name!=""){
				$ro=$pdo->query(
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
	}

	$pgroup_array=[];
	$rows_pgroup=$pdo->query(
		"SELECT * FROM `page_group`"
		)->fetchAll();
	foreach($rows_pgroup as $row_pgroup){
		$pgroup_array[$row_pgroup['no']]=$row_pgroup['name'];
	}
	//功能區



	//主標題
	echo '<div class="container-fluid text-white shadow" style="width:100%;height:100px;background-image:url(\'img/title-background.jpg\')">
			<div class="m-auto" style="width:90%">
			<table class="h-100">
				<tr>
					<td class="align-middle">
					<h2 style="font-weight:bolder;">'.$row_page['title'].'</h2>
					</td>
				</tr>
			</table>
		
			</div>
		</div>';
	//主標題

	//頁面內容區-------------------------------------------------
	echo '<div class="m-0 m-auto" style="width:90%;padding-top:50px;">';


	//右下新增按鈕
	echo '<div class="position-fixed" style="right:30px;bottom:60px;z-index:1500">';
	echo '<button id="idButtonShowNewDiv" class="mdl-button bg-primary text-white mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent"><i class="material-icons">add</i></button>';
	echo '<script>
			$( document ).ready(function() {
				$("#idNewDiv").hide();
			});
			$("#idButtonShowNewDiv").click(function(){
				$("#idEditDiv").fadeOut();
				$("#idNewDiv").fadeIn("slow");
			});
		</script>';
	echo '</div>';
	//右下新增按鈕


	//新增資料
	echo '<div id=idNewDiv class="container position-fixed" style="z-index:2000;display:none;">
			<div class="card shadow p-3 t-bg-reg" style="text-align;right;width:100%;float: right !important;">
				<b>新增頁面</b>
				<form action="?fn='.$_GET['fn'].'&act=insert" method="post" enctype="multipart/form-data">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">頁面ID</span>
								</div>
								<input type=text name="id" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">頁面標題</span>
								</div>
								<input type=text name="title" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text">頁面群組</label>
								</div>
								<select name="group" class="custom-select">
									<option value=0>無群組</option>';
	foreach ($pgroup_array as $tmpidx => $tmpname){
		echo 						'<option value='.$tmpidx.'>'.$tmpname.'</option>';
	}
	echo						'</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text">允許訪客</label>
								</div>
								<select name="guest" class="custom-select">
									<option value=0>否</option>
									<option value=1>是</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text">頁面類型</label>
								</div>
								<select id=testselect name="type" class="custom-select">
									<option value=0>後台網頁</option>
									<option value=1>前台網頁</option>
								</select>
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
					<div style="position:absolute;right:0;bottom:0;z-index:2500;">
						<button type="submit" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >送出</button>
						<button id=idNewDivButtonClose1 type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >關閉</button>
						<script>$("#idNewDivButtonClose1").click(function(){
							$("#idNewDiv").fadeOut();
						});
						</script>
					</div>
				</form>
			</div>
			<div class="card shadow p-3 t-bg-reg" style="text-align;right;width:100%;">
				<b>新增群組</b>
				<form action="?fn='.$_GET['fn'].'&act=insertgroup" method="post">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">群組名稱</span>
								</div>
								<input type=text name="name" class="form-control">
							</div>
						</div>
					</div>
					<div style="position:absolute;right:0;bottom:0;z-index:2500;">
						<button type="submit" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >送出</button>
						<button id=idNewDivButtonClose2 type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >關閉</button>
						<script>$("#idNewDivButtonClose2").click(function(){
							$("#idNewDiv").fadeOut();
						});
						</script>
					</div>
				</form>
			</div>
		</div> ';
	//新增資料

	//修改資料
	echo '<div id=idEditDiv class="container position-fixed" style="z-index:2000;display:none;">';
	echo 	'<div class="card shadow p-3 t-bg-green" style="width:100%; position: absolute;">';

	if ($act=="edit") {
		echo 	'<b>修改頁面</b>';
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

		$row=$pdo->query(
			"SELECT * FROM `page` WHERE `no`=" . $no
			)->fetch();

		//echo " 要修改的頁面編號為:" . $no;
		echo	'<form action="?fn='.$_GET['fn'].'&act=editsubmit" method="post" enctype="multipart/form-data">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">頁面ID</span>
								</div>
								<input type=text name="id" value="'. $row['id'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">頁面標題</span>
								</div>
								<input type=text name="title" value="'. $row['title'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text">頁面群組</label>
								</div>
								<select name="group" class="custom-select">
									<option value=0>無群組</option>';
		foreach ($pgroup_array as $tmpidx => $tmpname){
			echo 					'<option value='.$tmpidx.' '.($tmpidx==$row['pgroup']?' selected':'').'>'.$tmpname.'</option>';
		}
		echo					'</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text">允許訪客</label>
								</div>
								<select name="guest" class="custom-select">
									<option value=0>否</option>
									<option value=1'.($row['guest']==1?' selected':'').'>是</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text">頁面類型</label>
								</div>
								<select name="type" class="custom-select">
									<option value=0>後台網頁</option>
									<option value=1'.($row['type']==1?' selected':'').'>前台網頁</option>
								</select>
							</div>
						</div>
					</div>
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
									$("#fileEdit1").change(function() {
										$("#filepathEdit1").text( $("#fileEdit1").val() );
									});
								</script>
							</div>
						</div>
					</div>
					<div style="position:absolute;right:0;bottom:0px;z-index:2500;">
						<input type=hidden name="no" value="'. $row['no'] .'">
						<button type="submit" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >送出</button>
						<button id=idEditDivButtonClose type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >關閉</button>
						<script>$("#idEditDivButtonClose").click(function(){
							$("#idEditDiv").fadeOut();
						});
						</script>
					</div>
				</form>';
		echo 	'<script>$("#idEditDiv").fadeIn("slow");</script>';
	}


	////
	if ($act=="editgroup") {
		echo 	'<b>修改群組</b>';
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

		$row=$pdo->query(
			"SELECT * FROM `page_group` WHERE `no`=" . $no
			)->fetch();

		//echo " 要修改的頁面編號為:" . $no;
		echo	'<form action="?fn='.$_GET['fn'].'&act=editgroupsubmit" method="post">
					<div class="row-sm">
						<div class="col-12 col-xl-7 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">群組名稱</span>
								</div>
								<input type=text name="name" value="'. $row['name'] .'" class="form-control">
							</div>
						</div>
					</div>
					<div style="position:absolute;right:0;bottom:0px;z-index:2500;">
						<input type=hidden name="no" value="'. $row['no'] .'">
						<button type="submit" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >送出</button>
						<button id=idEditDivButtonClose type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >關閉</button>
						<script>$("#idEditDivButtonClose").click(function(){
							$("#idEditDiv").fadeOut();
						});
						</script>
					</div>
				</form>';
		echo 	'<script>$("#idEditDiv").fadeIn("slow");</script>';
	}

	echo 	'</div>';
	echo '</div>';
	//修改資料

	//查詢頁面資料
	echo '<div class="row">
			<div class="card shadow w-100 mb-5 tQueryBackground">

				<b>查詢頁面</b>
				<table id=tableQuery1 class="rwd-table" style="margin:0 auto;width:100%;">
					<thead>
					<tr>
						<th>頁面ID</th>
						<th>頁面標題</th>
						<th>頁面群組</th>
						<th>檔案路徑</th>
						<th>允許訪客</th>
						<th>頁面類型</th>
						<th style="width:10%;">操作</th>
					</tr>
					</thead>
					<tbody>';

	$idprefix='idpage';
	$rows=$pdo->query(
		"SELECT * FROM `page`"
		)->fetchAll();

	foreach($rows as $row){
		echo 		'<tr id="'.$idprefix.$row['no'].'">
						<td data-th="頁面ID" ><a href="?fn='.$row['id'].'" target=_blank>'. $row['id'] .'</a></td>
						<td data-th="頁面標題" >'. $row['title'] .'</td>
						<td data-th="頁面群組" >'. ($row['pgroup']==0?'無群組':$pgroup_array[$row['pgroup']]) .'</td>
						<td data-th="檔案路徑" >'. $row['path'] .'</td>
						<td data-th="允許訪客" >'. ($row['guest']==1?'是':'') .'</td>
						<td data-th="頁面類型" >'. ($row['type']==1?'前台':'後台') .'</td>
						<td data-th="操作" >
							<a href="?fn='.$_GET["fn"].'&act=edit&no='.$row['no'].'"><button type="button" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" >修改</button></a>';
		if (strpos($row['path'],'/')==0){
			echo			'<button type="button" class="mdl-button bg-dark text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" >DEL</button>';
		}else{
			echo			'<button type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" onclick="del('."'".$idprefix."'".','.$row['no'].')" >DEL</button>';
		}
		echo 			'</td>
					</tr>';
	}
	echo 		'</tbody>';

	echo '
					<tfoot>
					<tr>
						<th>頁面ID</th>
						<th>頁面標題</th>
						<th>頁面群組</th>
						<th>檔案路徑</th>
						<th>允許訪客</th>
						<th>頁面類型</th>
						<th style="width:10%;">操作</th>
					</tr>
					</tfoot>
				</table>

			</div>
		</div>';
	//查詢頁面資料

	//查詢群組資料
	echo '<div class="row">
			<div class="card shadow w-100 mb-5 tQueryBackground2">
			
							<b>查詢群組</b>
				<table id=tableQuery2 class="rwd-table" style="margin:0 auto;width:100%;">
					<thead>
					<tr>
						<th>群組名稱</th>
						<th style="width:10%;">操作</th>
					</tr>
					</thead>
					<tbody>';

	$idprefix='idgroup';
	$rows=$pdo->query(
		"SELECT * FROM `page_group`"
		)->fetchAll();
	foreach($rows as $row){
		echo 		'<tr id="'.$idprefix.$row['no'].'">

						<td data-th="群組名稱" >'. $row['name'] .'</td>
						<td data-th="操作" >
							<a href="?fn='.$_GET["fn"].'&act=editgroup&no='.$row['no'].'">
								<button type="button" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" >修改</button>
							</a>';
		$rows_find=$pdo->query(
			"SELECT * FROM `page` WHERE `pgroup` = '".$row['no']."'"
			)->fetchAll();

		if (count($rows_find)>0){
			echo			'<button type="button" class="mdl-button bg-dark text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" >DEL</button>';
		}else{
			echo			'<button type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" onclick="delgroup('."'".$idprefix."'".','.$row['no'].')" >DEL</button>';
		}
		echo 			'</td>
					</tr>';
	}
	echo 			'</tbody>
					<tfoot>
					<tr>
						<th>群組名稱</th>
						<th style="width:10%;">操作</th>
					</tr>
					</tfoot>
				</table>
			
			
			</div>
		</div>';
	//查詢群組資料


	echo '<br><br><br><br><br><br><br><br>';


	echo '<script>
		//$('."'".'[data-toggle="tooltip"]'."'".').tooltip();
		//$("button").tooltip();

		$("#tableQuery1").DataTable({"responsive": true,"paging": false});
		$("#tableQuery2").DataTable({"responsive": true,"paging": false});

		function del(idprefix,idx){
			console.log(idx);
			$.get("admin_pageadmin_api.php",{"act":"del","no":idx},function(data){
				console.log(data)
				var obj = JSON.parse(data);
				if (obj.status=="ok"){
					$("#"+idprefix+idx).hide();
					$("#idDebug").html(obj.sql);
				}
			})
		}

		function delgroup(idprefix,idx){
			console.log(idx);
			$.get("admin_pageadmin_api.php",{"act":"delgroup","no":idx},function(data){
				console.log(data)
				var obj = JSON.parse(data);
				if (obj.status=="ok"){
					$("#"+idprefix+idx).hide();
					$("#idDebug").html(obj.sql);
				}
			})
		}
		
		//status
		//scol? fname?
		function get(idprefix,idx){}
		function getgroup(idprefix,idx){}
		function edit(idprefix,idx){}
		function editgroup(idprefix,idx){}
		function add(idprefix,idx){}
		function addgroup(idprefix,idx){}
	</script>';


	//頁面內容區-------------------------------------------------
	echo '</div>';
?>