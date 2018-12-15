<?php
	include_once "include/base.php";
	include_once "include/auth.php";
?>
<?php
	$rows=$pdo->query(
		"SELECT * FROM `site_info`"
		)->fetchAll();

	$siteinfo=[];
	foreach ($rows as $row ) {
		$siteinfo[$row['name']]=$row['value'];
	}
?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php
	if ($siteinfo) {
		echo '<title>'.$siteinfo['title'].'</title>';
	}
	?>

<?php include "include/head.php"; ?>

<?php
	$row_pr=$pdo->query(
		"SELECT * FROM `user` WHERE `acc`='".$_SESSION['admin']."'"
		)->fetch();
	if ($row_pr) {
		$permission=unserialize($row_pr['permission']);
	}else{
		$permission = [];
	}
?>

<?php 
	//導航列
	//<!--Navbar-->
	echo '<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top" style="border-bottom:5px solid #666;">';
	//<!-- Navbar brand -->
	echo 	'<a class="navbar-brand" href="?fn=home">'.(!empty($siteinfo)?$siteinfo['sitename']:'Navbar').'</a>';
	//<!-- Collapse button -->
	echo	'<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler01" aria-controls="navbarToggler01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>';
	//<!-- Collapsible content -->
	echo	'<div class="collapse navbar-collapse" id="navbarToggler01">';
	//<!-- Links -->
	echo		'<ul class="navbar-nav mr-auto mt-2 mt-lg-0">';
	//頁面
	$row_nowpage=$pdo->query(
		"SELECT * FROM `page` WHERE `id`='".$fn."'"
		)->fetch();

	$rows_pgroup=$pdo->query(
		"SELECT * FROM `page_group`"
		)->fetchAll();
	foreach($rows_pgroup as $row_pgroup){
		if ($rows_test=$pdo->query(
				"SELECT * FROM `page` WHERE `pgroup` = ".$row_pgroup['no'] ." AND `type` = ".$row_nowpage['type']
			)){
			$rows_test=$rows_test->fetchAll();
		}else{
			redirect("?fn=home");
		}
		
		if (count($rows_test)>0){

			echo '
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							'.$row_pgroup['name'].'
						</a>';

			$rows_page=$pdo->query(
				"SELECT * FROM `page` WHERE `pgroup` = ".$row_pgroup['no'] ." AND `type` = ".$row_nowpage['type']
				)->fetchAll();
			echo 		'<div class="dropdown-menu shadow" aria-labelledby="navbarDropdown">';
			foreach($rows_page as $row_page){
				if ($row_page['guest']==1){
					echo 	'<a class="dropdown-item" href=?fn='.$row_page['id'].'>'.$row_page['title'].'</a>';
				}elseif(array_key_exists($row_page['id'],$permission) && $permission[$row_page['id']]==1){
					echo 	'<a class="dropdown-item" href=?fn='.$row_page['id'].'>'.$row_page['title'].'</a>';
				}else{
					echo 	'<a class="dropdown-item disabled" href=#>'.$row_page['title'].'</a>';
				}
			}
			echo 		'</div>
					</li>';
		}

	}


	echo  '</ul>
			<ul class="navbar-nav">';

	if	($_SESSION['admin']!='guest'){
		if ($row_nowpage['type']==0){
			echo '<li class="nav-item">
					<a class="nav-link" href="/phpmyadmin" target="_blank">phpMyAdmin</a>
				</li>';
		}
		echo 	'<li class="nav-item">';
				if ($row_nowpage['type']==0){
					echo '<a class="nav-link" href=index.php>返回前台</a>';
				}else{
					echo '<a class="nav-link" href="?fn=back_home"><i class="fa fa-cog" aria-hidden="true"></i>後台管理</a>';
				}
					
		echo	'</li>';
	}
	echo		'<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" style="margin-right:20px;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-user"></i>使用者: '.$_SESSION['admin'].'
					</a>
					<div class="dropdown-menu shadow" aria-labelledby="navbarDropdown">';
	if	($_SESSION['admin']!='guest'){
		echo 			'<a class="dropdown-item" href="api.php?do=logout">登出</a>';
	}else{
		echo 			'<form id=login action="api.php?do=login" method="POST" class="px-1 py-0">
							<div class="form-group">
								<label for="DropdownFormUser1">帳號</label>
								<input type="text" name="acc" class="form-control" value="demo" id="DropdownFormUser1" placeholder="User">
	  						</div>
							<div class="form-group">
								<label for="DropdownFormPassword1">密碼</label>
								<input type="password" name="pw" class="form-control" value="demo" id="DropdownFormPassword1" placeholder="Password">
	  						</div>
						</form>';
		echo '<a class="dropdown-item" href="#" onclick="$('."'".'#login'."'".').submit();">登入</a>';
		echo '<a class="dropdown-item" href="?fn=reg">註冊</a>';
	}
	
	echo 			'</div>
				</li>
			</ul>
		</div>
	</nav>';
	//導航列

	//頁面內容
	(@$fn=$_POST["fn"]) or (@$fn=$_GET["fn"]) or ($fn="");
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or ($act="");
	(@$id=$_POST["id"]) or (@$id=$_GET["id"]) or ($id="");

	$row_page=$pdo->query(
		"SELECT * FROM `page` WHERE `id` = '".$fn."'"
		)->fetch();

	if ($row_page){
		echo '<div style="margin-bottom:100px; margin-top:57px; ">';
		include_once $row_page['path'];
		echo '</div>';
	}else{
		redirect('?fn=home');
	}
	//頁面內容

	include_once "include/end.php";

	//BOTTOM
	echo '<div class="bg-dark text-light text-center position-fixed fixed-bottom" style="height:50px;">
			<div class="d-table h-100 w-100">
				<div class="d-table-cell align-middle">
					copyright © '.date('Y').' tantails all rights reserved
				</div>
			</div>
		</div>';
	//BOTTOM
?>
</body>
</html>