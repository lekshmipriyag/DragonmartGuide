<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}

if(!isset($_GET['sh'])){
		header("Location: index.php"); /* Redirect browser */
		exit();
	}
?>
<?php
include('Connections/dragonmartguide.php');
include('Connections/frontend_function.php');
include('Connections/fun_c_tionRfront.php');
	
	$shopId  					= 	isset($_GET['sh'])?$_GET['sh']:'';
	$objProduct = new Product();
	$objProduct->shopid 		= $shopId;
	$getProductResult			=	$objProduct->getShopProductDetails();
	$getResData					=	mysqli_fetch_array($getProductResult);
	$objProduct->advType		=	'productlist_slide';
	$getAdData					=   $objProduct->getAdvertisement();
	
	//if(!isset($_SESSION['shopviewcount'])){$_SESSION['shopviewcount'] = 1;}
	//if(in_array($shopId,$_SESSION['shopviewcount'])){
		  //  array_push($_SESSION['shopviewcount'],$shopId);
			$objProduct->updateShopViewsCount();
	//}
	
	if(isset($_POST['emailname'])){
			if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){ 
			$msg="<span style='color:red'>The Captcha code does not match!</span>";

		}else{// Captcha verification is Correct. Final Code Execute here!		
			$msg=" ";
			$objEmail 				= 	new Contact();
			$clientIpAddr			=	$objEmail->get_client_ip();
			$objEmail->em_shopid 	= 	$shopId; //dummy value of shop id ;
			$objEmail->em_prodid	=	'';
		    $objEmail->em_flag 		=	'shop';
			$objEmail->page_name	=	'products.php';
			$objEmail->em_ipaddress =   $clientIpAddr;
			$objEmail->sendEmail();
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Success! </strong>Your request submitted successfully.</div>";
	}
			
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dragon Mart - <?php echo $getResData['shop_name'];?> </title>

<meta name="description" content="<?php echo isset($getResData['shop_description'])?preg_replace( "/\r|\n/", " ",strip_tags($getResData['shop_description'])):'';?>" />
<meta name="keywords" content="<?php echo isset($getResData['shop_keywords'])?preg_replace('/&#44;/', ', ', strip_tags($getResData['shop_keywords'])):'';?>" />
<meta name="author" content="WEBAPPi">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="1 days">
<meta name="Subject" content="Guide">
<meta name="Language" content="EN">

<meta name="google-site-verification" content="xSen_USZvabGBPVXXlBsU1Yqvt0QUeKfiYpWKWGrqXg" />

<meta name="msvalidate.01" content="A7DEE5B67339CA0FEE6E02A395D21BB7" />
 

	<link rel="canonical" href="http://dragonmartguide.com/" />
	<meta property="og:title" content="Dragon Mart - <?php echo $getResData['shop_name'];?> " />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://dragonmartguide.com/" />
	<meta property="og:image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
	<meta property="og:site_name" content="<?php echo $getResData['shop_name'];?>" />
	<meta property="og:description" content="<?php echo isset($getResData['shop_description'])?preg_replace( "/\r|\n/", " ",strip_tags($getResData['shop_description'])):'';?>" />
	
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="Dragon Mart - <?php echo $getResData['shop_name'];?> " />
	<meta name="twitter:description" content="<?php echo isset($getResData['shop_description'])?preg_replace( "/\r|\n/", " ",strip_tags($getResData['shop_description'])):'';?>" />
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

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
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
<script type="text/javascript">
jQuery(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})
</script>
<script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>


</head>

<body>
<?php
include('header.php'); 
?>

<!-- company containtr start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="carousel slide" id="carousel-170318">
        <div class="logo-image" style="border:solid 0px red; z-index:100;">
        <?php
			if($getResData['shop_logo'] !=''){$sLogo = $getResData['shop_logo'];}else{$sLogo = "http://".$_SERVER["SERVER_NAME"]."/images/temp_picture/logo_temp.jpg";}
		?>
        <img src=<?php echo $sLogo;?> alt="<?php echo $sLogo;?>" />
        </div>
        <ol class="carousel-indicators">
          <li class="active" data-slide-to="0" data-target="#carousel-170318"> </li>
          <li data-slide-to="1" data-target="#carousel-170318"> </li>
          <li data-slide-to="2" data-target="#carousel-170318"> </li>
        </ol>
        <div class="carousel-inner">
			
			<div class="item active"> 
          
          <?php
				if(isset($getResData['shop_name'])) { $getResData['shop_name'];}
				else {$getResData['shop_name'] = '';}
				
				if($getResData['shop_picture'] == ''){
						
					if(isset($getResData['shop_category'])){
						$jsons = json_decode($getResData['shop_category']); 
					} 
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
							 <img src="<?php echo $bannerImage;?>" alt="<?php echo $getResData['shop_name']; ?>" /> 
						<?php }
				}else{?>
					<img src="<?php echo $getResData['shop_picture'];?>" alt="<?php echo $getResData['shop_name']; ?>" /> 
				<?php }?>
				
			
            <div class="carousel-caption">
              <h4> <?php   echo isset($getResData['shop_name'])?$getResData['shop_name']:'';?> </h4>
              <p> <?php    echo isset($getResData['shop_description'])?$getResData['shop_description']:'';?></p>
            </div>
          	</div>
      
          <!--<div class="item"> <img alt="Carousel Bootstrap Second" src="http://lorempixel.com/output/sports-q-c-1600-500-2.jpg" />
            <div class="carousel-caption">
              <h4> Second Thumbnail label </h4>
              <p> Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit. </p>
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
          <h3 class="text-info" style="padding:0px; margin-top:0px; text-transform:uppercase;"> <?php   echo isset($getResData['shop_name'])?$getResData['shop_name']:'';?> Products</h3>
        </div>
      </div>
       <div class="label label-info pull-right Rmall"><?php echo $getResData['shop_mall'];?> 
       </div>
     
      <!-- row end --> 
      
      <!-- product start -->
      <div class="col-lg-12 col-md-12" style="margin-bottom:30px; margin-top:20px;"> 
        <!-- row start -->
        <div class="row">
			 <?php 
				

				$selectProduct 	= "SELECT * FROM product_details WHERE prodt_company_id = '$shopId' and prodt_status = 'on' ORDER BY product_details.prodt_cre DESC";
				$productResult	= mysqli_query($db,$selectProduct);
				while($resultData	= mysqli_fetch_array($productResult)){

					 $currentDateTime 	= 	date('Y-m-d',strtotime($_SESSION['now']));
					 $prodtCreatedTime 	= 	$resultData['prodt_cre'];
				
					 $date1				=	date_create($currentDateTime);
					 $date2				=	date_create($prodtCreatedTime);
					 $diff				=	date_diff($date1,$date2);
					 $days				=	$diff->format("%R%a");
				?>
				
			<div class="col-sm-6 col-md-4">
			  <div class="thumbnail RPheight">
			  <?php $prodid	=	$resultData['prodt_id'];?>
				  <div class="Rthump"><a href="productdetails.php?pt=<?php echo $prodid; ?>&sh=<?php echo $shopId;  ?>"> <img src="<?php echo $resultData['prodt_picture']?> " alt="Product picture"></a>
<!--					<span class="tag2 sale2">Sale</span> -->
						<?php if(abs($days) <= 30){ 
							echo "<span class='tag3 hot2'>New</span> "; }
				        ?>
					<!--<span class="tag3 hot2">New</span> -->
				   </div>
				  <div class="caption">
					<h3 class="rrcpny"><?php echo $resultData['prodt_name']; ?></h3>
					<p class="rrDetls2"><?php echo limit_text(strip_tags($resultData['prodt_description']),15); ?></p>
					<p>
					
					
					<a href="productdetails.php?pt=<?php echo $prodid; ?>&sh=<?php echo $shopId;  ?>" class="btn btn-primary" role="button" title = "Details">Details</a>
					
					
					 <i class="fa fa-heart Rfav pull-right" title="Favourite"></i>  
					 <i class="fa fa-mail-forward Rforw pull-right" title="Forward"></i>
					
					</p>
				  </div>
			  </div>
			 </div>
			<?php }?>
			  
        </div>
        <!-- row end --> 
      </div>
      <!-- product end -->
      <!-- contact details -->
      <h3 class="text-primary"> Company enquiry contact </h3>
      <form role="form" style="margin-bottom:20px;" name="email_form" id="email_form" method="POST" >
        <div class="form-group">
          <input class="form-control" name="company" type="hidden" readonly="readonly" />
          <input class="form-control" name="company_email" type="hidden" readonly="readonly" />
          <input class="form-control" name="ip_address" type="hidden" readonly="readonly" />
          <label for="exampleInputEmail1"> Your Name </label>
          <input class="form-control" name="emailname" type="text" required="required" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1"> Contact No </label>
          <input class="form-control" name="emailcontact" type="tel" required="required" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1"> Email </label>
          <input class="form-control" name="emailid" type="email" required="required" />
        </div>       
        <div class="form-group">
              <label for="message">Message </label>
              <textarea class="form-control" id="message" name="message" style="width:100%; height:150px;"></textarea>
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
        
        <button type="submit" class="btn btn-default" title = "Submit"> Submit </button>
      </form>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-12">
     
     <?php 
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
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="row Rhead">
        <div class="col-md-12">
          <h3> You may like this also... </h3>
        </div>
      </div>
        <?php
		$shopCat	=	$getResData['shop_category'];
		$shopjsns = json_decode($shopCat); 
		$forCount	=	'1';
			 foreach($shopjsns as $data => $value){
					 $categoryMID	=	 $value->cate_mid;
				if($forCount == '1'){
					$pID =  'prodt_category LIKE '."'".'%"'.$categoryMID.'"%'."'"; 
				 }else{
					 $pID.=  ' OR prodt_category LIKE '."'".'%"'.$categoryMID.'"%'."'"; 
				 }
				 ++$forCount;
			}
		
		?>
      
      <!-- Insert to your webpage where you want to display the carousel -->
      <div id="amazingcarousel-container-1" style="padding:0px; margin-bottom:50px;">
    <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:1140px;margin:0px auto 0px;">
        <div class="amazingcarousel-list-container">
            <ul class="amazingcarousel-list">
               <?php
		  $selectRelatedProductData = mysqli_query($db,"SELECT DISTINCT prodt_company_id,prodt_id,prodt_picture,prodt_name FROM product_details WHERE  prodt_company_id != '$shopId' AND ($pID)  ORDER BY RAND() LIMIT 15 ");
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
      <!-- End of body section HTML codes --> 
    </div>
  </div>
</div>
<!-- company container end --> 


 
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

 <!--Floting menus start-->
<?php include("floatingMenu.php"); ?>
<!--Floting menus end --> 

<!--footer-->
<?php include("footer.php"); ?>
<!--footer-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--> 
<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> 
<script src="gridder-master/dist/js/jquery.gridder.js"></script>  -->
</body>
</html>