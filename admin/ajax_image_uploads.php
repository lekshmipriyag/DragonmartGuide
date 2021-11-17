<?php
if ( !isset( $_SESSION ) ) {
	session_start();
}
if(isset($_POST['delete_id']) && $_POST['delete_id'] != "" && $_SESSION['MM_Username'] != ""){
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	
	if(isset($_POST['delete_id'])){$delid = $_POST['delete_id'];}
	$usernameP = $_SESSION[ 'MM_Username' ];
	$useridP = $_SESSION['loginUserid'];
	$sqlquery = "UPDATE `pictures` SET `pic_status` = 'del' WHERE `pictures`.`pic_id` = '$delid'";
	$queryresult=mysqli_query($db, $sqlquery) or die(mysqli_error());
	
	
	$upPic = mysqli_query($db, "select * from `pictures` where `pictures`.`pic_userid`='$useridP' AND `pic_username`='$usernameP' AND `pic_status` IN ('on', 'approval') ORDER BY `pictures`.`pic_cre` DESC");
	
	while($upRow = mysqli_fetch_array($upPic)){
		$rs = round(filesize("../images/products/".$upRow['pic_picture'])/1024);
		$rd = date('M d, Y @ i:s', strtotime($upRow['pic_cre']));
		echo "<div class='RiList' onclick='kontakte(this);'><i class='glyphicon glyphicon-trash Rxicon' aria-hidden='true' id='".$upRow['pic_id']."'></i><img src='../images/products/".$upRow['pic_picture']."' alt='".$upRow['pic_picture']."' rel='".$rs."' rd='".$rd."' rt='".$upRow['pic_type']."' /></div>";
	}
	
}else{
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
$national_date_time_24 = date('Y-m-d H:i:s');

		include('../Connections/dragonmartguide.php');
		$idname = "pic_id"; // table id colomun
		if(isset($_POST['useridP'])){$useridP = $_POST['useridP'];}
		
		$usernameP = $_SESSION[ 'MM_Username' ];
		$tableP = "pictures";
		$pictureP = "newfile";
		//$oldpictureP = $oldpictureP;
		$pathP = "../images/products/";
		$dpathP = "dragonmartguide.com/images/products/";
		$sizeP = "5242880";
		//$idP = $idP;
		if(isset($_FILES[$pictureP]["type"])){$imgType = $_FILES[$pictureP]["type"];}
		
		$q2 = "select MAX(".$idname.") from ".$tableP;
		$result2 = mysqli_query($db, $q2);
		$data2 = mysqli_fetch_array($result2);
		
		if (isset($_FILES[$pictureP]["name"]))
		{
			$nid = ++$data2[0];
			if(isset($idP)){
				$nid = $idP;
			}
			
		if ((($_FILES[$pictureP]["type"] == "image/gif")
		|| ($_FILES[$pictureP]["type"] == "image/jpeg")
		|| ($_FILES[$pictureP]["type"] == "image/ICO")
		|| ($_FILES[$pictureP]["type"] == "image/png")
		|| ($_FILES[$pictureP]["type"] == "image/pjpeg"))
		&& ($_FILES[$pictureP]["size"] < $sizeP))
		   
		{
			if ($_FILES[$pictureP]["error"] > 0)
			{
				echo "Return Code: " . $_FILES[$pictureP]["error"] . "<br />";
			} else {
				if (file_exists($pathP . $nid."_" . $_FILES[$pictureP]["name"]))
				{
					echo "<div style=\"position:absolute; width:250px; left:50%; top:50px; margin-left:-125px; color:red; background-color:#FFEAEA; border:solid 2px red; z-index:5; text-align:center;\">". $_FILES[$pictureP]["name"] . " 1 already exists. </div>";
					
					echo '<meta http-equiv="Refresh" content="0; URL='.$_SERVER['HTTP_REFERER'].'">';
					exit();
					
				} else {
					$filename = preg_replace('/\s+/', '_', $_FILES[$pictureP]["name"]);
					move_uploaded_file($_FILES[$pictureP]["tmp_name"], $pathP . $nid."_" . $filename);
					$picturenameP =  $nid."_".$filename;
					
					$sqlquery = "INSERT INTO `pictures` (`pic_id`, `pic_category`, `pic_userid`, `pic_username`, `pic_picture`, `pic_type`, `pic_linked`, `pic_cre`, `pic_status`) VALUES (NULL, 'product', '".$_SESSION[ 'loginUserid' ]."', '".$_SESSION[ 'MM_Username' ]."', '$picturenameP', '$imgType', '', '$national_date_time_24', 'approval')";
					$queryresult=mysqli_query($db, $sqlquery) or die(mysqli_error());
					
					
					$last_insert_id	= mysqli_insert_id($db);
					$insertData		= mysql_real_escape_string($sqlquery);
					$tableName		= 'pictures';
					$page_name		= 'ajax_image_uploads';
					
					$sqlqueryForUpdateInfo = "INSERT INTO `updt_info` (`updt_id`, `updt_type`, `updt_pagename`, `updt_tablename`, `updt_rowid`, `updt_userid`, `updt_data`, `updt_time`, `updt_viewstatus`)VALUES (NULL, 'insert', '$page_name', '$tableName', '$last_insert_id', '".$_SESSION[ 'loginUserid' ]."', '$insertData', '".$_SESSION['now']."', 'not viewed')";
					
					$queryresult=mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error());
					
					
					//$updateInfoObj	= new Updates;
					//$updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
					
					
					
					
					//if($_POST[$oldpictureP] != ""){
					//unlink($_SERVER['DOCUMENT_ROOT'].$dpathP.$_POST[$oldpictureP]);
					//}
				}
			}
		} else {
			$mpicture_file =  $_FILES[$pictureP]["name"];
			echo "<script type='text/javascript'>alert('File : $mpicture_file is not right. Sorry!');</script>"; 	
			//echo '<meta http-equiv="Refresh" content="0; URL='.$_SERVER['HTTP_REFERER'].'">';
			//exit();
		}
		} else {
			exit(); // if no picture exit
		}

$upPic = mysqli_query($db, "select * from `pictures` where `pictures`.`pic_userid`='$useridP' AND `pic_username`='$usernameP' AND `pic_status` IN ('on', 'approval') ORDER BY `pictures`.`pic_cre` DESC");
while($upRow = mysqli_fetch_array($upPic)){
	$rs = round(filesize("../images/products/".$upRow['pic_picture'])/1024);
	$rd = date('M d, Y @ i:s', strtotime($upRow['pic_cre']));
	echo "<div class='RiList' onclick='kontakte(this);'><i class='glyphicon glyphicon-trash Rxicon' aria-hidden='true' id='".$upRow['pic_id']."'></i><img src='../images/products/".$upRow['pic_picture']."' alt='".$upRow['pic_picture']."' rel='".$rs."' rd='".$rd."' rt='".$upRow['pic_type']."' /></div>";
}
}
?>


<script>
$('.Rxicon').click(function(){
			if (confirm('Are you sure to delete?')) {
		   var del_id = $(this).attr('id');
		   //var rowElement = $(this).parent().parent(); //grab the row
		   $.ajax({
					type:'POST',
					url:'ajax_image_uploads.php',
					data: 'delete_id='+del_id,
					success:function(data) {
							$('#loading').hide();
							$( '#RupImgdiv' ).html( '' );
							$("#RiListPrnt").html(data);
						},
						error: function(){
							alert('error');
						}   
					});
				}
			});	
</script>