<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER[ 'PHP_SELF' ] . "?doLogout=true";
if ( ( isset( $_SERVER[ 'QUERY_STRING' ] ) ) && ( $_SERVER[ 'QUERY_STRING' ] != "" ) ) {
	$logoutAction .= "&" . htmlentities( $_SERVER[ 'QUERY_STRING' ] );
}

if ( ( isset( $_GET[ 'doLogout' ] ) ) && ( $_GET[ 'doLogout' ] == "true" ) ) {
	//to fully log out a visitor we need to clear the session varialbles
	$_SESSION[ 'MM_Username' ] = NULL;
	$_SESSION[ 'MM_UserGroup' ] = NULL;
	$_SESSION[ 'PrevUrl' ] = NULL;
	unset( $_SESSION[ 'MM_Username' ] );
	unset( $_SESSION[ 'MM_UserGroup' ] );
	unset( $_SESSION[ 'PrevUrl' ] );

	$logoutGoTo = "../login.php";
	if ( $logoutGoTo ) {
		header( "Location: $logoutGoTo" );
		exit;
	}
}
?>
<?php
$page_type = "shop_side";
$page_name = "shop_settings";
include( '../Connections/permission.php' );
?>
<?php
if ( !isset( $_SESSION ) ) {
	session_start();
}
$MM_authorizedUsers = "$permission";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized( $strUsers, $strGroups, $UserName, $UserGroup ) {
	// For security, start by assuming the visitor is NOT authorized. 
	$isValid = False;

	// When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
	// Therefore, we know that a user is NOT logged in if that Session variable is blank. 
	if ( !empty( $UserName ) ) {
		// Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
		// Parse the strings into arrays. 
		$arrUsers = Explode( ",", $strUsers );
		$arrGroups = Explode( ",", $strGroups );
		if ( in_array( $UserName, $arrUsers ) ) {
			$isValid = true;
		}
		// Or, you may restrict access to only certain users based on their username. 
		if ( in_array( $UserGroup, $arrGroups ) ) {
			$isValid = true;
		}
		if ( ( $strUsers == "" ) && false ) {
			$isValid = true;
		}
	}
	return $isValid;
}

$MM_restrictGoTo = "../login.php";
if ( !( ( isset( $_SESSION[ 'MM_Username' ] ) ) && ( isAuthorized( "", $MM_authorizedUsers, $_SESSION[ 'MM_Username' ], $_SESSION[ 'MM_UserGroup' ] ) ) ) ) {
	$MM_qsChar = "?";
	$MM_referrer = $_SERVER[ 'PHP_SELF' ];
	if ( strpos( $MM_restrictGoTo, "?" ) )$MM_qsChar = "&";
	if ( isset( $_SERVER[ 'QUERY_STRING' ] ) && strlen( $_SERVER[ 'QUERY_STRING' ] ) > 0 )
		$MM_referrer .= "?" . $_SERVER[ 'QUERY_STRING' ];
	$MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode( $MM_referrer );
	header( "Location: " . $MM_restrictGoTo );
	exit;
}
?>
<?php
$thishopno = array();

//if ( isset( $_POST[ 'shop_select' ] ) ) {
//	$_SESSION[ 'shop_id' ] = $_POST[ 'shop_select' ];
//} elseif ( !isset( $_POST[ 'shop_select' ] ) && isset( $_SESSION[ 'shop_id' ] ) ) {
//	$_SESSION[ 'shop_id' ] = $_SESSION[ 'shop_id' ];
//}
include( '../Connections/dragonmartguide.php' );
include( '../Connections/fun_c_tion.php' );
if ( isset( $_POST[ 'comp_name' ] ) && $_SESSION[ 'token' ] == $_POST[ 'token' ] ) {
	$shopUpdt = new SHOP;
	$shopUpdt->m_shop();
}

//$shopid = $_SESSION['shop_id'];
//if($shopid == ""){$shopid = $usershoplist[0];}
//if(isset($_SESSION['PermitedShop_ids'])){$Tpshopid = $_SESSION['PermitedShop_ids'];}
/*echo "<script>alert('$Tpshopid');</script>";*/
if(isset($_GET['id'])){
	$shopid = $_GET['id'];
}else{
	header( "Location: " . $MM_restrictGoTo );
	exit();
}


if(($_SESSION['live_user_type'] === "shopuser" && $shopid === $userloginID) || ($_SESSION['live_user_type'] === "adminuser" && in_array('shop_settings', $permission_set))){
	$shop_result = mysqli_query( $db, "select * from `shop_details` where `shop_details`.`shop_id`='$shopid'" );
	$shopRow = mysqli_fetch_array( $shop_result );
	
	
	$no_result = mysqli_query( $db, "SELECT * FROM `shop_number` WHERE `sno_shopid` in (0, $shopid) AND `sno_status`='on' ORDER BY `shop_number`.`sno_number` ASC ");
	while($noRow = mysqli_fetch_array( $no_result )){
		//$shopno[$noRow['sno_shopid']] = "'".$noRow['sno_number']."'";
		if($noRow['sno_shopid'] == $shopid) {$thishopno[] = $noRow['sno_number'];}else{$shopno[] = "'".$noRow['sno_number']."'";}
	}
}else{
	echo "<script>alert('WARNING: Don't do like this anymore!');</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL='../index.php'\" />";
	//header("Location: shop_home.php");
	exit();
}

//if(in_array($shopid, $usershoplist) || $check_permission['user_type'] == "adminuser"){
//
//$shop_result = mysqli_query( $db, "select * from `shop_details` where `shop_details`.`shop_id`='$shopid'" );
//$shopRow = mysqli_fetch_array( $shop_result );
//
////if($shopid == ""){$shopid = 1;}
//$no_result = mysqli_query( $db, "SELECT * FROM `shop_number` WHERE `sno_shopid` in (0, $shopid) AND `sno_status`='on' ORDER BY `shop_number`.`sno_shopid` ASC " );
//while($noRow = mysqli_fetch_array( $no_result )){
//	//$shopno[$noRow['sno_shopid']] = "'".$noRow['sno_number']."'";
//	if($noRow['sno_shopid'] == $shopid) {$thishopno[] = $noRow['sno_number'];}else{$shopno[] = "'".$noRow['sno_number']."'";}
//}
//	}else{
//	$_SESSION['shop_id'] = $_SESSION['PermitedShop_ids'][0];
//	echo "<script>alert('WARNING: Don't do like this anymore!');</script>";
//	echo "<meta http-equiv=\"refresh\" content=\"0;URL='".$_SERVER["PHP_SELF"]."'\" />";
//	//header("Location: shop_home.php");
//	exit();
//}



?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Shop Settings :: Dragon Mart Guide</title>
	<!--<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />-->
	<!--<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css">-->
	<!--<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.css" />
<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />-->
	<link type="text/css" rel="stylesheet" href="../css/clientstyle.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<!--<script type="text/javascript" src="../datatable/jquery-1.12.4.js"></script>-->
	<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
	</style>
	
	
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	
	

	
	
	
	
	<link type="text/css" rel="stylesheet" href="../test/bootstrap-multiselect.css">
	<script type="text/javascript" src="../test/bootstrap-multiselect.js"></script>


	<!-- Theme -->
	<!--<link href="assets/css/main.css" rel="stylesheet" type="text/css" />-->
	<link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<!--<link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />-->

	<!--<link rel="stylesheet" href="assets/css/fontawesome/font-awesome.min.css">-->
	<!--[if IE 7]>
		<link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

	<!--[if IE 8]>
		<link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
<!--	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>-->

	<!--=== JavaScript ===-->


<!--	<script type="text/javascript" src="assets/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>

	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/libs/lodash.compat.min.js"></script>-->

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="assets/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Smartphone Touch Events -->
<!--
	<script type="text/javascript" src="plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="plugins/event.swipe/jquery.event.move.js"></script>
	<script type="text/javascript" src="plugins/event.swipe/jquery.event.swipe.js"></script>
-->

	<!-- General -->
	<script type="text/javascript" src="assets/js/libs/breakpoints.js"></script>
 <script type="text/javascript" src="plugins/respond/respond.min.js"></script>  <!--Polyfill for min/max-width CSS3 Media Queries (only for IE8)-->
<!--	<script type="text/javascript" src="plugins/cookie/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>-->

	<!-- Page specific plugins -->
	<!-- Charts -->
	<script type="text/javascript" src="plugins/sparkline/jquery.sparkline.min.js"></script>

	<!--<script type="text/javascript" src="plugins/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="plugins/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="plugins/blockui/jquery.blockUI.min.js"></script>-->

	<!-- Forms -->
	<script type="text/javascript" src="plugins/typeahead/typeahead.min.js"></script> <!-- AutoComplete -->
	<!--<script type="text/javascript" src="plugins/autosize/jquery.autosize.min.js"></script>
	<script type="text/javascript" src="plugins/inputlimiter/jquery.inputlimiter.min.js"></script>-->
	<!--<script type="text/javascript" src="plugins/uniform/jquery.uniform.min.js"></script>--> <!-- Styled radio and checkboxes -->
	<script type="text/javascript" src="plugins/tagsinput/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="plugins/select2/select2.min.js"></script>  <!--Styled select boxes -->
	<!--<script type="text/javascript" src="plugins/fileinput/fileinput.js"></script>-->
	<!--<script type="text/javascript" src="plugins/duallistbox/jquery.duallistbox.min.js"></script>
	<script type="text/javascript" src="plugins/bootstrap-inputmask/jquery.inputmask.min.js"></script>
	<script type="text/javascript" src="plugins/bootstrap-wysihtml5/wysihtml5.min.js"></script>
	<script type="text/javascript" src="plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>
	<script type="text/javascript" src="plugins/bootstrap-multiselect/bootstrap-multiselect.min.js"></script>-->

	<!-- Globalize -->
	<!--<script type="text/javascript" src="plugins/globalize/globalize.js"></script>
	<script type="text/javascript" src="plugins/globalize/cultures/globalize.culture.de-DE.js"></script>
	<script type="text/javascript" src="plugins/globalize/cultures/globalize.culture.ja-JP.js"></script>-->

	<!-- App -->
	<script type="text/javascript" src="assets/js/app.js"></script>
	<script type="text/javascript" src="assets/js/plugins.js"></script>
	<!--<script type="text/javascript" src="assets/js/plugins.form-components.js"></script>-->


<script>
	$(document).ready(function(){
		// For category list toggle start
		$("div.listplus").click(function () {
			//$("li > ul", this).toggle();
			$(this).siblings('ul').slideToggle('slow');
		});
		// For category list toggle end
		
		$('.select2-select-02').select2({
		tags: [<?php sort($shopno); echo implode(",",$shopno); ?>]
		});
		
		"use strict";

		App.init(); // Init layout and core plugins
		Plugins.init(); // Init all plugins
		FormComponents.init(); // Init all form-specific plugins
		
	});
	</script>

	<!-- Demo JS -->
	<script type="text/javascript" src="assets/js/custom.js"></script>
	<script type="text/javascript" src="assets/js/demo/form_components.js"></script>

</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 C-left">
				<?php include("shop_left_bar.php"); ?>
			</div>
			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
			
				<?php include("shop_top_bar.php"); ?>

				<div class="row">
					<div class="col-lg-12 C-main">
						<div class="row">
							<div class="C-dash1">Shop Settings</div>
							<div class="C-dash2">view and edit</div>
						</div>
						<div class="row">
							<!--<div class="col-lg-12 C-main-in">
								<div class="form-group">
									<form name="cngshop" method="post" enctype="multipart/form-data">
									<?php //print_r($_SESSION); ?>
										<label for="shop_select"> Select Shop Name </label>
										<select name="shop_select" id="shop_select" class="form-control" onchange="submit();">

											<?php
											//$prmtshopids = implode(",", $_SESSION[ 'PermitedShop_ids' ]);
											//$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_id` IN ($prmtshopids)" );
											//while ( $prmt_row = mysqli_fetch_array($prmt_shops) ) {
												//$prmtArray = unserialize( $prmt_row[ 'shop_number' ] );
												?>

											<option value="<?php //echo $prmt_row['shop_id']; ?>" <?php //if($_SESSION[ 'shop_id']==$prmt_row[ 'shop_id']){echo "selected";} ?> >
												<?php //echo $prmt_row['shop_name'] ?> (
												<?php //sort($prmtArray); echo implode(",",$prmtArray); ?> )
											</option>
											<?php
											//}
											?>
										</select>
									</form>
								</div>
							</div>-->
							<div class="col-lg-12 C-main-in">
								<div class="C-infoC">Total Products <span class="label label-primary">50</span>
								</div>
								<div class="C-infoC">Live Products <span class="label label-success">42</span>
								</div>
								<div class="C-infoC">Latest Products <span class="label label-info">3</span>
								</div>
								<div class="C-infoC">Inactive Products <span class="label label-warning">8</span>
								</div>
								<div class="C-infoC">Deleted Products <span class="label label-danger">23</span>
								</div>
								
								
							</div>
							
							<div class="col-lg-12">
								<div class="row">
									<div class="col-sm-4 col-xs-4" style="text-align: center;">
									<button class="btn btn-default btn-lg" style="width: 100%;">Free</button>
									</div>
									<div class="col-sm-4 col-xs-4" style="text-align: center;">
									<button class="btn btn-success btn-lg" style="width: 100%;">Regular</button>
									 </div>
									<div class="col-sm-4 col-xs-4" style="text-align: center;">
									<button class="btn btn-default btn-lg" style="width: 100%;">Premium</button>
									</div>
								</div>

							</div>

							<div class="col-lg-12 C-main-in" style="padding-top: 15px;">

								<form name="shopForm" id="shopForm" method="post" enctype="multipart/form-data">

									<!-- shop info start -->
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<h3 class="Rh3">Shop Info</h3>
										<div class="form-group">
											<label for="comp_name"> Shop Name </label>
											<input class="form-control" id="comp_name" name="comp_name" type="text" value="<?php echo $shopRow['shop_name']; ?>" required="required"/>
										</div>
										<div class="form-group">
											<label for="comp_no"> Shop Number </label>
											<?php
											sort($thishopno);
											$thishopno = array_map('trim', $thishopno);
											?>
											<input name="comp_no" id="input22" class="select2-select-02 col-md-12 full-width-fix" multiple data-placeholder="Type to add a Tag" type="hidden" value="<?php echo implode(", ",$thishopno); ?>" required="required" >
											
											<!--<input class="form-control" id="comp_no" name="comp_no" type="text" required="required" value="<?php //echo implode(", ", unserialize( $shopRow[ 'shop_number' ] )); ?>" placeholder="eg. AB01, EA03, ... (Use comma)"/>-->
										</div>
										<div class="form-group">
											<label for="comp_location"> Shop Location </label>
											<select class="form-control" id="comp_location" name="comp_location" required>
											<?php if(isset($shopRow['shop_mall'])){$shop_mall = $shopRow['shop_mall'];} else {$shop_mall = "na";} ?>
												<option value="">--Select Mall--</option>
												<option <?php if($shop_mall == "Dragon Mart 1"){echo " selected ";} ?> value="Dragon Mart 1">Dragon Mart 1</option>
												<option <?php if($shop_mall == "Dragon Mart 2"){echo " selected ";} ?> value="Dragon Mart 2">Dragon Mart 2</option>
											</select>
										</div>
										<div class="form-group">
											<label for="comp_floor"> Floor / Level </label>
											
											<select class="form-control" id="comp_floor" name="comp_floor" required>
											<?php if(isset($shopRow['shop_floor'])){$shop_floor = $shopRow['shop_floor'];} else {$shop_floor = "na";} ?>
												<option value="">--Select Floor--</option>
												<option <?php if($shop_floor == "Ground Floor"){echo " selected ";} ?> value="Ground Floor">Ground Floor</option>
												<option <?php if($shop_floor == "1st Floor"){echo " selected ";} ?> value="1st Floor">1st Floor</option>
												<option <?php if($shop_floor == "2nd Floor"){echo " selected ";} ?> value="2nd Floor">2nd Floor</option>
												<option <?php if($shop_floor == "3rd Floor"){echo " selected ";} ?> value="3rd Floor">3rd Floor</option>
												<option <?php if($shop_floor == "4th Floor"){echo " selected ";} ?> value="4th Floor">4th Floor</option>
												<option <?php if($shop_floor == "5th Floor"){echo " selected ";} ?> value="5th Floor">5th Floor</option>
											</select>
											
										</div>
																				
										<div class="form-group " style="margin-bottom:90px !important;;">											
											<div class="col-md-6" style="padding-left: 0px; padding-right: 5px;">
											<label for="comp_zone">Zone </label>
											<input class="form-control" id="comp_zone" name="comp_zone" type="text" value="<?php echo $shopRow['shop_zone']; ?>" placeholder="eg.GB, BA"/>
											
											</div>
											<div class="col-md-6" style="padding-left: 5px; padding-right: 0px;">
											<label for="comp_parking">Nearest Entrance </label>
											<input class="form-control" id="comp_parking" name="comp_parking" type="text" value="<?php echo $shopRow['shop_near_gate']; ?>" placeholder="eg. Gate 1, Gate 2 (Use comma)"/>
											</div>	
										</div>
										
										
										<div class="form-group">
											<label for="comp_landmart"> Landmark </label>
											<input class="form-control" id="comp_landmart" name="comp_landmart" type="text" value="<?php echo $shopRow['shop_landmark']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_city"> City </label>
											<select class="form-control" id="comp_city" name="comp_city" required>
												<option <?php if($shopRow[ 'shop_city']=="International City" ){echo "selected";} ?> value="International City">International City</option>
												<option <?php if($shopRow[ 'shop_city']=="Muscat" ){echo "selected";} ?> value="Muscat">Muscat</option>
												<option <?php if($shopRow[ 'shop_city']=="Muharraq" ){echo "selected";} ?> value="Muharraq">Muharraq</option>
											</select>

										</div>
										<div class="form-group">
											<label for="comp_emirate"> State </label>
											<select class="form-control" id="comp_emirate" name="comp_emirate" required>
												<option <?php if($shopRow[ 'shop_state']=="Dubai" ){echo "selected";} ?> value="Dubai">Dubai</option>
												
											</select>

										</div>
										<div class="form-group">
											<label for="comp_country"> Country </label>
											<select class="form-control" id="comp_country" name="comp_country" required>
												<option <?php if($shopRow[ 'shop_country']=="UAE" ){echo "selected";} ?> value="UAE">UAE</option>
											</select>
										</div>
									</div>
									<!-- shop info end -->
									<!-- Contact info start -->
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<h3 class="Rh3">Contact Info</h3>
										<div class="form-group">
											<label for="comp_person"> Name </label>
											<input class="form-control" id="comp_person" name="comp_person" type="text" required="required" value="<?php echo $shopRow['shop_contact_person']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_primary"> Primary Contact (Office Use) </label>
											<div class="input-group"> <span class="input-group-addon">+971</span>
												<input class="form-control" id="comp_primary" name="comp_primary" type="tel" pattern=".[0-9].{8, 14}" required="required" value="<?php echo $shopRow['shop_maincontact']; ?>"/>
											</div>
										</div>
										<div class="form-group">

											<label for="comp_contact1"> Mobile Number 1 </label>
											<div class="input-group"> <span class="input-group-addon">+971</span>
												<input class="form-control" id="comp_contact1" name="comp_contact1" type="tel" aria-label="contact1" value="<?php echo $shopRow['shop_mobile1']; ?>"/>
												<span class="input-group-addon RckMsg">
													<?php
													if ( unserialize( $shopRow[ 'shop_whatsapp' ] ) != "" ) {
														$wa = unserialize( $shopRow[ 'shop_whatsapp' ] );
													} else {
														$wa[] = "na";
													}
													if ( unserialize( $shopRow[ 'shop_wechat' ] ) != "" ) {
														$wc = unserialize( $shopRow[ 'shop_wechat' ] );
													} else {
														$wc[] = "na";
													}
													?>

													<input type="checkbox" name="comp_contact1Wa" aria-label="contact1" title="Whatsapp" style="vertical-align: middle;" <?php if (in_array( "mobile1", $wa)) {echo "checked";} ?> >
													<img src="../images/whatsapp-icon1.png" width="20" height="20" alt="Whatsapp" title="Whatsapp"/>
													<input type="checkbox" name="comp_contact1Wc" aria-label="contact1" title="WeChat" style="vertical-align: middle;" <?php if (in_array( "mobile1", $wc)) {echo "checked";} ?> >
													<img src="../images/wechat-logo.png" width="20" height="20" alt="WeChat" title="WeChat"/> </span>

											</div>
										</div>
										<div class="form-group">
											<label for="comp_contact2"> Mobile Number 2 </label>
											<div class="input-group"> <span class="input-group-addon">+971</span>
												<input class="form-control" id="comp_contact2" name="comp_contact2" type="tel" aria-label="contact2" value="<?php echo $shopRow['shop_mobile2']; ?>"/>
												<span class="input-group-addon RckMsg">
                <input type="checkbox" name="comp_contact2Wa" aria-label="contact2" title="Whatsapp" style="vertical-align: middle;" <?php if (in_array("mobile2", $wa)) {echo "checked";} ?> >
                <img src="../images/whatsapp-icon1.png" width="20" height="20" alt="Whatsapp" title="Whatsapp" />
                <input type="checkbox" name="comp_contact2Wc" aria-label="contact2" title="WeChat" style="vertical-align: middle;" <?php if (in_array("mobile2", $wc)) {echo "checked";} ?> >
                <img src="../images/wechat-logo.png" width="20" height="20" alt="WeChat" title="WeChat" /> </span>
											

											</div>
										</div>
										<div class="form-group">
											<label for="comp_email"> Landline </label>
											<div class="input-group"> <span class="input-group-addon">+971</span>
												<input class="form-control" id="comp_tel" name="comp_tel" type="tel" value="<?php echo $shopRow['shop_tel']; ?>"/>
											</div>
										</div>
										<div class="form-group">
											<label for="comp_email"> Email </label>
											<input class="form-control" id="comp_email" name="comp_email" type="email" required="required" value="<?php echo $shopRow['shop_email']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_website"> Website </label>
											<input class="form-control" id="comp_website" name="comp_website" type="url" value="<?php echo $shopRow['shop_website']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_bis_type"> Business Type </label>
											<select class="form-control" id="comp_bis_type" name="comp_bis_type">
												<option <?php if($shopRow[ 'shop_bus_type']=="Retail Only" ){echo "selected";} ?> value="Retail Only">Retail Only</option>
												<option <?php if($shopRow[ 'shop_bus_type']=="Wholesale Only" ){echo "selected";} ?> value="Wholesale Only">Wholesale Only</option>
												<option <?php if($shopRow[ 'shop_bus_type']=="Wholesale & Retail" ){echo "selected";} ?> value="Wholesale & Retail">Wholesale & Retail</option>
											</select>
										</div>
										<div class="form-group">
											<label for="comp_export"> Export </label>
											<select class="form-control" id="comp_export" name="comp_export">
												<option <?php if($shopRow[ 'shop_expt']=="No" ){echo "selected";} ?> value="No">No</option>
												<option <?php if($shopRow[ 'shop_expt']=="Yes" ){echo "selected";} ?> value="Yes">Yes</option>
											</select>
										</div>
									</div>
									<!-- Contact info end -->
									<!-- Social start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc;">
										<h3 class="Rh3">Social Links</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<?php
										$social = $shopRow[ 'shop_socialmedia' ];
										if($social != ""){
											$social = unserialize( $shopRow[ 'shop_socialmedia' ]);
										} else {$social = array('twitter'=>"",'facebook'=>"",'instagram'=>"",'googleplus'=>"",'pinterest'=>"",'youtube'=>"");}
										?>

										<div class="form-group">
											<label for="comp_twitter"> Twitter </label>
											<input class="form-control" id="comp_twitter" name="comp_twitter" type="url" value="<?php echo $social['twitter']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_facebook"> Facebook </label>
											<input class="form-control" id="comp_facebook" name="comp_facebook" type="url" value="<?php echo $social['facebook']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_instagram"> Instagram </label>
											<input class="form-control" id="comp_instagram" name="comp_instagram" type="url" value="<?php echo $social['instagram']; ?>"/>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="comp_google"> Google+ </label>
											<input class="form-control" id="comp_google" name="comp_google" type="url" value="<?php echo $social['googleplus']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_pinterest"> Pinterest </label>
											<input class="form-control" id="comp_pinterest" name="comp_pinterest" type="url" value="<?php echo $social['pinterest']; ?>"/>
										</div>
										<div class="form-group">
											<label for="comp_youtube"> Youtube </label>
											<input class="form-control" id="comp_youtube" name="comp_youtube" type="url" value="<?php echo $social['youtube']; ?>"/>
										</div>
									</div>
									<!-- Social end -->
									<!-- Shop service start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc;">
										<h3 class="Rh3">Shop Service</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<?php
										$pays = $shopRow['shop_paytype'];
										
										if($pays != ""){$pays = unserialize($pays);}else{$pays = array('0'=>1);}
									?>
										<div class="form-group">
											<label for="comp_delivery"> Mode of Payment </label>
											<br/>
											
											<label for="cash">
                <input type="checkbox" name="cash" id="cash" value="Cash" <?php if(in_array("Cash", $pays)){echo "checked";} ?> />
                Cash</label>
										
										

											<label for="cheque">
                <input type="checkbox" name="cheque" id="cheque" value="Cheque" <?php if(in_array("Cheque", $pays)){echo "checked";} ?> />
                Cheque</label>
										

											<label for="cards">
                <input type="checkbox" name="cards" id="cards" value="Cards" <?php if(in_array("Cards", $pays)){echo "checked";} ?> />
                Cards</label>
										

										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="comp_delivery"> Delivery Service </label>
											<br/>
											<label for="cash">
                <input type="radio" name="delivery" id="delivery_1" value="Yes" <?php if($shopRow['shop_delivery'] == "Yes"){echo "checked";} ?>/>
                Yes</label>
										

											<label for="cheque">
                <input type="radio" name="delivery" id="delivery_2" value="No" <?php if($shopRow['shop_delivery'] == "No"){echo "checked";} ?>/>
                No</label>
										

										</div>
									</div>
									<!-- Shop service end -->

									<!-- Content start -->

									<div class="col-lg-12" style="border-top:solid 1px #ccc;">
										<h3 class="Rh3">Detailed contents</h3>
										<div class="form-group">
											<label for="keywords"> keywords </label>
											<textarea class="form-control" name="keywords"><?php echo $shopRow['shop_keywords']; ?></textarea>

										</div>
										<div class="form-group">
											<label for="description"> Shop Description </label>
											<textarea class="form-control" name="description"><?php echo $shopRow['shop_description']; ?></textarea>

										</div>
										<div class="form-group">
											<label for="profile"> Web Profile for Customers </label>
											<textarea class="form-control" name="profile"><?php echo $shopRow['shop_profile']; ?></textarea>

										</div>

									</div>
									<!-- Content end -->

									<!-- uploads start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc;">
										<h3 class="Rh3">Uploads</h3>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="comp_bannerimg"> Banner Image </label>
											<input class="form-control" type="text" name="bannerimg" id="bannerimg" data-toggle="modal" data-target="#exampleModal" data-whatever="bannerimg" readonly style="cursor: pointer;" placeholder="Click to select picture" />
											<div class="testimg1" id="testimg1">
												<img id="bannerimg1" class="testimage" src="<?php echo $shopRow['shop_picture']; ?>">

											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="comp_logoimg"> Logo Image </label>
											<input class="form-control" type="text" name="logoimg" id="logoimg" data-toggle="modal" data-target="#exampleModal" data-whatever="logoimg" readonly style="cursor: pointer;" placeholder="Click to select picture" />
											<div class="testimg1" id="testimg2">
												<img id="bannerimg2" class="testimage" src="<?php echo $shopRow['shop_logo']; ?>">
											</div>
										</div>
									</div>
									<script>
										$( '#bannerimg' ).focusin( function ( e ) {
											var rurl = $('#bannerimg').val();
											$('#bannerimg1').attr("src",rurl);
											if(rurl == ''){
												var usrpic = $('#userpic_old').val();
												$('#bannerimg1').attr("src",usrpic);
											}
											
										} );
										$( '#logoimg' ).focusin( function ( e ) {
											var rurl1 = $('#logoimg').val();
											$('#bannerimg2').attr("src",rurl1);
											if(rurl == ''){
												var usrpic = $('#userpic_old').val();
												$('#bannerimg2').attr("src",usrpic);
											}
										} );


									</script>
									

									
									
									
									
									<!--<script>
										$( '#bannerimg' ).change( function ( e ) {
											$( '#testimg1' ).html( '' );
											for ( var i = 0; i < e.originalEvent.target.files.length; i++ ) {
												var file = e.originalEvent.target.files[ i ];
												var img = document.createElement( "img" );
												var reader = new FileReader();
												img.className = "testimage";
												img.id = "bannerimg1";

												reader.onloadend = function () {
													img.src = reader.result;
												}
												reader.readAsDataURL( file );
												//$("input").after(img);
												document.getElementById( "testimg1" ).appendChild( img );
											}
										} );



										$( '#logoimg' ).change( function ( e ) {
											$( '#testimg2' ).empty();
											for ( var i = 0; i < e.originalEvent.target.files.length; i++ ) {
												var file = e.originalEvent.target.files[ i ];
												var img = document.createElement( "img" );
												var reader = new FileReader();
												img.className = "testimage";
												img.id = "bannerimg2";

												reader.onloadend = function () {
													img.src = reader.result;
												}
												reader.readAsDataURL( file );
												//$("input").after(img);
												document.getElementById( "testimg2" ).appendChild( img );
											}
										} );
									</script>-->
									
									
									<!-- uploads end -->
									
									<!-- row 3 start -->
									<!-- Category start -->
          						
          <div class="col-lg-12" style="background-color:#E6E6E6;">
          <?php print_r($_POST); ?>
           <details>
			   <summary style="margin-bottom: 20px;"><span style="font-size: 25px;">Category </span> <span style="font-size: 15px;"> related to the shop </span> <span style="font-size: 12px; color: blue;">Show/Hide <span style="font-size: 20px;">⇕</span></span> </summary>

            <div class="form-group rrcheckbox" > 
                 
              <!-- category row start -->
<?php
function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}


function removeElementWithValue($array, $key, $value){
     foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
               unset($array[$subKey]);
          }
     }
     return $array;
}
?>
              <?php

			  $RPstyl = "";
			  $comemain2 = "";
			  $cate_select = $db->query("select * from `categories` where `categories`.`status`='on' ORDER BY `categories`.`cate_parent` ASC, `cate_main` ASC, `cate_list` ASC");
			  while ($cate_main = $cate_select->fetch_assoc()){
				  $cate_full[] = $cate_main;
			  }
			  //$filteredArray1 = array_filter($cate_full, function ($var){return ($var['cate_main'] == '999');});
			  $filteredArray1 = unique_multidim_array($cate_full,'cate_parent'); 
			  foreach($filteredArray1 as $cate_full_array1){
				  //echo "<div class='col-md-6 col-sm-6 col-xs-12 RClist'>";
					  echo "<div class='Rlist_mm'><div class='RClistM'>".$cate_full_array1['cate_parent']."</div>";
				  $cprnt = $cate_full_array1['cate_parent'];
				  $filteredArray2 = array_filter($cate_full, function ($var) use ($cprnt) {return ($var['cate_parent'] == $cprnt);});
				  $filteredArray2 = unique_multidim_array($filteredArray2,'cate_main');

					
				  foreach($filteredArray2 as $cate_fmain2){
					  $clist = $cate_fmain2['cate_main'];
					  $filteredArray3 = array_filter($cate_full, function ($var) use ($clist) {return ($var['cate_main'] == $clist);});
					  $filteredArray3 = removeElementWithValue($filteredArray3, "cate_list", 999);
					  if(count($filteredArray3) > 0){$RPstyl = " class='listplus' ";}else{$RPstyl = " class='listplus2' ";}
						
						
					  if($cate_fmain2['cate_main'] != '999' && ($comemain2 == "" || $comemain2 != $cate_fmain2['cate_main'])){
						  echo "<ul class='RulList'>";
						  echo "<li><div ".$RPstyl."> + </div> <input class='parent1' name='cateM[]' type='checkbox' value='".$cate_fmain2['id']."^_main^_".$cate_fmain2['cate_main']."'> ";
						  echo $cate_fmain2['cate_main'];
						  //echo " <span class='Rcount'>".count($filteredArray3)."</span>";
						  $comemain2 = $cate_fmain2['cate_main'];
					  }
					  $filteredArray3 = unique_multidim_array($filteredArray3,'cate_list');
					  echo "<ul class='RRChilds' style='display:none;'>";
					  foreach($filteredArray3 as $cate_flist2){
						  if($cate_flist2['cate_list'] != "999" && $cate_flist2['cate_main'] = $cate_fmain2['cate_main'] && $cate_flist2['cate_parent'] = $cate_fmain2['cate_parent']){
							  echo "<li>";
							  echo "<label class='checkbox-inline'>";
							  echo "<input name='cateL[]' type='checkbox' value='".$cate_flist2['id']."^_list^_".$cate_flist2['cate_list']."'>";
							  echo $cate_flist2['cate_list']." </label>";
							  echo "</li>";
						  }
					  }
					  echo "</ul>";
					  echo "</li></ul>";
					 // echo "</div>";
				  }
				  echo "</div>";
			  }
				  
				  
				  
				?>

              <script>
			  /*for company category list*/
				$(document).ready(function () {
					$("div.listplus").click(function () {
						//$("li > ul", this).toggle();

						$(this).siblings('ul').slideToggle('slow');
					});
				});/*for company category list*/
/*for company category list auto select*/	  
$('li :checkbox').on('click', function () {
    var $chk = $(this),
        $li = $chk.closest('li'),
        $ul, $parent;
    if ($li.has('ul')) {
        $li.find(':checkbox').not(this).prop('checked', this.checked)
    }
    do {
        $ul = $li.parent();
        $parent = $ul.siblings(':checkbox');
        if ($chk.is(':checked')) {
            $parent.prop('checked', $ul.has(':checkbox:not(:checked)').length == 0)
        } else {
            $parent.prop('checked', false)
        }
        $chk = $parent;
        $li = $chk.closest('li');
    } while ($ul.is(':not(.someclass)'));
});/*for company category list auto select*/

				</script> 
              <!-- category row end --> 
              

            </div>
			  </details>
          </div>
          							<!-- Category end --> 
									<!-- row 3 end -->
									
									<!-- Button start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc; text-align: right; padding: 15px 0 15px 0;">

										<input class="btn btn-warning btn-lg" type="submit" name="submit" value="Submit Form">
										<input class="btn btn-default btn-lg" type="reset" name="reset" value="Reset Form">

									</div>
									<!-- Button end -->
									
									
									
									
									
									
									<div class="col-lg-12">
									<input type="text" name="bannerimgold" value="<?php echo $shopRow['shop_picture']; ?>" />
									<input type="text" name="logoimgold" value="<?php echo $shopRow['shop_logo']; ?>" />
									<?php
									$token = uniqid( '', true );
									$_SESSION[ 'token' ] = $token;
									$thishopnof = implode(',',$thishopno);
									?>
								<input type="hidden" name="token" value="<?php echo $token; ?>"/>
								<input type="hidden" name="shopid" value="<?php echo $shopRow['shop_id'] ?>" />
								<input type="hidden" name="shopnos_old" value="<?php echo $thishopnof; ?>"  />
								<input type="hidden" name="shopstatus" value="<?php echo $shopRow['shop_status'];?>" />
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- C-main column end -->
				</div>
				<!-- row 2 end -->
				
				
			</div>
			<!-- C-main column end -->
		</div>
		<!-- container row end -->
	</div>
	<!-- container end -->
	<?php include('shop_footer.php'); ?>
	<script>
		$(document).ready (function(){
			$("#success-alert").delay(5000).hide(500);
		 });
	</script>
</body>

</html>