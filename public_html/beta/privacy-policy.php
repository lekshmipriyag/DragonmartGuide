<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}
?>
<?php
include( 'Connections/dragonmartguide.php');
include( 'Connections/frontend_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home - Dragon Mart Guide - Dubai - China Mall</title>
<link rel="icon" type="image/png" href="images/favicon.png" />
<!--<link type="text/scss" rel="stylesheet" href="css/bootstrap.css" />-->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" >
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.css" />
<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />-->
<link type="text/css" rel="stylesheet" href="css/mystyle.css" >
<link rel="stylesheet" href="css/font-awesome.min.css">
<link href="gridder-master/dist/css/jquery.gridder.min.css" rel="stylesheet">

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

<script type="text/javascript" src="js/banner.js"></script>
<script type='text/javascript'>
	function refreshCaptcha(){
		var img = document.images['captchaimg'];
		img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	}
</script>	
<script type="text/javascript">
jQuery(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})
</script>
<style>
	.p_content{
		font-size:14px;
		line-height: 24px;
		text-align: justify;
	}
	.p_title{
		font-size:24px;
		color: #000000;
	}
</style>
</head>

<body>
<?php
include('header.php'); 

?>	
<!-- company containtr start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      
    </div>
  </div>
  <div class="row ComcontontRow">
    <div class="col-md-2 col-sm-4 col-xs-12"> 
      <!-- left side colm row start -->
		<?php //include('Sidebar_users.php'); ?>
      <!-- left side colm row end --> 
      
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
        
		 <div class="col-md-12" style="padding:0px;">
          <h3 class="p_title" style="padding:0px; margin-top:0px; text-transform:uppercase;">privacy policy
		  </h3>	  
     </div>
	<div class="p_content">
		<p><strong><b>Privacy Policy</b></strong></p>	
		<p>Last update: 12-06-2015</p>
		<p>This Privacy Policy for dragonmartguide is developed on June 12, 2015. This policy discloses the privacy practices for the website.</p>
		<p><strong>Disclaimer of other websites:</strong></p>
		<p>
   		The website may contain links to other websites for your convenience and information. We do not undertake any responsibilities of the content or privacy policies of the linked websites.
   		</p>
		<p><strong>Policy on our information collection:</strong></p>
		<p>
			We collect personal and non personal information about the user directly or by third party websites when you register, subscribe, order or contacting us via submission form. On registering with us, we collect your personal details, contact numbers, valid email address for the use within the privacy policy. When you authorize us through a third party websites or social media to receive data about you, we use that information in accordance with our privacy policy.
		</p>
		<p>
			<strong>Billing and Credit Card Information</strong>
		</p>
		<p>
			To enable payment or donations, we collect and store name, address, contact details, email addresses, credit card or other billing information. This information will only be shared with third parties who help to complete the purchase transaction. We do not share this information to any of third party unless it is related to a payment option.
		</p>
		<p>
			<strong>Non-personal information</strong>
		</p>
		<p>
		We collect your non-personal information via internet technology such as IP address, geological location information, unique device identifiers, browser type, browser language and other transactional information.
		</p>
		<p>
		We may use cookies, web beacons, HTML5 local storage and other similar technologies to manage access to and use of the services, recognize you and your personalization to understand about the public usage of our website. If you block the cookies, you may not access to certain areas in our website. We may transmit some of the collected non-personal information to third party web sites to manage our incoming and outgoing advertisements.
		</p>
		<p>
			And we gather certain information automatically and store it in log files for our site statistics analysis, advertising needs, developing our site experience and performance.
		</p>
		<p><strong>Changes to This Policy</strong></p>
		<p>
			This Privacy Policy may be amended from time to time. Any such changes will be posted on this page. If we make a significant or material change in the way we use your personal information, the change will be posted on this page thirty (30) days prior to taking effect and registered users will be notified via email.
		</p>
		
	</div>

    </div>
    <div class="col-md-2 col-sm-4 col-xs-12">
    <?php 
		
		$objProduct = new Product();
		$objProduct->advType		=	'productlist_slide';
		$getAdData					=   $objProduct->getAdvertisement();
		
		$rowCount			=	mysqli_num_rows($getAdData);
		while($getAdDataResult	=	mysqli_fetch_array($getAdData )){
		$adTypeVal			=	$getAdDataResult['sett_val1'];
		$adTypeID				=	$getAdDataResult['Ad_Type'];
		$advIDD					=	$getAdDataResult['Ad_Id'];		
		$objProduct->updateViewCount($advIDD,$adTypeID);	
			if($rowCount <= $adTypeVal){?>
			<div class="row" style="margin-bottom:15px; width:50%">
       			 <div class="col-md-12" style="padding:0px;">
       			 	<img class="adImageClick" id = "<?php echo $advIDD;?>" alt="<?php if(isset($getAdDataResult['shop_name'])) echo $getAdDataResult['shop_name']; ?>" src="<?php echo $getAdDataResult['Ad_Picture']; ?>" width="175" />
       			 </div>
      		</div>
			<?php }?>
		
			
		<?php }
	 ?>
    </div>
  </div>
  </div>
<!-- company container end --> 

 


<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--> 
<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->
<script src="gridder-master/dist/js/jquery.gridder.js"></script> 
<script>
            jQuery(document).ready(function ($) {
				
                // Call Gridder
                $(".gridder").gridderExpander({
                    scrollOffset: 60,
                    scrollTo: "panel", // "panel" or "listitem"
                    animationSpeed: 400,
                    animationEasing: "easeInOutExpo",
                    onStart: function () {
                        console.log("Gridder Inititialized");
                    },
                    onExpanded: function (object) {
                        console.log("Gridder Expanded");
                        $(".carousel").carousel();
                    },
                    onChanged: function (object) {
                        console.log("Gridder Changed");
                    },
                    onClosed: function () {
                        console.log("Gridder Closed");
                    }
                });
            });
        </script>
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
<!--footer-->
<?php include("footer.php"); ?>
<!--footer-->  
</body>
</html>