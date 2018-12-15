<?php
	//f nul len spc 
	function val($val,$str){
		global $pdo;
		$result = array();
		//$result['total']=0;

		if (is_array($val)){
			foreach($val as $fn){
				switch ($fn){
					case 'null':
						$result['null'] = ($str=="" || empty($str)?1:0);
						break;
					case 'len':
						$result['len'] = ((strlen($str) <3 || strlen($str)>12)?1:0);
						break;
					case 'spc':
						$result['spc'] = 0;
						for ($i=0;$i<strlen($str);$i++){
							$test=mb_substr($str,$i,1,'utf8');
							if (!(
									( ord('a') <= ord($test) ) && ( ord($test) <= ord('z') ) ||
									( ord('A') <= ord($test) ) && ( ord($test) <= ord('Z') ) ||
									( ord('0') <= ord($test) ) && ( ord($test) <= ord('9') )
								)){
								$result['spc'] = 1;
							}
						}
						break;
					case 'upper':
						//
						//$result['total'] += $result['upper'];
					case 'double':
						$result['double'] = 0;
						$sql_acc="SELECT count(*) FROM `user` WHERE `acc`='".$str."' OR `email`='".$str."'";
						$row_acc=$pdo->query($sql_acc)->fetchColumn();
						if ($row_acc>0) {
						//重複
							$result['double'] = 1;
						}
						break;
					case 'atsign':
						$result['atsign'] = 0;
						if (strpos($str,"@")==0){
							$result['atsign'] = 1;
						}
						break;
					case 'date':
						$result['date'] = 0;
						$d = DateTime::createFromFormat('Y-m-d', $str);
						if ($d && $d->format('Y-m-d') === $str){
							$result['date'] = 1;
						}
						break;
					case 'number':
						$result['number'] = 0;
						for ($i=0;$i<strlen($str);$i++){
							$test=mb_substr($str,$i,1,'utf8');
							if (!(
								//	( ord('a') <= ord($test) ) && ( ord($test) <= ord('z') ) ||
								//	( ord('A') <= ord($test) ) && ( ord($test) <= ord('Z') ) ||
									( ord('0') <= ord($test) ) && ( ord($test) <= ord('9') )
								)){
								$result['number'] = 1;
							}
						}
						break;
					case 'phone':
						$result['phone'] = 0;
						for ($i=0;$i<strlen($str);$i++){
							$test=mb_substr($str,$i,1,'utf8');
							if (!(
								//	( ord('a') <= ord($test) ) && ( ord($test) <= ord('z') ) ||
								//	( ord('A') <= ord($test) ) && ( ord($test) <= ord('Z') ) ||
									( ord('0') <= ord($test) ) && ( ord($test) <= ord('9') ) ||
									$test == '-'
								)){
								$result['phone'] = 1;
							}
						}
						break;
					default: 
				}
			}
		}
		return $result;
	}

	function uploadFile($inputFiles,$inputFileType){
		if(!empty($inputFiles)){
			$tmp=$inputFiles['tmp_name'];  //暫存路徑
			$filename=$inputFiles['name']; //原始檔名
			$type=$inputFiles['type'];     //檔案類型
			$size=$inputFiles['size'];     //檔案大小

			if ($inputFiles['size']==0) {
				return false;
			}

			switch($inputFileType){
				case "image":
					$nowtime=time();
					$tmpAvatar=$nowtime;						//
					//$mime= getimagesize($tmp)['mime'];
					switch($type){
						case "image/png":
							$tmpAvatar.= ".PNG";
							break;
						case "image/gif":
							$tmpAvatar.= ".GIF";
							break;
						case "image/jpeg":
							$tmpAvatar.= ".JPG";
							break;
					}
					move_uploaded_file($tmp,'./file/img/'.$tmpAvatar);
					$tmpAvatarIcon=$nowtime."_icon.JPG";
								
					$doupload=true;
					//圖檔處理
					switch($type){
						case "image/png":
							$image_src=imagecreatefrompng('./file/img/'.$tmpAvatar); //建立圖檔資源
							break;
						case "image/gif":
							$image_src=imagecreatefromgif('./file/img/'.$tmpAvatar);
							break;
						case "image/jpeg":
							$image_src=imagecreatefromjpeg('./file/img/'.$tmpAvatar);
							break;
						default:
							echo "檔案格式不符";
							$doupload=false;
							break;
					}
									
					if ($doupload){
						$width=imagesx($image_src);  //取寬度
						$height=imagesy($image_src); //取高度
						$image_dst=imagecreatetruecolor(100,100); //建立新圖片資源
							
						if($width>$height){
							$x=round(($width-$height)/2);
							$y=0;
							$edge=$height;
						}elseif($width<$height){
							$x=0;
							$y=round(($height-$width)/2);
							$edge=$width;
						}else{
							$x=0;
							$y=0;
							$edge=$width;
						}
							
						imagecopyresampled(
							$image_dst,	$image_src,
							0,0,		$x,$y,
							100,100,	$edge,$edge	
							);

						imagejpeg($image_dst,'./file/img/'.$tmpAvatarIcon);  //存成jpg
						//imagepng($image_dst,'./file/img/'.$tmpAvatarIcon."_icon.png");   //存成png

						//刪除記憶體中的圖片資源
						imagedestroy($image_dst);
						imagedestroy($image_src);

						$tmpFileArray=[
							0 => $tmpAvatar,
							1 => $tmpAvatarIcon
						];
						return $tmpFileArray;
					}
					break;
				case "storeitemimg":
					move_uploaded_file($tmp,'./file/store/'.$filename);
	
					$doupload=true;
						
					if ($doupload){
						$tmpFileArray=[
							0 => $filename
						];
						return $tmpFileArray;
					}
					break;
				case "file":
					move_uploaded_file($tmp,'./file/page/'.$filename);
	
					$doupload=true;
						
					if ($doupload){
						$tmpFileArray=[
							0 => $filename
						];
						return $tmpFileArray;
					}
					break;
				case "slideimage":
					move_uploaded_file($tmp,'./file/slide/'.$filename);
		
					$doupload=true;
						
					if ($doupload){
						$tmpFileArray=[
							0 => $filename
						];
						return $tmpFileArray;
					}
					break;
				default:

			}
		}
		return false;
	}

	function redirect($url){
		echo '<script>window.location.href="'.$url.'"</script>"'; 
	}

?>