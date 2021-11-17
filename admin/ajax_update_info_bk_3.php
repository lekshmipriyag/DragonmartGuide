<?php
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	define('BASE_URL', '/dragonmartguide.com');
	
	$upTableId 		= $_POST['upTableID'];
	$tblName		=	'';
	$statusName 	= 	'';
	$idName			= 	'';
	$selectData		=	mysqli_query($db,"SELECT * FROM updt_info WHERE updt_id = '$upTableId'");
	$fetchData		=	mysqli_fetch_array($selectData);
	$colID			=	$fetchData['updt_rowid'];
	$tblName		= 	$fetchData['updt_tablename'];
	$loginuserID 	=  $_SESSION['loginUserid'];
	if($tblName == 'advertisement'){
		$statusName		=	'Ad_Status';
		$idName			=	'Ad_Id';
	}else if($tblName == 'offer_dmg'){
		$statusName		=	'offer_status';
		$idName			=	'offer_id';
	}else if($tblName == 'product_details'){
		$statusName		=	'prodt_status';
		$idName			=	'prodt_id';
	}
	else if($tblName == 'enquiry_dmg'){
		$statusName		=	'em_status';
		$idName			=	'em_id';
	}
	else if($tblName == 'pictures'){
		$statusName		=	'pic_status';
		$idName			=	'pic_id';
	}
	else if($tblName == 'shop_details'){
		$statusName		=	'shop_status';
		$idName			=	'shop_id';
	}
	
	else if($tblName == 'user_register'){
		$statusName		=	'reg_status';
		$idName			=	'reg_id';
		$selectRegisterUserData = mysqli_query($db,"SELECT * FROM user_register WHERE reg_id = '$colID'");
		if(mysqli_num_rows($selectRegisterUserData)>0){
			$fetchRegistreUserData 	= mysqli_fetch_array($selectRegisterUserData);
			
			$regUserName 			= $fetchRegistreUserData['reg_username'];
			$regFirstName 			= $fetchRegistreUserData['reg_firstname'];
			$regLastName 			= $fetchRegistreUserData['reg_lastname'];
			$regAddress 			= $fetchRegistreUserData['reg_address'];
			$regMobile 				= $fetchRegistreUserData['reg_mobile'];
			//$regCategory   			= $fetchRegistreUserData['reg_cateroty'];
			//$regShopNumber 			= $fetchRegistreUserData['reg_shopnumber'];
			$regMallname 			= $fetchRegistreUserData['reg_mallname'];
			$personName = $regFirstName." ".$regLastName;
			
			$regShopNumber = explode(',',  $fetchRegistreUserData['reg_shopnumber']);
	//,`shop_category` = '$regCategory'
			
			foreach($regShopNumber as $shpNum){
				
				$updateShopData	=	mysqli_query($db,"update `shop_details` SET 
				`shop_contact_person` = '$personName',
				`shop_mobile1` = '$regMobile',
				`shop_email` = '$regUserName',
				`shop_zone` = '$regMallname',
				`shop_landmark` = '$regAddress'
			 
				WHERE shop_number LIKE '%".'"'.$shpNum.'";'."%'"); 
			}
			
		}
	}
	if($tblName == 'user_register'){
	 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'on', `reg_adminid` = '$loginuserID'
						     WHERE `$idName` = '$colID' AND (`$statusName` = 'approval' OR `$statusName` = 'on')";
	mysqli_query($db,$sqlquery);
		
	    $selectDataQuery = mysqli_query($db,"select * from user_register where reg_id = '$colID' and reg_status = 'on'");
		if(mysqli_num_rows($selectDataQuery) >0){
			$selectData  = mysqli_fetch_array($selectDataQuery);
			$userLoginName 	=   $selectData['reg_username'];
			$passwd			=	$selectData['reg_password'];
			$uName			=	$selectData['reg_firstname'];
			$gender			=	$selectData['reg_gender'];	
			$addr			=	$selectData['reg_address'];
			$userMob		=	$selectData['reg_mobile'];
			$type			=	'shopuser';
			$userShops		=	unserialize($selectData['reg_shopselected']);
			$shopNumberData[] =  $userShops['shopid'];
			$selectedShops	=	 serialize($shopNumberData);
			$userPerm		=	'';
			$userPics		=	$selectData['reg_pic'];
			$imagePic		=	"http://" . $_SERVER['SERVER_NAME']. BASE_URL."/images/login/".$userPics;
			$userCre		=	$selectData['reg_cre_date'];
			$userModi		=	$selectData['reg_modi_date'];
			$userStat		=	$selectData['reg_status'];
			
			
			//for update user_dmg
			$sqlInsertRegisterData		=	"INSERT INTO `user_dmg`							      
																(
																	`user_username`,
																	`user_password`,
																	`user_name`,
																	`user_gender`,
																	`user_address`,
																	`user_mobile`,
																	`user_type`,
																	`user_shops`,
																	`user_permission`,
																	`user_pic`,
																	`user_cre`,
																	`user_modi`,
																	`user_status`
																	
																)VALUES (
																	 '$userLoginName',
																	 '$passwd',
																	 '$uName',
																	 '$gender', 
														 			 '$addr',
																	 '$userMob',
																	 '$type',
																	 '$selectedShops',
																	 '$userPerm',
																	 '$imagePic',
																	 '$userCre',
																	 '$userModi',
																	 '$userStat'
																	 )";
			
			//user_dmg end
			mysqli_query($db, $sqlInsertRegisterData) or die(mysqli_error($db));
			$last_insert_id	= mysqli_insert_id($db);
			$shpID	=	$userShops['shopid'];
			$updateShopData	=	mysqli_query($db,"update `shop_details` SET `shop_user_id` = '$last_insert_id' WHERE  shop_id = '$shpID'");
			
		
			
			
				//move image from temporary folder to permanent folder
			if($userPics != ''){
				$temporaryPath	=	$_SERVER['DOCUMENT_ROOT']."/dragonmartguide.com/images/login/".$userPics;
				
				if (file_exists($temporaryPath))
					{
						$imageAfterunderscore = substr($userPics, strpos($userPics, "_") + 1);
						$newName = $last_insert_id."_".$imageAfterunderscore;
						
						$renamePath	=	$_SERVER['DOCUMENT_ROOT']."/dragonmartguide.com/images/login/".$newName;
						rename($temporaryPath, $renamePath);
						$permanentPath	=	$_SERVER['DOCUMENT_ROOT']."/dragonmartguide.com/images/products/".$newName;	
						copy($renamePath,$permanentPath);
						unlink($renamePath);
						$imgType	=	'image/jpeg';
						$sqlPicturequery = "INSERT INTO `pictures` (
															`pic_id`, 
															`pic_category`,
															`pic_userid`, 
															`pic_username`, 
															`pic_picture`,
															`pic_type`,
															`pic_linked`,
															`pic_cre`, 
															`pic_status`) 
													VALUES 
													(NULL,
													'profile', 
													'".$_SESSION[ 'loginUserid' ]."', 
													'".$_SESSION[ 'MM_Username' ]."',
													'$newName', 
													'$imgType',
													'', 
													'$national_date_time_24',
													'on')";
						$queryresult=mysqli_query($db, $sqlPicturequery) or die(mysqli_error());
					}
				}
			
			include('../Connections/email_newUserShopApproved.php');
		}
		
		
		
		
	}else{
		 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'on'
						     WHERE `$idName` = '$colID' AND (`$statusName` = 'approval' OR `$statusName` = 'on')";
	     mysqli_query($db,$sqlquery);
	}
	?>

	<?php
	
	$sqlquery2 = "UPDATE `updt_info` SET `updt_viewstatus` = 'on' 
						     WHERE `updt_rowid` = '$colID' ";
	 mysqli_query($db,$sqlquery2); 
		
?>