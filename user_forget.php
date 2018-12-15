<form action="api.php?do=forget" method="post">
	<div class="card p-3" style="width:300px; height:150px;margin:100px auto;">
		<div class="row">
			<div class=col>
				email
			</div>
			<div class=col>
				<input type="text" name="email" class="form-control" style="width:200px;">
			</div>
		</div>
		<div class="row">
			<div class=col>
<?php
	(@$pw=$_POST["pw"]) or (@$pw=$_GET["pw"]) or ($pw="");
	if ($pw!=""){
		echo '<span class="text-center" style="color:#f00">你的密碼為:'.$pw.'</span>';
	}
?>
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
