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
$page_name = "product_list";
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
// RR Start
// Shop selected or not?
if ( isset( $_POST[ 'shop_select' ] ) ) {
	$_SESSION[ 'shop_id' ] = $_POST[ 'shop_select' ];
} elseif ( !isset( $_POST[ 'shop_select' ] ) && isset($_GET['shopId']) ) {
	$_SESSION[ 'shop_id' ] = $_GET['shopId'];
}
// RR End
include( '../Connections/dragonmartguide.php' );
include( '../Connections/functionsL.php' );
//$companyId = (isset($_GET['shopId']))?$_GET['shopId']:'';


// RR Start
if($_SESSION['live_user_type'] == "shopuser"){
	
if(isset($_SESSION['shop_id'])){$shopid = $_SESSION['shop_id'];}else{$shopid = $usershoplist[0];}
	
	if(isset($_SESSION['PermitedShop_ids'])){$shop_user_shop_list = implode(',', $_SESSION['PermitedShop_ids']);}else{$shop_user_shop_list = 0;}
	
	$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_id` IN ($shop_user_shop_list)" );
	
	if(isset($_GET['shopId'])){
		$getid = $_GET['shopId'];
	}
	
	if(isset($getid) && in_array($getid, $shop_user_shop_list)){
		$shopid = $_GET['shopId'];
	}
	
	
	
}elseif($_SESSION['live_user_type'] == "adminuser"){
	$prmt_shpID = mysqli_query( $db, "select shop_id from `shop_details` where `shop_status` = 'on' ORDER BY `shop_details`.`shop_name` ASC LIMIT 1, 1" );
	$row_shpID = mysqli_fetch_array($prmt_shpID);
	
	if(isset($_SESSION['shop_id'])){$shopid = $_SESSION['shop_id'];}else{$shopid = $row_shpID['shop_id'];}
	
	$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where `shop_status` = 'on' ORDER BY `shop_details`.`shop_name` ASC" );
	
	if(isset($_GET['shopId'])){
		$shopid = $_GET['shopId'];
	}
}
// RR End







?>
<?php
//Delete product based on prodId and action = delprod
if(!empty($_GET['deleteprodId']) && $_GET['action'] == 'delprod'){

$objProduct				= new Product();
$objProduct->tableName	= "product_details";
$objProduct->delColumnId = $_GET['deleteprodId'];
$objProduct->liveuser	= $_SESSION['MM_Username'];
$objProduct->status   	= 'delete'	;	
$objProduct->page_name	= 'product_list' ;
$objProduct->deleteProduct();
	echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Deleted.</div>";
}
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Product List :: Dragon Mart Guide</title>
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
							<div class="C-dash1">Product List
							<a href = "add_product.php" class = "btn btn-xs btn-success" style="display: inline;" title = "New Product">New Product</a>
							</div>
						</div>
						<div class="row">	
						
											
						<div class="col-lg-12 C-main-in">
								<div class="form-group">
									<form name="cngshop" method="post" enctype="multipart/form-data" action="product_list.php">
										<label for="shop_select"> Select Shop Name </label>
										<select name="shop_select" id="shop_select" class="form-control" onchange="submit();" >
										<script>
										$(document).ready(function(){
											var wheight  = $('#shop_select').width();
											$('.RRSShop').css('width', wheight);
										});
	
										</script>
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
											<th>Product Name</th>
											<th>Picture</th>
											<th>Unit Type</th>
											<th>Brand</th>
											<th>Categories</th>
											<th>Updated At</th>
											<th>Views</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
//											if($_SESSION['live_user_type'] == "shopuser"){
//											//$shIds = implode("','", $_SESSION['PermitedShop_ids']);
//												
//									
//										}elseif($_SESSION['live_user_type'] == "adminuser"){
//											$productList = mysqli_query($db, "SELECT * FROM `product_details` 
//											 WHERE 
//											  `prodt_status` != 'delete' 
//											  ORDER BY `product_details`.`prodt_cre` DESC");
//										}
										
										$q2 = "SELECT * FROM `product_details` WHERE `prodt_company_id`='$shopid' AND `prodt_status` !='delete' ORDER BY `product_details`.`prodt_cre` DESC";
									
										$productList = mysqli_query($db, $q2);
										
										
										while($productData	= mysqli_fetch_array($productList)){ ?>
										<tr>
										<?php
											$Jcategory = json_decode($productData['prodt_category'], true);
											$prodId = $productData['prodt_id'];
											$shopId	= $productData['prodt_company_id'];	
										?>
											<td title="<?php echo "Product Name "?>"><?php echo $productData['prodt_name']; ?></td>
											<td><img src="<?php echo $productData['prodt_picture']?> " alt="Product picture" style="width:100px;height:100px;"></td>
											<td><?php echo $productData['prodt_unite_type']; ?></td>
											<td><?php echo $productData['prodt_brand']; ?></td>
											<td>
											<?php
											foreach($Jcategory as $cat_disply){
												if($cat_disply['cate_level'] == 2){
													echo $cat_disply['cate_main'].", ";
												}elseif($cat_disply['cate_level'] == 3){
													echo $cat_disply['cate_list'].", ";
												}
											}
																						
											?>
											
											
											</td>
											<td><?php echo $productData['prodt_modi']; ?></td>
											<td><?php echo $productData['prodt_views_count']; ?></td>
											<td><?php echo $productData['prodt_status']; ?></td>
											<td>
												<a href = "add_product.php?action=edit&prodid=<?php echo $prodId ?>" class = "label label-primary" title = "Edit">Edit</a>&nbsp
													<a href = "product_list.php?action=delprod&deleteprodId=<?php echo $prodId;?>" class = "label label-danger" title = "Delete">Delete</a>
											</td>
									
										<?php }?>
										
										</tr>
								
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