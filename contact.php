<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}
?>
<?php
include('Connections/dragonmartguide.php');
include('Connections/frontend_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home - Dragon Mart Guide - Dubai - China Mall</title>
<link rel="icon" type="image/png" href="images/favicon.png">
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />-->
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
	.contact-us{
		font-weight: 800;
	}
	.contact-us .contacy-us-map-section{
		position: relative;
		width: 100%;
		height: 250px;
		border-radius: 3px;
		overflow: hidden;
		margin-bottom: 20px;
	}
	.contact-us .address-details{
		position: relative;
		padding-bottom: 20px;
		width: 280px;
	}
	.contact-us .contact-form{
		position: relative;
		padding: 30px;
		background: #f8f8f8;
		border-radius: 3px;
		border: 1px solid #dddddd;
	}
	
	div.wpcf7{
		margin: 0;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
		margin-left: 0px;
		
		padding: 0;
		padding-top: 0px;
		padding-right: 0px;
		padding-bottom: 0px;
		padding-left: 0px;
	}
	
</style>
</head>

<body>
<?php
include('header.php'); 
if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}	
		

if(isset($_POST['emailname']) &&  $session_tokens == $tokens){
		if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){ 
			$msg="<span style='color:red'>The Captcha code does not match!</span>";

		}else{// Captcha verification is Correct. Final Code Execute here!	
			$msg=" ";
			$objEmail 					= 	new Contact();
			$clientIpAddr				=	$objEmail->get_client_ip();
			$objEmail->em_prodid		=	'';
		    $objEmail->em_flag 			=	'contact';
			$objEmail->page_name		=	'contact.php';
			$objEmail->em_ipaddress 	=   $clientIpAddr;
			$objEmail->sendEmail();
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Success! </strong>Your request submitted successfully.</div>";
			}
	}	
?>	
<!-- company containtr start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="carousel slide" id="carousel-170318">
        <div class="logo-image" style="border:solid 0px red; z-index:100;">
        <img src="http://localhost/dragonmartguide.com/images/temp_picture/logo_temp.jpg" alt="" />
        </div>
        <ol class="carousel-indicators">
          <li class="active" data-slide-to="0" data-target="#carousel-170318"> </li>
          <li data-slide-to="1" data-target="#carousel-170318"> </li>
          <li data-slide-to="2" data-target="#carousel-170318"> </li>
        </ol>
        <div class="carousel-inner">
          <div class="item active"> 
			  <img src="images/temp_picture/antiques.jpg" alt="company name" /> 
				<div class="carousel-caption">
				  <h4>  </h4>
				  <p> </p>
				</div>
          </div>
        </div>
        <a class="left carousel-control" href="#carousel-170318" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-170318" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a> </div>
    </div>
  </div>
  <div class="row ComcontontRow">
   <style>
	   .RCicon{
		   width: 40px;
		   height: 40px;
		   line-height: 40px;
		   background-color: gold;
		   text-align: center;
		   border-radius: 3px;
		   position: absolute;
	   }
	   .address-details {
		   position: relative;
			padding-bottom: 20px;
/*			width: 280px;*/
		   display: inline-block !important;
	   }
	   
	  .address-details p {
		   position: relative;
padding-left: 55px;
margin: 0;
font-size: 15px;
color: #777777;
		  text-align: left;
	   }
	  </style>
   <div class = "row">
		<div class="col-md-6"> 
			<h3><strong>OUR </strong>HQ</h3> 
			<div class ="contacy-us-map-section">
				<h5></h5>
			</div>	
			<div class ="row">
			<div class ="col-md-6 col-sm-12 p_content">
				<h5><b>Address Details</b></h5>	
				<div class = "address-details clearfix">
					<i class="fa fa-map-marker RCicon"></i>
					
					<p>Office 09, C11, China Cluster</p>
					<p>International City, Next to Dragon Mart</p>
					<p>Dubai, U.A.E.</p>
				</div>
					<div class = "address-details clearfix">
					<i class="fa fa-phone-square RCicon"></i>
						<p>
							<span><strong>Phone:</strong>+971 55 9426343</span>
							<span><strong>Fax:</strong>+971 44477871 </span>
						</p>
						<p>International City, Next to Dragon Mart</p>
						<p>Dubai, U.A.E.</p>
				  </div>
				  	<div class = "address-details clearfix">
					<i class="fa fa-envelope-open RCicon"></i>
						<p>
							<span><strong>E-mail:</strong>info@dragonmartguide.com</span>
							<span>
							<span>
								<strong>Website :</strong> www.dragonmartguide.com
							</span> 
							</span>
						</p>
					
				  </div>
				</div>
				<div class ="col-md-6 col-sm-12 p_content">
				<h5><strong>Opening Hours</strong></h5>
					<div class = "address-details clearfix">
					<i class="fa fa-clock-o RCicon"></i>
					<p>
						<span>
							<strong>Sun-Thu</strong>
							9:00 am to 6:00 pm
						</span>
						<span>
							<strong>Friday</strong>
							Closed
						</span>
						<span>
							<strong>Saturday</strong>
							Closed
						</span>
					</p>	
					</div>
			</div>
			
				
			</div>
			<div class="row">
				<div class="col-md-12">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3611.037787878444!2d55.4123991802354!3d25.16820188119995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f61463a83dc0f%3A0x587dbde25d95e43c!2sMASS+PRINTING+%26+PUBLISHING!5e0!3m2!1sen!2sae!4v1508255930578" width="100%" height="280" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		
		<div class = "col-md-6">
			<h3>
				<strong>Message</strong>
				 Us
			 </h3>
			<p style="text-align:justify; text-indent:hanging">
				Dragon Mart Guide is a fully functional website for the business members of Dragon Mart and its nearby. The below shown submission form is for the use of shop owners and business advertising inquiries only. The viewers can use the individual shops contact page for any kind of product or business inquiries related to the shop.
			</p>
			<div class="contact-form">
		    
			<form role="form" style="margin-bottom:20px;" name="email_form" id="email_form" method="POST" >
				<div class="form-group">
					  <input class="form-control" name="company" type="hidden" readonly="readonly" />
					  <input class="form-control" name="company_email" type="hidden" readonly="readonly" />
					  <input class="form-control" name="ip_address" type="hidden" readonly="readonly" />
					  <label for="exampleInputEmail1"> Your Name </label>
					  <input class="form-control" name="emailname" type="text" required="required" />
				</div>
				<div class="form-group">
				  <label for="exampleInputEmail1"> Email </label>
				  <input class="form-control" name="emailid" type="email" required="required" />
				</div>
			<div class="form-group">
			  <label for="exampleInputEmail1"> Contact No </label>
			  <input class="form-control" name="emailcontact" type="tel" pattern=".[0-9].{7,13}" />
			</div>
 
			<div class="form-group">
			  <label for="message">Message </label>
			  <textarea class="form-control" id="message" name="message" style="width:100%; height:150px;"></textarea>
			</div>
		     <div class="form-group">
			  <label for="captcha">CAPTCHA Code: </label>
			  <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
			  <label for='message'>Enter the code above here :</label>
			  <input id="captcha_code" name="captcha_code" type="text"><a href='javascript: refreshCaptcha();'><span style="font-size: 25px; font-family: Gotham, Helvetica Neue, Helvetica, Arial,' sans-serif';">֎</span></a><br>
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
        <button type="submit" class="btn btn-default"> Submit </button>
      </form>
		 
			</div>
	   </div>
	   
	</div>
   
   
   
   
    <div class="col-md-8 col-sm-8 col-xs-12">
   
  
      

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
		$Mquery = "SELECT pt.prodt_id, pt.prodt_name, pt.prodt_picture, pt.prodt_company_id, sd.shop_name FROM product_details AS pt INNER JOIN shop_details AS sd on pt.prodt_company_id = sd.shop_id where pt.prodt_status='on' ORDER BY pt.prodt_cre DESC LIMIT 15 ";
		$mTrend = mysqli_query($db, $Mquery);
		?>
      
      <!-- Insert to your webpage where you want to display the carousel -->
      <div id="amazingcarousel-container-1" style="padding:0px; margin-bottom:50px;">
    <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:1140px;margin:0px auto 0px;">
        <div class="amazingcarousel-list-container">
            <ul class="amazingcarousel-list">
               <?php
		  //$selectRelatedProductData = mysqli_query($db,"SELECT DISTINCT prodt_company_id,prodt_id,prodt_picture,prodt_name FROM product_details WHERE $pID ORDER BY RAND() LIMIT 15 ");
			while($fetchArrayProdtData	= mysqli_fetch_array($mTrend)){
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



<!--footer-->
<?php include("footer.php"); ?>
<!--footer--> 
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
</body>
</html>