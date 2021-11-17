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
$page_name = "shop_list";
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
//$thishopno = array();
//if ( isset( $_POST[ 'shop_select' ] ) ) {
//	$_SESSION[ 'shop_id' ] = $_POST[ 'shop_select' ];
//} elseif ( !isset( $_POST[ 'shop_select' ] ) && isset( $_SESSION[ 'shop_id' ] ) ) {
//	$_SESSION[ 'shop_id' ] = $_SESSION[ 'shop_id' ];
//}
include( '../Connections/dragonmartguide.php' );
include( '../Connections/fun_c_tion.php' );
//if ( isset( $_POST[ 'comp_name' ] ) && $_SESSION[ 'token' ] == $_POST[ 'token' ] ) {
//	$shopUpdt = new SHOP;
//	$shopUpdt->m_shop();
//}

//$shopid = $_SESSION['shop_id'];
//if($shopid == ""){$shopid = $usershoplist[0];}
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
//	echo "<script>alert('WARNING: Do not do like this anymore!');</script>";
//	echo "<meta http-equiv=\"refresh\" content=\"0;URL='".$_SERVER["PHP_SELF"]."'\" />";
//	//header("Location: shop_home.php");
//	exit();
//}
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Shop Listings :: Admin</title>
	<!--<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />-->
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css">
	<!--<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.css" />
<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />-->
	<link type="text/css" rel="stylesheet" href="../css/clientstyle.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	
	<!-- DataTables -->
	<link type="text/css" rel="stylesheet" href="../datatable/dataTables.bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="../datatable/responsive.bootstrap.min.css">
	
	<!--<script type="text/javascript" src="../datatable/jquery-1.12.4.js"></script>-->
	<script type="text/javascript" src="../datatable/jquery.dataTables.min.js"></script>
	<!--<script type="text/javascript" src="../datatable/dataTables.bootstrap.min.js"></script>--> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../datatable/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="../datatable/responsive.bootstrap.min.js"></script>
	<!-- DataTables -->
	
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
							<div class="C-dash1">Shop List</div>
							<div class="C-dash2">view and edit</div>
						</div>
						<div class="row">
						
						
						
						
						<!--<div class="col-lg-12 C-main-in">
								<div class="form-group">
									<form name="cngshop" method="post" enctype="multipart/form-data">
										<label for="shop_select"> Select Shop Name </label>
										<select name="shop_select" id="shop_select" class="form-control" onchange="submit();">

											<?php
											//$prmtshopids = implode(",", $_SESSION[ 'PermitedShop_ids' ]);
											//$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_id` IN ($prmtshopids)" );
											//while ( $prmt_row = mysqli_fetch_array($prmt_shops) ) {
												//$prmtArray = unserialize( $prmt_row[ 'shop_number' ] );
												?>

											<option value="<?php ///echo $prmt_row['shop_id']; ?>" <?php //if($_SESSION[ 'shop_id']==$prmt_row[ 'shop_id']){echo "selected";} ?> >
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
							<div class="col-lg-12 C-main-in" style="padding-top: 15px;">
								<!--=== Responsive DataTable start ===-->
								<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25">
									<thead>
										<tr>
											<th></th>
											<th>Shop Name</th>
											<th>Privilege</th>
											<th>Shop No</th>
											<th>User Name</th>
											<th>Mall</th>
											<th>Zone</th>
											
											<th>Categories</th>
											<th>Since</th>
											<th>Status</th>
											<th>Controls</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
										if($_SESSION['live_user_type'] == "shopuser"){

											$shoplist = mysqli_query($db, "SELECT * FROM `shop_details` WHERE `shop_user_id` = '$userloginID' AND `shop_status`='on' ORDER BY `shop_details`.`shop_name` ASC");
										}elseif($_SESSION['live_user_type'] == "adminuser"){
											$shoplist = mysqli_query($db, "SELECT * FROM `shop_details` ORDER BY `shop_details`.`shop_cre` DESC");
											
											$userlist = mysqli_query($db, "SELECT * FROM `user_dmg` where `user_dmg`.`user_type`='shopuser'");
											
											while ($ulist = mysqli_fetch_array($userlist)){
												$shopuerlist[$ulist['user_id']] = $ulist['user_username'];
											}
										}
										while ($slist = mysqli_fetch_array($shoplist)){
									?>
										<tr>
										<?php 
											

											$shID =$slist['shop_id'];
											$shopPrvEndDate	=	 $slist['shop_priv_end'];
											$currentDate	=	date('Y-m-d h:i:s');
											?>
											
											<td></td>	
											
												
																	
											<td style="position: relative;">
											
											<?php
											if($shopPrvEndDate > $currentDate ){
											echo "<span class='label label-success' style='position:absolute; top:0px; right:0px; border-radius:0px 0px 0px 5px; text-decoration: none;' title='Click here to add and edit offers...' >";
											
											echo "<a href = 'shop_offers.php?sid=$shID' style='color: #fff; text-decoration: none;'>Create Offer</a></span>";
											}
											?>
											
											<?php echo $slist['shop_name']; ?></td>
											<td>free, silver, gold, diamond</td>
											<td><?php echo implode(', ', unserialize($slist['shop_number'])); ?></td>
											<td><?php if(isset($shopuerlist[$slist['shop_user_id']])){echo $shopuerlist[$slist['shop_user_id']];}  ?></td>
											<td><?php echo $slist['shop_mall']; ?></td>
											<td><?php echo $slist['shop_zone']; ?></td>
											<td>
											<?php
											$catArray = json_decode($slist['shop_category'], true);
											//print_r($catArray);
											if(isset($catArray)){
											foreach($catArray as $cateArray){
												if(isset($cateArray['cate_level'])){$catLevel = $cateArray['cate_level'];}else{$catLevel = '';}
												
											if($catLevel == 2){echo "<span class='cate2'>".$cateArray['cate_main'].", </span>";}
											elseif($catLevel == 3){echo "<span class='cate3'>".$cateArray['cate_list'].", </span>";}
											}
											}
											?>
											</td>
											
											<td><?php echo $slist['shop_cre']; ?></td>
											<td>
											<?php
											if($slist['shop_status'] == "on"){
												echo "<span class='label label-success'ech>Active</span>";
											}elseif($slist['shop_status'] == "approval"){
												echo "<span class='label label-warning'>Approval</span>";
											}elseif($slist['shop_status'] == "del"){
												echo "<span class='label label-danger'>Delete</span>";
											}
											?>
											
											</td>
											<td>
											<?php if($_SESSION['live_user_type'] == 'adminuser'){?>
												<a href="shop_settings.php?id=<?php echo $slist['shop_id']; ?>"><span class="label label-primary">Edit</span></a>
											<?php } ?>
											
											<!--<a href="add_product.php?shopDataId=<?php //echo $slist['shop_id']; ?>"><span class="label label-info">New Product</span></a>-->
											<a href="product_list.php?shopId=<?php echo $slist['shop_id']; ?>"><span class="label label-warning">View Product</span></a>
											</td>
										</tr>
										<?php
										}
										
										?>
										
										
								

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