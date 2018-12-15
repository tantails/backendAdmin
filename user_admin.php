<?php
	include_once "include/base.php";
	//檢查是否有登入及是否從backend.php引用
	include_once "include/auth.php";
?>

<?php
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or (@$act="");

	//功能區
	switch ($act){
		//接收編輯使用者送出的資料並寫入資料庫
		case 'editsubmit':
			(@$id=$_POST["id"]) or (@$id=$_GET["id"]) or ($id="");
			(@$acc=$_POST["acc"]) or (@$acc=$_GET["acc"]) or ($acc="");
			(@$pw=$_POST["pw"]) or (@$pw=$_GET["pw"]) or ($pw="");
			(@$email=$_POST["email"]) or (@$email=$_GET["email"]) or ($email="");
			(@$permission=$_POST["permission"]) or (@$pr=$_GET["permission"]) or ($permission=[]);
			(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or ($name="");
			(@$birthday=$_POST["birthday"]) or (@$birthday=$_GET["birthday"]) or ($birthday="");
			(@$tel=$_POST["tel"]) or (@$tel=$_GET["tel"]) or ($tel="");
			(@$addr=$_POST["addr"]) or (@$addr=$_GET["addr"]) or ($addr="");
			(@$identity=$_POST["identity"]) or (@$identity=$_GET["identity"]) or ($identity="");

			$pr_new=[];
			foreach($permission as $key => $value){
				$pr_new[$value] = 1;
			}
			$pr_new = serialize($pr_new);
						
			//檔案上傳
			if(!empty($_FILES) && !empty($_FILES['img'])){
				$avatars = uploadFile($_FILES['img'],"image");

				if ($avatars){
					$sql_file1="UPDATE `user` SET `avatar` = '".$avatars[0]."', `avatar_small` = '".$avatars[1]."' WHERE `user`.`id` = ".$id;
					$row_file1=$pdo->query($sql_file1);
				}
			}
			//檔案上傳
						
			$sql_edit="UPDATE `user` SET `acc` = '".$acc."', `pw` = '".$pw."', `email` = '".$email."', `permission` = '".$pr_new."', `name` = '".$name."', `birthday` = '".$birthday."', `tel` = '".$tel."', `addr` = '".$addr."', `identity` = '".$identity."' WHERE `user`.`id` = ".$id;
			$row_edit=$pdo->query($sql_edit);

			redirect('?&fn='.$_GET['fn']);
			break;
		//刪除使用者
		case 'del':
			(@$id=$_POST["id"]) or (@$id=$_GET["id"]) or ($id="");

			$sql_del="DELETE FROM `user` WHERE `user`.`id` = ".$id;
			$row_del=$pdo->query($sql_del);

			redirect('?&fn='.$_GET['fn']);
			break;
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

			</div>
		</div> ';
	//新增資料


	//修改資料
	echo '<div id=idEditDiv class="container position-fixed" style="z-index:2000;display:none;">';
	echo 	'<div class="card shadow p-3 t-bg-green" style="width:100%; position: absolute;">';

	if ($act=="edit"){
		(@$id=$_POST["id"]) or (@$id=$_GET["id"]) or ($id="");
	$sql_fn1user="SELECT * FROM `user` WHERE `id`=$id";
	$row_fn1user=$pdo->query($sql_fn1user)->fetch();
	$permission=unserialize($row_fn1user['permission']);

	echo 		'<b>修改使用者</b>';
	echo 		'<form action="?fn=useradmin&act=editsubmit" method="post" enctype="multipart/form-data">
					<div class="row-sm">
						<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">帳號</span>
								</div>
								<input type=text name="acc" value="'.$row_fn1user['acc'].'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">密碼</span>
								</div>
								<input type=text name="pw" value="'.$row_fn1user['pw'].'" name="title" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">
						<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="">頁面標題</span>
								</div>
								<input type=text name="email" value="'.$row_fn1user['email'].'" class="form-control">
							</div>
						</div>
					</div>
					<div class="row-sm">';
	//將各頁面id及title從資料庫表單`page`中取出並印出選項
	$sql_page="SELECT * FROM `page` WHERE `guest` <> 1;";
	$rows_page=$pdo->query($sql_page)->fetchAll();
	foreach($rows_page as $row_page){
		echo 			'<div class="col-12 col-sm-4 col-xl-2 p-0" style="display:inline-block;">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text"> <input type="checkbox" name=permission[] '.(array_key_exists($row_page['id'],$permission) && $permission[$row_page['id']]==1?'checked':'').' value="'.$row_page['id'].'"> </span>
								 </div>
								 <input type=text value="'.$row_page['title'].'" class="form-control bg-white" disabled>
							</div>
						</div>';
	}
	echo				'
						<div class="row-sm">
							<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="">姓名</span>
									</div>
									<input type=text name="name" value="'.$row_fn1user['name'].'" class="form-control">
								</div>
							</div>
						</div>
						<div class="row-sm">
							<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="">生日</span>
									</div>
									<input type=text name="birthday" value="'.$row_fn1user['birthday'].'" class="form-control">
								</div>
							</div>
						</div>
						<div class="row-sm">
							<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="">電話</span>
									</div>
									<input type=text name="tel" value="'.$row_fn1user['tel'].'" class="form-control">
								</div>
							</div>
						</div>
						<div class="row-sm">
							<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="">住址</span>
									</div>
									<input type=text name="addr" value="'.$row_fn1user['addr'].'" class="form-control">
								</div>
							</div>
						</div>
						<div class="row-sm">
							<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="">身分</span>
									</div>
									<select name=identity class="custom-select">
										<option>未選擇</option>';
	$sql_identity="SELECT * FROM `identity`";
	$ro_identity=$pdo->query($sql_identity)->fetchAll();
	foreach($ro_identity as $row_identity){
		echo 							'<option value="'.$row_identity['id'].'" '.($row_identity['id']==$row_fn1user['identity']?' selected':'').'>'.$row_identity['name'].'</option>';
	}
	if ($row_fn1user['avatar']=="") {
		$avatar='img/svg.php?w=200&h=200&b=000&t=No%20Image';
		$avatar_small='img/svg.php?w=100&h=100&b=000&t=No%20Image';
	}else{
		$avatar='file/img/'.$row_fn1user['avatar'];
		$avatar_small='file/img/'.$row_fn1user['avatar_small'];
	}
	echo							'</select>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">頭像</span>
								</div>
								<div class="custom-file">
									<input id=fileAvatar1 name=img type="file" class="custom-file-input" id="inputGroupFile01">
									<label id=filepathAvatar1 class="custom-file-label" for="inputGroupFile01">選擇檔案</label>
								</div>
								<script>
									$("#fileAvatar1").change(function() {
										$("#filepathAvatar1").text( $("#fileAvatar1").val() );
									});
								</script>
							</div>
						</div>						
						<div class="col-12 col-sm-12 col-lg-8 col-xl-6 p-0">
							<a href="'.$avatar.'" target=_blank><img id=imgAvatar src="'.$avatar_small.'" ></a>
						</div>
					</div>
					<div style="position:absolute;right:0;bottom:0;z-index:2500;">
						<input name=id type="hidden" value="'.$row_fn1user['id'].'">
						<button type="submit" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >送出</button>
						<button id=idEditDivButtonClose type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >關閉</button>
						<script>$("#idEditDivButtonClose").click(function(){
							$("#idEditDiv").fadeOut();
						});
						</script>
					</div>
				</form>';
	echo 		'<script>$("#idEditDiv").fadeIn("slow");</script>';			
	}

	echo	'</div>
		</div> ';
	//修改資料
	

	//查詢資料
	echo '<div class="row">
			<div class="card shadow w-100 mb-5 tQueryBackground">


		 		<b>查詢使用者</b>';
	echo 		'<table id=tableQuery1 class="rwd-table" style="width:100%;margin:0 auto;border:0px;">
					<thead>
					<tr>
						<th>使用者</th>
						<th style="width:5%;">no</th>
						<th style="width:10%;">操作</th>
					</tr>
					</thead>
					<tbody>';
	$sql_fn1user="SELECT * FROM `user`";
	$rows_fn1user=$pdo->query($sql_fn1user)->fetchAll();
	foreach($rows_fn1user as $row){
		echo 		'<tr>
						<td data-th="使用者" >'.$row['acc'].'</td>
						<td data-th="no" >'.$row['id'].'</td>
						<td data-th="操作" >
							<a href="?fn=useradmin&act=edit&id='.$row['id'].'">
								<button type="button" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" >修改</button>
							</a> 
							<a href="?fn=useradmin&act=del&id='.$row['id'].'">
								<button type="button" class="mdl-button bg-danger text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent t_input" >刪除</button>
							</a>
						</td>
					</tr>';
	}
	echo 			'</tbody>
					<tfoot>
					<tr>
						<th>使用者</th>
						<th style="width:5%;">no</th>
						<th style="width:10%;">操作</th>
					</tr>
					</tfoot>
				</table>		


			</div>
		</div>';
	//查詢資料


	echo '</div>';
	//頁面內容區-------------------------------------------------

	echo '<script>
	
		$("#tableQuery1").DataTable({"responsive": true,"paging": false});

	</script>';

	//清除多餘頭像
	$path='file/img/';
	$out = scandir($path);
	foreach ($out as $index => $filepath){
		if ($index>1 && $filepath!="0000000000.jpg" && $filepath!="0000000000_icon.jpg"){
			$sql_find="SELECT * FROM `user` WHERE `avatar`='" . $filepath . "' OR `avatar_small` = '".$filepath."'";
			$rows_find=$pdo->query($sql_find)->fetchAll();
			if (!$rows_find){
				echo $path.$filepath . '>nofind';
				unlink($path.$filepath);
				echo '<br>';
			}
		}
	}
?>