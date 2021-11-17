 <?php

die('Testing');
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}
?>
<?php

/* ---------- common functions --------------------*/
//$timezone = $_SESSION['comData']['timesone'];
if ( function_exists( 'date_default_timezone_set' ) )date_default_timezone_set( 'Asia/Dubai' );
$national_date_time_24 = date( 'Y-m-d H:i:s' );
$_SESSION[ 'now' ] = $national_date_time_24;
/* ---------- common functions --------------------*/

include('Connections/dragonmartguide.php');
//include('Connections/frontend_function.php');
?>	
<?php
$Mquery = "SELECT pt.prodt_id, pt.prodt_name, pt.prodt_picture, pt.prodt_company_id, sd.shop_name FROM product_details AS pt INNER JOIN shop_details AS sd on pt.prodt_company_id = sd.shop_id where pt.prodt_status='on' ORDER BY pt.prodt_cre DESC LIMIT 15 ";
$mTrend = mysqli_query($db, $Mquery);

$Fquery = "SELECT pt.prodt_id, pt.prodt_name, pt.prodt_picture, pt.prodt_company_id, sd.shop_name FROM shop_details AS sd INNER JOIN product_details AS pt on sd.shop_id = pt.prodt_company_id where sd.shop_status = 'on' AND pt.prodt_status='on' AND sd.shop_priv_start < '$national_date_time_24' AND sd.shop_priv_end > '$national_date_time_24' ORDER BY RAND() AND pt.prodt_cre DESC LIMIT 15";
$featured = mysqli_query($db, $Fquery);

$getOfferData	=	mysqli_query($db, "SELECT * FROM offer_dmg off INNER JOIN shop_details sh ON sh.shop_id = off.offer_shop_id WHERE off.offer_status = 'on' AND ('$national_date_time_24' BETWEEN off.offer_start AND off.offer_end)");
	

?>
<?php include 'slider/embed.php'; ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dragon Mart Guide - Dragon mart dubai | china market dubai |china mall in dubai  |China Town in Dubai</title>

<meta name="description"  content="Dubai Dragon Mart is the largest China Market in Dubai. Cheap China products, best quality, largest collection, latest products, whole sale and retail sales." />
<meta name="keywords"  content="ibis dragon mart dubai, shopping in dragon mart, china bazaar, whole sale china market, banks in dragon mart, list of products available in dragon mart, stores in dragon mart" />
<meta name="google-site-verification" content="xSen_USZvabGBPVXXlBsU1Yqvt0QUeKfiYpWKWGrqXg" />

<meta name="msvalidate.01" content="A7DEE5B67339CA0FEE6E02A395D21BB7" />
 
<?php RevSliderEmbedder::headIncludes(); ?>
	<link rel="canonical" href="http://dragonmartguide.com/" />
	<meta property="og:title" content="Dragon Mart Guide - Dubai - China Mall" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://dragonmartguide.com/" />
	<meta property="og:image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
	<meta property="og:site_name" content="Dragon Mart Guide" />
	<meta property="og:description" content="Dubai Dragon Mart is the largest China Market in Dubai. Cheap China products, best quality, largest collection, latest products, whole sale and retail sales." />
	
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="Dragon Mart Guide - Dubai - China Mall" />
	<meta name="twitter:description" content="Dubai Dragon Mart is the largest China Market in Dubai. Cheap China products, best quality, largest collection, latest products, whole sale and retail sales." />
	<meta name="twitter:image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
	<meta itemprop="image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
 
  
<link rel="icon" type="image/png" href="images/favicon.png" />
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />-->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" >
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.css" />
<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />-->
<link type="text/css" rel="stylesheet" href="css/mystyle.css" >
<link rel="stylesheet" href="css/font-awesome.min.css">

<!--<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>-->
<!--<script type="text/javascript" src="js/bootstrap.js" ></script>-->
<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" ></script>-->

<!-- Insert to your webpage before the </head> -->
<!--<script src="carouselengine/jquery.js"></script>-->
<script src="carouselengine/amazingcarousel.js"></script>
<link rel="stylesheet" type="text/css" href="carouselengine/initcarousel-1.css">
<script src="carouselengine/initcarousel-1.js"></script>

<!--<script src="carouselengine/amazingcarousel.js"></script>-->
<link rel="stylesheet" type="text/css" href="carouselengine2/initcarousel-2.css">
<script src="carouselengine2/initcarousel-2.js"></script>
<!-- End of head section HTML codes -->

<script type="text/javascript" src="js/banner.js"></script>
<script type="text/javascript">
jQuery(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})
</script>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "website",
  "url": "http://dragonmartguide.com",
  "logo": "http://dragonmartguide.com/images/gs-icon.png"
}
</script>

</head>

<body>
<?php
include('header.php');
?>
<!--Banner and ads-->
<div class="container" id="bannerID">
  <div class="row">
    <div class="col-md-12 Banner1">
     <?php RevSliderEmbedder::putRevSlider('reveal-add-on3'); ?>
    </div>
   <!-- <div class="col-md-3 Banner1Ad"> <img src="images/advertisements/Blue-Bird-Nursery_Roll-Up-Media_95x240-cm_Panel-4.jpg" alt="advvv" width="100%" style="max-height:333px; display: block !important;" /></div> -->
  </div>
</div>
<!--Banner and ads--> 

<!--Market trends-->
<div class="container">
  <div class="row Rhead">
    <div class="col-md-12">
      <h3> Market Trends </h3>
    </div>
  </div>
  <div class="row"> 
    <!-- Market Trends start -->
    <div id="amazingcarousel-container-1" style="padding:0px; margin-bottom:50px;">
    <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:1140px;margin:0px auto 0px;">
        <div class="amazingcarousel-list-container">
            <ul class="amazingcarousel-list">
               
               <?php
				while($mTrow = mysqli_fetch_array($mTrend)){
					
				
				?>
               
                <li class="amazingcarousel-item">
                    <div class="amazingcarousel-item-container">
<div class="amazingcarousel-image"><a href="productdetails.php?pt=<?php echo $mTrow['prodt_id']."&sh=".$mTrow['prodt_company_id']; ?>" title="<?php echo $mTrow['shop_name']; ?>"  target="_blank"><img src="<?php echo $mTrow['prodt_picture']; ?>"  alt="<?php echo $mTrow['prodt_name']; ?>" height="240px" /></a></div>
<div class="amazingcarousel-title"><?php echo $mTrow['prodt_name']; ?></div>                    </div>
                </li>
                <?php
                }
				?>
            </ul>
            <div class="amazingcarousel-prev"></div>
            <div class="amazingcarousel-next"></div>
        </div>
        <!--<div class="amazingcarousel-nav"></div>
        <div class="amazingcarousel-engine"><a href="http://amazingcarousel.com">jQuery Image Scroller</a></div>-->
    </div>
</div>
    <!-- Market Trends end --> 
  </div>
</div>
<div class="container rrback">
 <div class="container">
  <div class="row Rhead">
    <div class="col-md-12">
      <h3> Featured Listing </h3>
    </div>
  </div>
  <div class="row"> 
    <!-- feature listing start -->
<div id="amazingcarousel-container-2" style="padding:0px; margin-bottom:50px;">
    <div id="amazingcarousel-2" style="display:none;position:relative;width:100%;max-width:1140px;margin:0px auto 0px;">
        <div class="amazingcarousel-list-container">
            <ul class="amazingcarousel-list">
               <?php
				
				while($Frow = mysqli_fetch_array($featured)){
				?>

                <li class="amazingcarousel-item">
                    <div class="amazingcarousel-item-container">
<div class="amazingcarousel-image"><a href="productdetails.php?pt=<?php echo $Frow['prodt_id']."&sh=".$Frow['prodt_company_id']; ?>" title="<?php echo $Frow['shop_name']; ?>" target="_blank"><img src="<?php echo $Frow['prodt_picture']; ?>"  alt="<?php echo $Frow['prodt_name']; ?>" height="220px" /></a></div>
<div class="amazingcarousel-title"><?php echo $Frow['prodt_name']; ?></div>
<div class="amazingcarousel-title RRFuture"><?php echo $Frow['shop_name']; ?></div>                    </div>
                </li>
                <?php
				}
				?>

            </ul>
            <div class="amazingcarousel-prev"></div>
            <div class="amazingcarousel-next"></div>
        </div>
        <!--<div class="amazingcarousel-nav"></div>
        <div class="amazingcarousel-engine"><a href="http://amazingcarousel.com">jQuery Carousel</a></div>-->
    </div>
</div>
<!-- feature listing end -->
  </div>
  </div>
</div>
<!--Market trends--> 

<!--Featured Listing-->
<div class="container" style="margin-top:0px;">
  <div class="row Rhead">
    <div class="col-md-12">
      <h3> Special Offers </h3>
    </div>
  </div>
  
	<div class="row">
	  <?php 
		if(mysqli_num_rows($getOfferData) > 0){
			while($getOffer = mysqli_fetch_array($getOfferData)){
		?>
		  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 RosubMain">
		  <div class="row Roffer">
			<div class="col-md-7 col-sm-7 col-xs-7" style="padding-right:0px;"> <span class="rOfRat">
			<?php	
						$offerType = '';
						if($getOffer['offer_type'] == 'buy-get'){
							$offerType = 'Buy Get ';
						}elseif($getOffer['offer_type'] == 'discount'){
							$offerType = 'Discount ' ;
						}elseif($getOffer['offer_type'] == 'flat'){
							$offerType = 'Flat Sale';
						}elseif($getOffer['offer_type'] == 'cashback'){
							$offerType = 'Cashback';
						}elseif($getOffer['offer_type'] == 'scratch-win'){
							$offerType = 'scratch & Win ';
						}elseif($getOffer['offer_type'] == 'exchange'){
							$offerType = 'Exchange ';
						}elseif($getOffer['offer_type'] == 'mall-offer'){
							$offerType = 'Mall Offer';
						}
						
			echo $offerType;	
			?>
			</span> </div>
			<div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
			  <button class="btn-primary">Get Now</button>
			</div>
		  </div>
		  <div class="row Rodata">
			<div class="col-md-12 col-sm-12">
			  <div class="row Proffer">
			  
				<!--<div class="col-md-6 col-sm-6 col-xs-6 Rorate"><span>50%</span> </div>-->
            <div class="col-md-3 col-sm-3 col-xs-3 pull-right RoLocation"><span><?php if($getOffer['shop_mall'] == 'Dragon Mart 1'){echo "DM 1";}else{ echo "DM 2";}; ?></span> </div>
         	  </div>
			  <div class="col-md-12" style="height:185px; overflow:hidden;"> 
			  <img class="Roimage" alt="Bootstrap Image Preview" src=<?php echo $getOffer['offer_picture']; ?> /> </div>
			  <h4 class="rrcpny"><?php echo $getOffer['shop_name'];?></h4>
			  <p class="rrDetls"> <?php
				$offerDeta =  $getOffer['offer_details'];
				  echo $offerDeta = substr($offerDeta,0,100).'...';
				 ?></p>
			</div>
		  </div>
		</div>
   
   <?php }
	}
	?>
   
		   </div>
	
  
</div>


<!--Featured Listing end-->


<!--Featured Listing-->
<!--<div class="container" style="margin-top:0px;">
  <div class="row Rhead">
    <div class="col-md-12">
      <h3> Special Offers </h3>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 RosubMain">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7" style="padding-right:0px;"> <span class="rOfRat">Discount</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"><span>50%</span> </div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 1</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/m580_of1_44_vp.jpg" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 RosubMain">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7"><span class="rOfRat">Exchange</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"> </div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 1</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/httpeu.chv.meimagesfg2ra_ru.jpg" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 RosubMain">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7"><span class="rOfRat">Flat Sale</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"><span>50%</span> </div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 2</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/httpeu.chv.meimagesfg_mgizu.jpg" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 RosubMain">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7"><span class="rOfRat">Cash Back</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"></div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 1</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/httpeu.chv.meimagesfg_mgizu.jpg" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 RosubMain mobile-hide">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7"><span class="rOfRat">Buy 3 Get 1</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"><span>50%</span> </div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 1</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/httpeu.chv.meimagesa7rsojua.jpg" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 RosubMain mobile-hide">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7"><span class="rOfRat">Scratch Win</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"><span>50%</span> </div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 1</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/httpeu.chv.meimages6j5nxjqr.jpg" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 RosubMain mobile-hide">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7"><span class="rmony">AED <span style="text-decoration:line-through;">1000</span></span> <span class="rOfRat">800</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"><span>50%</span> </div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 1</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/easels_aw109_sample_10.png" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 RosubMain mobile-hide">
      <div class="row Roffer">
        <div class="col-md-7 col-sm-7 col-xs-7"><span class="rmony">AED <span style="text-decoration:line-through;">1000</span></span> <span class="rOfRat">800</span> </div>
        <div class="col-md-5 col-sm-5 col-xs-5 rObtn" >
          <button class="btn-primary">Get Now</button>
        </div>
      </div>
      <div class="row Rodata">
        <div class="col-md-12 col-sm-12">
          <div class="row Proffer">
            <div class="col-md-6 col-sm-6 col-xs-6 Rorate"><span>50%</span> </div>
            <div class="col-md-6 col-sm-6 col-xs-6 RoLocation"><span>DM 1</span> </div>
          </div>
          <div class="col-md-12" style="height:185px; overflow:hidden;"> <img class="Roimage" alt="Bootstrap Image Preview" src="images/products/dsc01984.jpg" /> </div>
          <h4 class="rrcpny">Company Name here</h4>
          <p class="rrDetls"> Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor ... </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Featured Listing--> 

<!--Event Listing-->
<?php
	if($userid === 'rajaram'){
	?>
<div class="container" style="margin-top:40px;">
  <div class="row Rhead">
    <div class="col-md-12">
      <h3> Events </h3>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 bootstrap snippets">
	<!-- product -->
	<div class="product-content product-wrap clearfix">
		<div class="row">
				<div class="col-md-5 col-sm-12 col-xs-12" style="padding-top:12px;">
					<div class="product-image"> 
						<img src="images/products/dsc01984.jpg" alt="194x228" class="img-responsive"> 
						<span class="tag2 hot">
							LIVE
						</span> 
					</div>
				</div>
				<div class="col-md-7 col-sm-12 col-xs-12">
				<div class="product-deatil">
						<h5 class="name">
							<a href="#">
								Event Name <span>Comady, music, Magic ...</span>
							</a>
						</h5>
						<p class="price-container">
							<span>Mr. Farook</span>
						</p>
						<span class="tag1"></span> 
				</div>
				<div class="description">
					<p>Dubai is a city and emirate in the United Arab Emirates known for luxury shopping, ultramodern architecture and a lively nightlife scene.</p>
                    
				</div>
				<div class="product-info smart-form">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4"> 
							<a href="javascript:void(0);" class="btn btn-success">Like <i class="fa fa-thumbs-o-up"></i></a>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8" style="text-align:right;">
                        <time>TUE, APR 11 8.00 PM</time>
							<!--<div class="rating">
                            
								<label for="stars-rating-5"><i class="fa fa-star"></i></label>
								<label for="stars-rating-4"><i class="fa fa-star"></i></label>
								<label for="stars-rating-3"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-2"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-1"><i class="fa fa-star text-primary"></i></label>
							</div>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product -->
</div>
<div class="col-xs-12 col-sm-6 col-md-6 bootstrap snippets">
	<!-- product -->
	<div class="product-content product-wrap clearfix">
		<div class="row">
				<div class="col-md-5 col-sm-12 col-xs-12" style="padding-top:12px;">
					<div class="product-image"> 
						<img src="images/products/cherry black tea-240x300.JPG" alt="194x228" class="img-responsive"> 
						<span class="tag2 hot">
							LIVE
						</span> 
					</div>
				</div>
				<div class="col-md-7 col-sm-12 col-xs-12">
				<div class="product-deatil">
						<h5 class="name">
							<a href="#">
								Event Name <span>Comady, music, Magic ...</span>
							</a>
						</h5>
						<p class="price-container">
							<span>Mr. Farook</span>
						</p>
						<span class="tag1"></span> 
				</div>
				<div class="description">
					<p>Dubai is a city and emirate in the United Arab Emirates known for luxury shopping, ultramodern architecture and a lively nightlife scene. </p>
                    
				</div>
				<div class="product-info smart-form">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4"> 
							<a href="javascript:void(0);" class="btn btn-success">Like <i class="fa fa-thumbs-o-up"></i></a>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8" style="text-align:right;">
                        <time>TUE, APR 11 8.00 PM</time>
							<!--<div class="rating">
                            
								<label for="stars-rating-5"><i class="fa fa-star"></i></label>
								<label for="stars-rating-4"><i class="fa fa-star"></i></label>
								<label for="stars-rating-3"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-2"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-1"><i class="fa fa-star text-primary"></i></label>
							</div>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product -->
</div>
<div class="col-xs-12 col-sm-6 col-md-6 bootstrap snippets">
	<!-- product -->
	<div class="product-content product-wrap clearfix">
		<div class="row">
				<div class="col-md-5 col-sm-12 col-xs-12" style="padding-top:12px;">
					<div class="product-image"> 
						<img src="images/products/g200_aj_p.jpg" alt="194x228" class="img-responsive"> 
						<span class="tag2 hot">
							NEXT
						</span> 
					</div>
				</div>
				<div class="col-md-7 col-sm-12 col-xs-12">
				<div class="product-deatil">
						<h5 class="name">
							<a href="#">
								Event Name <span>Comady, music, Magic ...</span>
							</a>
						</h5>
						<p class="price-container">
							<span>Mr. Farook</span>
						</p>
						<span class="tag1"></span> 
				</div>
				<div class="description">
					<p>Dubai is a city and emirate in the United Arab Emirates known for luxury shopping, ultramodern architecture and a lively nightlife scene. </p>
                    
				</div>
				<div class="product-info smart-form">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4"> 
							<a href="javascript:void(0);" class="btn btn-success">Like <i class="fa fa-thumbs-o-up"></i></a>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8" style="text-align:right;">
                        <time>TUE, APR 11 8.00 PM</time>
							<!--<div class="rating">
								<label for="stars-rating-5"><i class="fa fa-star"></i></label>
								<label for="stars-rating-4"><i class="fa fa-star"></i></label>
								<label for="stars-rating-3"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-2"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-1"><i class="fa fa-star text-primary"></i></label>
							</div>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product -->
</div>
<div class="col-xs-12 col-sm-6 col-md-6 bootstrap snippets">
	<!-- product -->
	<div class="product-content product-wrap clearfix">
		<div class="row">
				<div class="col-md-5 col-sm-12 col-xs-12" style="padding-top:12px;">
					<div class="product-image"> 
						<img src="images/products/764302400745.png" alt="194x228" class="img-responsive"> 
						<span class="tag2 hot">
							NEXT
						</span> 
					</div>
				</div>
				<div class="col-md-7 col-sm-12 col-xs-12">
				<div class="product-deatil">
						<h5 class="name">
							<a href="#">
								Event Name <span>Comady, music, Magic ...</span>
							</a>
						</h5>
						<p class="price-container">
							<span>Mr. Farook 4</span>
						</p>
						<span class="tag1"></span> 
				</div>
				<div class="description">
					<p>Dubai is a city and emirate in the United Arab Emirates known for luxury shopping, ultramodern architecture and a lively nightlife scene. </p>
                    
				</div>
				<div class="product-info smart-form">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4"> 
							<a href="javascript:void(0);" class="btn btn-success">Like <i class="fa fa-thumbs-o-up"></i></a>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8" style="text-align:right !important;">
                        <time>TUE, APR 11 8.00 PM</time>
							<div class="rating">
								<!--<label for="stars-rating-5"><i class="fa fa-star"></i></label>
								<label for="stars-rating-4"><i class="fa fa-star"></i></label>
								<label for="stars-rating-3"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-2"><i class="fa fa-star text-primary"></i></label>
								<label for="stars-rating-1"><i class="fa fa-star text-primary"></i></label>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product -->
</div>
</div>
<?php
	}
	?>
<!--Event Listing--> 

<!--Floting menus-->
<!--<nav class="Menu_container"><a href="tel:+971501481234" class="buttons rit RbLst" tooltip="Pickup Service" style="padding:4px;"><i class="fa fa-truck fa-2x"></i></a> <a href="tel:+971501481234" class="buttons rit RbLst" tooltip="Taxi Service" style="padding:4px;"><i class="fa fa-taxi fa-2x"></i></a> <a class="buttons rit" tooltip="Taxi" href="#" style="padding:12px; color:#333;"><i class="fa fa-taxi fa-2x"></i></a> </nav>-->
<!--Floting menus--> 

<!--Floting menus Left-->
<!--<nav class="Menu_containerL"  > <a href="tel:+971501481234" class="buttons lft RbLst" tooltip="Office Service" style="padding-left:8px; padding-top:7px;"><i class="fa fa-question-circle fa-2x"></i></a> <a href="tel:+971501481234" class="buttons lft RbLst" tooltip="Police" style="padding-left:10px; padding-top:6px;"><i class="fa fa-user fa-2x"></i></a> <a href="tel:+971501481234" class="buttons lft RbLst" tooltip="Wheelchair" style="padding:7px;"><i class="fa fa-wheelchair fa-2x"></i></a> <a href="tel:+971501481234" class="buttons lft RbLst" tooltip="Medical" style="padding-top:4px; padding-left:5px;"><i class="fa fa-medkit fa-2x"></i></a> <a href="tel:+971501481234" class="buttons lft RbLst" tooltip="ATM" style="padding:3px;"><i class="fa fa-credit-card-alt fa-2x"></i></a> <a class="buttons lft" tooltip="At your service" href="#" style="padding:7.5px; color:#333;"><i class="fa fa-life-ring fa-3x"></i></a> </nav>-->
<!--Floting menus Left--> 

<!--footer-->
<?php include('footer.php') ?>

<!--header-->
 
 <script>
	 //for advertisement product image link
	$('.adImageClick').click(function(){
		var imageID =  this.id ;	
				$.ajax({
					url:"ajax_ad.php",
					data:{
							"imageID"		:imageID
						},
					async:false,
					method: 'POST',
					success: function(data)
						{  
							window.open(data, '_blank');
						}	
				});
	});
 </script>
</body>
</html>