<?php
	(@$acc=$_POST["acc"]) or (@$acc=$_GET["acc"]) or ($acc="");
	(@$pw=$_POST["pw"]) or (@$pw=$_GET["pw"]) or ($pw="");
	(@$email=$_POST["email"]) or (@$email=$_GET["email"]) or ($email="");
	(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or ($name="");
	(@$birthday=$_POST["birthday"]) or (@$birthday=$_GET["birthday"]) or ($birthday="");
	(@$tel=$_POST["tel"]) or (@$tel=$_GET["tel"]) or ($tel=""); 
?>
  <style>
  table{
    width:400px;
    margin:20px auto;
    border:1px solid #555;
  }
  td{
    border-bottom:1px solid #eee;
    padding:5px 2px;
  }
  td:nth-child(1){
    text-align:right;
  }
  </style>
</head>


<body>
<form action="api.php?do=reg" method="post" enctype="multipart/form-data">
	<div class="card p-3" style="width:450px; height:400px;margin:100px auto;">
		<div class="row">
			<div class=col>
				帳號
			</div>
			<div class=col>
				<input type="text" name="acc" class="form-control" style="width:250px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				密碼
			</div>
			<div class=col>
				<input type="password" name="pw" class="form-control" style="width:250px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				電子郵件
			</div>
			<div class=col>
				<input type="text" name="email" class="form-control" style="width:250px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				姓名
			</div>
			<div class=col>
				<input type="text" name="name" class="form-control" style="width:250px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				生日
			</div>
			<div class=col>
				<input type="date" name="birthday" class="form-control" style="width:250px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				電話
			</div>
			<div class=col>
				<input type="text" name="tel" class="form-control" style="width:250px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				地址
			</div>
			<div class=col>
				<select name="city" class="form-control">
					<option value="新北市">新北市</option>
					<option value="台北市">台北市</option>
					<option value="台中市">台中市</option>
					<option value="台南市">台南市</option>
					<option value="花蓮市">花蓮市</option>
					<option value="宜蘭市">宜蘭市</option>
				</select>
				<input type="text" name="addr" class="form-control" style="width:250px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				身份別
			</div>
			<div class=col>
				<select name="identity" class="form-control" style="width:250px;">
					<option>請選擇</option>
					<?php 
						include_once "base.php";
						$sql="SELECT * FROM `identity`";
						$rows=$pdo->query($sql)->fetchAll();
						foreach ($rows as $row){
							print_r($row);
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class=col>
				頭像
			</div>
			<div class=col>
				<input type="file" name="img" class="form-control" style="width:250px;">
			</div>
		</div>
		<div style="position:absolute;right:0;bottom:0;z-index:2500;">
			<button type="submit" class="mdl-button bg-primary text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >送出</button>
			<a href="?fn=home">
				<button id=idNewDivButtonClose2 type="button" class="mdl-button bg-dark text-white mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >返回</button>
			</a>
		</div>
	</div>
</form>
