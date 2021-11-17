<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home - Dragon Mart Guide - Dubai - China Mall</title>

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
</head>

<body>
<?php
include('header.php'); 
if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}
		
include( 'Connections/dragonmartguide.php');
include( 'Connections/frontend_function.php');
	
if(isset($_POST['txt_firstName']) &&  $session_tokens == $tokens){
	
	
		if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){ 
			$msg="<span style='color:red'>The Captcha code does not match!</span>";
			echo "<div class='alert alert-danger' id='failure-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Failure ! </strong>Captcha code does not match.</div>";
		}else{// Captcha verification is Correct. Final Code Execute here!	*/
			$msg=" ";
			$objData 					= 	new Register();
			$objData->tablename			=	'user_register';
			$objData->pagename			=   'userlogin';
			
			$objData->insertLoginData();
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Success! </strong>Your request submitted successfully. We will contact soon.If you have any queries please contact to +971 501486343</div>";
		}
			
	}	
?>	
<!-- company containtr start -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="carousel slide" id="carousel-170318">
        <div class="logo-image" style="border:solid 0px red; z-index:100;">
        <img src="images/logo-User-login.jpg" alt="" />
        </div>
        <ol class="carousel-indicators">
          <li class="active" data-slide-to="0" data-target="#carousel-170318"> </li>
          <li data-slide-to="1" data-target="#carousel-170318"> </li>
          <li data-slide-to="2" data-target="#carousel-170318"> </li>
        </ol>
        <div class="carousel-inner">
          <div class="item active"> 
			  <img src="images/login/login.png" alt="company name" /> 
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
    <div class="col-md-2 col-sm-4 col-xs-12"> 
      <!-- left side colm row start -->
		<?php include('Sidebar_users.php'); ?>
      <!-- left side colm row end --> 
      
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="row" style="margin:0px; border-bottom:solid 3px gold; width:100%;">
		 <div class="col-md-12" style="padding:0px;">
          <h3 class="text-info" style="padding:0px; margin-top:0px; text-transform:uppercase;"> User Registration 
		  </h3>	  
        </div>
      </div>
       <div class="label label-info pull-right" style="padding: 5px;background-color: gold;color: #333;border-top-right-radius: 0px;"><?php echo "DRAGON MART GUIDE";?> 
       </div>
        <dl style="margin-top:15px;">
        <dt></dt>
			<dd>  </dd>
      </dl>
      
     <address>
      <strong></strong><br />
    </address>
    
      <h3 class="text-primary"> Login </h3>
      <form role="form" style="margin-bottom:20px;" name="login_form" id="login_form" method = "post" enctype="multipart/form-data" action="userlogin.php" >
      	   		<input type = "password" name = "notuse1" id = "notuse1" value = "" style="display: none;">
      	   		<input type = "hidden" name = "dataShopID" id = "dataShopID" value = "">
      	   		<input type = "hidden" name = "dataShopName" id = "dataShopName" value = "">
      	   		<input type = "hidden" name = "dataShopNumber" id = "dataShopNumber" value = "">
      	   		
       	   		<div class="form-group">
				<label for="username"> User Name <span class="text-info">Email: username@domain.com </span></label>
					<input class="form-control" id="username" name="username" type="email" required="required" placeholder="Email: name@domain.com" onBlur="checkAvailability();" />
					<span id="user-availability-status"></span>
					<img src="/images/LoaderIcon2.gif" id="loaderIcon" style="display:none" />
			</div>
	   
		  <!-- <div class="form-group">
          	<label for="exampleInputEmail1"> Email (Username) </label>
         	 <input class="form-control" name="emailid" type="email" required="required" />
        	</div>-->
        <div class="form-group">
				<label for="password"> Password <button type="button" class="btn btn-success btn-xs" onClick="generatePass();" style="width: auto !important; ">Password Generator</button> <div id="gpass" class="text-danger" style="display: inline; width: auto !important;" ></div></label>
				<script>
							function generatePass(){
										var randomstring = Math.random().toString(36).slice(-8);
										$('#gpass').html(randomstring);
							};
						</script>
						
					<input class="form-control" id="password" name="password" type="password" value="" placeholder="Minimum 6 : Atleast 1 Number " autocomplete="off" required />
		</div>
        <div class="form-group">
				<label for="confirm_password"> Confirm Password </label>
						
											
				<input class="form-control" id="confirm_password" name="confirm_password" type="password" data-match="#password" data-match-error="Whoops, these don't match" placeholder="Confirm" required/>
				<span id="passwordConfirm"></span>
		</div>
        <div class="form-group">
          <label for="firstname"> First Name </label>
          <input class="form-control" name="txt_firstName" type="text" required />
        </div>
        <div class="form-group">
          <label for="secondname"> Last Name </label>
          <input class="form-control" name="txt_secondName" type="text" />
        </div>
        
			<div class="form-group">
					<label for="gender"> Gender </label>
					<br/>
					<label for="male">
               			 <input type="radio" name="radio_gender" id="radio" value="Male"/>
               				 Male</label>
		
					<label for="female">
						 <input type="radio" name="radio_gender" id="radio" value="Female"/>
							Female</label>				
			</div>
			<div class="form-group">
         	 <label for="shopname"> Designation </label>
         	 <input class="form-control" name="txt_designation" type="txt"/>
       	   </div>
			<div class="form-group">
         	 <label for="shopname"> Mall Name </label>
         	 <input class="form-control" name="txt_mall" type="txt" required/>
       	   </div>
       	    
       	   
			<div class="form-group">
			  <label for="address">Address </label>
			   <input class="form-control" name="txt_address" type="txt"/>
			</div>
	      
		   <div class="form-group">
         	 <label for="mobile"> Mobile No </label>
         	 <input class="form-control" name="txt_mob" type="tel" required/>
       	   </div>
       
      	   
       	   <div class="form-group">
         	 <label for="shopnumber"> Shop Number </label>
         	 <input class="form-control" name="txt_shopNumber" id = "txt_shopNumber" type="txt" value ="" required/>
       	   </div>
       	   
       	   <div id="shopdata"></div>
		 <!-- <span class="btn btn-default shopClass" id = "shopdata"></span>-->
     	  <span id = "shopErr"></span>
      	
       	<div class="form-group" id = "enquiry" style="background-color: #FDEFB0;">
         	 <label for="shopname"> Claim your shop </label>
			<span id ="shopMsg"></span>
        	 <textarea class="form-control" name="txt_Message" id="txt_Message" placeholder = "Write us to add your missing shops or contact 0501486343"></textarea>
		  </div>
      	<div>
      	   <span id ="emptyMsg"></span>
		  </div>
       	   
       	   			
			<div class="form-group">
				<label for="prod_image"> Profile Picture <span class="text-info">File: .jpg, .png and .gif only allowed </span></label>
				<input class="form-control" type="file" name="file_user" id="file_user"  placeholder="Click to select picture" />
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
         <button type="reset" class="btn btn-md btn-danger" title = "Reset"> Reset </button>
        <button id = "submit" type="submit" class="btn btn-md btn-success" title="Submit"> Register </button>
      </form>
    </div>
<!--    <div class="col-md-2 col-sm-4 col-xs-12">
      <div class="row" style="margin-bottom:15px; width:100%">
        <div class="col-md-12" style="padding:0px;"> <img src="images/advertisements/site1.jpg" alt="company name"  /> </div>
      </div>
      <div class="row" style="width:100%">
        <div class="col-md-12" style="padding:0px;"> <img src="images/advertisements/site2.jpg" alt="company name" /> </div>
      </div>
    </div>-->
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="row Rhead">
        <div class="col-md-12">
          <h3> You may like this also... </h3>
        </div>
      </div>
      
      <!-- Insert to your webpage where you want to display the carousel -->
      <div id="amazingcarousel-container-3" style="padding:0px;">
        <div id="amazingcarousel-3" style="display:none;position:relative;width:100%;margin:0px auto 0px; max-width:1800px !important;">
          <div class="amazingcarousel-list-container">
            <ul class="amazingcarousel-list">
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/2-240x300.jpg" title="DECUSTERFORM_033_032-lightbox"  class="html5lightbox"><img src="images/products/2-240x300.jpg"  alt="DECUSTERFORM_033_032-lightbox" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/5b82004d30e86e5a228e16cd9c144167.jpg" title="DECUSTERFORM_034_033"  class="html5lightbox"><img src="images/products/5b82004d30e86e5a228e16cd9c144167.jpg"  alt="DECUSTERFORM_034_033" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/3138aMqJjoL._SY300_QL70_.jpg" title="DECUSTERFORM_034_033-lightbox"  class="html5lightbox"><img src="images/products/3138aMqJjoL._SY300_QL70_.jpg"  alt="DECUSTERFORM_034_033-lightbox" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/75066_of1_9k_vp.jpg" title="DECUSTERFORM_035_034"  class="html5lightbox"><img src="images/products/75066_of1_9k_vp.jpg"  alt="DECUSTERFORM_035_034" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/88704_of1_9d_vp.jpg" title="DECUSTERFORM_035_034-lightbox"  class="html5lightbox"><img src="images/products/88704_of1_9d_vp.jpg"  alt="DECUSTERFORM_035_034-lightbox" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/1490702074_Cameras-634x452-en.jpg" title="DECUSTERFORM_036_035"  class="html5lightbox"><img src="images/products/1490702074_Cameras-634x452-en.jpg"  alt="DECUSTERFORM_036_035" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/764302211150.png" title="DECUSTERFORM_036_035-lightbox"  class="html5lightbox"><img src="images/products/764302211150.png"  alt="DECUSTERFORM_036_035-lightbox" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/764302400745.png" title="DECUSTERFORM_037_036"  class="html5lightbox"><img src="images/products/764302400745.png"  alt="DECUSTERFORM_037_036" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/3473311405609.jpg" title="DECUSTERFORM_037_036-lightbox"  class="html5lightbox"><img src="images/products/3473311405609.jpg"  alt="DECUSTERFORM_037_036-lightbox" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/dsc01984.jpg" title="DECUSTERFORM_038_037"  class="html5lightbox"><img src="images/products/dsc01984.jpg"  alt="DECUSTERFORM_038_037" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/download-9.jpg" title="DECUSTERFORM_038_037-lightbox"  class="html5lightbox"><img src="images/products/dsc01984.jpg"  alt="images/products/download-9.jpg" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/g200_aj_p.jpg" title="DECUSTERFORM_039_038"  class="html5lightbox"><img src="images/products/g200_aj_p.jpg"  alt="DECUSTERFORM_039_038" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/httpeu.chv.meimagesa7rsojua.jpg" title="DECUSTERFORM_039_038-lightbox"  class="html5lightbox"><img src="images/products/httpeu.chv.meimagesa7rsojua.jpg"  alt="DECUSTERFORM_039_038-lightbox" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/m580_of1_44_vp.jpg" title="DECUSTERFORM_040_039"  class="html5lightbox"><img src="images/products/m580_of1_44_vp.jpg"  alt="DECUSTERFORM_040_039" /></a></div>
                </div>
              </li>
              <li class="amazingcarousel-item">
                <div class="amazingcarousel-item-container">
                  <div class="amazingcarousel-image"><a href="images/products/764302400745.png" title="DECUSTERFORM_040_039-lightbox"  target="_blank"><img src="images/products/764302400745.png"  alt="DECUSTERFORM_040_039-lightbox" /></a></div>
                </div>
              </li>
            </ul>
            <div class="amazingcarousel-prev"></div>
            <div class="amazingcarousel-next"></div>
          </div>
          <div class="amazingcarousel-nav"></div>
          <div class="amazingcarousel-engine"><a href="http://amazingcarousel.com">JavaScript Scroller</a></div>
        </div>
      </div>
      <!-- End of body section HTML codes --> 
    </div>
  </div>
</div>
<!-- company container end --> 

<!--Floting menus start-->
<?php include("floatingMenu.php"); ?>
<!--Floting menus end --> 

<!--footer-->
<?php include("footer.php"); ?>
<script src="js/userlogin.js"></script> 
<!--footer--> 
</body>
</html>