<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}
?>

<?php
include( '../Connections/dragonmartguide.php' );
include( '../Connections/side_bar_functionsL.php' );

$objData					=	new Sidebar();
$offerCount					=	$objData->getShopOfferCount();
$activeCount				=	$objData->getActiveProducts();
$totalproducts				=	$objData->getTotalProducts();
$inActiveCount				=	$objData->getInActiveProducts();
$deletedProducts			=	$objData->getDeletedProducts();
$getLiveAd					=	$objData->getLiveAd();
$featureList				=	$objData->featureList();
$getLiveOffer				=	$objData->getLiveOffer();	
$getContactNumCount 		=   $objData->getContactNumCount();
$getProductViewCount		=	$objData->getProductViewCount();
$getPageImpressionCount		=	$objData->getPageImpressionCount();
?>					
				<div class="C-logo-prnt">
					<a style="text-decoration: none;" href="shop_home.php"><div class="C-logo">Dragon&nbsp;<span>&nbsp;Mart&nbsp;</span>&nbsp;Guide </div></a>
					We serve you better
				</div>
				
				<hr class="C-hr-1">
				<?php if(basename($_SERVER['PHP_SELF']) != "media_uploads.php"){ ?>
					<div class="C-infoC"><?php include('model_media.php'); ?></div> <br/><br/><br/>
				<?php } ?>
				
				
				<div>
				
					<ul class="C-menu-list">
						<li class="C-menu-listMin">Views & Impressions</li>
						<li>Page impressions (<?php echo $getPageImpressionCount;?>) over all</li>
						<li>Product views (<?php echo $getProductViewCount;?>) over all</li>
						<li>Contact number views (<?php echo $getContactNumCount; ?>) over all</li>
						<li>Live Offers (<?php echo $getLiveOffer; ?>)</li>
						<li>Live feature listing (<?php echo $featureList; ?>)</li>
						<li>Live Advertisement (<?php echo $getLiveAd; ?>)</li>
					</ul>


					<ul class="C-menu-list">
						<li class="C-menu-listMin">Company</li>
						<li>This company offer (<?php echo $offerCount;?>)</li>
						<li>Total products (<?php echo $totalproducts;?>)</li>
						<li>Active products (<?php echo $activeCount;?>)</li>
						<li>Inactive products (<?php echo $inActiveCount;?>)</li>
						<li>Deleted products (<?php echo $deletedProducts;?>)</li>
					</ul>
				</div>