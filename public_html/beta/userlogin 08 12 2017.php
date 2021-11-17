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
<title>Shop Registration form - Dragon Mart Guide - Dubai - China Mall</title>

<meta name="description"  content="Dubai Dragon Mart shop owners can register here with their shop and personal details. And also we provide free shop and product listing here." />
<meta name="keywords"  content="Free registration, shop registration, free product listing, free shop listing, customer care center,ibis hotel in duai,china,dragon mart shopping,dragon mart online,ae,uae,in,com,shopping in dragon mart,shopping in dubai mall,dubai shopping,shopping at dragon mart,dragon shopping,dragon shops,shops in dragon mart,shopping malls in dubai,dubai shopping malls,dragon mart,drugan mart,drogan market,china bazaar,dubai mall,china mall,dubai mart,china market,all things buy one place,biggest mall,cheapest things,cheap rate mall,quality products,china products,whole sale china market,wholesale market,world cheapest market,easy buying mall,chinese market,dragon mart office,office location,dragon mart contacts,office timing,shopping hours,ramadan trading hours,ramadan offers,ramadan special offers,unique iftars this ramadan,first ramadan,ramadan timings for dragonmart,dragon mart opening hours for ramadan,ramadan hours,dragon mart dubai,dragon mall dubai,dubai dragon mart,products in dragon mart,facilities of dragon mart,atm in dragon mart,banks in dragon mart,shopping timing of dragonmart,list of products available in dragon mart,electronics in dragon mart,stores in dragon mart,furniture stores in dragon mart,electronics store in dragon mart,toys stores in dragon mart,games shops in dragon mart,educational items in dragon mart,kids items in dragon mart" />
<meta name="google-site-verification" content="xSen_USZvabGBPVXXlBsU1Yqvt0QUeKfiYpWKWGrqXg" />

<meta name="msvalidate.01" content="A7DEE5B67339CA0FEE6E02A395D21BB7" />
 

	<link rel="canonical" href="http://dragonmartguide.com/" />
	<meta property="og:title" content="Shop Registration form - Dragon Mart Guide - Dubai - China Mall" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://dragonmartguide.com/userlogin.php" />
	<meta property="og:image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
	<meta property="og:site_name" content="Dragon Mart Guide" />
	<meta property="og:description" content="Dubai Dragon Mart shop owners can register here with their shop and personal details. And also we provide free shop and product listing here." />
	
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="Shop Registration form - Dragon Mart Guide - Dubai - China Mall" />
	<meta name="twitter:description" content="Dubai Dragon Mart shop owners can register here with their shop and personal details. And also we provide free shop and product listing here." />
	<meta name="twitter:image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
	<meta itemprop="image" content="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/images/favicon.png" />
 
<link rel="icon" type="image/png" href="images/favicon.png" />
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
//			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
//						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
//						<strong>Success! </strong>Your request submitted successfully. We will contact soon.If you have any queries please contact to +971 501486343</div>";
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
		<?php //include('Sidebar_users.php'); ?>
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
				<label for="username"> User Name <span class="text-info Rhint">Email: username@domain.com </span></label>
					<input class="form-control" id="username" name="username" type="email" required="required" placeholder="Email: name@domain.com" onBlur="checkAvailability();" />
					<span id="user-availability-status"></span>
					<img src="/images/LoaderIcon.gif" id="loaderIcon" style="display:none" />
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
						
					<input class="form-control" id="password" name="password" type="password" placeholder="Minimum 6 : Atleast 1 Number " required />
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
         	 <input class="form-control" name="txt_mob" type="tel" pattern="^(?:0|\(?\+971\)?\s?|00971\s?)[4-5](?:[\.\-\s]?\d\d){4}$" required/>
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
       	    <script>
			  $(document).ready(function() {    
				 $("#txt_shopNumber").bind('blur keyup',function(e) {  
					  if (e.type == 'blur' || e.keyCode == '188')  {

				var shopNum = $('#txt_shopNumber').val();
				$.ajax({
					url:"ajax_login.php",
					data:{
							"shopNum"		:shopNum
						},
					async:false,
					method: 'POST',
					type: JSON,
					success: function(data)
						{  
							if(data === "No Data"){
								//$('#txt_Message').val(shopNum);
								$('#shopdata').hide();
								$('#shopMsg').show();
								$('#shopMsg').css("color","red");
								$('#shopMsg').html("( Above some shops are currently unavailable. )");
								$('#enquiry').show();
								$('#shopErr').hide();
							
							}else if(data === ""){
								$('#shopMsg').hide();
								$('#enquiry').hide();
								$('#txt_Message').text('');
								$('#shopErr').show();
								$('#shopErr').text('shop number required');
								$('#emptyMsg').text('');
								$('#shopErr').css("color","red");
								$('#shopdata').hide();
							}
							else{
								$('#shopErr').hide();
								$('#shopMsg').hide();
								$('#enquiry').hide();
								$('#txt_Message').text('');
								$('#shopdata').show();
								$('#shopdata').html(data);
								
							}
						}	
				});
					  }

				 });  
			  });
		  </script>
       	   			
			<div class="form-group">
				<label for="prod_image"> Profile Picture <span class="text-info Rhint">File: .jpg, .png and .gif only allowed </span></label>
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
        
         <button type="reset" class="btn btn-md btn-default" title = "Reset" style="width: 40%; margin-left: 9%;"> Reset </button>
        <button id = "submit" type="submit" class="btn btn-md btn-success" title="Submit" style="width: 40%; margin-right: 9%;"> Register </button>
        
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
              <?php
				$selectRelatedProductData = mysqli_query($db,"SELECT DISTINCT prodt_company_id,prodt_id,prodt_picture,prodt_name FROM product_details ORDER BY RAND() LIMIT 15 ");
				while($fetchArrayProdtData	= mysqli_fetch_array($selectRelatedProductData)){
				$pt = $fetchArrayProdtData['prodt_id'];
				$sh = $fetchArrayProdtData['prodt_company_id'];
				?>
             
              <li class="amazingcarousel-item">
                    <div class="amazingcarousel-item-container">
						<div class="amazingcarousel-image">
							<a href="productdetails.php?pt=<?php echo $pt; ?>&sh=<?php echo $sh;  ?>" title="<?php echo $fetchArrayProdtData['prodt_name'];?>"  target="_blank">
							<img src="<?php echo $fetchArrayProdtData['prodt_picture'];?>"  alt="<?php echo $fetchArrayProdtData['prodt_name']; ?>" height="240px" /></a>
						</div>
					</div>
                </li>
                <?php }?>
            </ul>
            <div class="amazingcarousel-prev"></div>
            <div class="amazingcarousel-next"></div>
          </div>
        </div>
      </div>
      <!-- End of body section HTML codes --> 
    </div>
  </div>
</div>
<!-- company container end --> 

 
<script src="js/userlogin.js"></script> 
<!--footer-->
<?php include("footer.php"); ?>
<!--footer--> 
</body>
</html>