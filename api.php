<?php
include_once "include/base.php";

(@$do=$_POST["do"]) or (@$do=$_GET["do"]) or (@$do="");
if (isset($_SESSION['admin'])){
	$sql_permission="SELECT * FROM `user` WHERE `acc`='".$_SESSION['admin']."'";
	$row_permission=$pdo->query($sql_permission)->fetch();
	$page_permission = unserialize($row_permission['permission']);
}


switch($do){
	//註冊帳號功能
	case "reg":
		(@$acc=$_POST["acc"]) or (@$acc=$_GET["acc"]) or ($acc="");
		(@$pw=$_POST["pw"]) or (@$pw=$_GET["pw"]) or ($pw="");
		//$pw = hash('sha1', $pw);
		(@$email=$_POST["email"]) or (@$email=$_GET["email"]) or ($email="");
		(@$name=$_POST["name"]) or (@$name=$_GET["name"]) or ($name="");
		(@$birthday=$_POST["birthday"]) or (@$birthday=$_GET["birthday"]) or ($birthday="");
		(@$city=$_POST["city"]) or (@$city=$_GET["city"]) or ($city="");
		(@$addr=$_POST["addr"]) or (@$addr=$_GET["addr"]) or ($addr="");
		$addr=$city.$addr;
		(@$tel=$_POST["tel"]) or (@$tel=$_GET["tel"]) or ($tel="");
		(@$identity=$_POST["identity"]) or (@$identity=$_GET["identity"]) or ($identity="");

		$msg="";
		$err=[];

		//帳號驗證 $acc
		$val_acc=val(['null','len','spc','double'],$acc);
		$str_acc = implode('-',$val_acc);
		$err[]="acc=".$str_acc;
		
		//密碼驗證 $pw
		$val_pw=val(['null'],$pw);
		$str_pw = implode('-',$val_pw);
		$err[]="pw=".$str_pw;

		//信箱驗證 $email
		$val_email=val(['null','atsign','double'],$email);
		$str_email = implode('-',$val_email);
		$err[]="email=".$str_email;

		//姓名驗證 $name
		$val_name=val(['null','spc'],$name);
		$str_name = implode('-',$val_name);
		$err[]="name=".$str_name;

		//生日驗證 $birthday
		$val_birthday=val(['null'],$birthday);
		//,'date'
		$str_birthday = implode('-',$val_birthday);
		$err[]="birthday=".$str_birthday;

		//地址驗證 $addr
		$val_addr=val(['null'],$addr);
		$str_addr = implode('-',$val_addr);
		$err[]="addr=".$str_addr;

		//電話驗證 $tel
		$val_tel=val(['null','phone'],$tel);
		$str_tel = implode('-',$val_tel);
		$err[]="tel=".$str_tel;

		//身分驗證 $identity
		$val_identity=val(['null'],$identity);
		$str_identity = implode('-',$val_identity);
		$err[]="identity=".$str_identity;

		$msg=implode("&",$err);
		
		$avatar="";
		$avatar_icon="";
		//檔案上傳
		if(!empty($_FILES) && !empty($_FILES['img'])){
			echo 22;
			$avatars = uploadFile($_FILES['img'],"image");
			print_r($avatars);
			if ($avatars){
				$avatar=$avatars[0];
				$avatar_icon=$avatars[1];
			}
		}
		//檔案上傳
		
		if (!strpos($msg,"1")){
			//新使用者預設權限
			$permission=serialize(['func5' => 1,'func10' => 1]);
			$row=$pdo->query(
				"INSERT INTO `user` ( `id`, `acc`, `pw`, `permission`, `email`, `name`, `birthday`, `tel`, `addr`, `identity`, `avatar`, `avatar_small` ) VALUES ( NULL, '".$acc."', '".$pw."', '".$permission."', '".$email."', '".$name."', '".$birthday."', '".$tel."', '".$addr."', '".$identity."', '".$avatar."', '".$avatar_icon."' );"
				);

			header("location:backend.php?fn=login");
		}else{
			header("location:backend.php?fn=reg?s=err&". $msg);
		}
		header("location:backend.php?fn=login");
		break;
	//登入檢查功能
	case "login":
		(@$acc=$_POST["acc"]) or (@$acc=$_GET["acc"]) or ($acc="");
		(@$pw=$_POST["pw"]) or (@$pw=$_GET["pw"]) or ($pw="");

		$row=$pdo->query(
			"SELECT * FROM `user` WHERE `acc`='".$acc."' AND `pw`='".$pw."'"
			)->fetch();
		if ($row) {
			$_SESSION['admin']=$acc;
			//setcookie('login',$acc,time()+600);
			header("location:backend.php?fn=home");
		}else{
			header("location:backend.php?fn=login&login=err");
		}
		
		break;
	//忘記密碼
	case "forget":
		(@$email=$_POST["email"]) or (@$email=$_GET["email"]) or ($email="");
	//	(@$acc=$_POST["acc"]) or (@$acc=$_GET["acc"]) or ($acc="");

		$row=$pdo->query(
			"SELECT * FROM `user` WHERE `email`='".$email."'"
			)->fetch();

		if ($row) {
			header("location:backend.php?fn=forget&pw=".$row['pw']);
		}else{
			header("location:backend.php?fn=forget");
		}

		break;
	//登出
	case "logout":
		$_SESSION['admin']=$acc;
		//setcookie('login',$acc,time()+600);
		//$_SESSION['admin']=null;
		unset($_SESSION['admin']);
		
		header("location:backend.php?fn=home");
		break;
	//其他
	default:
		header("location:backend.php?fn=home");
}
?>

