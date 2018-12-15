<form action="api.php?do=login" method="post">
	<div class="card p-3" style="width:300px; height:150px;margin:100px auto;">
		<div class="row">
<?php
	(@$login=$_POST["login"]) or (@$login=$_GET["login"]) or ($login="");
	if ($login=="err"){
		echo '<span style="color:#f00">登入錯誤</span>';
	}
?>
		</div>
		<div class="row">
			<div class=col>
				帳號
			</div>
			<div class=col>
				<input type="text" name="acc" class="form-control" style="width:200px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
				密碼
			</div>
			<div class=col>
				<input type="password" name="pw" class="form-control" style="width:200px;">
			</div>
		</div>
		<div class=row>
			<div class="col text-right">
				<a href="?fn=forget">忘記密碼</a> | 
      			<a href="?fn=reg">註冊新帳號</a>
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
