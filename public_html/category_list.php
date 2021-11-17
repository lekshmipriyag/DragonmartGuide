<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}
?>
<?php
if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}	
 	
include( 'Connections/dragonmartguide.php' );
include( 'Connections/frontend_function.php' );

	if(isset($_POST['emailname']) &&  $session_tokens == $tokens){
		if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){ 
			$msg="<span style='color:red'>The Captcha code does not match!</span>";

		}else{// Captcha verification is Correct. Final Code Execute here!	
			$msg=" ";
			$objEmail 					= 	new Contact();
			$clientIpAddr				=	$objEmail->get_client_ip();
			$objEmail->em_shopid 		= 	''	; //dummy value of shop id ;
			$objEmail->em_prodid		=	'';
		    $objEmail->em_flag 			=	'suggestion';
			$objEmail->page_name		=	'categoryList.php';
			$objEmail->em_ipaddress 	=   $clientIpAddr;
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
<title>Category List - Dragon Mart Guide - Dubai - China Mall</title>
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
	.ulcls {
    padding: 0em;
	margin-bottom: 0px !important; 	
	
}

.ulcls .licls, .ulcls .licls .ulcls .licls {
    position:relative;
    top:0;
    bottom:0;
    padding-bottom: 7px;

}

.ulcls .licls .ulcls {
 margin-left: 2em;
}

.licls {
    list-style-type: none;
}

.licls a {
    padding:0 0 0 10px;
   position: relative;
    top:.2em;
}

.licls a:hover {
    text-decoration: none;
}

a.addBorderBefore:before {
    content: "";
    display: inline-block;
    width: 2px;
    height: 28px;
    position: absolute;
    left: -47px;
    top:-16px;
    border-left: 1px solid gray;
}

.licls:before {
    content: "";
    display: inline-block;
    width: 25px;
    height: 0;
    position: relative;
    left: 0em;
/*    top:1em;*/
    border-top: 1px solid gray;
}
	
	

.ulcls .licls .ulcls .licls:last-child:after, .ulcls .licls:last-child:after {
    content: '';
    display: block;
    width: 1em;
/*    height: 1em;*/
    position: relative;
    background: #fff;
/*    top: 9px;*/
    left: -1px;
}
	
	.p_content{
		font-size:14px;
		line-height: 24px;
		text-align: justify;
		/* Restrict users for selecting content*/
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		-o-user-select: none;
		user-select: none;
	}
	.p_title{
		font-size:24px;
		color: #ED0F13;
	}
	
	.enquiry{
   		
		border-radius: 75%;
	}

	
.right {
  position: fixed;
  top: 0;
  bottom: 0;
  height: 2.5em;
  margin: auto;
/*  background:#2794C1;*/
}

.right {
   right: 0;
}
	
.btn-circle {

  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.42;
}	


	
</style>	
	

</head>

<body>

<!--<a href="#txt_suggestion" class = "btn btn-danger right enquiry">Suggestions</a>-->

<?php
include('header.php'); 

?>	
<!-- company containtr start -->
<div class="container-fluid">
  <div class="row">
   
  </div>
  <div class="row ComcontontRow">
    
  <div class="col-md-2 col-sm-2 col-xs-2"> 
	  </div>
    <div class="col-md-8 col-sm-8 col-xs-8">
		
	<div class = "row">
		 <div class="col-md-12" style="padding-bottom:10px;">
			  <h3 class="p_title" style="padding:0px; margin-top:0px; text-transform:uppercase;">
				  <b>CATEGORY LIST</b>
			  </h3>	  
		 </div>	
	</div>	
		<div class = "row">
		<div class ="col-md-12 col-sm-12 col-xs-12 p_content">						
			 <?php

				$selectParentData = mysqli_query($db,"SELECT distinct cate_parent FROM categories WHERE cate_main != '999' AND cate_list = '999'");
				while($parent = mysqli_fetch_array($selectParentData)){
					$parentCategory	=	 $parent['cate_parent'];
					?>
						<?php 
							echo "<ul class='ulcls'>";
							echo "<li class = 'licls'>". strtoupper($parentCategory);
					?>
			   <?php

					$selectCategoryMain = mysqli_query($db,"SELECT distinct cate_main FROM categories WHERE cate_parent = '$parentCategory'");
						while($mainCategory= mysqli_fetch_array($selectCategoryMain)){

						 $categoryMain = $mainCategory['cate_main'];
							if($categoryMain != '999'){


								 $selectCategoryList = mysqli_query($db,"SELECT distinct cate_list FROM categories WHERE cate_parent = '$parentCategory' AND cate_main = '$categoryMain'");
								if(mysqli_num_rows($selectCategoryList) > 1){

										echo "<ul class='ulcls'>";
										echo "<li class = 'licls'>".strtoupper($categoryMain); "</li>";
									 while($categoryList	= mysqli_fetch_array($selectCategoryList)){
									  $listData		=	$categoryList['cate_list'];
										 if($listData != '999'){
											 echo "<ul class='ulcls'>"; ?>
													<li class = 'licls'><a href='search.php?search=<?php echo $listData ?>' ><?php echo $listData ?></a></li>
											<?php  echo "</ul>"; 
										 }

								 }
								}else{
									echo "<ul class='ulcls'>"; ?>
										<li class = 'licls'>
										<a href='search.php?search=<?php echo $categoryMain ?>'><?php echo $categoryMain; ?></a>
										</li>
										<?php
								}

								echo "</li>";
								echo "</ul> ";
							}
						}
					echo "</li> ";
					echo "</ul> ";
				}
			?>

		</div>
		</div>
    </div>
    
    <div class="col-md-2 col-sm-2 col-xs-2"> 
<!--     <a href="#txt_suggestion" class="btn btn-default btn-circle right">Suggestions</a>-->
     <a href="#txt_suggestion" class="btn btn-primary right">Suggestions</a>
    </div>
  </div>
  <div class="row">
   
    <div class="col-md-2 col-sm-2 col-xs-2"> 
      
    </div>
    <div class="col-md-8 col-sm-8 col-xs-8">
		    <!-- For category  suggestions-->
		<a name="txt_suggestion"></a>
      <h3 class="text-primary"> Your Suggestions </h3>
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
              <label for="exampleInputEmail1"> Contact Number </label>
              <input class="form-control" name="emailcontact" type="tel" pattern=".[0-9].{7,13}" />
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <label for="exampleInputEmail1"> Email </label>
              <input class="form-control" name="emailid" type="email" required="required" />
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
    
     <div class="col-md-2 col-sm-2 col-xs-2"> 
      
    </div>
  </div>
</div>
<!-- company container end --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="js/MultiNestedList.js"></script>

<!-- Restrict users for copying content -->
<script type="text/javascript">
document.oncopy = function(){
    var bodyEl = document.body;
    var selection = window.getSelection();
    selection.selectAllChildren( document.createElement( 'div' ) );
};
</script>


<!-- Restrict users for right clicking the page -->
<script>
	$(document).ready(function() {
    $(".container-fluid").on("contextmenu",function(){
       return false;
    }); 
	
	 $(".navbar-fixed-top").on("contextmenu",function(){
       return false;
    });
		
   $(".footer1").on("contextmenu",function(){
       return false;
    });
		
   $(".footer-bottom").on("contextmenu",function(){
       return false;
    });
		
	$(".Menu_containerL").on("contextmenu",function(){
       return false;
    });
	$(".tntdiv").on("contextmenu",function(){
       return false;
    });	
	$(".fb-page").on("contextmenu",function(){
       return false;
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