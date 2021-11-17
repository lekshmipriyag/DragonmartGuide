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
	class Offer {
		
		public $ofr_shop_id;
		public $ofr_user_id;
		public $ofr_name;
		public $ofr_type;
		public $ofr_type_1;
		public $ofr_type_2;
		public $ofr_details;
		public $ofr_start;
		public $ofr_end;
		public $ofr_picture;
		public $ofr_views;
		public $ofr_modi;
		public $ofr_cre;
		public $ofr_status;
		
		public $tableName;
		public $delColumnId;
		public $liveuser;
		public $status;
		public $last_insert_id;
		public $page_name;
		
		public function c_offer(){ //offer creation
			
			include('../Connections/dragonmartguide.php');
			$this->offer_shop_id	=	$_POST['companyID'];
			$this->ofr_user_id		= 	$_SESSION['loginUserid'];
			$this->ofr_name			= 	htmlentities($_POST['offername']);
			$this->ofr_name 		= 	mysql_real_escape_string($this->ofr_name);
			
			if(isset($_POST['offertype'])){
					$this->ofr_type		= $_POST['offertype'] ;
					switch($this->ofr_type){
						case "discount" :
							if($_POST['percentage'])
							{ 
								$this->ofr_type_1 = htmlentities($_POST['percentage']);
							}else {
								$this->ofr_type_2 = htmlentities($_POST['dirhams']);
							}
							break;
						case "flat" :	
							$this->ofr_type_1 = htmlentities($_POST['Flat-percentageS']);
							$this->ofr_type_2 = htmlentities($_POST['Flat-percentageE']);
							break;
						case "buy-get" :	
							$this->ofr_type_1 = htmlentities($_POST['buy-get1']);
							$this->ofr_type_2 = htmlentities($_POST['buy-get2']);
							break;
						case "cashback" :	
							$this->ofr_type_1 = htmlentities($_POST['purchase']);
							$this->ofr_type_2 = htmlentities($_POST['cashback']);	
							break;
						default :
							$this->ofr_type_1 = "";
							$this->ofr_type_2 = "";
					}
			}
			$this->ofr_details 	= htmlentities($_POST['offerdetails']);	
			$this->ofr_details  = mysql_real_escape_string($this->ofr_details);
			$offerDate 			= explode(' - ', $_POST['daterange']);
		
			$startDate = strtr($offerDate[0], '/', '-');
			$endDate   = strtr($offerDate[1], '/', '-');
			$this->ofr_start 	= date('Y-m-d H:i:s', strtotime($startDate));
			$this->ofr_end 		= date('Y-m-d H:i:s', strtotime($endDate));
			
			$this->ofr_picture 	= $_POST['bannerimg'];		
			
			$sqlquery 			= "INSERT INTO `offer_dmg`
			                        			  (`offer_id`, 
												  `offer_shop_id`, 
												  `offer_user_id`,
												  `offer_name`, 
												  `offer_type`,
												  `offer_type_1`,
												  `offer_type_2`,
												  `offer_details`, 
												  `offer_start`, 
												  `offer_end`, 
												  `offer_picture`, 
												  `offer_views`,
												  `offer_modi`, 
												  `offer_cre`, 
												  `offer_status`)
						VALUES (NULL, 
								'$this->offer_shop_id', 
								'$this->ofr_user_id', 
								'$this->ofr_name',
								'$this->ofr_type',
								'$this->ofr_type_1',
								'$this->ofr_type_2',
								'$this->ofr_details', 
								'$this->ofr_start', 
								'$this->ofr_end', 
								'$this->ofr_picture', 
								'', 
								'0000-00-00 00:00:00', 
								'".$_SESSION['now']."', 
								'approval')";
		    $queryresult	=	mysqli_query($db, $sqlquery) or die(mysqli_error($db));
			
			$this->last_insert_id	= mysqli_insert_id($db);
			//after each trigger whatever it is ,must inserted into update_info_dmg table.
			$insertData				=	 mysql_real_escape_string($sqlquery);
			$this->tableName		= 'offer_dmg';
			
		  /* $sqlqueryForUpdateInfo 			= "INSERT INTO 					         `updt_info`(`updt_id`,`updt_type`,`updt_pagename`,`updt_tablename`,`updt_rowid`,`updt_userid`,`updt_data`,`updt_time`,`updt_viewstatus`)VALUES (NULL, 'insert', '$this->page_name','offer_dmg','$this->last_insert_id','".$_SESSION['loginUserid']."', '$insertData','".$_SESSION['now']."', 'not viewed')";
			
			mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));*/
			
			 $updateInfoObj = new Updatesinfo();
			  $updateInfoObj->processInformation(
												'insert',
												 $this->page_name,
												 $this->tableName,
												 $this->last_insert_id,
												 $_SESSION['loginUserid'],
												 $insertData,
												 $_SESSION['now']
											  );
					
		}
		
		public function m_offer(){  // offer modification
				
		include('../Connections/dragonmartguide.php');
			
			$this->offer_shop_id	=	$_POST['companyID'];	
			$this->ofr_user_id		=	$_SESSION['loginUserid'];
			$this->ofr_id 	    	=	htmlentities($_POST['offerHiddenID']);
			$this->ofr_name			=	htmlentities($_POST['offername']);
			$this->ofr_name 		=	mysql_real_escape_string($this->ofr_name);
			
			if(isset($_POST['offertype'])){
					$this->ofr_type		= $_POST['offertype'] ;
					switch($this->ofr_type){
						case "discount" :
							if(isset($_POST['percentage']))
							{
								$this->ofr_type_1 = htmlentities($_POST['percentage']);
							}else{
								$this->ofr_type_2 = htmlentities($_POST['dirhams']);
							}
							break;
						case "flat" :	
							$this->ofr_type_1 = htmlentities($_POST['Flat-percentageS']);
							$this->ofr_type_2 = htmlentities($_POST['Flat-percentageE']);
							break;
						case "buy-get" :	
							$this->ofr_type_1 = htmlentities($_POST['buy-get1']);
							$this->ofr_type_2 = htmlentities($_POST['buy-get2']);
							break;
						case "cashback" :	
							$this->ofr_type_1 = htmlentities($_POST['purchase']);
							$this->ofr_type_2 = htmlentities($_POST['cashback']);	
							break;
						default :
							$this->ofr_type_1 = "";
							$this->ofr_type_2 = "";
					}
			}
			
			$this->ofr_details 	= htmlentities($_POST['offerdetails']);	
			$this->ofr_details  = mysql_real_escape_string($this->ofr_details);
			$offerDate 			= explode(' - ', $_POST['daterange']);
			
			$startDate = strtr($offerDate[0], '/', '-');
			$endDate   = strtr($offerDate[1], '/', '-');
			
			$this->ofr_start 	= date('Y-m-d H:i:s', strtotime($startDate));
			$this->ofr_end 		= date('Y-m-d H:i:s', strtotime($endDate));
		
			if(isset($_POST['bannerimg'])){
			$this->offer_picture = $_POST['bannerimg'];
			}
			else{$this->offer_picture = $_POST['userpic_old'];}
		
			$sqlquery = "UPDATE `offer_dmg` SET `offer_name` = '$this->ofr_name', `offer_type` = '$this->ofr_type', `offer_type_1` = '$this->ofr_type_1', `offer_type_2` = '$this->ofr_type_2', `offer_details` = '$this->ofr_details', `offer_start` = '$this->ofr_start', `offer_end` = '$this->ofr_end', `offer_picture` = '$this->offer_picture', `offer_modi` = '".$_SESSION['now']."' WHERE `offer_dmg`.`offer_id` = '$this->ofr_id '";
		
			mysqli_query($db, $sqlquery) or die(mysqli_error($db));
			
			
			//after each trigger whatever it is ,must inserted into update_info_dmg table.
			$updateData			=	 mysql_real_escape_string($sqlquery);
			$lastUpdatedId		=	 $this->ofr_id;
			$this->tableName	=	 'offer_dmg';
			
		  /* $sqlqueryForUpdateInfo 			= "INSERT INTO 					         							`updt_info`(`updt_id`,`updt_type`,`updt_pagename`,`updt_tablename`,`updt_rowid`,`updt_userid`,`updt_data`,`updt_time`,`updt_viewstatus`)VALUES (NULL, 'update', '$this->page_name','offer_dmg','$lastUpdatedId','".$_SESSION['loginUserid']."', '$updateData','".$_SESSION['now']."', 'not viewed')";
			
			mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db)); */
			
			 $updateInfoObj = new Updatesinfo();
			   $updateInfoObj->processInformation(
												'update',
												 $this->page_name,
												 $this->tableName,
												 $lastUpdatedId,
												 $_SESSION['loginUserid'],
												 $updateData,
												 $_SESSION['now']
											  );
		}
		
		
		public function deleteData(){
			include('../Connections/dragonmartguide.php');
			
			$getOfferUserId	= "SELECT `offer_user_id` FROM `offer_dmg` WHERE `offer_id` = '$this->delColumnId' ";
			$userID			= mysqli_query($db,$getOfferUserId);
			$resultData		= mysqli_fetch_array($userID);
			$offerUserID	= $resultData['offer_user_id'];
			
			$userData 		= mysqli_query($db,"SELECT `user_username` FROM `user_dmg` WHERE `user_id` = 												'$offerUserID'");
			$userDataResult = mysqli_fetch_array($userData);	
			$userNameLive	= $userDataResult['user_username'];	
			
			if($userNameLive == $this->liveuser){
				$sqlquery = "UPDATE `$this->tableName` SET `offer_status` = '$this->status' 
						     WHERE `offer_id` = '$this->delColumnId' AND `offer_user_id` = '$offerUserID' ";
				mysqli_query($db,$sqlquery); 
				
			//after each trigger whatever it is ,must inserted into update_info_dmg table.	
			$updateData	=	 mysql_real_escape_string($sqlquery);	
			$lastUpdatedId	= $this->delColumnId;
			$this->tableName = 'offer_dmg';	
			
		 /*  $sqlqueryForUpdateInfo 			= "INSERT INTO 					         								`updt_info`(`updt_id`,`updt_type`,`updt_pagename`,`updt_tablename`,`updt_rowid`,`updt_userid`,`updt_data`,`updt_time`,`updt_viewstatus`)VALUES (NULL, 'delete', '$this->page_name','offer_dmg','$lastUpdatedId','".$_SESSION['loginUserid']."', '$updateData','".$_SESSION['now']."', 'not viewed')";
			
			mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));*/
				
			$updateInfoObj = new Updatesinfo();
			$updateInfoObj->processInformation(
												'delete',
												 $this->page_name,
												 $this->tableName,
												 $lastUpdatedId,
												 $_SESSION['loginUserid'],
												 $updateData,
												 $_SESSION['now']
											  );
			
			}
		}
		
		
	}

?>
<?php 
class common{
	
	public function joinWithEnquiry($joinTable,$rowID){
		 include('../Connections/dragonmartguide.php');

		if($joinTable == 'user_register'){
			$primaryID = 'reg_id';
			$selectField = 'reg_pic';
		}
		/*else if($joinTable == 'advertisement'){
			$primaryID = 'Ad_Id';
			$selectField = 'Ad_Picture';
		}
		
		echo "SELECT J.$selectField FROM updt_info AS U INNER JOIN $joinTable AS J  ON U.updt_rowid = J.reg_id WHERE J.$primaryID = $rowID";*/
		
		 $resultData = mysqli_query($db,"SELECT J.$selectField FROM updt_info AS U INNER JOIN $joinTable AS J  ON U.updt_rowid = J.$primaryID WHERE J.$primaryID = $rowID");
		 $fetchResultData = mysqli_fetch_array($resultData);
		return $fetchResultData[$selectField];

	}
}
?>
<?php
	class Product{
		
		public $tableName;
		public $selectedColumn;
		
		public $product_id;
		public $prodt_category;
		public $prodt_codeno;
		public $prodt_name;
		public $prodt_picture;
		public $prodt_newpics;
		public $prodt_description;
		public $prodt_specifications;
		public $prodt_price;
		public $prodt_size;
		public $prodt_avail_quantity;
		public $prodt_unite_type;
		public $prodt_avail_color;
		public $prodt_brand;
		public $prodt_offer_type;
		public $prodt_offer;
		public $prodt_offer_from;
		public $prodt_offer_to;
		public $prodt_offer_times;
		public $prodt_company_id;
		public $prodt_fav_count;
		public $prodt_views_count;
		public $prodt_offer_views;
		public $prodt_ranking;
		public $prodt_cre;
		public $prodt_modi;
		public $prodt_status;
		public $delColumnId;
		public $liveuser;
		
		
		
			
		

		public function getCategoryList(){
			
		    include('../Connections/dragonmartguide.php');
			$resultData	=	mysqli_query($db,"SELECT DISTINCT `$this->selectedColumn` FROM `$this->tableName`");
			return $resultData;
		}
		
		public function insertProductDetails(){ // insert product category details to db
			include('../Connections/dragonmartguide.php');	
			
			$this->prodt_category 			= $_POST['prodCategory'];
			$this->prodt_name 				= $_POST['prod_name'];
			$this->prodt_size		 		= $_POST['prodSize'];
			$this->prodt_avail_quantity 	= $_POST['availQty'];
			//$this->prodt_avail_color 		= serialize($_POST['availColor']);
			$this->prodt_avail_color 		= $_POST['availColor'];
			$this->prodt_unite_type 		= $_POST['prodUnit'];
			$this->prodt_brand				= $_POST['prodBrand'];	
			$this->prodt_description		= $_POST['prod_desc'];
			$this->prodt_specifications		= $_POST['prod_spec'];
			$this->prodt_picture 			= $_POST['productimg'];
			$this->prodt_newpics 			= (isset($_POST['productnewpics'])?serialize($_POST['productnewpics']):'');
			$this->prodt_status				= 'approval';
			$this->prodt_cre				= $_SESSION['now'];
			
			
			$sqlInsertQuery 			= "INSERT INTO `product_details`
			                        			  (`prodt_id`,
												  `prodt_category`, 
												  `prodt_codeno`, 
												  `prodt_name`,
												  `prodt_picture`,
												  `prodt_newpics`,
												  `prodt_description`,
												  `prodt_specifications`,
												  `prodt_price`,
												  `prodt_size`,
												  `prodt_avail_quantity`, 
												  `prodt_unite_type`, 
												  `prodt_avail_color`, 
												  `prodt_brand`,
												  `prodt_offer_type`,
												  `prodt_offer`, 
												  `prodt_offer_from`, 
												  `prodt_offer_to`,
												  `prodt_offer_times`, 
												  `prodt_company_id`, 
												  `prodt_fav_count`,
												  `prodt_views_count`,
												  `prodt_offer_views`, 
												  `prodt_ranking`, 
												  `prodt_cre`,
												  `prodt_modi`,
												  `prodt_status`
												  )
						VALUES (NULL, 
								'$this->prodt_category', 
								'', 
								'$this->prodt_name',
								'$this->prodt_picture',
								'$this->prodt_newpics',
								'$this->prodt_description',
								'$this->prodt_specifications',
								'',
								'$this->prodt_size', 
								'$this->prodt_avail_quantity', 
								'$this->prodt_unite_type', 
								'$this->prodt_avail_color', 
								'$this->prodt_brand', 
								'',
								'',
								'0000-00-00 00:00:00', 
								'0000-00-00 00:00:00', 
								'',
								'$this->prodt_company_id',
								'',
								'',
								'',
								'',
								'$this->prodt_cre', 
								'0000-00-00 00:00:00', 
								'$this->prodt_status')";
			mysqli_query($db, $sqlInsertQuery) or die(mysqli_error($db));
			
			
			
		   $this->last_insert_id = mysqli_insert_id($db);
			//after each trigger whatever it is ,must inserted into update_info_dmg table.
			$insertData	=	 mysql_real_escape_string($sqlInsertQuery);
			$this->tableName	=	"product_details";
			
		   /*$sqlqueryForUpdateInfo 			= "INSERT INTO 					         `updt_info`(`updt_id`,`updt_type`,`updt_pagename`,`updt_tablename`,`updt_rowid`,`updt_userid`,`updt_data`,`updt_time`,`updt_viewstatus`)VALUES (NULL, 'insert', '$this->page_name','add_product','$this->last_insert_id','".$_SESSION['loginUserid']."', '$insertData','".$_SESSION['now']."', 'not viewed')";
			
			mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));
			*/
					$updateInfoObj = new Updatesinfo();
					$updateInfoObj->processInformation(
												'insert',
												 $this->page_name,
												 $this->tableName,
												 $this->last_insert_id,
												 $_SESSION['loginUserid'],
												 $insertData,
												 $_SESSION['now']
											  );
			
			
			
		}
		
		public function updateProductDetails(){ // insert product category details to db
			include('../Connections/dragonmartguide.php');	
			
			 $this->product_id 	    		= $_POST['productHiddenID'];
			 $this->prodt_category 			= $_POST['prodCategory'];
			 $this->prodt_name 				= $_POST['prod_name'];
			 $this->prodt_size		 		= $_POST['prodSize'];
			 $this->prodt_avail_quantity 	= $_POST['availQty'];
			 //$this->prodt_avail_color 		= serialize($_POST['availColor']);
			 $this->prodt_avail_color 		= $_POST['availColor'];
			 $this->prodt_unite_type 		= $_POST['prodUnit'];
			 $this->prodt_brand				= $_POST['prodBrand'];	
			 $this->prodt_description		= $_POST['prod_desc'];
			 $this->prodt_specifications	= $_POST['prod_spec'];
			 $this->prodt_picture 			= $_POST['productimg'];
			 $this->prodt_newpics 			= serialize($_POST['productnewpics']);
			 $this->prodt_status			= 'approval';
			 $this->prodt_modi				= $_SESSION['now'];
			 $this->tableName				= "product_details";	
			
			echo $sqlquery = "UPDATE `product_details` SET
									`prodt_category` 		= '$this->prodt_category', 
									`prodt_name` 			= '$this->prodt_name',
									`prodt_picture` 		= '$this->prodt_picture',
									`prodt_newpics` 		= '$this->prodt_newpics',
									`prodt_description` 	= '$this->prodt_description',
									`prodt_specifications` 	= '$this->prodt_specifications'',
									`prodt_size` 		   	= '$this->prodt_size',
									`prodt_avail_quantity` 	= '$this->prodt_avail_quantity',
									`prodt_unite_type` 		= '$this->prodt_unite_type', 
									`prodt_avail_color` 	= '$this->prodt_avail_color',
									`prodt_brand` 			= '$this->prodt_brand',
									`prodt_modi` 			= '".$_SESSION['now']."'
									WHERE `product_details`.`prodt_id` = '$this->product_id  '";
		
			mysqli_query($db, $sqlquery) or die(mysqli_error($db));
			
			
			
			//after each trigger whatever it is ,must inserted into update_info_dmg table.
			$updateData	=	 mysql_real_escape_string($sqlquery);
			$lastUpdatedId	=	$this->product_id;
			
		   /*$sqlqueryForUpdateInfo 			= "INSERT INTO 					         							`updt_info`(`updt_id`,`updt_type`,`updt_pagename`,`updt_tablename`,`updt_rowid`,`updt_userid`,`updt_data`,`updt_time`,`updt_viewstatus`)VALUES (NULL, 'update', '$this->page_name','add_product','$lastUpdatedId','".$_SESSION['loginUserid']."', '$updateData','".$_SESSION['now']."', 'not viewed')";
			
			mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));*/
			
			
			$updateInfoObj = new Updatesinfo();
			$updateInfoObj->processInformation(
												'update',
												 $this->page_name,
												 $this->tableName,
												 $lastUpdatedId,
												 $_SESSION['loginUserid'],
												 $updateData,
												 $_SESSION['now']
											  );
			
			
		}
		
		
		
		
		
		
		public function deleteProduct(){ //update prodt_status to delete
			include('../Connections/dragonmartguide.php');
			
			 $getUserData	= "SELECT U.user_username, U.user_id FROM `user_dmg` U 
								INNER JOIN  `shop_details` S ON S.shop_user_id = U.user_id
								INNER JOIN 	`product_details` P ON P.prodt_company_id = S.shop_id
								WHERE P.prodt_id = '$this->delColumnId' "; 
			 $userID 		=  mysqli_query($db,$getUserData);
			 $resultData	= mysqli_fetch_array($userID);
			 $userName		= $resultData['user_username'];
			 $modi_time		= $_SESSION['now'];
			
			 $sqlquery 		= "UPDATE `$this->tableName` SET `prodt_status` = '$this->status' ,`prodt_modi` = '$modi_time'
						     WHERE `prodt_id` = '$this->delColumnId' ";
			 mysqli_query($db,$sqlquery); 
			
			$updateData			=	 mysql_real_escape_string($sqlquery);	
			$lastUpdatedId		= $this->delColumnId;
			$this->tableName 	= "product_details";
		    //after each trigger whatever it is ,must inserted into update_info_dmg table.	
		  	/* $sqlqueryForUpdateInfo 			= "INSERT INTO 					         								`updt_info`(`updt_id`,`updt_type`,`updt_pagename`,`updt_tablename`,`updt_rowid`,`updt_userid`,`updt_data`,`updt_time`,`updt_viewstatus`)VALUES (NULL, 'delete', '$this->page_name','add_product','$lastUpdatedId','".$_SESSION['loginUserid']."', '$updateData','".$_SESSION['now']."', 'not viewed')";
			
			mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));*/
			
			$updateInfoObj = new Updatesinfo();
			$updateInfoObj->processInformation(
												'delete',
												 $this->page_name,
												 $this->tableName,
												 $lastUpdatedId,
												 $_SESSION['loginUserid'],
												 $updateData,
												 $_SESSION['now']
											  );
		
		}
		
	}

class Ad{ //insert advertisement details to db
	public $Ad_Type;
	public $Ad_Name;
	public $Ad_Shopid;
	public $Ad_Shopname;
	public $Ad_Userid;
	public $Ad_Username;
	public $Ad_Description;
	public $Ad_Pagename;
	public $Ad_Startdate;
	public $Ad_Enddate;
	public $Ad_Createddate;
	public $Ad_Modifieddate;
	public $Ad_views;
	public $Ad_Clicks;
	public $Ad_Status;
	public $Ad_Picture;
	
	public function getShopWithNumber(){
		include('../Connections/dragonmartguide.php');
		$getData	=	"SELECT shop_id,shop_name,shop_number FROM shop_details ORDER BY shop_name";
		$getResult	=	mysqli_query($db,$getData);
		return($getResult);
		
	}
	
	public function getAdData($adType){
		include('../Connections/dragonmartguide.php');
		 $selectQuery	=	"SELECT ad.*, s.* FROM advertisement ad INNER JOIN settings s ON s.sett_id = ad.Ad_Type
							 WHERE ad.Ad_Type = '$adType' AND ad.Ad_Status != 'delete' AND ad.Ad_Status != 'off'   ";
		$selectData		=   mysqli_query($db,$selectQuery);
		return $selectData;

	}
	
	public function insertAdData($adType){
		include('../Connections/dragonmartguide.php');
		
		//$this->Ad_Type				=	isset($_POST['adtype'])?$_POST['adtype']:'';
		$this->Ad_Type 				= 	$adType;		
	    $this->Ad_Name				=	isset($_POST['adname'])?$_POST['adname']:'';
		$this->Ad_Shopid			=	isset($_POST['adShopName'])?$_POST['adShopName']:'';
		$this->Ad_Shopname			= 	isset($_POST['newShopName'])?$_POST['newShopName']:'';
		$this->Ad_Userid			=	$_SESSION['loginUserid'];
		$this->Ad_Username			=	$_SESSION['MM_Username'];
		$this->Ad_Description		=  isset($_POST['addesc'])?$_POST['addesc']:'';
		$this->Ad_Pagename 			= 	'';
		$adDate 					= explode(' - ', $_POST['daterange']);	
		$startDate = strtr($adDate[0], '/', '-');
		$endDate   = strtr($adDate[1], '/', '-');	
		$this->Ad_Startdate 	= date('Y-m-d H:i:s', strtotime($startDate));
		$this->Ad_Enddate 		= date('Y-m-d H:i:s', strtotime($endDate));
		$this->Ad_Url				=	isset($_POST['adurl'])?$_POST['adurl']:'';
		$this->Ad_Picture			=	isset($_POST['bannerimg'])?$_POST['bannerimg']:'';
		$this->Ad_Createddate 		= 	$_SESSION['now'];
		$this->Ad_Modifieddate 		= 	'0000-00-00 00:00:00';
		$this->Ad_views 			= 	'';
		$this->Ad_Clicks 			= 	'';
		$this->Ad_Status			=	'approval';
		$this->page_name			=	'advertisement.php';
		
				echo $sqlquery 			= "INSERT INTO `advertisement`
														  (
														  `Ad_Type`, 
														  `Ad_Name`,
														  `Ad_Shopid`, 
														  `Ad_Shopname`,
														  `Ad_Userid`,
														  `Ad_Username`,
														  `Ad_Description`,
														  `Ad_Pagename`,
														  `Ad_Startdate`, 
														  `Ad_Enddate`, 
														  `Ad_Picture`,
														  `Ad_Url`,
														  `Ad_Createddate`, 
														  `Ad_Modifieddate`, 
														  `Ad_views`,
														  `Ad_Clicks`,
														  `Ad_Status`)
								VALUES (
										'$this->Ad_Type', 
										'$this->Ad_Name', 
										'$this->Ad_Shopid',
										'$this->Ad_Shopname',
										'$this->Ad_Userid',
										'$this->Ad_Username',
										'$this->Ad_Description',
										'$this->Ad_Pagename',
										'$this->Ad_Startdate', 
										'$this->Ad_Enddate',
										'$this->Ad_Picture',
										'$this->Ad_Url',
										'$this->Ad_Createddate', 
										'$this->Ad_Modifieddate', 
										'$this->Ad_views', 
										'$this->Ad_Clicks', 
										'$this->Ad_Status')";
				mysqli_query($db,$sqlquery);
				$this->last_insert_id	= mysqli_insert_id($db);
				$insertData				= mysql_real_escape_string($sqlquery);
				$this->tableName		= "advertisement";			
					$updateInfoObj = new Updatesinfo();
					$updateInfoObj->processInformation(
												'insert',
												 $this->page_name,
												 $this->tableName,
												 $this->last_insert_id,
												 $_SESSION['loginUserid'],
												 $insertData,
												 $_SESSION['now']
											  );

	}
	
	public function deleteAdData(){ // update status delete
			
			include('../Connections/dragonmartguide.php');
			$this->page_name = 'ad_list';
			$this->tableName	= 'advertisement';
			$modi_time		= $_SESSION['now'];
	    	$sqlquery = "UPDATE `$this->tableName` SET `Ad_Status` = '$this->status' ,`Ad_Modifieddate` = '$modi_time'
					WHERE `Ad_Id` = '$this->delColumnId' ";
			 mysqli_query($db,$sqlquery); 
			
			$updateData	=	 mysql_real_escape_string($sqlquery);	
			$lastUpdatedId	= $this->delColumnId;
		
			$updateInfoObj = new Updatesinfo();
					$updateInfoObj->processInformation(
												'delete',
												 $this->page_name,
												 $this->tableName,
												 $lastUpdatedId,
												 $_SESSION['loginUserid'],
												 $updateData,
												 $_SESSION['now']
											  );
			
	}
	
	public function updateAdData($adType){
		include('../Connections/dragonmartguide.php');
		$this->Ad_Id				=	isset($_POST['adHiddenID'])?$_POST['adHiddenID']:'';
		$this->Ad_Type 				= 	$adType;
		$this->Ad_Name				=	isset($_POST['adname'])?$_POST['adname']:'';
		$this->Ad_Shopid			=	isset($_POST['adShopName'])?$_POST['adShopName']:'';
		$this->Ad_Shopname			= 	isset($_POST['newShopName'])?$_POST['newShopName']:'';
		$this->Ad_Userid			=	$_SESSION['loginUserid'];
		$this->Ad_Username			=	$_SESSION['MM_Username'];
		$this->Ad_Description		=   isset($_POST['addesc'])?$_POST['addesc']:'';
		$adDate 					= 	explode(' - ', $_POST['daterange']);	
		$startDate 					= 	strtr($adDate[0], '/', '-');
		$endDate   					= 	strtr($adDate[1], '/', '-');	
		$this->Ad_Startdate 		= 	date('Y-m-d H:i:s', strtotime($startDate));
		$this->Ad_Enddate 			= 	date('Y-m-d H:i:s', strtotime($endDate));
		$this->Ad_Picture			=	isset($_POST['bannerimg'])?$_POST['bannerimg']:'';
		$this->Ad_Url				=	isset($_POST['adurl'])?$_POST['adurl']:'';
		$this->Ad_Modifieddate 		= 	$_SESSION['now'];
		$this->tableName			= 	'advertisement';
		$this->page_name			=	'advertisement.php';
		
		$sqlquery 					= 	"UPDATE `advertisement` SET
										`Ad_Type` 						= '$this->Ad_Type', 
										`Ad_Name` 						= '$this->Ad_Name',
										`Ad_Shopid`						= '$this->Ad_Shopid',
									    `Ad_Shopname`					= '$this->Ad_Shopname',
										`Ad_Userid`						= '$this->Ad_Userid',	
										`Ad_Username`					= '$this->Ad_Username',	
										`Ad_Description` 				= '$this->Ad_Description',
										`Ad_Startdate` 					= '$this->Ad_Startdate',
										`Ad_Enddate` 					= '$this->Ad_Enddate',
										`Ad_Picture`					= '$this->Ad_Picture',
										`Ad_Url`						= '$this->Ad_Url',
										`Ad_Modifieddate` 				= '".$_SESSION['now']."'
										WHERE `advertisement`.`Ad_Id`	= '$this->Ad_Id'";
		
		mysqli_query($db, $sqlquery) or die(mysqli_error($db));
		$updateData	=	 mysql_real_escape_string($sqlquery);
		$lastUpdatedId	= $this->Ad_Id;

		$updateInfoObj = new Updatesinfo();
					$updateInfoObj->processInformation(
												'update',
												 $this->page_name,
												 $this->tableName,
												 $lastUpdatedId,
												 $_SESSION['loginUserid'],
												 $updateData,
												 $_SESSION['now']
											  );
		
	}
}


?>
<?php
class Enquiry{
	public $tableName;
	public $fieldName;
	public $value;
	public $cond;
	public function deleteEnquiry(){
		include('../Connections/dragonmartguide.php');
		$sqlquery = "UPDATE `$this->tableName` SET $this->fieldName = '$this->value' WHERE $this->cond";
		mysqli_query($db,$sqlquery);
		$updateData	=	 mysql_real_escape_string($sqlquery);
		$updateInfoObj = new Updatesinfo();
					$updateInfoObj->processInformation(
												'update',
												 $this->page_name,
												 $this->tableName,
												 $this->em_id,
												 $_SESSION['loginUserid'],
												 $updateData,
												 $_SESSION['now']
											  );
	}
}
?>
	
<?php
class Onlineusr{ // login details of each user
	
	public $on_id;
	public $on_userId;
	public $on_username;
	public $on_usertype;
	public $on_pagename;
	public $on_lastactive;
	
	public function userLoginData($on_userId,$on_username,$on_usertype,$on_pagename,$on_lastactive){
		include('../Connections/dragonmartguide.php');
			$sqlquery 			= "INSERT INTO `online_user`
														  (
														  `on_userid`,
														  `on_username`,
														  `on_usertype`,
														  `on_pagename`,
														  `on_lastactive`
														 )
													VALUES (
															'$on_userId',
															'$on_username',
															'$on_usertype',
															'$on_pagename',
															'$on_lastactive')";
			mysqli_query($db,$sqlquery);
	
	}
	
}
?>
<?php
class Updatesinfo{  
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
		
		include('../Connections/dragonmartguide.php');
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


?>
			

		

