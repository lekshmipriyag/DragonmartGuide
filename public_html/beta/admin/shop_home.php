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
$page_name = "shop_home";
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
$thishopno = array();
if ( isset( $_POST[ 'shop_select' ] ) ) {
	$_SESSION[ 'shop_id' ] = $_POST[ 'shop_select' ];
} elseif ( !isset( $_POST[ 'shop_select' ] ) && isset( $_SESSION[ 'shop_id' ] ) ) {
	$_SESSION[ 'shop_id' ] = $_SESSION[ 'shop_id' ];
}
include( '../Connections/dragonmartguide.php' );
include( '../Connections/fun_c_tion.php' );
if ( isset( $_POST[ 'comp_name' ] ) && $_SESSION[ 'token' ] == $_POST[ 'token' ] ) {
	$shopUpdt = new SHOP;
	$shopUpdt->m_shop();
}



if($_SESSION['live_user_type'] == "shopuser"){
	
if(isset($_SESSION['shop_id'])){$shopid = $_SESSION['shop_id'];}else{$shopid = $usershoplist[0];}
	
	if(isset($_SESSION['PermitedShop_ids'])){$shop_user_shop_list = implode(',', $_SESSION['PermitedShop_ids']);}else{$shop_user_shop_list = 0;}
	
	$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_id` IN ($shop_user_shop_list) ORDER BY `shop_details`.`shop_name` ASC" );
	
	
	
	
}elseif($_SESSION['live_user_type'] == "adminuser"){
	$prmt_shpID = mysqli_query( $db, "select shop_id from `shop_details` where `shop_status` = 'on' ORDER BY `shop_details`.`shop_name` ASC LIMIT 1, 1" );
	$row_shpID = mysqli_fetch_array($prmt_shpID);
	
	if(isset($_SESSION['shop_id'])){$shopid = $_SESSION['shop_id'];}else{$shopid = $row_shpID['shop_id'];}
	
	$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_status` = 'on' ORDER BY `shop_details`.`shop_name` ASC" );
}
/*$shop_result = mysqli_query( $db, "select * from `shop_details` where `shop_details`.`shop_id`='$shopid'" );
$shopRow = mysqli_fetch_array( $shop_result );*/





/*if(in_array($shopid, $usershoplist) || $check_permission['user_type'] == "adminuser"){

$shop_result = mysqli_query( $db, "select * from `shop_details` where `shop_details`.`shop_id`='$shopid'" );
$shopRow = mysqli_fetch_array( $shop_result );

//if($shopid == ""){$shopid = 1;}
$no_result = mysqli_query( $db, "SELECT * FROM `shop_number` WHERE `sno_shopid` in (0, $shopid) AND `sno_status`='on' ORDER BY `shop_number`.`sno_shopid` ASC " );
while($noRow = mysqli_fetch_array( $no_result )){
	//$shopno[$noRow['sno_shopid']] = "'".$noRow['sno_number']."'";
	if($noRow['sno_shopid'] == $shopid) {$thishopno[] = $noRow['sno_number'];}else{$shopno[] = "'".$noRow['sno_number']."'";}
}
	}else{
	$_SESSION['shop_id'] = $_SESSION['PermitedShop_ids'][0];
	echo "<script>alert('WARNING: Do not do like this anymore!');</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL='".$_SERVER["PHP_SELF"]."'\" />";
	//header("Location: shop_home.php");
	exit();
}*/
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Untitled Document</title>
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
							<div class="C-dash1">Products</div>
							<div class="C-dash2">view and edit</div>
						</div>
						<div class="row">
						
						
						
						
						<div class="col-lg-12 C-main-in">
								<div class="form-group">
									<form name="cngshop" method="post" enctype="multipart/form-data">
										<label for="shop_select"> Select Shop Name </label>
										<select name="shop_select" id="shop_select" class="form-control" onchange="submit();">

											<?php
											//$prmtshopids = implode(",", $_SESSION[ 'PermitedShop_ids' ]);
											//$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_id` IN ($prmtshopids)" );
											while ( $prmt_row = mysqli_fetch_array($prmt_shops) ) {
												$prmtArray = unserialize( $prmt_row[ 'shop_number' ] );
												?>

											<option value="<?php echo $prmt_row['shop_id']; ?>" <?php if($shopid == $prmt_row[ 'shop_id']){echo "selected";} ?> >
												<?php echo $prmt_row['shop_name'] ?> (
												<?php sort($prmtArray); echo implode(",",$prmtArray); ?> )
											</option>
											<?php
											}
											?>
										</select>
									</form>
								</div>
							</div>
							
							
							
							
							
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
											<th>Name</th>
											<th>Picture</th>
											<th>Unit Type</th>
											<th>Stock</th>
											<th>Brand</th>
											<!--<th>Price</th>-->
											<th>Categories</th>
											<th>Updated</th>
											<th>Views</th>
											<th>Rank</th>
											<th>Status</th>
											<th>Controls</th>
										</tr>
									</thead>
									<tbody>
									<?php
										
										$shop_prodctList = mysqli_query($db, "SELECT * FROM `product_details` where `product_details`.`prodt_company_id` = '$shopid' AND `prodt_status` = 'on'");
										while($sopProducts = mysqli_fetch_array($shop_prodctList)){
									?>
										<tr>
											<td><?php echo $sopProducts['prodt_name']; ?></td>
											<td><div class="C-imgList"><img src="<?php echo $sopProducts['prodt_picture']; ?>" alt="<?php echo $sopProducts['prodt_name']; ?>"/></div></td>
											<td><?php echo $sopProducts['prodt_unite_type']; ?></td>
											<td><?php echo $sopProducts['prodt_size']; ?></td>
											<td><?php echo $sopProducts['prodt_brand']; ?></td>
											<!--<td>10</td>-->
											<td><?php echo $sopProducts['prodt_category']; ?></td>
											<td><?php echo date('d/m/Y', strtotime($sopProducts['prodt_modi']));  ?></td>
											<td><?php echo $sopProducts['prodt_views_count']; ?></td>
											<td><?php echo $sopProducts['prodt_ranking']; ?></td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
									<?php
										}
									?>
										<!--<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/nieman-marcus-09-2015-free-gift-w-125.jpg" alt=""/></div></td>
											<td>No</td>
											<td>52</td>
											<td>NA</td>
											<td>50</td>
											<td>Bag, Hand Bag</td>
											<td>2011/07/25</td>
											<td>215</td>
											<td>8422</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/neiman-marcus-06-2015-gwp-any-100.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>NA</td>
											<td>123</td>
											<td>Bag, Hand Bag</td>
											<td>2009/01/12</td>
											<td>540</td>
											<td>1562</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Travel Bag</td>
											<td><div class="C-imgList"><img src="../images/products/mb05-black-0.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>Raja</td>
											<td>22</td>
											<td>Travel Bag, Black Bag</td>
											<td>2012/03/29</td>
											<td>1789</td>
											<td>6224</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/m580_of1_44_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>Ram</td>
											<td>10</td>
											<td>Shirt, Mens wear</td>
											<td>2008/11/28</td>
											<td>2568</td>
											<td>5407</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimagesfg_mgizu.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>Samsung</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/12/02</td>
											<td>1426</td>
											<td>4804</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimages6j5nxjqr.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>Samsung</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/08/06</td>
											<td>6597</td>
											<td>9608</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shamboo</td>
											<td><div class="C-imgList"><img src="../images/products/dsc01984.jpg" alt=""/></div></td>
											<td>Mli</td>
											<td>1000</td>
											<td>Fa</td>
											<td>2</td>
											<td>greem</td>
											<td>2010/10/14</td>
											<td>4268</td>
											<td>6200</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Talcum</td>
											<td><div class="C-imgList"><img src="../images/products/download-9.jpg" alt=""/></div></td>
											<td>gram</td>
											<td>100</td>
											<td>Rook</td>
											<td>5</td>
											<td>Power, fashion</td>
											<td>2009/09/15</td>
											<td>358</td>
											<td>2360</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Fresh Juice</td>
											<td><div class="C-imgList"><img src="../images/products/cherry black tea-240x300.jpg" alt=""/></div></td>
											<td>Ltr</td>
											<td>100</td>
											<td>NA</td>
											<td>5</td>
											<td>Cool Drings, Juice</td>
											<td>2008/12/13</td>
											<td>458</td>
											<td>1667</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Tablet</td>
											<td><div class="C-imgList"><img src="../images/products/black_tea_-_box_1__1.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>GVO</td>
											<td>26</td>
											<td>medical, Medicin</td>
											<td>2008/12/19</td>
											<td>965</td>
											<td>3814</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Handle</td>
											<td><div class="C-imgList"><img src="../images/products/bc7bc164-ad3f-4a37-9d18-fa9e1aa56bd7.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>100</td>
											<td>NA</td>
											<td>10</td>
											<td>Door, Handle</td>
											<td>2013/03/03</td>
											<td>7589</td>
											<td>9497</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lady T-Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/b1003_bk_42_p.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>NA</td>
											<td>15</td>
											<td>T-shirt, Girl T-Shirt</td>
											<td>2008/10/16</td>
											<td>3957</td>
											<td>6741</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Brush</td>
											<td><div class="C-imgList"><img src="../images/products/764302400745.png" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>Diar</td>
											<td>4</td>
											<td>sa fsdaf dsa fsdf</td>
											<td>2012/12/18</td>
											<td>1489</td>
											<td>3597</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Greem</td>
											<td><div class="C-imgList"><img src="../images/products/764302211150.png" alt=""/></div></td>
											<td>Gram</td>
											<td>30</td>
											<td>&nbsp;</td>
											<td>9</td>
											<td>medical, Medicin</td>
											<td>2010/03/17</td>
											<td>6897</td>
											<td>1965</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Glass</td>
											<td><div class="C-imgList"><img src="../images/products/1490767446_ssunglasses-634x452-EN.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>&nbsp;</td>
											<td>50</td>
											<td>spectacles, </td>
											<td>2012/11/27</td>
											<td>495</td>
											<td>1581</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Still Camera</td>
											<td><div class="C-imgList"><img src="../images/products/1490702074_Cameras-634x452-en.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>2150</td>
											<td>Camera, still camera</td>
											<td>2010/06/09</td>
											<td>1423</td>
											<td>3059</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lip stick</td>
											<td><div class="C-imgList"><img src="../images/products/1490686017_beauty-en-634x452.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>fashion</td>
											<td>2009/04/10</td>
											<td>952</td>
											<td>1721</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bambers</td>
											<td><div class="C-imgList"><img src="../images/products/1490685994_baby-en-634x452.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>4</td>
											<td>baby wear</td>
											<td>2012/10/13</td>
											<td>1021</td>
											<td>2558</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Overcoat</td>
											<td><div class="C-imgList"><img src="../images/products/88704_of1_9d_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>45</td>
											<td>cloths</td>
											<td>2012/09/26</td>
											<td>1324</td>
											<td>2290</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Electronic coil</td>
											<td><div class="C-imgList"><img src="../images/products/3a66f57e-7a71-4232-b879-61e0f9589c18.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Electronic</td>
											<td>2011/09/03</td>
											<td>785</td>
											<td>1937</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										
										<tr>
											<td>Drings</td>
											<td><div class="C-imgList"><img src="../images/products/2-240x300.jpg" alt=""/></div></td>
											<td>Ltr</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Cool Drings, Juice</td>
											<td>2011/04/25</td>
											<td>150</td>
											<td>5421</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/nieman-marcus-09-2015-free-gift-w-125.jpg" alt=""/></div></td>
											<td>No</td>
											<td>52</td>
											<td>&nbsp;</td>
											<td>50</td>
											<td>Bag, Hand Bag</td>
											<td>2011/07/25</td>
											<td>215</td>
											<td>8422</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/neiman-marcus-06-2015-gwp-any-100.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>&nbsp;</td>
											<td>123</td>
											<td>Bag, Hand Bag</td>
											<td>2009/01/12</td>
											<td>540</td>
											<td>1562</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Travel Bag</td>
											<td><div class="C-imgList"><img src="../images/products/mb05-black-0.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>&nbsp;</td>
											<td>22</td>
											<td>Travel Bag, Black Bag</td>
											<td>2012/03/29</td>
											<td>1789</td>
											<td>6224</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/m580_of1_44_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Shirt, Mens wear</td>
											<td>2008/11/28</td>
											<td>2568</td>
											<td>5407</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimagesfg_mgizu.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/12/02</td>
											<td>1426</td>
											<td>4804</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimages6j5nxjqr.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/08/06</td>
											<td>6597</td>
											<td>9608</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shamboo</td>
											<td><div class="C-imgList"><img src="../images/products/dsc01984.jpg" alt=""/></div></td>
											<td>Mli</td>
											<td>1000</td>
											<td>&nbsp;</td>
											<td>2</td>
											<td>greem</td>
											<td>2010/10/14</td>
											<td>4268</td>
											<td>6200</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Talcum</td>
											<td><div class="C-imgList"><img src="../images/products/download-9.jpg" alt=""/></div></td>
											<td>gram</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>5</td>
											<td>Power, fashion</td>
											<td>2009/09/15</td>
											<td>358</td>
											<td>2360</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Fresh Juice</td>
											<td><div class="C-imgList"><img src="../images/products/cherry black tea-240x300.jpg" alt=""/></div></td>
											<td>Ltr</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>5</td>
											<td>Cool Drings, Juice</td>
											<td>2008/12/13</td>
											<td>458</td>
											<td>1667</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Tablet</td>
											<td><div class="C-imgList"><img src="../images/products/black_tea_-_box_1__1.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>26</td>
											<td>medical, Medicin</td>
											<td>2008/12/19</td>
											<td>965</td>
											<td>3814</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Handle</td>
											<td><div class="C-imgList"><img src="../images/products/bc7bc164-ad3f-4a37-9d18-fa9e1aa56bd7.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Door, Handle</td>
											<td>2013/03/03</td>
											<td>7589</td>
											<td>9497</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lady T-Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/b1003_bk_42_p.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>&nbsp;</td>
											<td>15</td>
											<td>T-shirt, Girl T-Shirt</td>
											<td>2008/10/16</td>
											<td>3957</td>
											<td>6741</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Brush</td>
											<td><div class="C-imgList"><img src="../images/products/764302400745.png" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>4</td>
											<td>sa fsdaf dsa fsdf</td>
											<td>2012/12/18</td>
											<td>1489</td>
											<td>3597</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Greem</td>
											<td><div class="C-imgList"><img src="../images/products/764302211150.png" alt=""/></div></td>
											<td>Gram</td>
											<td>30</td>
											<td>&nbsp;</td>
											<td>9</td>
											<td>medical, Medicin</td>
											<td>2010/03/17</td>
											<td>6897</td>
											<td>1965</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Glass</td>
											<td><div class="C-imgList"><img src="../images/products/1490767446_ssunglasses-634x452-EN.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>&nbsp;</td>
											<td>50</td>
											<td>spectacles, </td>
											<td>2012/11/27</td>
											<td>495</td>
											<td>1581</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Still Camera</td>
											<td><div class="C-imgList"><img src="../images/products/1490702074_Cameras-634x452-en.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>2150</td>
											<td>Camera, still camera</td>
											<td>2010/06/09</td>
											<td>1423</td>
											<td>3059</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lip stick</td>
											<td><div class="C-imgList"><img src="../images/products/1490686017_beauty-en-634x452.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>fashion</td>
											<td>2009/04/10</td>
											<td>952</td>
											<td>1721</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bambers</td>
											<td><div class="C-imgList"><img src="../images/products/1490685994_baby-en-634x452.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>4</td>
											<td>baby wear</td>
											<td>2012/10/13</td>
											<td>1021</td>
											<td>2558</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Overcoat</td>
											<td><div class="C-imgList"><img src="../images/products/88704_of1_9d_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>45</td>
											<td>cloths</td>
											<td>2012/09/26</td>
											<td>1324</td>
											<td>2290</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Electronic coil</td>
											<td><div class="C-imgList"><img src="../images/products/3a66f57e-7a71-4232-b879-61e0f9589c18.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Electronic</td>
											<td>2011/09/03</td>
											<td>785</td>
											<td>1937</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Drings</td>
											<td><div class="C-imgList"><img src="../images/products/2-240x300.jpg" alt=""/></div></td>
											<td>Ltr</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Cool Drings, Juice</td>
											<td>2011/04/25</td>
											<td>150</td>
											<td>5421</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/nieman-marcus-09-2015-free-gift-w-125.jpg" alt=""/></div></td>
											<td>No</td>
											<td>52</td>
											<td>&nbsp;</td>
											<td>50</td>
											<td>Bag, Hand Bag</td>
											<td>2011/07/25</td>
											<td>215</td>
											<td>8422</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/neiman-marcus-06-2015-gwp-any-100.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>&nbsp;</td>
											<td>123</td>
											<td>Bag, Hand Bag</td>
											<td>2009/01/12</td>
											<td>540</td>
											<td>1562</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Travel Bag</td>
											<td><div class="C-imgList"><img src="../images/products/mb05-black-0.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>&nbsp;</td>
											<td>22</td>
											<td>Travel Bag, Black Bag</td>
											<td>2012/03/29</td>
											<td>1789</td>
											<td>6224</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/m580_of1_44_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Shirt, Mens wear</td>
											<td>2008/11/28</td>
											<td>2568</td>
											<td>5407</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimagesfg_mgizu.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/12/02</td>
											<td>1426</td>
											<td>4804</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimages6j5nxjqr.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/08/06</td>
											<td>6597</td>
											<td>9608</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shamboo</td>
											<td><div class="C-imgList"><img src="../images/products/dsc01984.jpg" alt=""/></div></td>
											<td>Mli</td>
											<td>1000</td>
											<td>&nbsp;</td>
											<td>2</td>
											<td>greem</td>
											<td>2010/10/14</td>
											<td>4268</td>
											<td>6200</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Talcum</td>
											<td><div class="C-imgList"><img src="../images/products/download-9.jpg" alt=""/></div></td>
											<td>gram</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>5</td>
											<td>Power, fashion</td>
											<td>2009/09/15</td>
											<td>358</td>
											<td>2360</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Fresh Juice</td>
											<td><div class="C-imgList"><img src="../images/products/cherry black tea-240x300.jpg" alt=""/></div></td>
											<td>Ltr</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>5</td>
											<td>Cool Drings, Juice</td>
											<td>2008/12/13</td>
											<td>458</td>
											<td>1667</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Tablet</td>
											<td><div class="C-imgList"><img src="../images/products/black_tea_-_box_1__1.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>26</td>
											<td>medical, Medicin</td>
											<td>2008/12/19</td>
											<td>965</td>
											<td>3814</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Handle</td>
											<td><div class="C-imgList"><img src="../images/products/bc7bc164-ad3f-4a37-9d18-fa9e1aa56bd7.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Door, Handle</td>
											<td>2013/03/03</td>
											<td>7589</td>
											<td>9497</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lady T-Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/b1003_bk_42_p.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>&nbsp;</td>
											<td>15</td>
											<td>T-shirt, Girl T-Shirt</td>
											<td>2008/10/16</td>
											<td>3957</td>
											<td>6741</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Brush</td>
											<td><div class="C-imgList"><img src="../images/products/764302400745.png" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>4</td>
											<td>sa fsdaf dsa fsdf</td>
											<td>2012/12/18</td>
											<td>1489</td>
											<td>3597</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Greem</td>
											<td><div class="C-imgList"><img src="../images/products/764302211150.png" alt=""/></div></td>
											<td>Gram</td>
											<td>30</td>
											<td>&nbsp;</td>
											<td>9</td>
											<td>medical, Medicin</td>
											<td>2010/03/17</td>
											<td>6897</td>
											<td>1965</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Glass</td>
											<td><div class="C-imgList"><img src="../images/products/1490767446_ssunglasses-634x452-EN.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>&nbsp;</td>
											<td>50</td>
											<td>spectacles, </td>
											<td>2012/11/27</td>
											<td>495</td>
											<td>1581</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Still Camera</td>
											<td><div class="C-imgList"><img src="../images/products/1490702074_Cameras-634x452-en.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>2150</td>
											<td>Camera, still camera</td>
											<td>2010/06/09</td>
											<td>1423</td>
											<td>3059</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lip stick</td>
											<td><div class="C-imgList"><img src="../images/products/1490686017_beauty-en-634x452.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>fashion</td>
											<td>2009/04/10</td>
											<td>952</td>
											<td>1721</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bambers</td>
											<td><div class="C-imgList"><img src="../images/products/1490685994_baby-en-634x452.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>4</td>
											<td>baby wear</td>
											<td>2012/10/13</td>
											<td>1021</td>
											<td>2558</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Overcoat</td>
											<td><div class="C-imgList"><img src="../images/products/88704_of1_9d_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>45</td>
											<td>cloths</td>
											<td>2012/09/26</td>
											<td>1324</td>
											<td>2290</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Electronic coil</td>
											<td><div class="C-imgList"><img src="../images/products/3a66f57e-7a71-4232-b879-61e0f9589c18.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Electronic</td>
											<td>2011/09/03</td>
											<td>785</td>
											<td>1937</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Drings</td>
											<td><div class="C-imgList"><img src="../images/products/2-240x300.jpg" alt=""/></div></td>
											<td>Ltr</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Cool Drings, Juice</td>
											<td>2011/04/25</td>
											<td>150</td>
											<td>5421</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/nieman-marcus-09-2015-free-gift-w-125.jpg" alt=""/></div></td>
											<td>No</td>
											<td>52</td>
											<td>&nbsp;</td>
											<td>50</td>
											<td>Bag, Hand Bag</td>
											<td>2011/07/25</td>
											<td>215</td>
											<td>8422</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bags</td>
											<td><div class="C-imgList"><img src="../images/products/neiman-marcus-06-2015-gwp-any-100.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>&nbsp;</td>
											<td>123</td>
											<td>Bag, Hand Bag</td>
											<td>2009/01/12</td>
											<td>540</td>
											<td>1562</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Travel Bag</td>
											<td><div class="C-imgList"><img src="../images/products/mb05-black-0.jpg" alt=""/></div></td>
											<td>No</td>
											<td>500</td>
											<td>&nbsp;</td>
											<td>22</td>
											<td>Travel Bag, Black Bag</td>
											<td>2012/03/29</td>
											<td>1789</td>
											<td>6224</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/m580_of1_44_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Shirt, Mens wear</td>
											<td>2008/11/28</td>
											<td>2568</td>
											<td>5407</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimagesfg_mgizu.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/12/02</td>
											<td>1426</td>
											<td>4804</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Camera</td>
											<td><div class="C-imgList"><img src="../images/products/httpeu.chv.meimages6j5nxjqr.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>150</td>
											<td>Camera, spy camera</td>
											<td>2012/08/06</td>
											<td>6597</td>
											<td>9608</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Shamboo</td>
											<td><div class="C-imgList"><img src="../images/products/dsc01984.jpg" alt=""/></div></td>
											<td>Mli</td>
											<td>1000</td>
											<td>&nbsp;</td>
											<td>2</td>
											<td>greem</td>
											<td>2010/10/14</td>
											<td>4268</td>
											<td>6200</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Talcum</td>
											<td><div class="C-imgList"><img src="../images/products/download-9.jpg" alt=""/></div></td>
											<td>gram</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>5</td>
											<td>Power, fashion</td>
											<td>2009/09/15</td>
											<td>358</td>
											<td>2360</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Fresh Juice</td>
											<td><div class="C-imgList"><img src="../images/products/cherry black tea-240x300.jpg" alt=""/></div></td>
											<td>Ltr</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>5</td>
											<td>Cool Drings, Juice</td>
											<td>2008/12/13</td>
											<td>458</td>
											<td>1667</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Tablet</td>
											<td><div class="C-imgList"><img src="../images/products/black_tea_-_box_1__1.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>26</td>
											<td>medical, Medicin</td>
											<td>2008/12/19</td>
											<td>965</td>
											<td>3814</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Handle</td>
											<td><div class="C-imgList"><img src="../images/products/bc7bc164-ad3f-4a37-9d18-fa9e1aa56bd7.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Door, Handle</td>
											<td>2013/03/03</td>
											<td>7589</td>
											<td>9497</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lady T-Shirt</td>
											<td><div class="C-imgList"><img src="../images/products/b1003_bk_42_p.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>&nbsp;</td>
											<td>15</td>
											<td>T-shirt, Girl T-Shirt</td>
											<td>2008/10/16</td>
											<td>3957</td>
											<td>6741</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Brush</td>
											<td><div class="C-imgList"><img src="../images/products/764302400745.png" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>4</td>
											<td>sa fsdaf dsa fsdf</td>
											<td>2012/12/18</td>
											<td>1489</td>
											<td>3597</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Greem</td>
											<td><div class="C-imgList"><img src="../images/products/764302211150.png" alt=""/></div></td>
											<td>Gram</td>
											<td>30</td>
											<td>&nbsp;</td>
											<td>9</td>
											<td>medical, Medicin</td>
											<td>2010/03/17</td>
											<td>6897</td>
											<td>1965</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Glass</td>
											<td><div class="C-imgList"><img src="../images/products/1490767446_ssunglasses-634x452-EN.jpg" alt=""/></div></td>
											<td>No</td>
											<td>50</td>
											<td>&nbsp;</td>
											<td>50</td>
											<td>spectacles, </td>
											<td>2012/11/27</td>
											<td>495</td>
											<td>1581</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Still Camera</td>
											<td><div class="C-imgList"><img src="../images/products/1490702074_Cameras-634x452-en.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>2150</td>
											<td>Camera, still camera</td>
											<td>2010/06/09</td>
											<td>1423</td>
											<td>3059</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Lip stick</td>
											<td><div class="C-imgList"><img src="../images/products/1490686017_beauty-en-634x452.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>25</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>fashion</td>
											<td>2009/04/10</td>
											<td>952</td>
											<td>1721</td>
											<td><span class="label label-warning">Inactive</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Bambers</td>
											<td><div class="C-imgList"><img src="../images/products/1490685994_baby-en-634x452.jpg" alt=""/></div></td>
											<td>Pack</td>
											<td>100</td>
											<td>&nbsp;</td>
											<td>4</td>
											<td>baby wear</td>
											<td>2012/10/13</td>
											<td>1021</td>
											<td>2558</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Overcoat</td>
											<td><div class="C-imgList"><img src="../images/products/88704_of1_9d_vp.jpg" alt=""/></div></td>
											<td>No</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>45</td>
											<td>cloths</td>
											<td>2012/09/26</td>
											<td>1324</td>
											<td>2290</td>
											<td><span class="label label-success">Active</span></td>
											<td><span class="label label-default">Edit</span></td>
										</tr>
										<tr>
											<td>Electronic coil</td>
											<td><div class="C-imgList"><img src="../images/products/3a66f57e-7a71-4232-b879-61e0f9589c18.jpg" alt=""/></div></td>
											<td>Set</td>
											<td>10</td>
											<td>&nbsp;</td>
											<td>10</td>
											<td>Electronic</td>
											<td>2011/09/03</td>
											<td>785</td>
											<td>1937</td>
											<td><span class="label label-danger">Delete</span></td>
											<td>&nbsp;</td>
										</tr>-->
										
										

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