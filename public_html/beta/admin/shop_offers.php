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
$page_name = "shop_offers";
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
include('../Connections/fun_c_tion.php');
include('../Connections/functionsL.php');


?>
<?php
if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}


//privilage start date and privilage end date from db
$shpId	=	isset($_GET['sid'])?$_GET['sid']:''; // 99 is a dummy value remove it
if(isset($_GET['sid'])){$_SESSION['shop_id'] = $shpId; $shpId = $_SESSION['shop_id'];}


$checkUrlID	=	mysqli_query($db,"SELECT * FROM shop_details WHERE shop_id = '$shpId'");
if(mysqli_num_rows($checkUrlID) == 0){
 	header("Location: shop_list.php"); 
		exit();
}

/*$getShopData	= "SELECT `shop_priv_start`,`shop_priv_end` FROM `shop_details` WHERE `shop_id` = '$shpId' AND 
 				  `shop_priv_start` <= '".$_SESSION['now']."' and  `shop_priv_end` >= '".$_SESSION['now']."'";*/
$getShopData	= "SELECT `shop_priv_start`,`shop_priv_end` FROM `shop_details` WHERE `shop_id` = '$shpId'";
$getShopDetails  = mysqli_query($db,$getShopData);

/*if(mysqli_num_rows($getShopDetails) <= 0){
	header( "Location: shop_offer_list.php");
	exit;
}*/
$getDateDetails	= mysqli_query($db,$getShopData);
$getDate	=	mysqli_fetch_array($getDateDetails);

$startDate	=	$getDate['shop_priv_start'];
$endDate	=	$getDate['shop_priv_end'];
$date1 = strtr($startDate, '-', '/');
 $privilageStartDate =  date('d/m/Y  H:i:s', strtotime($date1));
$date2 = strtr($endDate, '-', '/');
$privilageEndDate =  date('d/m/Y  H:i:s:', strtotime($date2));


$_SESSION['privillage_start_date']	=	$privilageStartDate;
$_SESSION['privillage_end_date']	=	$privilageEndDate;

if(isset($_POST['offername']) &&  $session_tokens == $tokens){
	$sessionStartDate	=	strtr($_SESSION['privillage_start_date'], '/', '-');
	$sessionEndDate		=	strtr($_SESSION['privillage_end_date'], '/', '-');
	if(isset($_POST['daterange']) ){
					//Get start date and end date after form submission
			$offerDate 			= explode(' - ', $_POST['daterange']);
			$startDate = strtr($offerDate[0], '/', '-');
			$endDate   = strtr($offerDate[1], '/', '-');

			$startDateByPost	= date('d-m-Y',strtotime($startDate));
			$endDateByPost		= date('d-m-Y',strtotime($endDate));

			//$dateRangeOverlaps = $sessionStartDate <= $startDateByPost and $endDateByPost <= $sessionEndDate;
			//if($dateRangeOverlaps){
				$objOfferL	= new Offer();
				$objOfferL->page_name = 'shop_offers';
				$hiddenOfferId	=	'';
				$offerIdByUrl	=	''; 
				$hiddenOfferId = (isset($_POST['offerHiddenID'])) ? $_POST['offerHiddenID']:'No hidden id';
				$offerIdByUrl  = (isset($_GET['fid'])) ? $_GET['fid']:'No url ID';

				if($hiddenOfferId == $offerIdByUrl ){
					$objOfferL->m_offer();
					header("Location: shop_offer_list.php");
				}
				else{
					$objOfferL->c_offer();
					echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Success! </strong>Offer created successfully.</div>";
				}
			/*}else{ 
				echo "<div class='alert alert-danger' id='success-alert' style='text-align:center;'>
						<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
						<strong>Failed</strong> Invalid Date</div>";
		 }	*/

	}
	
}

?>
<?php
$offerDaterange = date('d/m/Y', strtotime($_SESSION['now']))." - ".date('d/m/Y', strtotime($_SESSION['now']));
if(!empty($_GET['fid']) && $_GET['f'] == 'edit'){
	
	$offerId = $_GET['fid'];
	$resultData = mysqli_query($db,"SELECT * FROM `offer_dmg` WHERE `offer_id` = '$offerId' AND `offer_status` != 'delete'  ");
	$offerDataE = mysqli_fetch_array($resultData);	
	$startDate	= $offerDataE['offer_start'];
	$endDate	= $offerDataE['offer_end'];	
	
	$offerStart	=	strtr($startDate, '-', '/');
	$offerEnd	=	strtr($endDate, '-', '/');
	
	$ofrStart 	= date('d/m/Y H:i:s', strtotime($offerStart));
	$ofrEnd 	= date('d/m/Y H:i:s', strtotime($offerEnd));
	$offerDaterange	= $ofrStart." - ".$ofrEnd;
}
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Shop Offers :: Dragon Mart Guide</title>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
  
  
  <!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

 </head>


</head>
<body>
<?php print_r($_SESSION); ?>
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
							<div class="C-dash1">Offer Settings 
							<form name="work" method="post" style="display: inline;">
							<a href = "shop_offers.php" class = "btn btn-xs btn-success" style="display: inline;" title = "New Offer">New Offer</a>
							<a href = "shop_offer_list.php" class = "btn btn-xs btn-primary" style="display: inline;" title = "View Offers">View Offers</a>
							
							</form>
							</div>
						</div>
						<div class="row">
						
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

								<form name="register_form" id="register_form" method="post" enctype="multipart/form-data">
								<input type = "hidden" name = "offerHiddenID" id = "offerHiddenID" value ="<?php if(isset($offerId)) echo $offerId ;?>">
									<!-- user registration start -->
									
										<h3 class="Rh3">Offer Info</h3>
										<div class="form-group">
											<label for="offername"> Offer Name </label>
											<input type = "hidden" name = "companyID" id = "companyID" value = "<?php echo $shpId;?>">
										
												<!--<input type = "hidden" name = "startDate" id = "startDate" value = "<?php //echo $privilageStartDate;?>">
												<input type = "hidden" name = "endDate" id = "endDate" value = "<?php //echo $privilageEndDate;?>">-->
												
											
											<input class="form-control" id="offername" name="offername" type="text" value="<?php if(isset($offerDataE['offer_name']))echo $offerDataE['offer_name']; ?>" required="required" placeholder="Offer Name" />
										</div>
										<div class="input-group">
											<span style="color: red" id="spanOfferName">Invalid Name</span>
										</div>
										<div class="form-group">
											<label for="offertype">Offer Type</label>
											<select name="offertype" id="offertype" class="form-control" required>
												<option value="" class="showSingle" target="0">- - - Select offer type - - - </option>
												<option value="discount" <?php if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'discount') echo "selected" ;?> class="showSingle" target="1">Discount Offer</option>
												<option value="flat" <?php if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'flat') echo "selected" ;?> class="showSingle" target="2">Flat Sale</option>
												<option value="buy-get" <?php if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'buy-get') echo "selected" ;?> class="showSingle" target="3">Buy & Get</option>
												<option value="cashback" <?php if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'cashback') echo "selected" ;?> class="showSingle" target="4">Cashback Offer</option>
												<option value="scratch-win" <?php if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'scratch-win') echo "selected" ;?> class="showSingle">Scratch & Win</option>
												<option value="exchange" <?php if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'exchange') echo "selected" ;?> class="showSingle">Exchange Offer</option>
												<option value="mall-offer" <?php if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'mall-offer') echo "selected" ;?> class="showSingle">Mall Offer</option>
											</select>
										</div>
										
										
										<div class="form-group targetDiv" id="div1" >
											<label for="offer_discount">Discount Offer</label>
											<div class="input-group">
												<input type="number" name="percentage" id="percentage" class="form-control offerL" aria-describedby="basic-addon1" placeholder="Percentage" value = "<?php if(isset($offerDataE['offer_type_1']) && $offerDataE['offer_type'] == 'discount' ){echo $offerDataE['offer_type_1'];} ?>">
												<span class="input-group-addon" id="basic-addon2">% Percentage</span>
											</div>
											
											<label for="offer_discount" style="text-align: center; width: 100%;">(Or)</label>
											<div class="input-group">
												<input type="number" name="dirhams" id="dirhams" class="form-control offerL" aria-describedby="basic-addon1" placeholder="AED Dirhams" value = "<?php if(isset($offerDataE['offer_type_2']) && $offerDataE['offer_type'] == 'discount' )echo $offerDataE['offer_type_2']; ?>">
												<span class="input-group-addon" id="basic-addon2">AED Dirhams</span>
											</div>
											<div class="input-group" id = "spanID">
											<span style="color: red" id="spanPercentage">Choose any one of the discount offer</span>
											</div>
										</div>
										<div class="form-group targetDiv" id="div2">
											<label for="offer_Flat">Flat Offer Sales</label>
											<div class="input-group">
												<input type="number" id = "flatPercentageS" name="Flat-percentageS" class="form-control  flatpercent" aria-describedby="basic-addon1" placeholder="Percentage" value = "<?php if(isset($offerDataE['offer_type_1']) && $offerDataE['offer_type'] == 'flat' )echo $offerDataE['offer_type_1']; ?>">
												<span class="input-group-addon" id="basic-addon2">% Percentage</span>
											</div>
											<label for="offer_discount" style="text-align: center; width: 100%;">(TO)</label>
											<div class="input-group">
												<input type="number" name="Flat-percentageE" id="flatPercentageE" class="form-control flatpercent" aria-describedby="basic-addon1" placeholder="Percentage" value = "<?php if(isset($offerDataE['offer_type_2']) && $offerDataE['offer_type'] == 'flat' )echo $offerDataE['offer_type_2']; ?>">
												<span class="input-group-addon" id="basic-addon2">% Percentage</span>
											</div>
											<div class="input-group">
											<span style="color: red" id="spanflatOfferL">Fill both fields of Flat Offer Sales</span>
											</div>
										</div>
										<div class="form-group targetDiv" id="div3">
											<label for="buy-get1">Buy & Get offer</label>
											<div class="input-group">
												<input type="number" id = "buy" name="buy-get1" class="form-control  buyGetL" aria-describedby="basic-addon1" placeholder="Buy" value = "<?php if(isset($offerDataE['offer_type_1']) && $offerDataE['offer_type'] == 'buy-get' )echo $offerDataE['offer_type_1']; ?>"><span class="input-group-addon" id="basic-addon1">Buy</span></span>
											</div>
											<label for="buy-get2" style="text-align: center; width: 100%;">(AND)</label>
											<div class="input-group">
												<input type="number" id ="get" name="buy-get2" class="form-control  buyGetL" aria-describedby="basic-addon1" placeholder="Get" value = "<?php if(isset($offerDataE['offer_type_2']) && $offerDataE['offer_type'] == 'buy-get' )echo $offerDataE['offer_type_2']; ?>">
												<span class="input-group-addon" id="basic-addon2">Get</span>
											</div>
											<div class="input-group">
											<span style="color: red" id="spanBuyGetOfferL">
												Buy & Get percentage required
											</span>
											</div>
										</div>
										<div class="form-group targetDiv" id="div4">
											<label for="purchase">Cash back offer</label>
											<div class="input-group">
												<input type="number" id = "purchase" name="purchase" class="form-control cashBackL" aria-describedby="basic-addon1" placeholder="Purchase" value = "<?php if(isset($offerDataE['offer_type_1']) && $offerDataE['offer_type'] == 'cashback' )echo $offerDataE['offer_type_1']; ?>">
												<span class="input-group-addon" id="basic-addon2">Purchase AED</span>
											</div>
											<label for="cashback" style="text-align: center; width: 100%;">(Get)</label>
											<div class="input-group">
												<input type="number" name="cashback" class="form-control cashBackL" aria-describedby="basic-addon1" id = "cashback" placeholder="Cashback" value = "<?php if(isset($offerDataE['offer_type_2']) && $offerDataE['offer_type'] == 'cashback' )echo $offerDataE['offer_type_2']; ?>">
												<span class="input-group-addon" id="basic-addon2">Cashback AED</span>
											</div>
											<div class="input-group">
											<span style="color: red" id="spanCashbackOfferL">
												Enter purchase & cashback Offers
											</span>
											</div>
										</div>
										<div class="form-group">
											<label for="purchase">Offer Details</label>
											<textarea class="form-control" name="offerdetails" id="offerdetails" rows="5"><?php if(isset($offerDataE['offer_details']))echo $offerDataE['offer_details']?></textarea>
										</div>
									<script>
									jQuery(function(){
											 //jQuery('#showall').click(function(){
												   jQuery('.targetDiv').hide();
											//});
											jQuery('.showSingle').click(function(){
												  jQuery('.targetDiv').hide();
												  jQuery('#div'+$(this).attr('target')).show();
											});
										<?php 
											if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'discount') echo "jQuery('#div1').show()" ;
										    else if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'flat') echo "jQuery('#div2').show()" ;
											else if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'buy-get') echo "jQuery('#div3').show()" ;
											else if(isset($offerDataE['offer_type']) && $offerDataE['offer_type'] == 'cashback') echo "jQuery('#div4').show()" ;
										   
										
										?>
									});
									</script>
										<div class="form-group">
											<label for="daterange"> Offer Date <span class="text-info">Select date from to</span></label>

											<input class="form-control" type="text" name="daterange" value="<?php if(isset($offerDaterange)) echo $offerDaterange;?>" />
 									
									<script type="text/javascript">
									$(function() {
										startDate = $('#startDate').val();
										endDate = $('#endDate').val();
										$('input[name="daterange"]').daterangepicker({
											//minDate: startDate,
											//maxDate: endDate,
											minDate: '<?php echo $privilageStartDate;?>',
											maxDate: '<?php echo $privilageEndDate;?>',
											timePicker: true,
											//timePickerIncrement: 30,
											locale: {
												format: 'DD/MM/YYYY h:mm A'
											}
										});
									});
									</script>
											
										</div>
										
										
										
									<!-- uploads start -->
									<!--<div class="col-lg-12" style="border-top:solid 1px #ccc;">
										<h3 class="Rh3">Uploads</h3>
									</div>-->
									<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">-->
										<div class="form-group">
											<label for="comp_bannerimg"> Image <span class="text-info">File: .jpg, .png and .gif only allowed </span></label>
											<!--<input class="form-control" type="file" name="bannerimg" id="bannerimg"/>-->
											<input class="form-control" type="text" name="bannerimg" id="bannerimg" value="<?php if(isset($offerDataE['offer_picture'])) echo $offerDataE['offer_picture'];  ?>"  data-toggle="modal" data-target="#exampleModal" data-whatever="bannerimg" readonly placeholder="Click to select picture"/>
											
											<div class="testimg1" id="testimg1">
												<img id="bannerimg1" class="testimage" src="<?php if(isset($offerDataE['offer_picture'])) echo $offerDataE['offer_picture'];  ?>">

											</div>
											<div class="input-group">
											<span style="color: red" id="spanIdImageL">
												Please select image
											</span>
											</div>
										</div>
									<!--</div>-->
									
									<script>
										$( '#bannerimg' ).focusin( function ( e ) {
											var rurl = $('#bannerimg').val();
											$('#bannerimg1').attr("src",rurl);
											if(rurl == ''){
												var usrpic = $('#userpic_old').val();
												$('#bannerimg1').attr("src",usrpic);
											}
										} );


									</script>
									
									
									<!-- uploads end -->
									
									
									<?php
										$token = uniqid( '', true );
										$_SESSION[ 'token' ] = $token;
									?>
								
								<input type="hidden" name="token" value="<?php echo $token; ?>"/>

									<!-- Button start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc; text-align: right; padding: 15px 0 15px 0;">

										<input class="btn btn-warning btn-lg" title = "Submit" type="submit" id="submit" name="submit" value="Submit Form">
										<input class="btn btn-default btn-lg" title = "Reset"  type="reset" name="reset" id = "reset" value="Reset Form">
										
									</div>
									<!-- Button end -->
									
									
									
									
									
									
								<div class="col-lg-12">
								
								<?php
								$token = uniqid( '', true );
								$_SESSION[ 'token' ] = $token;
								?>
								
								<input type="hidden" name="token" value="<?php echo $token; ?>"/>
								<input type="hidden" name="userID" value="<?php if(isset($userRow['user_id'])){echo $userRow['user_id'];} ?>"/>
								<input type="hidden" name="userpic_old" id="userpic_old" value="<?php if(isset($offerDataE['offer_picture'])) echo $offerDataE['offer_picture'];  ?>"  />
								<textarea name="shopids_old" style="display: none;"><?php if(isset($userRow['user_shops'])){echo $userRow['user_shops'];} ?></textarea>
								
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
	
</body>

</html>




<script type="text/javascript" src="js/shop_offers.js">
	//alert('success');
</script>