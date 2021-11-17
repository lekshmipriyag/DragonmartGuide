<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
$page_type = "shop_side";
$page_name = "shop_offer_list";
include('../Connections/permission.php');
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "$permission";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
include( '../Connections/dragonmartguide.php' );
include( '../Connections/functionsL.php' );
$userloginID	=	$_SESSION['loginUserid'];

//Delete offer based on offerId and action = deloffer
if(!empty($_GET['deleteofferId']) && $_GET['action'] == 'deloffer'){

$objOfferL				= new Offer();
$objOfferL->tableName	= "offer_dmg";
$objOfferL->delColumnId = $_GET['deleteofferId'];
$objOfferL->page_name	= 'offer_list';
$objOfferL->liveuser	= $_SESSION['MM_Username'];
$objOfferL->status   	= 'delete'	;	
$objOfferL->deleteData();
	echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Deleted.</div>";
}

?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Offer List :: Dragon Mart Guide</title>
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="../css/clientstyle.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	
	<!-- DataTables -->
	<link type="text/css" rel="stylesheet" href="../datatable/dataTables.bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="../datatable/responsive.bootstrap.min.css">
	<script type="text/javascript" src="../datatable/jquery.dataTables.min.js"></script> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../datatable/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="../datatable/responsive.bootstrap.min.js"></script>
	<!-- DataTables -->
	
</head>

<body>
<?PHP print_r($_SESSION); ?>
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
							<div class="C-dash1">Offer List
							<a href = "shop_offers.php" class = "btn btn-xs btn-success" style="display: inline;" title = "New Offer">New Offer</a>
							</div>
						</div>
						<div class="row">						
							<div class="col-lg-12 C-main-in">
							<?php  $totalProducts = mysqli_query($db,"SELECT count(*) AS TotalRecords FROM 									`offer_dmg` ");
								
								?>
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
							<div class="col-lg-12 C-main-in" style="padding-top: 15px;">
								<!--=== Responsive DataTable start ===-->
								<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25">
									<thead>
										<tr>
											<th>Shop Name</th>
											<th>Offer Name</th>
											<th>Offer Type</th>
											<th>Start</th>
											<th>End</th>
											<th>Controls</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if($_SESSION['live_user_type'] == "shopuser"){
									
										  $offerList = mysqli_query($db,"SELECT offer.*,shop.shop_name,shop.shop_number 							FROM `offer_dmg` offer
																			INNER JOIN shop_details shop 
																			ON shop.shop_id = offer.offer_shop_id
																			WHERE offer.offer_user_id ='$userloginID' AND offer.offer_status != 'delete'
																		 	ORDER BY offer.offer_cre DESC");
											
										}elseif($_SESSION['live_user_type'] == "adminuser"){
																			$offerList = mysqli_query($db, "SELECT offer.*,shop.shop_name,shop.shop_number FROM `offer_dmg` offer
																			INNER JOIN shop_details shop 
																			ON shop.shop_id = offer.offer_shop_id
																			WHERE  offer.offer_status != 'delete' 
											  								ORDER BY offer.offer_cre DESC");
											
											/*$userlist = mysqli_query($db, "SELECT * FROM `user_dmg` where `user_dmg`.`user_type`='shopuser'");
											
											while ($ulist = mysqli_fetch_array($userlist)){
												$shopuerlist[$ulist['user_id']] = $ulist['user_username'];
											} */
										}
										//die;
										 $rowCount = mysqli_num_rows($offerList);
										if($rowCount > 0){
											while ($offerDataL = mysqli_fetch_array($offerList)){ ?>
											<tr>							 
												<?php $offerId 			= $offerDataL['offer_id']; 
													  $offerShopId		=	$offerDataL['offer_shop_id'];
													  $offerUserId 		= $offerDataL['offer_user_id']; 
													$shopNumberSeries 	=  implode(',',unserialize($offerDataL['shop_number']));
												?>
												<td><?php echo $offerDataL['shop_name']." ( ".$shopNumberSeries." )"; ?></td>
												<td><?php echo $offerDataL['offer_name']; ?></td>
												<td><?php echo $offerDataL['offer_type']; ?></td>
												<td><?php echo $offerDataL['offer_start']; ?></td>
												<td><?php echo $offerDataL['offer_end']; ?></td>
											<!--	<td>
												  <?php 
													/*$currentDateTime=$_SESSION['now'];
												    $timesNow 		= new DateTime($currentDateTime);
													$datetime1  	= new DateTime($offerDataL['offer_end']);
													$datetime2  	= new DateTime($offerDataL['offer_start']);
												    $interval   	= $datetime1->diff($timesNow);
											        $dayL       	= $interval->format('%d');	
												    $monthL     	= $interval->format('%m');
													$yearL      	= $interval->format('%y');
													if($dayL <=0 && $monthL <=0 && $yearL <=0)
														echo "<span class='label label-danger'>OFF</span>";
													else
														echo "<span class='label label-success'>ON</span>"; */
													?>
												</td>-->
												<td>
													<?php
													if($offerDataL['offer_status'] == "on"){
														echo "<span class='label label-success'>Active</span>";
													}elseif($offerDataL['offer_status'] == "approval"){
														echo "<span class='label label-warning'>Approval</span>";
													}elseif($offerDataL['offer_status'] == "delete"){
														echo "<span class='label label-danger'>Delete</span>";
													}
													?>
											
												</td>
												<td>
													<a href = "shop_offers.php?f=edit&fid=<?php echo $offerId;?>&sid=<?php echo $offerShopId ?>" class = "glyphicon glyphicon-pencil" title="Edit">Edit</a>&nbsp
													<a href = "shop_offer_list.php?action=deloffer&deleteofferId=<?php echo $offerId;?>" class = "glyphicon glyphicon-trash" title = "Delete">Delete</a>
												</td>
											
											<?php
						
										}?>
										</tr>
										<?php }
										else{ ?>
											<tr>
												<td><span style="color: red;"><?php echo "No Records found";?></span>
												</td>
											</tr>				
										<?php } ?>
										</tbody>
									 </table>
										
										
								
								<!--=== Responsive DataTable end ===-->
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
	</div><!-- container end -->
<?php include('shop_footer.php'); ?>
<script>
	$(document).ready(function() {
    $('#example').DataTable();
	} );
</script>
</body>

</html>