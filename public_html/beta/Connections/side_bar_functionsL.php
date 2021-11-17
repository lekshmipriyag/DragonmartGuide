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
class Sidebar{
	
	public function getShopOfferCount(){ //Total Offer Count
		include('../Connections/dragonmartguide.php');
		$selectData		= mysqli_query($db,"SELECT *  FROM offer_dmg WHERE offer_shop_id != ''");
		$offerCount		= mysqli_num_rows($selectData);
		return $offerCount;
	}
	
	public function getTotalProducts(){ //Total Offer Count
		include('../Connections/dragonmartguide.php');
		$totalProducts			= mysqli_query($db,"SELECT *  FROM product_details WHERE prodt_status != 'delete'");
		$totalCount			= mysqli_num_rows($totalProducts);
		return $totalCount;
	}
	
	public function getActiveProducts(){ //Total active product Count
		include('../Connections/dragonmartguide.php');
		$activeProducts			= mysqli_query($db,"SELECT *  FROM product_details WHERE prodt_status = 'on'");
		$activeCount			= mysqli_num_rows($activeProducts);
		return $activeCount;
	}
	
	public function getInActiveProducts(){ //Total inactive product Count
		include('../Connections/dragonmartguide.php');
		$inActiveProducts		= mysqli_query($db,"SELECT *  FROM product_details WHERE prodt_status != 'on' AND prodt_status != 'delete'");
		$inActiveCount				= mysqli_num_rows($inActiveProducts);
		return $inActiveCount;
	}
	
	public function getDeletedProducts(){ //Total deleted product count
		include('../Connections/dragonmartguide.php');
		$deleteProduct		= mysqli_query($db,"SELECT *  FROM product_details WHERE prodt_status = 'delete'");
		$deletedProduct		= mysqli_num_rows($deleteProduct);
		return $deletedProduct;
	}
	
	public function getLiveAd(){ // live Advertisement
		include('../Connections/dragonmartguide.php');
		$currentDate	=	date('Y-m-d',strtotime($_SESSION['now']));
		$selectAd = mysqli_query($db,"SELECT *
								  FROM `advertisement`
								  WHERE ('$currentDate' BETWEEN DATE_FORMAT(Ad_Startdate, '%Y-%m-%d')  AND DATE_FORMAT(Ad_Enddate, '%Y-%m-%d'))");
		$liveAd	=	mysqli_num_rows($selectAd);
		return $liveAd;

	} 
	
	public function featureList(){
		include('../Connections/dragonmartguide.php');
		$currentDate	=	date('Y-m-d',strtotime($_SESSION['now']));
		
		$selectList 	= mysqli_query($db,"SELECT *
								  FROM `shop_details`
								  WHERE ( DATE_FORMAT(shop_priv_end, '%Y-%m-%d') >= '$currentDate') AND shop_priv_end != ''");
		$featureList	=	mysqli_num_rows($selectList); 
		return $featureList;
	}
	
	public function getLiveOffer(){ // live Advertisement
		include('../Connections/dragonmartguide.php');
		$currentDate	=	date('Y-m-d',strtotime($_SESSION['now']));
		$selectOffer = mysqli_query($db,"SELECT *
								  	  FROM `offer_dmg`
								   	  WHERE ( DATE_FORMAT(offer_end, '%Y-%m-%d') >= '$currentDate') AND offer_end != ''");
		$liveOffer	=	mysqli_num_rows($selectOffer);
		return $liveOffer;
	} 
	
	public function getContactNumCount(){
		include('../Connections/dragonmartguide.php');
		$contactData		= mysqli_query($db,"SELECT sum(shop_feature_list) AS contactCount  FROM shop_details WHERE shop_status != 'delete'");
		$resultData	=	mysqli_fetch_array($contactData);
		return $resultData['contactCount'];	
	}
	
	public function getProductViewCount(){
		include('../Connections/dragonmartguide.php');
		$productData		= mysqli_query($db,"SELECT sum(prodt_views_count) AS prodtViewCount  FROM product_details WHERE prodt_status != 'delete'");
		$resultData	=	mysqli_fetch_array($productData);
		return $resultData['prodtViewCount'];	
	}
		public function getPageImpressionCount(){
			include('../Connections/dragonmartguide.php');
			$impressionCount	=	mysqli_query($db,"SELECT sum(p.prodt_views_count) AS prodtViewCount,sum(s.shop_feature_list) AS contactCount FROM shop_details s INNER JOIN product_details p on p.prodt_company_id = s.shop_id WHERE s.shop_status !='delete' AND p.prodt_status != 'delete'");
			
			$resultCount =	mysqli_fetch_array($impressionCount);
			return $resultCount['contactCount']+$resultCount['prodtViewCount'];
			
		}
}
?>