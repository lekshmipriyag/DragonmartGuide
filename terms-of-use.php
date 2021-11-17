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
          <h3 class="p_title" style="padding:0px; margin-top:0px; text-transform:uppercase;">
			  <b>TERMS OF USE</b>
		  </h3>	  
     </div>
	<div class="p_content">
			
		<p>
			Please read these Terms and Conditions carefully. These are the general Terms and Conditions governing your access and use of this website (“Site”). IF YOU DO NOT AGREE WITH THESE TERMS AND CONDITIONS, PLEASE DO NOT USE THIS SITE. By continuing to use the Site and/or any of the services shown on the Site, you agree to be bound by these Terms and Conditions.
		</p>

		<p><strong>ACCEPTANCE</strong></p>
		<p>
			Denying / Ignoring this page will not claiming rights to act against any of the following terms. Your continued use of this site means you accept the terms.
		</p>
		<p><strong>COPYRIGHT © Mass Publishing LLC 2015, ALL RIGHTS RESERVED.</strong></p>
		<p>Copyright in the page design, content and information and their arrangement, is owned by Mass Publishing LLC, unless indicated.</p>
		<p><strong>USE OF INFORMATION AND MATERIALS</strong></p>
		<p>The information and materials contained in these pages – and the terms, conditions, and descriptions that appear – are subject to change.</p>
		<p>
		The information and materials contained in this site, including text, graphics, links or other items are prepared based on availability. We do not warrant the accuracy, adequacy or completeness of the information and materials and expressly disclaims liability for errors or omissions therein. The website is not a direct selling site, hence Mass Publishing LLC not undertaking any kind of warranty / responsibility on product quality, warranty, supplier liability, service issues. The images / photographs for the products are used for illustrative purpose only. The stock availability is subject to the supplier’s storage. The quality of the represented product and its reliability is depends on the suppliers selling policy. No claim is bound with the website or Mass Publishers. Legal issues should be cleared in between the purchaser and the seller only.
		</p>



		<p><strong>EXCLUSION OF LIABILITY</strong><p>
		<p>
			In no event will Mass Publishing LLC be liable for any damages, including without limitation direct or indirect, special, incidental, or consequential damages, losses or expenses arising in connection with this site or use thereof or inability to use by any party, or reliance on the contents of this site, or in connection with any failure of performance, omission, error,delay, defect, interruption or failure in operation or transmission, computer virus or system failure, even if Mass Publishing LLC, its representatives, are advised of the possibility of such damages, losses or expense, hyperlinks to other internet resources are at your own risk; the content, accuracy, opinions expressed, and other links provided by these resources are not investigated, verified, monitored, or endorsed by Mass Publishing LLC. This Exclusion clause shall take effect to the fullest extent permitted by law.
		</p>

		<p><strong>SUBMISSION</strong></p>
		<p>
			All information submitted to Mass Publishing LLC via this site once, shall be deemed and remain the property of Mass Publishing LLC who shall be free to use, for any purpose, any ideas, concepts, know-how or techniques contained in information a visitor to this site provides Mass Publishing LLC through this site. Mass Publishing LLC shall not be subject to any obligations of confidentiality or privacy regarding submitted information except as agreed by the Mass Publishing LLC or as otherwise specifically agreed or required by law.
		</p>
		<p><strong>CHANGES</strong></p>
		<p>These terms and conditions are subject to change and can be modified at any time without notice.</p>
		<p>GOVERNING LAW & JURISDICTION</p>
		<p>
			By accessing this website and obtaining the facilities, products or services offered through this website, you agree that the law of the United Arab Emirates (UAE) shall govern such access and the provision of such facilities, products and services and you agree to submit to the exclusive jurisdiction of the UAE courts.
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