<?php
	include_once "include/base.php";
	include_once "include/auth.php";
?>

<?php 
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or (@$act="");

	switch ($act){
		case "del":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");

			$sql="DELETE FROM `store_order` WHERE `no`='". $no ."';";
			$ro=mysqli_query($link,$sql);

			redirect('?&fn='.$_GET['fn']);
			break;
	}

	
	
	echo '<div class="container">';
	echo 	'<div class="row">';
	echo 		'<div class="col p-1 shadow">';

	echo 			'<table style="margin:0 auto;width:100%;">';
	echo 				'<tr>
							<th>訂單單號</th>
							<th>金額</th>
							<th>帳號</th>
							<th>訂單姓名</th>
							<th>訂單email</th>
							<th>訂單地址</th>
							<th>訂單電話</th>
							<th>下單時間</th>
							<th>no</th>
							<th>操作</th>
						</tr>';
	//取得目前使用者ID
	$sql_user="SELECT * FROM `user` WHERE `acc`='".$_SESSION['admin']."'";
	$row_user=$pdo->query($sql_user)->fetch();
	
	//取得所有訂單
	$sql="SELECT * FROM `store_order`";
	$rows=$pdo->query($sql)->fetchAll();
	foreach($rows as $row){
		echo 			'<tr>
							<td><a href="?fn='.$_GET['fn'].'&act=showord&ordno='.$row['orderno'].'">'.$row['orderno'].'</a></td>
							<td>'.$row['total'].'</td>
							<td>'.$row['acc'].'</td>
							<td>'.$row['cartname'].'</td>
							<td>'.$row['cartemail'].'</td>
							<td>'.$row['cartaddr'].'</td>
							<td>'.$row['carttel'].'</td>
							<td>'.$row['ordertime'].'</td>
							<td>'.$row['no'].'</td>
							<td>';
		if ($row_user['id']==$row['acc'] || $row_user['id']=='1'){
			echo				'<a href="?fn='.$_GET["fn"].'&act=del&no='.$row['no'].'">
									<button type="button" class="'.$tbutton_danger.'" >刪除</button>
								</a>';
		}
		echo 				'</td>
						</tr>';	
	}
	echo 			'</table>';
	echo 		'</div>';
	echo 	'</div>';
	echo '</div>';

	echo '<br>';



	if ($act=="showord"){
		echo '
		<div class="container">
			<div class="row">
				<div class="col p-1 shadow">';

		//(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no="");
		(@$ordno=$_POST["ordno"]) or (@$ordno=$_GET["ordno"]) or (@$ordno="");
		$sql="SELECT * FROM `store_order` WHERE `orderno`='".$ordno."'";
		$row=$pdo->query($sql)->fetch();

		$itemlist=unserialize($row['itemlist']);
		$str="";
		foreach($itemlist as $index => $value){
			//echo $index.'<br>';
			$str.=$value['name'].',數量:'.$value['num'].',單價:'.$value['price'].'<br>';
		}

		echo 		'<table style="margin:0 auto;width:100%;">';
		echo 			'<tr>
							<th style="width:100px;">訂單單號</th>
							<td>'.$row['orderno'].'</td>
						</tr><tr>
							<th>金額</th>
							<td>'.$row['total'].'</td>
						</tr><tr>
							<th>帳號</th>
							<td>'.$row['acc'].'</td>
						</tr><tr>
							<th>訂單姓名</th>
							<td>'.$row['cartname'].'</td>
						</tr><tr>
							<th>訂單email</th>
							<td>'.$row['cartemail'].'</td>
						</tr><tr>
							<th>訂單地址</th>
							<td>'.$row['cartaddr'].'</td>
						</tr><tr>
							<th>訂單電話</th>
							<td>'.$row['carttel'].'</td>
						</tr><tr>
							<th>下單時間</th>
							<td>'.$row['ordertime'].'</td>
						</tr><tr>
							<th>購物清單</th>
							<td>'.$str.'</td>
						</tr><tr>
							<th>no</th>
							<td>'.$row['no'].'</td>
						</tr>';
		echo 		'</table>';

		echo 	'</div>
			</div>
		</div>';
	}
?>