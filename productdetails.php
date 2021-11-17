<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}

if(!isset($_GET['sh']) || !isset($_GET['pt'])){
		header("Location: index.php"); /* Redirect browser */
		exit();
	}
	
?>
<!-- company containtr start -->
<?php 
if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}	
 	
include( 'Connections/dragonmartguide.php' );
include( 'Connections/frontend_function.php' );
	
	$shopID		=	isset($_GET['sh'])?$_GET['sh']:'';
	$productID	=	isset($_GET['pt'])?$_GET['pt']:'';

	$objProduct = new Product();
	$objProduct->shopid 		= 	$shopID;
	$objProduct->productID		= 	$productID;
	$productResult				=	$objProduct->getProductDetails();
	$fetchProductData			=	mysqli_fetch_array($productResult);
	$objProduct->advType		=	'productdetails_slide';
	$getAdData					=   $objProduct->getAdvertisement();
	

	//if(!isset($_SESSION['viewcount'])){$_SESSION['viewcount'] = 1;}
	//if(in_array($productID,$_SESSION['viewcount'])){
	//	    array_push($_SESSION['viewcount'],$productID);
			$objProduct->tableName		= 'product_details';
			$objProduct->updateproductViewsCount();
	//}
	
	
	if(isset($_POST['emailname']) &&  $session_tokens == $tokens){
		if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){ 
			$msg="<span style='color:red'>The Captcha code does not match!</span>";

		}else{// Captcha verification is Correct. Final Code Execute here!	
			$msg=" ";
			$objEmail 					= 	new Contact();
			$clientIpAddr				=	$objEmail->get_client_ip();
			$objEmail->em_shopid 		= 	$shopID	; //dummy value of shop id ;
			$objEmail->em_prodid		=	$productID;
		    $objEmail->em_flag 			=	'review';
			$objEmail->page_name		=	'productdetails.php';
			$objEmail->em_ipaddress 	=   $clientIpAddr;
			$objEmail->sendEmail();
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Success! </strong>Your request submitted successfully.</div>";
			}
	}
	$selectData		=	"SELECT p.*,s.* FROM product_details p INNER JOIN shop_details s on s.shop_id = p.prodt_company_id  WHERE p.prodt_id = '$productID' AND p.prodt_company_id = '$shopID' AND p.prodt_status = 'on' ORDER BY p.prodt_cre ";
	$fetchData		=	mysqli_query($db,$selectData);
	$fetchResult	=	mysqli_fetch_array($fetchData);
	$objProduct->shopid 	= $fetchResult['shop_id'];;
	$offerdata				= $objProduct->getProductOfferDetails();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dragon Mart - <?php echo $fetchResult['prodt_name'];?> </title>
	
<meta name="description" content="<?php echo isset($fetchResult['prodt_description'])?preg_replace( "/\r|\n/", " ", strip_tags($fetchResult['prodt_description'])):'';?>" />
<meta name="keywords" content="<?php echo isset($fetchResult['shop_keywords'])?preg_replace('/&#44;/', ', ', strip_tags($fetchResult['shop_keywords'])):'';?>" />
<meta name="author" content="WEBAPPi">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="1 days">
<meta name="Subject" content="Guide">
<meta name="Language" content="EN">

<meta name="google-site-verification" content="xSen_USZvabGBPVXXlBsU1Yqvt0QUeKfiYpWKWGrqXg" />

<meta name="msvalidate.01" content="A7DEE5B67339CA0FEE6E02A395D21BB7" />
 

	<link rel="canonical" href="http://dragonmartguide.com/" />
	<meta property="og:title" content="Dragon Mart - <?php echo $fetchResult['shop_name'];?> " />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://dragonmartguide.com/" />
	<meta property="og:image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
	<meta property="og:site_name" content="<?php echo $fetchResult['prodt_name'];?>" />
	<meta property="og:description" content="<?php echo isset($fetchResult['prodt_description'])?preg_replace( "/\r|\n/", "", strip_tags($fetchResult['prodt_description'])):'';?>" />
	
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="Dragon Mart - <?php echo $fetchResult['shop_name'];?> " />
	<meta name="twitter:description" content="<?php echo isset($fetchResult['prodt_description'])?preg_replace( "/\r|\n/", "", strip_tags($fetchResult['prodt_description'])):'';?>" />
	<meta name="twitter:image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
	<meta itemprop="image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />


<!-- Dragon mart, Dubai malls, China mall -->
<link rel="icon" type="image/png" href="images/favicon.png">
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />-->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" >
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.css" />
<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />-->
<link type="text/css" rel="stylesheet" href="css/mystyle.css" >
<link type="text/css" rel="stylesheet" href="css/captchastyle.css" >
<link rel="stylesheet" href="css/font-awesome.min.css">
<!--<link href="gridder-master/dist/css/jquery.gridder.min.css" rel="stylesheet">-->

<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
<!--<script type="text/javascript" src="js/bootstrap.js" ></script>-->
<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" ></script>-->

<!-- Insert to your webpage before the </head> -->
<script src="carouselengine/jquery.js"></script>
<script src="carouselengine/amazingcarousel.js"></script>
<link rel="stylesheet" type="text/css" href="carouselengine/initcarousel-1.css">
<script src="carouselengine/initcarousel-1.js"></script>

<!--<script src="carouselengine/amazingcarousel.js"></script>-->
<link rel="stylesheet" type="text/css" href="carouselengine3/initcarousel-3.css">
<script src="carouselengine3/initcarousel-3.js"></script>
<!-- End of head section HTML codes -->
<!--<script type="text/javascript" src="js/productdetailspage.js" ></script>-->
<script type="text/javascript" src="js/banner.js"></script>
<script type='text/javascript'>
	function refreshCaptcha(){
		var img = document.images['captchaimg'];
		img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	}
</script>
<script type="text/javascript">
   $(document).ready(function(){
            //-- Click on detail
            $("ul.menu-items > li").on("click",function(){
                $("ul.menu-items > li").removeClass("active");
                $(this).addClass("active");
            })

            $(".attr,.attr2").on("click",function(){
                var clase = $(this).attr("class");

                $("." + clase).removeClass("active");
                $(this).addClass("active");
            })

            //-- Click on QUANTITY
            $(".btn-minus").on("click",function(){
                var now = $(".section > div > input").val();
                if ($.isNumeric(now)){
                    if (parseInt(now) -1 > 0){ now--;}
                    $(".section > div > input").val(now);
                }else{
                    $(".section > div > input").val("1");
                }
            })            
            $(".btn-plus").on("click",function(){
                var now = $(".section > div > input").val();
                if ($.isNumeric(now)){
                    $(".section > div > input").val(parseInt(now)+1);
                }else{
                    $(".section > div > input").val("1");
                }
            })                        
        })
		
		
		
		
		
		
		
		
		
		/*
Credits:
https://github.com/marcaube/bootstrap-magnify
*/


!function ($) {

    "use strict"; // jshint ;_;


    /* MAGNIFY PUBLIC CLASS DEFINITION
     * =============================== */

    var Magnify = function (element, options) {
        this.init('magnify', element, options)
    }

    Magnify.prototype = {

        constructor: Magnify

        , init: function (type, element, options) {
            var event = 'mousemove'
                , eventOut = 'mouseleave';

            this.type = type
            this.$element = $(element)
            this.options = this.getOptions(options)
            this.nativeWidth = 0
            this.nativeHeight = 0

            this.$element.wrap('<div class="magnify" \>');
            this.$element.parent('.magnify').append('<div class="magnify-large" \>');
            this.$element.siblings(".magnify-large").css("background","url('" + this.$element.attr("src") + "') no-repeat");

            this.$element.parent('.magnify').on(event + '.' + this.type, $.proxy(this.check, this));
            this.$element.parent('.magnify').on(eventOut + '.' + this.type, $.proxy(this.check, this));
        }

        , getOptions: function (options) {
            options = $.extend({}, $.fn[this.type].defaults, options, this.$element.data())

            if (options.delay && typeof options.delay == 'number') {
                options.delay = {
                    show: options.delay
                    , hide: options.delay
                }
            }

            return options
        }

        , check: function (e) {
            var container = $(e.currentTarget);
            var self = container.children('img');
            var mag = container.children(".magnify-large");

            // Get the native dimensions of the image
            if(!this.nativeWidth && !this.nativeHeight) {
                var image = new Image();
                image.src = self.attr("src");

                this.nativeWidth = image.width;
                this.nativeHeight = image.height;

            } else {

                var magnifyOffset = container.offset();
                var mx = e.pageX - magnifyOffset.left;
                var my = e.pageY - magnifyOffset.top;

                if (mx < container.width() && my < container.height() && mx > 0 && my > 0) {
                    mag.fadeIn(100);
                } else {
                    mag.fadeOut(100);
                }

                if(mag.is(":visible"))
                {
                    var rx = Math.round(mx/container.width()*this.nativeWidth - mag.width()/2)*-1;
                    var ry = Math.round(my/container.height()*this.nativeHeight - mag.height()/2)*-1;
                    var bgp = rx + "px " + ry + "px";

                    var px = mx - mag.width()/2;
                    var py = my - mag.height()/2;

                    mag.css({left: px, top: py, backgroundPosition: bgp});
                }
            }

        }
    }


    /* MAGNIFY PLUGIN DEFINITION
     * ========================= */

    $.fn.magnify = function ( option ) {
        return this.each(function () {
            var $this = $(this)
                , data = $this.data('magnify')
                , options = typeof option == 'object' && option
            if (!data) $this.data('tooltip', (data = new Magnify(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.magnify.Constructor = Magnify

    $.fn.magnify.defaults = {
        delay: 0
    }


    /* MAGNIFY DATA-API
     * ================ */

    $(window).on('load', function () {
        $('[data-toggle="magnify"]').each(function () {
            var $mag = $(this);
            $mag.magnify()
        })
    })
} ( window.jQuery );




jQuery(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})
</script>
</head>


<body>
<?php
include('header.php'); 
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="carousel slide" id="carousel-170318">
        <div class="logo-image" style="border:solid 0px red; z-index:100;">
         <?php
			if($fetchProductData['shop_logo'] !=''){$sLogo = $fetchProductData['shop_logo'];}else{$sLogo = "images/temp_picture/logo_temp.jpg";}
		?>
         <img src=<?php echo $sLogo;?> alt="<?php echo $sLogo;?>" />
       <!-- <img src="<?php //echo $fetchProductData['shop_logo'];?>" alt="<?php //echo $fetchProductData['shop_name'];?>" /> -->
       </div>
        <ol class="carousel-indicators">
          <li class="active" data-slide-to="0" data-target="#carousel-170318"> </li>
          <li data-slide-to="1" data-target="#carousel-170318"> </li>
          <li data-slide-to="2" data-target="#carousel-170318"> </li>
        </ol>
        <div class="carousel-inner">
          <div class="item active">
             <?php
			  if(isset($fetchProductData['shop_name'])) { $fetchProductData['shop_name'];}
				else {$fetchProductData['shop_name'] = '';}
			  
			  if($fetchProductData['shop_picture']==''){
				      	$shopCategory = $fetchProductData['shop_category'];
						$jsons = json_decode($shopCategory); 
						  foreach($jsons as $data => $value){
							  $catagoryID	=	 $data;
							  $categoryMain	=	 $value->cate_main;
							  $categoryMID	=	 $value->cate_mid;
							  $getBannerData	=	mysqli_query($db,"SELECT * FROM settings WHERE sett_val1 = '$categoryMID'");
							  $getBannerImage	=	mysqli_fetch_array($getBannerData);
							   if($categoryMID == $getBannerImage['sett_val1']){
								  $bannerImage	=$getBannerImage['sett_val3'];
							   }	  
				  			}
				  if($bannerImage !=''){?>
							 <img src="<?php echo $bannerImage;?>" alt="<?php echo $fetchProductData['shop_name']; ?>" /> 
						<?php }
			  }else{?>
					<img src="<?php echo $fetchProductData['shop_picture'];?>" alt="<?php echo $fetchProductData['shop_name']; ?>" /> 
				<?php }?>
			  
       
			
           
             <div class="carousel-caption">
              <h4> <?php   echo isset($fetchProductData['shop_name'])?$fetchProductData['shop_name']:'';?> </h4>
              <p> <?php    echo isset($fetchProductData['shop_description'])?$fetchProductData['shop_description']:'';?></p>
            </div>
          </div>
          <!--<div class="item"> <img alt="Carousel Bootstrap Second" src="http://lorempixel.com/output/sports-q-c-1600-500-2.jpg" />
            <div class="carousel-caption">
              <h4> Second Thumbnail label </h4>
              <p>  Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit. </p>
            </div>
          </div>
          <div class="item"> <img alt="Carousel Bootstrap Third" src="http://lorempixel.com/output/sports-q-c-1600-500-3.jpg" />
            <div class="carousel-caption">
              <h4> Third Thumbnail label </h4>
              <p> Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit. </p>
            </div>
          </div>-->
        </div>
        <a class="left carousel-control" href="#carousel-170318" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-170318" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a> </div>
    </div>
  </div>
  <div class="row ComcontontRow">
    <div class="col-md-2 col-sm-4 col-xs-12"> 
      <!-- left side colm row start -->
      <?php include('Sidebar_users.php'); ?>
      <!-- left side colm row end --> 
      
    </div>
    <!-- main div md 8 start -->
    <div class="col-md-8 col-sm-8 col-xs-12"> 
      <!-- row start -->
      <div class="row" style="margin:0px; border-bottom:solid 3px gold; width:100%;">
        <div class="col-md-12" style="padding:0px;">
          <h3 class="text-info" style="padding:0px; margin-top:0px; text-transform:uppercase;"> <?php echo $fetchResult['shop_name'];?> </h3>
        </div>
      </div>
      
      <div class="label label-info pull-right Rmall"><?php echo $fetchProductData['shop_mall'];?> </div>
      <!-- row end --> 
      
      <!-- product start -->
      <div class="col-lg-12 col-md-12" style="margin-bottom:30px; margin-top:20px;"> 
        <!-- row start -->
        <div class="row">
          <div class="col-md-5 col-sm-6 col-xs-12 item-photo" style="margin-bottom: 75px;">
          <?php
			  if($fetchResult['prodt_picture']!= ''){
				  $prodPic	=	$fetchResult['prodt_picture'];
			  }else{
				  $prodPic ='';
			  }
			  ?>
          <img class="magMain" data-toggle="magnify" style="max-width:100%;" src="<?php echo $prodPic?>" alt="Product Picture" >
          <?php
			 $additionalPics = '';
			 $additionalPics = json_decode($fetchResult['prodt_newpics'],true);
		  ?>
          
          
          <div style="width: 1px; height: 1px; overflow: visible; position: absolute; bottom: -2px; left: 1px;">
          	<div style="position: absolute; top: 10px; width: 300px; height: 50px;"> 
          	<div style="width: 50px; height: 50px; float: left;">
          	<img class="cngI" onClick="cngImg();" style="width: 50px; height: 50px;" src="<?php echo $prodPic ;?>" />
          	</div>
          	<?php
				if(!empty($additionalPics)){
				foreach($additionalPics as $additionalPic){ ?>
				 <div style="width: 50px; height: 50px; float: left;">
          		<img class="cngI" onClick="cngImg();" style="width: 50px; height: 50px;" src="<?php echo $additionalPic ;?>" /></div>
				 
				<?php } }?>
          <script>
			  $('img.cngI').on({'click': function() {
						 var src = ($(this).attr('src'))
						 $('img.magMain').attr('src', src);
						$('.magnify-large').css({'background': 'transparent url("' + src + '") no-repeat'});
					}
				});
			</script>
          </div>
          	
          </div>
          
          
          </div>
          
          <div class="col-md-7 col-sm-6 col-xs-12" style="border:0px solid gray"> 
            <!-- Datos del vendedor y titulo del producto -->
            <h3><?php echo $fetchResult['prodt_name']; //(5054 Impressions or last 250 days)?></h3>
            
            <h5 style="color:#337ab7">Views <small style="color:#337ab7">
            <?php echo "(".$fetchResult['prodt_views_count']." Impressions in last ";
				   
				$prodtCreatedDate	=	date('Y-m-d',strtotime($fetchResult['prodt_cre']));
				$currenDat = date('Y-m-d');
				$date1=date_create($prodtCreatedDate);
				$date2=date_create($currenDat);
				$diff=date_diff($date1,$date2);
				echo $diff->format("%a days") .")";
				?></small></h5>
            
            <!-- Precios -->
            <h5 class="title-price"><small>
        
                <?php 
				if(mysqli_num_rows($offerdata) > 0){
						//while($offerDetails = mysqli_fetch_array($offerdata)){
						$offerDetails = mysqli_fetch_array($offerdata);
						$offerType = '';
						if($offerDetails['offer_type'] == 'buy-get'){
							$offerType = 'Buy Get Offer';
						}elseif($offerDetails['offer_type'] == 'discount'){
							$offerType = 'Discount Offer' ;
						}elseif($offerDetails['offer_type'] == 'flat'){
							$offerType = 'Flat Sale Offer';
						}elseif($offerDetails['offer_type'] == 'cashback'){
							$offerType = 'Cashback Offer';
						}elseif($offerDetails['offer_type'] == 'scratch-win'){
							$offerType = 'scratch & Win Offer';
						}elseif($offerDetails['offer_type'] == 'exchange'){
							$offerType = 'Exchange Offer';
						}elseif($offerDetails['offer_type'] == 'mall-offer'){
							$offerType = 'Mall Offer';
						}
						echo $offerType." ".$offerDetails['offer_name'];				
						//}
				}else{
					echo "No offer currently available";
				}
				
				?>
                
                </small></h5>
<!--            <h3 style="margin-top:0px;">AED <?php //echo $fetchResult['prodt_price'];  ?>  <span style="color: brown; text-decoration: line-through; font-size: 15px;"> AED<?php //echo $fetchResult['prodt_price'];  ?> </span></h3>-->
            
            
            <!-- Botones de compra -->
            <div class="section" style="background-color: transparent;">
              <button class="btn btn-primary" style="width:100%;"><i class="fa fa-heart Rfav" title="Favourite"></i> Favourite me</button>
              <h6 style="margin-top:20px; margin-bottom:20px;">
              <!-- AddToAny BEGIN -->
<!--<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_pinterest"></a>
<a class="a2a_button_wechat"></a>
<a class="a2a_button_whatsapp"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>-->
<!-- AddToAny END -->
<!-- Addthis start -->
<div class="addthis_inline_share_toolbox_elyw pull-right" style="float:right;"></div>
<!-- Addthis end -->

              </h6>
            </div>
          </div>
          <div class="col-md-12" style="margin-top:25px;"> 
            <script>
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script> 


<!-- rating start -->
<div class="col-lg-3 col-md-3 col-sm-5 col-xs-12" style="margin-bottom:30px;">
        <fieldset>
          	<?php
			 $selectData 	= mysqli_query($db,"SELECT prodt_ranking FROM product_details WHERE prodt_id = '$productID' AND prodt_company_id = '$shopID'"); 
			 if(mysqli_num_rows($selectData) > 0){
				  	$resultData	 	=	mysqli_fetch_array($selectData);
					 $dbRanking	 	=	unserialize($resultData['prodt_ranking']);
				 	
				 if(!empty($dbRanking)){
					  rsort($dbRanking);
					 $fivecount  	= 0;
					 $fourCount	 	= 0;
					 $threeCount 	= 0;
					 $twoCount	 	= 0;
					 $oneCount	 	= 0;
				 	 $totalCount 	= 0;
				 	 $sumOfCount 	= 0;
				 	 $averageRate	=	0;
					 $totArrayCount = count($dbRanking);
					 
					 foreach($dbRanking as $dbRank =>$value){
						$rateData = $value['rating'];
						 if($rateData == '5'){
							 $fivecount++;
						 }
						 if($rateData == '4'){
							 $fourCount++;
						 }
						 if($rateData == '3'){
							 $threeCount++;
						 }
						 if($rateData == '2'){
							 $twoCount++;
						 }
						 if($rateData == '1'){
							 $oneCount++;
						 }
					 }
				 $sumOfCount	=	(1*$oneCount)+(2*$twoCount)+(3*$threeCount)+(4*$fourCount)+(5*$fivecount);
		 		 $averageRate	=	$sumOfCount/$totArrayCount;?>
		 		<?php
		 	//try to get mac address
					// echo $_SERVER['HTTP_USER_AGENT'];
					// echo $_SERVER['REMOTE_ADDR'];
					//echo $uid = md5($_SERVER['HTTP_USER_AGENT'] .  $_SERVER['REMOTE_ADDR']);
					 //end mac addr
					 ?>
				 
					 <legend style="margin-bottom:0px !important; font-size:14px; color:#269abc;">Visitors Ratings:
					 	<span class="badge rcolor" id = "visitRate"> 

							<?php echo round($averageRate,2);?>
						 </span>
					 </legend>
					
				 <?php } else{?>
					 			 <legend style="margin-bottom:0px !important; font-size:14px; color:#269abc;">Visitors Ratings: <span class="badge rcolor" id = "visitRate"> 
									<?php echo "0.00 ";?>
							 </span></legend>
				<?php } ?>
				
				
				 <div id = 'rate'>
			 		 <?php
				 		 if(!empty($dbRanking)){?>
						 <?php
							 
						 $filterData = array_slice($dbRanking, 0,15);
							 foreach($filterData as $item => $val){
							 	$ratingRank = $val['rating'];
								$badgeClr = 'badge rcolor'.$ratingRank;
			 					echo "<span id = 'ratevalue' class='".$badgeClr."'>".$ratingRank."</span>";
							}?>	 
					<?php	
					   $totalArraySliceCount	= count($filterData)	;	 
					 	if($totArrayCount > 15){
							$newCount	=	$totArrayCount-$totalArraySliceCount;
							echo "...+(".$newCount.")";
						} 
				  }else{
				 echo"<span style='color:red'> You are the first one to rate here ... </span>";
				  } ?>
				</div>
				 
			<?php } ?>
         
        </fieldset>
      </div>
<div class="col-lg-3 col-md-3 col-sm-5 col-xs-12" style="margin-bottom:30px;">
<style>
/****** Style Star Rating Widget *****/
.rating { 
  border: none;
  float: left;
}

.rating > input { display: none; } 
.rating > label:before { 
  margin: 5px;
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before { 
  content: "\f089";
  position: absolute;
}

.rating > label { 
  color: #ddd; 
 float: right; 
}

/***** CSS Magic to Highlight Stars on Hover *****/

.rating > input:checked ~ label, /* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

.rating > input:checked + label:hover, /* hover current star when changing rating */
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label, /* lighten current selection */
.rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 
</style>
<script>
function set_mouseover(id) {
  jQuery('#rcolor').text(id);
}
</script>
<fieldset class="Rrate rating">
        <?php
	$productID	= 	isset($_GET['pt'])?$_GET['pt']:'';
	$shpID		= 	isset($_GET['sh'])?$_GET['sh']:'';
	$ratingSum	=	0;
	 	?>
         <input type ="hidden" id = "txtProduct" name = "txtProduct" value = "<?php echo $productID ?>" >
         <input type ="hidden" id = "txtShp" name = "txtShp" value = "<?php echo $shpID ?>" >
         <input type ="hidden" id = "rateSum" name = "rateSum" value = "<?php echo $ratingSum ?>" >
          <legend style="margin-bottom:0px !important; font-size:14px; color:#269abc;">Rate Here:
           
             <span class="badge rcolor" id="rcolor">0</span></legend>
          
			<?php
				$i = 5;
				$count	=	1;
	
				for($i=5;$i>=$count;$i--){
				?>
					<input type="radio" class="ratings" id="<?php echo "star".$i; ?>" data-id="<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" /><label class = "full" for="<?php echo "star".$i;?>" title="<?php echo "Awesome -".$i; ?> stars" onmouseover="set_mouseover('<?php echo $i; ?>')"></label>
				<?php } ?>
				<!-- <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars" onmouseover="set_mouseover('5')"></label>
				<input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars" onmouseover="set_mouseover('4')"></label>
				<input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars" onmouseover="set_mouseover('3')"></label>
				<input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars" onmouseover="set_mouseover('2')"></label>
				<input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star" onmouseover="set_mouseover('1')"></label> -->
        </fieldset>
</div>
<!-- rating end -->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Specifications</a></li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Reviews</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="pro_discript tab-pane fade in active" id="home">
                <?php echo $fetchResult['prodt_description']; ?>
			  </div>
              <div role="tabpanel" class="tab-pane fade" id="profile"><?php echo $fetchResult['prodt_specifications']?><br/>
               </div>
              <div role="tabpanel" class="tab-pane fade" id="messages">
              
              <?php
              	 $selectReviewData		=	"SELECT * FROM enquiry_dmg where em_flag = 'review' and em_status = 'on' and em_shopid = '$shpID' AND em_product_id = '$productID' ORDER BY em_createdAt DESC ";
				 $fetchReviewData		=	mysqli_query($db,$selectReviewData);
				  if(mysqli_num_rows($fetchReviewData)> 0){
					  	  while($fetchReviewResult	=	mysqli_fetch_array($fetchReviewData)){
					  ?>
					  <div class="row">
						 <div class="col-lg-12" style="background-color: #E9E9E9;">
						  	<div class="pull-left"><?php echo $fetchReviewResult['em_name']; ?></div>
						  	<div class="pull-right"><?php echo $fetchReviewResult['em_createdAt']; ?></div>
						  </div>
				 		 <div class="col-lg-12" style="margin-bottom: 25px; white-space: normal;"><?php echo $fetchReviewResult['em_message']; ?>
				 		 </div>
					 </div>	
					<?php }  
				  } else{ ?>
					   <div class="row">
			  	   			Add your review here .
				  	   </div>
				  <?php } ?>

              </div>
              <div role="tabpanel" class="tab-pane fade" id="settings">...</div>
            </div>
            <div> </div>
          </div>
        </div>
        <!-- row end --> 
      </div>
      <!-- product end -->
      
      <style>
/*form:invalid {
  border: 1px solid #ffdddd;
}
form:valid {
  border: 1px solid #ddffdd;
}*/

input:invalid {
	border:solid 1px red;
  background-color: #FBB;
}
input:valid {
  border:solid 1px #ddd;
}  
input:required {
  border-color: #ff0;
  border:solid 1px red;
}
input:required:valid {
  border:solid 1px #ddd;
}
input:required:invalid {
  border:solid 1px red;
}
      </style>
      <h3 class="text-primary"> Review </h3>
      <form role="form" style="margin-bottom:20px;" name="email_form" id="email_form" method="POST" >
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input class="form-control" name="company" type="hidden" readonly="readonly" />
              <input class="form-control" name="company_email" type="hidden" readonly="readonly" />
              <input class="form-control" name="ip_address" type="hidden" readonly="readonly" />
              <label for="exampleInputEmail1"> Your Name </label>
              <input class="form-control" name="emailname" type="text" required="required" />
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="exampleInputEmail1"> Email </label>
              <input class="form-control" name="emailid" type="email" required="required" />
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="exampleInputEmail1"> Contact Number </label>
              <input class="form-control" name="emailcontact" type="tel" pattern=".[0-9].{7,13}" />
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="exampleInputEmail1"> Website </label>
              <input class="form-control" name="website" type="url" />
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <label for="message">Message </label>
              <textarea class="form-control" id="message" name="message" style="width:100%; height:150px;"></textarea>
            </div>
          </div>
          
           <div class="form-group">
			  <label for="captcha">CAPTCHA Code: </label>
			  <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><a href='javascript: refreshCaptcha();'><span style="font-size: 25px; font-family: Gotham, Helvetica Neue, Helvetica, Arial,' sans-serif';">֎</span></a><br>
			  <label for='message'>Enter the code above here :</label>
			  <input id="captcha_code" name="captcha_code" type="text"><br>
			   Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
         </div>
         <?php if(isset($msg)){?>
				<div class="form-group">
					 <span style="color: red" id="captchaMsg"> <?php echo $msg;?></span>
				</div>
		 <?php } ?>
          
          	<?php
				$token = uniqid( '', true );
				$_SESSION[ 'token' ] = $token;
			?>
			<input type="hidden" name="token" value="<?php echo $token; ?>"/>
          
          
          <div class="col-md-12">
            <button type="submit" class="btn btn-default" title="submit"> Submit </button>
          </div>
        </div>
      </form>
    </div>
        
    <div class="col-md-2 col-sm-4 col-xs-12">
      <?php 
		$rowCount				=	mysqli_num_rows($getAdData);
		while($getAdDataResult	=	mysqli_fetch_array($getAdData )){
		$adTypeVal			=	$getAdDataResult['sett_val1'];
		$adTypeID				=	$getAdDataResult['Ad_Type'];
		$advIDD					=	$getAdDataResult['Ad_Id'];		
		$objProduct->updateViewCount($advIDD,$adTypeID);	
			if($rowCount <= $adTypeVal){
	  			//echo $getAdDataResult['Ad_Url'];
			?>
			<div class="row" style="margin-bottom:15px; width:50%">
       			 <div class="col-md-12" style="padding:0px;"> 
       			
       			 	<img class="adImageClick" id = "<?php echo $advIDD;?>" alt="<?php if(isset($getAdDataResult['shop_name'])) echo $getAdDataResult['shop_name']; ?>" src="<?php echo $getAdDataResult['Ad_Picture']; ?>" width="175" />
			
       			  </div>
      		</div>
			<?php }?>
		<?php }?>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="row Rhead">
        <div class="col-md-12">
          <h3> You may like this also... </h3>
        </div>
      </div>
      <?php
		$prodtCat	=	$fetchProductData['prodt_category'];
		$prodtjsns = json_decode($prodtCat); 
		$forCount	=	'1';
			 foreach($prodtjsns as $data => $value){
			
				 if($forCount == '1'){
					$pID =  'prodt_category LIKE '."'".'%"'.$data.'"%'."'"; 
				 }else{
					 $pID.=  ' OR prodt_category LIKE '."'".'%"'.$data.'"%'."'"; 
				 }
				 ++$forCount;
			}
		
		?>
	
    
      
      
      
      
       <!-- Market Trends start -->
    <div id="amazingcarousel-container-1" style="padding:0px; margin-bottom:50px;">
    <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:1140px;margin:0px auto 0px;">
        <div class="amazingcarousel-list-container">
            <ul class="amazingcarousel-list">
               <?php
		
		  $selectRelatedProductData = mysqli_query($db,"SELECT DISTINCT prodt_company_id,prodt_id,prodt_picture,prodt_name FROM product_details WHERE prodt_id != '$productID' AND ($pID) ORDER BY RAND() LIMIT 15 ");
			while($fetchArrayProdtData	= mysqli_fetch_array($selectRelatedProductData)){
				$pt = $fetchArrayProdtData['prodt_id'];
				$sh = $fetchArrayProdtData['prodt_company_id'];
				?>
				
                <li class="amazingcarousel-item">
                    <div class="amazingcarousel-item-container">
<div class="amazingcarousel-image"><a href="productdetails.php?pt=<?php echo $pt; ?>&sh=<?php echo $sh;  ?>" title="<?php echo $fetchArrayProdtData['prodt_name'];?>"  target="_blank"><img src="<?php echo $fetchArrayProdtData['prodt_picture'];?>"  alt="<?php echo $fetchArrayProdtData['prodt_name']; ?>" height="240px" /></a></div>
<!--<div class="amazingcarousel-title"><?php //echo $mTrow['prodt_name']; ?>Raja</div> -->                   </div>
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
</div>
<!-- company container end --> 



<script>
$('.ratings').click(function(){
		rating 		= $(this).attr('data-id');
		productId 	= $('#txtProduct').val();
		shopId 		= $('#txtShp').val();
		
		
				$.ajax({
			        	url:"ajax_rating.php",
			        	data:{
							"rating"		:rating,
							"productId"		:productId,
							"shopId"		:shopId,
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{  
							$('#rate').html(data);
						}	
			        });
		
	});
	
	//for advertisement product details image link
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


 

<!--footer-->
<?php include("footer.php"); ?>
<!--footer--> 

</body>
</html>



