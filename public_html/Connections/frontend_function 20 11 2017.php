<?php

/************************************************************************/
/* @category 	Multi cms with multi permissions 						*/
/* @package 	Shop listing portal 									*/
/* @author 		Original Author Raja Ram R <rajaram234r@gmail.com>		*/
/* @author 		Another Author Farook <mohamedfarooks@gmail.com> 		*/
/* @copyright 	2016 - 2017 ewebeye.com 								*/
/* @license 	Lekshmipriya												*/
/* @since 		This file available since 2.10 							*/
/* @date 		Created date 09/08/2017 								*/
/* @modify 		Latest modified date 09/08/2017						*/
/* @code 		PHP 5.7 												*/
/************************************************************************/
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

/* ---------- common functions --------------------*/
		//$timezone = $_SESSION['comData']['timesone'];
		if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
		$national_date_time_24	= date('Y-m-d H:i:s');
		$_SESSION['now'] 		= $national_date_time_24;
/* ---------- common functions --------------------*/


?>
<?php

class Contact{
	public $em_id;
	public $em_name;
	public $em_contactno;
	public $em_email;
	public $em_website;
	public $em_message;
	public $em_status;
	public $em_shopid;
	public $em_prodid;
	public $em_userid;
	public $em_createdAt;
	public $em_flag;
	public $page_name;
	public $tableName;
	
	public function sendEmail(){
		include('Connections/dragonmartguide.php');
		$this->em_name			=	isset($_POST['emailname'])?$_POST['emailname']:'';
		$this->em_contactno		=   isset($_POST['emailcontact'])?$_POST['emailcontact']:'';
		$this->em_email			=	isset($_POST['emailid'])?$_POST['emailid']:'';
		$this->em_website		=	isset($_POST['website'])?$_POST['website']:'';
		$this->em_message		=	isset($_POST['message'])?$_POST['message']:'';
		$this->em_status		=	'approval';
		$this->em_createdAt		=   $_SESSION['now'];
		$this->tableName		=	'enquiry_dmg';
		$this->em_userid		=	 isset($_SESSION['loginUserid'])?$_SESSION['loginUserid']:'';
		$sqlInsertEmailData		=	"INSERT INTO `enquiry_dmg`							      
																(
																	`em_shopid`,
																	`em_product_id`,
																	`em_userid`,
																	`em_name`,
																	`em_contactno`,
																	`em_email`,
																	`em_ipaddress`,
																	`em_website`,
																	`em_message`,
																	`em_flag`,
																	`em_createdAt`,
																	`em_status`
																	
																)VALUES (
																	 '$this->em_shopid',
																	 '$this->em_prodid',
																	 '$this->em_userid',
																	 '$this->em_name', 
														 			 '$this->em_contactno',
																	 '$this->em_email',
																	 '$this->em_ipaddress',
																	 '$this->em_website',
																	 '$this->em_message',
																	 '$this->em_flag',
																	 '$this->em_createdAt',
																	 '$this->em_status'
													)";
		
		
		mysqli_query($db,$sqlInsertEmailData);
		$this->last_insert_id	= mysqli_insert_id($db);
		$insertData				= mysql_real_escape_string($sqlInsertEmailData);
		
		$updateInfoObj = new Updates();
					 $updateInfoObj->processInformation(
												'insert',
												 $this->page_name,
												 $this->tableName,
												 $this->last_insert_id,
												 '',
												 $insertData,
												 $_SESSION['now']
											  );
		
	}
	
		public function get_client_ip() { //get the client ip address
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}
?>
	
<?php 
class Register{
		
		public $tablename;
		public $pagename;
	
		public $username;
		public $password;
		public $firstname;
		public $lastname;
		public $gender;
		public $address;
		public $mobile;
		public $shopnumber;
		public $shopselected;
		public $mallname;
		public $designation;
		public $pic;
		public $adminid;
		public $msg;
		public $createdDate;
		public $prodt_offer;
		public $status;
		
	public function insertLoginData(){
		include('Connections/dragonmartguide.php');
		//file upload start
	    
		/*$target_dir 	= 	"images/login/";
		
		$profPic  		=	$_FILES["file_user"]["name"];
		$target_file 	= 	$target_dir . basename($_FILES["file_user"]["name"]);
		move_uploaded_file($_FILES["file_user"]['tmp_name'],$target_file);*/
		//file upload end
		
		
	 	//file upload starts here
		
		$sizeP 		= 	"2097152";
		$pathP 		= 	"images/login/";
		//$dpathP 	= 	"dragonmartguide.com/images/login/";
		$idname		=	"reg_id";
		$tableP 	= 	"user_register";
		//$idP 		= $idP;
		
		$q2 = "select MAX(".$idname.") from ".$tableP;
		$result2 = mysqli_query($db, $q2);
		$data2 = mysqli_fetch_array($result2);
		
		$flag = 0;
		if ($_FILES["file_user"]["name"] != "")
		{
			$flag == 0;
			$nid = ++$data2[0];
		
			if ((($_FILES["file_user"]["type"] == "image/gif")
			|| ($_FILES["file_user"]["type"] == "image/jpeg")
			|| ($_FILES["file_user"]["type"] == "image/ICO")
			|| ($_FILES["file_user"]["type"] == "image/png")
			|| ($_FILES["file_user"]["type"] == "image/pjpeg"))
			&& ($_FILES["file_user"]["size"] < $sizeP))
			{
				
				if ($_FILES["file_user"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["file_user"]["error"] . "<br />";
						$flag = 0;
				} else {
					
					if (file_exists($pathP . $nid."_" . $_FILES["file_user"]["name"]))
					{	

						$mpicture_file =  $_FILES["file_user"]["name"];
						echo "<script type='text/javascript'>alert('Picture : $mpicture_file already exists. Sorry!');</script>"; 
						$flag = 0;

					} else {
						$filename = preg_replace('/\s+/', '_', $_FILES["file_user"]["name"]);
						move_uploaded_file($_FILES["file_user"]["tmp_name"], $pathP . $nid."_" . $filename);
						$this->reg_pic =  $nid."_".$filename;
						$flag = 1;
					}
					
				}
			} else {
				$mpicture_file =  $_FILES["file_user"]["name"];
				echo "<script type='text/javascript'>alert('Picture : $mpicture_file is not right picture. Sorry!');</script>"; 	
				$flag = 0;
			}
		} else {
			$this->reg_pic					=    '';
			$flag = 1;
		}
		
		
		// file upload ends here
		
		$this->reg_username			=	 isset($_POST['username'])?$_POST['username']:'';
		$this->reg_password			=    isset($_POST['password'])?$_POST['password']:'';
		$this->reg_firstname		=	 isset($_POST['txt_firstName'])?$_POST['txt_firstName']:'';
		$this->reg_lastname			=	 isset($_POST['txt_secondName'])?$_POST['txt_secondName']:'';
		$this->reg_gender			=	 isset($_POST['radio_gender'])?$_POST['radio_gender']:'';
		$this->reg_address			=	 isset($_POST['txt_address'])?$_POST['txt_address']:'';
		$this->reg_mobile			=	 isset($_POST['txt_mob'])?$_POST['txt_mob']:'';
		$mobData 					= 	 str_replace(' ', '', $this->reg_mobile);
		$this->reg_shopnumber		=	 isset($_POST['txt_shopNumber'])?$_POST['txt_shopNumber']:'';
		
		//for seralized array
		$shopIds 					= 	 isset($_POST['dataShopID'])?$_POST['dataShopID']:'';
		$shopNames 					= 	 isset($_POST['dataShopName'])?$_POST['dataShopName']:'';
		$shopNumbers 				= 	 isset($_POST['dataShopNumber'])?$_POST['dataShopNumber']:'';
		
		//$selectedNumbers 			=array('shopid'=>$shopIds,'shopName'=>$shopNames,array('shopNumber'=>$shopNumbers));
		$selectedNumbers 			=  array('shopid'=>$shopIds,'shopName'=>$shopNames,'shopNumber'=>$shopNumbers);
	    $selectDatas				=  serialize($selectedNumbers);
	
		$this->reg_shopselected		=	 $selectDatas;
		$this->reg_mallname			=	 isset($_POST['txt_mall'])?$_POST['txt_mall']:'';
		$this->reg_designation		=    isset($_POST['txt_designation'])?$_POST['txt_designation']:'';
		//$this->reg_pic				=    isset($profPic)?$profPic:'';
		$this->reg_adminId			=    '';
		$this->reg_msg				=    isset($_POST['txt_Message'])?$_POST['txt_Message']:'';
		$this->reg_cre_date			=    $_SESSION['now'];
		$this->reg_modi_date		=    '';
		$this->reg_status			=    'approval';
		
		if (filter_var($this->reg_username, FILTER_VALIDATE_EMAIL)) {
			$flag = 1;
		} else {
			$flag = 0;
		}
		
		 if ($this->reg_mobile != '') {
			$flag = 1;
		} else {
			$flag = 0;
		}
		
		if($this->reg_shopnumber !='' && $this->reg_msg != '' ){
			$flag = 1;
		}else{
			$flag = 0;
		}
		
		
		if($flag == 1){
				$sqlInsertRegisterData		=	"INSERT INTO `user_register`							      
																	(
																		`reg_username`,
																		`reg_password`,
																		`reg_firstname`,
																		`reg_lastname`,
																		`reg_gender`,
																		`reg_address`,
																		`reg_mobile`,
																		`reg_shopnumber`,
																		`reg_shopselected`,
																		`reg_mallname`,
																		`reg_designation`,
																		`reg_pic`,
																		`reg_adminId`,
																		`reg_msg`,
																		`reg_cre_date`,
																		`reg_modi_date`,
																		`reg_status`

																	)VALUES (
																		 '$this->reg_username',
																		 '$this->reg_password',
																		 '$this->reg_firstname',
																		 '$this->reg_lastname', 
																		 '$this->reg_gender',
																		 '$this->reg_address',
																		 '$this->reg_mobile',
																		 '$this->reg_shopnumber',
																		 '$this->reg_shopselected',
																		 '$this->reg_mallname',
																		 '$this->reg_designation',
																		 '$this->reg_pic',
																		 '$this->reg_adminId',
																		 '$this->reg_msg',
																		 '$this->reg_cre_date',
																		 '$this->reg_modi_date',
																		 '$this->reg_status'
																		 )";


			mysqli_query($db,$sqlInsertRegisterData);
			$this->last_insert_id	= mysqli_insert_id($db);
			$insertData				= mysql_real_escape_string($sqlInsertRegisterData);

			$updateInfoObj = new Updates();
						 $updateInfoObj->processInformation(
													'insert',
													 $this->pagename,
													 $this->tablename,
													 $this->last_insert_id,
													 '',
													 $insertData,
													 $_SESSION['now']
												  );
			include('Connections/email_newUserAdmin.php');
			include('Connections/email_newUserShop.php');
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Success! </strong>Your request submitted successfully. We will contact soon.If you have any queries please contact to +971 501486343</div>";

		}else{
			echo "<div class='alert alert-danger' id='danger-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Failure! </strong>Some valid datas are missing</div>";
		}
			
	}

} ?>
	
<?php
class Updates{  
	public $updateId;
	public $action;
	public $pageName;
	public $tableName;
	public $rowId;
	public $userId;
	public $data;
	public $updateTime;
	public $viewStatus;
	
	public function processInformation($action,$pageName,$tableName,$rowId,$userId,$data,$updateTime){			
		
		include('Connections/dragonmartguide.php');
		$sqlqueryForUpdateInfo 			= "INSERT INTO `updt_info`							      
																(
																	`updt_id`,
																	`updt_type`,
																	`updt_pagename`,
																	`updt_tablename`,
																	`updt_rowid`,
																	`updt_userid`,
																	`updt_data`,
																	`updt_time`,
													 				`updt_viewstatus`
																)VALUES (
																	 NULL,
																	 '$action', 
																	 '$pageName',
																	 '$tableName',
																	 '$rowId',
																	 '$userId',
																	 '$data',
																	 '".$updateTime."',
																	 'not viewed')";
		
			
		mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));
	}
}

class Product{
	public $shopid;
	public $productID;
	public $tableName;
	public $viewsCount;
	public $advType;

	public function updateShopViewsCount(){
		include('Connections/dragonmartguide.php');
			
		mysqli_query($db,"UPDATE `shop_details` SET `shop_view_count` = `shop_view_count`+1 WHERE `shop_id` = '$this->shopid' ");
		mysqli_query($db,"UPDATE `product_details` SET `prodt_views_count` = `prodt_views_count`+1 WHERE  `prodt_company_id` = '$this->shopid' ");
	}
	public function updateproductViewsCount(){
	
		include('Connections/dragonmartguide.php');
		mysqli_query($db,"UPDATE `$this->tableName` SET `prodt_views_count` = `prodt_views_count`+1,`prodt_click_count` =  `prodt_click_count`+1 WHERE `prodt_id` = '$this->productID' AND `prodt_company_id` = '$this->shopid' ");
		
		
	}
	
	public function getProductOfferDetails(){
		include('Connections/dragonmartguide.php');
		
	    $currenDat = date('Y-m-d H:i:s',strtotime($_SESSION['now']));
		$getOfferData	=	mysqli_query($db, "SELECT * FROM offer_dmg WHERE '$currenDat' >= offer_start  AND '$currenDat'  <= offer_end  AND offer_shop_id = '$this->shopid' AND offer_status = 'on'");
		
		
		return $getOfferData;
	}
	
	public function getShopDetails(){
		include('Connections/dragonmartguide.php');
		$getShopData	=	mysqli_query($db, "SELECT detail.*,num.* FROM shop_details detail INNER JOIN shop_number num ON detail.shop_id = num.sno_shopid  WHERE  detail.shop_id = '$this->shopid'");
		return $getShopData;
	}
	
	
	function getShopProductDetails(){
		include('Connections/dragonmartguide.php');
		//echo "SELECT s.*,p.* FROM shop_details s INNER JOIN product_details p ON s.shop_id = p.prodt_company_id WHERE s.shop_id = '$this->shopid'" ;
		$getShopData	=	mysqli_query($db, "SELECT s.*,p.* FROM shop_details s INNER JOIN product_details p ON s.shop_id = p.prodt_company_id WHERE s.shop_id = '$this->shopid'");
		return $getShopData;
	}
	
	function getProductDetails(){
		include('Connections/dragonmartguide.php');
		$getProductData	=	mysqli_query($db, "SELECT s.*,p.* FROM product_details p INNER JOIN shop_details s ON s.shop_id = p.prodt_company_id WHERE s.shop_id = '$this->shopid' and p.prodt_id = '$this->productID'");
		return $getProductData;
	}
	
	function getAdvertisement(){
		include('Connections/dragonmartguide.php');
		$currentDate	=	$_SESSION['now'];
		
		$getAdData	=	mysqli_query($db, "SELECT ad.*,sett.* FROM advertisement ad INNER JOIN settings sett ON sett.sett_id = ad.Ad_Type WHERE  Ad_Status = 'on'  AND sett.sett_where = '$this->advType' AND ('$currentDate' BETWEEN ad.Ad_Startdate AND ad.Ad_Enddate)");
		return $getAdData;
	}
	
	function getHomAd(){
		include('Connections/dragonmartguide.php');
		$currentDate	=	$_SESSION['now'];
		$getAdData	=	mysqli_query($db, "SELECT ad.*,sett.* FROM advertisement ad INNER JOIN settings sett ON sett.sett_id = ad.Ad_Type WHERE Ad_Status = 'on'  AND sett.sett_where = '$this->advType' AND ('$currentDate' BETWEEN ad.Ad_Startdate AND ad.Ad_Enddate) ORDER BY RAND() LIMIT 1");
		return $getAdData;
	}
	
	function updateViewCount($AdID,$adTypeID){
		include('Connections/dragonmartguide.php');
		
		mysqli_query($db,"UPDATE `advertisement` SET `Ad_Views` = `Ad_Views`+1 WHERE `Ad_Id` = '$AdID' AND Ad_Status = 'on' AND `Ad_Type` = '$adTypeID'");
	}
	
}





//	extract common search words start
	function extractCommonWords($string){
      $stopWords = array('i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www');
   
      $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
      $string = trim($string); // trim the string
      $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
      //$string = strtolower($string); // make it lowercase
   
      preg_match_all('/\b.*?\b/i', $string, $matchWords);
      $matchWords = $matchWords[0];
		
      foreach ( $matchWords as $key=>$item ) {
          if ( $item == '' ||  $item == '0' || in_array($item, $stopWords) || strlen($item) <= 3 ) {
              unset($matchWords[$key]);
          }
      }  
		$matchWords = array_unique($matchWords);
		$matchWords = array_values($matchWords);
      $wordCountArr = array();
//      if ( is_array($matchWords) ) {
//          foreach ( $matchWords as $key => $val ) {
//              //$val = strtolower($val);
//              if ( isset($wordCountArr[$val]) ) {
//                  $wordCountArr[$val]++;
//              } else {
//                  $wordCountArr[$val] = 1;
//              }
//          }
//      }
      //arsort($wordCountArr);
      $wordCountArr = array_slice($matchWords, 0, 10);
      return $wordCountArr;
}
//	extract common words end
?>		
			 

		

