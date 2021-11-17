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
$page_type = "admin_side";
$page_name = "privilege_settings";
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

if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}

if($_SESSION['live_user_type'] == 'adminuser'){
	
	$getpriv_type	=	"SELECT * FROM settings where `sett_type`='privilege' AND `status`='on' ";
	$getResult	=	mysqli_query($db,$getpriv_type);
					
	if(isset($_POST['PrivShopName']) &&  $session_tokens == $tokens){
		
		$adDate 						= explode(' - ', $_POST['daterange']);	
		$startDate 						= strtr($adDate[0], '/', '-');
		$startDate						= date('Y-m-d H:i:s', strtotime($startDate));
		$endDate   						= strtr($adDate[1], '/', '-');
		$endDate						= date('Y-m-d H:i:s', strtotime($endDate));
		
		$Cpriv = new privileges;
		$Cpriv->shop_id 	= $_POST['PrivShopName'];
		$Cpriv->privType	= $_POST['priv_type'];
		$Cpriv->startdate	= $startDate;
		$Cpriv->enddate		= $endDate;
		$Cpriv->Cprivileges();
		header("Location: privilege_list.php");
	}
		
	}else{
	header("Location: ../index.php");
	exit;
}
	



//Edit privilege area start

	if(!empty($_GET['shpid']) && $_GET['f'] == 'edit' ){
		$shopid		= $_GET['shpid'];
	
		$result = mysqli_query($db,"SELECT * FROM `shop_details` WHERE `shop_id` = '$shopid' ");
		$shpData = mysqli_fetch_array($result);	
		$startDate	= $shpData['shop_priv_start'];
		$endDate	= $shpData['shop_priv_end'];	

		$shpStart	=	strtr($startDate, '-', '/');
		$shpEnd		=	strtr($endDate, '-', '/');

		$shpStart 	= date('d/m/Y H:i:s', strtotime($shpStart));
		$shpEnd 	= date('d/m/Y H:i:s', strtotime($shpEnd));
		$shpDaterange	= $shpStart." - ".$shpEnd;
		
	}
//Edit privilege area end




?>

<html>

<head>

	<meta charset="utf-8">
	<title>Privilege Settings :: Dragon Mart Guide</title>
	<link type="text/css" rel="stylesheet" href="../css/clientstyle.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
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
<?php
	print_r($_SESSION);

	
?>
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
							<div class="C-dash1">Privilege
							<form name="work" method="post" style="display: inline;">
							
							<a href = "privilege_settings.php" class = "btn btn-xs btn-success" style="display: inline;" title = "New Ad">New Privilege</a>
							<a href = "privilege_list.php" class = "btn btn-xs btn-primary" style="display: inline;" title = "Privilege List">Privilege List</a>
							
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

								<form name="privilege_form" id="privilege_form" method="post" enctype="multipart/form-data">
								<input type = "hidden" name = "shopHiddenID" id = "shopHiddenID" value ="<?php if(isset($shopid)) echo $shopid ;?>">
									<!-- user registration start -->
										<h3 class="Rh3">Shop Privilege Settings</h3>
										<div class="form-group">
											<label for="PrivShopName">Shop Name</label>
											
											<select name="PrivShopName" id="PrivShopName" class="form-control shpList" required>
											<script>
											$(document).ready(function(){
												var wheight = $('#PrivShopName').width();
												$('.RRSShop').css('width', wheight);
											});
											</script>
												<option value="" class="showSingle" target="0">- - - Select Shop - - -</option>
												<?php
												$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_status`='on' ORDER BY `shop_name` ASC" );
											
											while ( $prmt_row = mysqli_fetch_array($prmt_shops) ) {
												$prmtArray = unserialize( $prmt_row[ 'shop_number' ] );
												?>
											
											<option class="RRSShop" value="<?php if(isset($prmt_row['shop_id'])){echo $prmt_row['shop_id'];} ?>"<?php if(isset($shopid) && $shopid == $prmt_row[ 'shop_id']){echo "selected";} ?> ><?php echo $prmt_row['shop_name'] ?> (<?php sort($prmtArray); echo implode(", ",$prmtArray); ?>)
											</option>
											<?php
											}
												?>
											</select>
										
										</div>
										
										
										
										
										
										
										<div class="form-group">
											<label for="priv_type">Privilege</label>
											<select name="priv_type" id="priv_type" class="form-control shpList" required>
												<option value="" class="showSingle" target="0">- - - Select Privilege type - - -
												</option>
												<?php while($resultData = mysqli_fetch_array($getResult)){?>
												<option value = "<?php echo $resultData['sett_where'];?>" <?php if(isset($shpData['shop_priv_type']) == $resultData['sett_where']) echo 'selected'; ?>><?php echo ucwords(str_replace('_', ' ', $resultData['sett_where'])); ?></option>
												<?php }?>
												
											</select>
										</div>
										
								
								
										
										<div class="form-group">
											<label for="daterange"> Shop Privilege Date <span class="text-info">Select date from to</span></label>

											<input class="form-control" type="text" name="daterange" value="<?php if(isset($shpDaterange)) echo $shpDaterange;?>" />
 
									<script type="text/javascript">
									$(function() {
										//startDate = $('#startDate').val();
										//endDate = $('#endDate').val();
										$('input[name="daterange"]').daterangepicker({
											minDate: '22/07/2017',
											maxDate: '22/08/2018',
											timePicker: true,
											//timePickerIncrement: 30,
											locale: {
												format: 'DD/MM/YYYY h:mm A'
											}
										});
									});
									</script>
											
										</div>

									
										
										
									<?php
										$token = uniqid( '', true );
										$_SESSION[ 'token' ] = $token;
									?>
								
								<input type="hidden" name="token" value="<?php echo $token; ?>"/>
								<input type="hidden" name="userpic_old" id="userpic_old" value="<?php if(isset($adData['Ad_Picture'])) echo $adData['Ad_Picture'];  ?>"  />

									<!-- Button start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc; text-align: right; padding: 15px 0 15px 0;">

										<input class="btn btn-warning btn-lg" type="submit" id="submit" name="submit" value="Submit Form" title = 'Submit'>
										<input class="btn btn-default btn-lg" type="reset" name="reset" value="Reset Form" title="Reset">
										
									</div>
									<!-- Button end -->
									
									
									
									
									
									
								<div class="col-lg-12">
								
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


