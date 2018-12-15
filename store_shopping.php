<?php
	include_once "include/base.php";
	include_once "include/auth.php";
?>

<?php
	(@$group=$_POST["group"]) or (@$group=$_GET["group"]) or (@$group=0);
	(@$ingroup=$_POST["ingroup"]) or (@$ingroup=$_GET["ingroup"]) or (@$ingroup=0);
	(@$act=$_POST["act"]) or (@$act=$_GET["act"]) or (@$act="");

	$igroup_array=[];
	$sql_pgroup="SELECT * FROM `store_itemgroup`";
	$rows_pgroup=$pdo->query($sql_pgroup)->fetchAll();
	foreach($rows_pgroup as $row_pgroup){
		$igroup_array[$row_pgroup['no']]=[
			'name' => $row_pgroup['name'],
			'ingroup' => $row_pgroup['ingroup']
		];
	}

	switch ($act){
		case "addcart":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no=0);
			(@$num=$_POST["num"]) or (@$num=$_GET["num"]) or (@$num=1);

			if ($no>0){
				if (empty($_SESSION['cart'])){
					$_SESSION['cart']=[];
				}

				if (empty($_SESSION['cart'][$no])){
					$_SESSION['cart'][$no]=$num;
				}else{
					$_SESSION['cart'][$no]+=$num;
				}
			}

			redirect('?fn='.$_GET['fn']);
			break;
		case "delcart":
			(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no=0);

			unset($_SESSION['cart'][$no]);

			redirect('?fn='.$_GET['fn'].'&act=cartlist');
			break;
		case "clearcart":
			$_SESSION['cart']=[];

			redirect('?fn='.$_GET['fn']);
			break;
		default:
	}
	//訂購完成, 確認訂購項目
	if ($act=="cartlist"){
		echo '<div class="container">';
		$carttotal=0;
		echo '<form action="?fn='.$_GET['fn'].'&act=cartsubmit" method="POST">';
		echo '<table style="margin:0 auto;width:700px;">';
		echo 	'<tr><th>商品編號</th>
				<th>商品名稱</th>
				<th>購買數量</th>
				<th>庫存數量</th>
				<th>單價</th>
				<th>小計</th>
				<th>操作</th></tr>';
		foreach ($_SESSION['cart'] as $index => $value){
			$sql="SELECT * FROM `store_item` WHERE `no` = ".$index;
			$row=$pdo->query($sql)->fetch();
			if ($row['stock']<$value){
				$_SESSION['cart'][$index]=$row['stock'];
				$value=$row['stock'];
			}
			$carttotal+=$row['price']*$value;
			echo '<tr>
					<td>'.$row['itemno'].'</td>
					<td>'.$row['name'].'</td>
					<td><input type=text name=cart['.$row['no'].'] value="'.$value.'"></td>
					<td>'.$row['stock'].'</td>
					<td>'.$row['price'].'</td>
					<td>'.($row['price']*$value).'</td>
					<td><a href="?fn='.$_GET['fn'].'&act=delcart&no='.$row['no'].'"><button type=button class="'.$tbutton_danger.'" >刪除</button></a></td>
					';
			echo '</td></tr>';
		}
		echo '<tr><td colspan=7>目前金額:'.$carttotal.'</td></tr>';
		echo '<tr><td colspan=7><a href="?fn='.$_GET['fn'].'"><button type=button class="'.$tbutton_default.'">繼續購物</button></a></td></tr>';
		echo '<tr><td colspan=7><button type="submit" class="'.$tbutton_default.'" >確認購買</button></td></tr>';
		
		echo '</table>';
		echo '</form>';
		echo '</div>';
		//cartsubmit
	}
	//訂購完成, 確認聯絡資料
	if ($act=="cartsubmit"){
		(@$cart=$_POST["cart"]) or (@$cart=$_GET["cart"]) or (@$cart=[]);

		foreach($cart as $index => $value){
			$_SESSION['cart'][$index]=$value;
		}

		echo '<div class="container">';
		$carttotal=0;

		echo '<table style="margin:0 auto;width:700px;">';
		echo 	'<tr><th>商品編號</th>
				<th>商品名稱</th>
				<th>購買數量</th>
				<th>庫存數量</th>
				<th>單價</th>
				<th>小計</th>';
		foreach ($_SESSION['cart'] as $index => $value){
			$sql="SELECT * FROM `store_item` WHERE `no` = ".$index;
			$row=$pdo->query($sql)->fetch();
			if ($row['stock']<$value){
				$_SESSION['cart'][$index]=$row['stock'];
				$value=$row['stock'];
			}
			$carttotal+=$row['price']*$value;
			echo '<tr>
					<td>'.$row['itemno'].'</td>
					<td>'.$row['name'].'</td>
					<td>'.$value.'</td>
					<td>'.$row['stock'].'</td>
					<td>'.$row['price'].'</td>
					<td>'.($row['price']*$value).'</td>
					';
			echo '</td></tr>';
		}
		echo '<tr><td colspan=6>目前金額:'.$carttotal.'</td></tr>';
		echo '</table>';

		echo '<br>';

		echo '<form action="?fn='.$_GET['fn'].'&act=cartok" method="POST">';
		$sql="SELECT * FROM `user` WHERE `acc` = '".$_SESSION['admin']."'";
		$row=$pdo->query($sql)->fetch();
		echo '<table style="margin:0 auto;width:700px;">';
		echo 	'
				<tr>
					<td>user</td>
					<td><input type=text name=cartuser value="'.$row['acc'].'"></td>
				</tr>
				<tr>
					<td>name</td>
					<td><input type=text name=cartname value="'.$row['name'].'"></td>
				</tr>
				<tr>
					<td>email</td>
					<td><input type=text name=cartemail value="'.$row['email'].'"></td>
				</tr>
				<tr>
					<td>addr</td>
					<td><input type=text name=cartaddr value="'.$row['addr'].'"></td>
				</tr>
				<tr>
					<td>tel</td>
					<td><input type=text name=carttel value="'.$row['tel'].'"></td>
				</tr>
				<tr><td colspan=2><a href="?fn='.$_GET['fn'].'"><button type=button class="'.$tbutton_default.'">繼續購物</button></a></td></tr>
				<tr><td colspan=2><a href="?fn='.$_GET['fn'].'&act=cartlist"><button class="'.$tbutton_default.'">返回修改訂單</button></a></td></tr>
				<tr><td colspan=2><a href="?fn='.$_GET['fn'].'&act=cartok"><button type="submit" class="'.$tbutton_default.'" >確認送出訂單</button></a></td></tr>	
				';

		echo '</table>';
		echo '</form>';

		echo '</div>';
	}
	//購物完成
	if ($act=="cartok"){
		(@$cartuser=$_POST["cartuser"]) or (@$cartuser=$_GET["cartuser"]) or (@$cartuser="");
		(@$cartname=$_POST["cartname"]) or (@$cartname=$_GET["cartname"]) or (@$cartname="");
		(@$cartemail=$_POST["cartemail"]) or (@$cartemail=$_GET["cartemail"]) or (@$cartemail="");
		(@$cartaddr=$_POST["cartaddr"]) or (@$cartaddr=$_GET["cartaddr"]) or (@$cartaddr="");
		(@$carttel=$_POST["carttel"]) or (@$carttel=$_GET["carttel"]) or (@$carttel="");

		$orderno="ORD".date("YmdHis");
		$ordertime=date("Y-m-d H:i:s");

		echo '<div class="container">';
		$carttotal=0;

		echo '<div class="alert alert-success" role="alert">
  			訂購成功,感謝你的選購! 訂單編號為:<a href="?fn=store_orderadmin&act=showord&ordno='.$orderno.'">'.$orderno.'</a>
		</div>';

		echo '<table style="margin:0 auto;width:700px;">';
		echo 	'<tr>
				<th>商品編號</th>
				<th>商品名稱</th>
				<th>購買數量</th>
				<th>庫存數量</th>
				<th>單價</th>
				<th>小計</th>';
		$itemlist=[];//itemname,price
		foreach ($_SESSION['cart'] as $index => $value){
			$sql="SELECT * FROM `store_item` WHERE `no` = ".$index;
			$row=$pdo->query($sql)->fetch();
			if ($row['stock']<$value){
				$_SESSION['cart'][$index]=$row['stock'];
				$value=$row['stock'];
			}
			$carttotal+=$row['price']*$value;

			$itemlist[$row['no']]=[];
			$itemlist[$row['no']]['itemno']=$row['itemno'];
			$itemlist[$row['no']]['name']=$row['name'];
			$itemlist[$row['no']]['price']=$row['price'];
			$itemlist[$row['no']]['num']=$value;
			echo '<tr>
					<td>'.$row['itemno'].'</td>
					<td>'.$row['name'].'</td>
					<td>'.$value.'</td>
					<td>'.$row['stock'].'</td>
					<td>'.$row['price'].'</td>
					<td>'.($row['price']*$value).'</td>
					';
			echo '</td></tr>';
		}
		$itemlist = serialize($itemlist);

		echo '<tr><td colspan=5>目前金額:'.$carttotal.'</td></tr>';
		echo '</table>';

		echo '<br>';

		echo '<table style="margin:0 auto;width:700px;">';
		echo 	'
				<tr>
					<td>user</td>
					<td>'.$cartuser.'</td>
				</tr>
				<tr>
					<td>name</td>
					<td>'.$cartname.'</td>
				</tr>
				<tr>
					<td>email</td>
					<td>'.$cartemail.'</td>
				</tr>
				<tr>
					<td>addr</td>
					<td>'.$cartaddr.'</td>
				</tr>
				<tr>
					<td>tel</td>
					<td>'.$carttel.'</td>
				</tr>
				<tr><td colspan=2><a href="?fn='.$_GET['fn'].'"><button type=button class="'.$tbutton_default.'">繼續購物</button></a></td></tr>
				';

		echo '</table>';

		echo '</div>';

		//取得目前登入帳號的id
		$sql="SELECT * FROM `user` WHERE `acc`='".$_SESSION['admin']."'";
		$row=$pdo->query($sql)->fetch();
		$accno=$row['id'];

		//寫入訂單
		$sql="INSERT INTO `store_order` (`no`, `orderno`, `total`, `acc`, `cartname`, `cartemail`, `cartaddr`, `carttel`, `ordertime`, `itemlist`) VALUES (NULL, '".$orderno."', '".$carttotal."', '".$accno."', '".$cartname."', '".$cartemail."', '".$cartaddr."', '".$carttel."', '".$ordertime."', '".$itemlist."');";
		$row=$pdo->query($sql);
		//清空購物車
		$_SESSION['cart']=[];
	}

	if ($act!="" && $act!="showitem"){exit();}
	echo '
	<div class="container-fluid bg-dark">

	<div class="container">
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">';
	$isfirst=true;
	$count=0;
	$sql="SELECT * FROM `store_slide`";
	$rows=$pdo->query($sql)->fetchAll();
	foreach($rows as $row){
		echo 	'<li data-target="#carouselExampleIndicators" data-slide-to="'.($count++).'" '.($isfirst==true?' class="active">':'').'</li>';
		$isfirst=false;
	}
	echo 		'
			</ol>
			<div class="carousel-inner">';
	$isfirst=true;
	$sql="SELECT * FROM `store_slide`";
	$rows=$pdo->query($sql)->fetchAll();
	foreach($rows as $row){
		echo 	'<div class="carousel-item'.($isfirst==true?' active':''). '">
					<img class="d-block w-100" src="'.$row['path'].'" alt="First slide">
				</div>';
		$isfirst=false;
	}
	echo	'</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>

	</div>
	';

	//echo '<a name=shopstart>';
	//購物車
	//如果購物車數量大於0 才顯示購物車
	if (!empty($_SESSION['cart']) && count($_SESSION['cart'])>0){
		echo '<div class="position-fixed bg-light" style="right:5px;bottom:50px;z-index:1500">';
		echo 	'<a href="?fn='.$_GET['fn'].'&act=clearcart"><button class="'.$tbutton_default.'" >清空購物車</button></a><br>';
		$carttotal=0;
		foreach ($_SESSION['cart'] as $index => $value){
			$sql="SELECT * FROM `store_item` WHERE `no` = ".$index;
			$row=$pdo->query($sql)->fetch();
			if ($row['stock']<$value){
				$_SESSION['cart'][$index]=$row['stock'];
				$value=$row['stock'];
			}
			$carttotal+=$row['price']*$value;
			echo $row['name'].':'.$value.'<br>';
		}
		echo 	'目前金額:'.$carttotal.'<br>';
		echo 	'<a href="?fn='.$_GET['fn'].'&act=cartlist"><button class="'.$tbutton_default.'" >結帳</button></a><br>';
		echo '</div>';
	}
	//購物車

	if ($act=="showitem"){
		(@$no=$_POST["no"]) or (@$no=$_GET["no"]) or (@$no=0);

		//container
		echo '<div class="container">';

		//row
		echo '<div class="row">';
		//左col
		echo 	'<div class="col-sm-2">';

		echo 		'<div class="list-group">';
		echo 			'<a href="?fn='.$_GET['fn'].'&group=0" class="list-group-item list-group-item-action '.($group==0?' active':' bg-secondary text-light').'" >所有分類</a>';

		$sql="SELECT * FROM `store_itemgroup` WHERE `ingroup` = 0";
		$rows=$pdo->query($sql)->fetchAll();
		foreach($rows as $row){
			echo 		'<a href="?fn='.$_GET["fn"].'&group='.$row['no'].'" class="list-group-item list-group-item-action'.($row['no']==$group||$row['no']==$ingroup?' active':' bg-secondary text-light').'" >'.$row['name'].'</a>';
			if ($group>0){
				if ($row['no']==$group){
					$sql_subgroup="SELECT * FROM `store_itemgroup` WHERE `ingroup` = ".$group;
					$rows_subgroup=$pdo->query($sql_subgroup)->fetchAll();
					foreach($rows_subgroup as $row_subgroup){
						echo '<a href="?fn='.$_GET['fn'].'&group='.$row_subgroup['no'].'&ingroup='.$row['no'].'" class="list-group-item list-group-item-action">'.$row_subgroup['name'].'</a>';
					}
				}
				if ($row['no']==$ingroup){
					$sql_subgroup="SELECT * FROM `store_itemgroup` WHERE `ingroup` = ".$ingroup;
					$rows_subgroup=$pdo->query($sql_subgroup)->fetchAll();
					foreach($rows_subgroup as $row_subgroup){
						echo '<a href="?fn='.$_GET['fn'].'&group='.$row_subgroup['no'].'&ingroup='.$row['no'].'" class="list-group-item list-group-item-action'.($row_subgroup['no']==$group?' bg-info':'').'" >'.$row_subgroup['name'].'</a>';
					}
				}
			}
		}
		echo 		'</div>';
		echo 	'</div>';
		//左col

		//右col
		echo 	'<div class="col-sm">';

		
		$sql="SELECT * FROM `store_item` WHERE `no` = ".$no;
		
		$rows=$pdo->query($sql)->fetchAll();
		foreach($rows as $row){
			echo 	'<div class="card">';
			echo 		'<div class="row">';
			echo 			'<div class="col-sm" style="max-width: 300px;">
								<a href="'.$row['path'].'" target=_blank><img src="'. $row['path'] .'" style="height:150px;"></a>
							</div>
							<div class="col-sm">
								<div class="row">
									<div class="row w-100 text-white bg-primary">'. $row['name'] .'</div>
									<div class="row w-100 bg-light">商品編號: '. $row['itemno'] .'</div>
									<div class="row w-100">分類: '. $igroup_array[$row['ingroup']]['name'] .'</div>
									<div class="row w-100 bg-light">價錢: '. $row['price'] .'</div>
									<div class="row w-100">規格: '. $row['spec'] .'</div>
									<div class="row w-100 bg-light">庫存: '. $row['stock'] .'</div>
									<div class="row w-100">'.$row['description'].'</div>
									<div class="row w-100">
										<form action="?fn='.$_GET['fn'].'&act=addcart&no=1" method="POST">
											購買:<input type=text name="num" value=1>
											<button type="submit" class="'.$tbutton_default.'">加入購物車</button>
										</form>
									</div>
								</div>
							</div>';
			echo 		'</div>';
			echo 	'</div>';
		}

		echo 	'</div>';
		//右col

		//row
		echo '</div>';

		//container
		echo '</div>';
	}

	if ($act==""){
		//container
		echo '<div class="container">';

		//row
		echo '<div class="row">';
		//左col
		echo 	'<div class="col-sm-2">';

		echo 		'<div class="list-group">';
		echo 			'<a href="?fn='.$_GET['fn'].'&group=0" class="list-group-item list-group-item-action '.($group==0?' active':' bg-light text-dark font-weight-bold').'" >所有分類</a>';

		$sql="SELECT * FROM `store_itemgroup` WHERE `ingroup` = 0";
		$rows=$pdo->query($sql)->fetchAll();
		foreach($rows as $row){
			echo 		'<a href="?fn='.$_GET["fn"].'&group='.$row['no'].'" class="list-group-item list-group-item-action font-weight-bold '.($row['no']==$group?' bg-primary text-light':'').($row['no']==$ingroup?' bg-warning text-dark':'').($row['no']!=$group && $row['no']!=$ingroup?' bg-light text-dark':'').'" >'.$row['name'].'</a>';
			if ($group>0){
				if ($row['no']==$group){
					$sql_subgroup="SELECT * FROM `store_itemgroup` WHERE `ingroup` = ".$group;
					$rows_subgroup=$pdo->query($sql_subgroup)->fetchAll();
					foreach($rows_subgroup as $row_subgroup){
						echo '<a href="?fn='.$_GET['fn'].'&group='.$row_subgroup['no'].'&ingroup='.$row['no'].'" class="list-group-item list-group-item-action">'.$row_subgroup['name'].'</a>';
					}
				}
				if ($row['no']==$ingroup){
					$sql_subgroup="SELECT * FROM `store_itemgroup` WHERE `ingroup` = ".$ingroup;
					$rows_subgroup=$pdo->query($sql_subgroup)->fetchAll();
					foreach($rows_subgroup as $row_subgroup){
						echo '<a href="?fn='.$_GET['fn'].'&group='.$row_subgroup['no'].'&ingroup='.$row['no'].'" class="list-group-item list-group-item-action'.($row_subgroup['no']==$group?' active':'').'" >'.$row_subgroup['name'].'</a>';
					}
				}
			}
		}
		echo 		'</div>';
		echo 	'</div>';
		//左col

		//右col
		echo 	'<div class="col-sm-10">';

		if ($group==0){
			$sql="SELECT * FROM `store_item` WHERE `status` = 1";
		}else{
			$sql="SELECT * FROM `store_item` WHERE `status` = 1 AND `ingroup` = ".$group;
		}
		$rows=$pdo->query($sql)->fetchAll();
		foreach($rows as $row){
			echo 	'<div class="col-sm-12 col-lg-6 col-xl-4 card" style="display:inline-block;">';
			echo 		'<div class="col" style="max-width: 300px;">
							<a href="?fn='.$_GET['fn'].'&act=showitem&no='.$row['no'].'"><img src="'. $row['path'] .'" style="height:150px;"></a>
						</div>
						<div class="col">
							<div class="row">
								<div class="row w-100 text-white bg-primary">'. $row['name'] .'</div>
								<div class="row w-50">'. '<a href="?fn='.$_GET['fn'].'&act=addcart&no='.$row['no'].'"><button class="'.$tbutton_default.'" >加入購物車</button></a>' .'</div>
								<div class="row w-50">價錢: '. $row['price'] .'</div>
								<!--div class="row w-100">'.$row['description'].'</div-->
							</div>
						</div>';
			echo 	'</div>';
		}

		echo 	'</div>';
		//右col

		//row
		echo '</div>';

		//container
		echo '</div>';
	}



?>