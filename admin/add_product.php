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
$page_name = "add_product";
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

include('../Connections/dragonmartguide.php');
include('../Connections/fun_c_tion.php');
//include('../Connections/functionsL.php');

if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}

if($session_tokens == $tokens && isset($_POST['prod_name']) && isset($_POST['framework']) && $_POST['Prodts_id'] == ''){
	//echo "<script>alert('new product intiated');</script>";
	$INprdt = new Protuct;
	$INprdt->Cproduct();
}
if($session_tokens == $tokens && isset($_POST['prod_name']) && isset($_POST['framework']) && isset($_POST['Prodts_id']) && $_POST['Prodts_id'] != ''){
	//echo "<script>alert('product updates intiated');</script>";
	//echo "<script>alert('updated');</script>";
	$INsprdt = new Protuct;
	$INsprdt->Uproduct();
	//echo "<script>alert('updated');</script>";
}


if(isset($_POST['shop_select']) && !isset($_POST['prod_name']) ){
	$_SESSION['shop_id'] = $_POST['shop_select'];
	$shopid = $_SESSION['shop_id'];
	//echo "<script>alert('selected shop only');</script>";
	
}elseif(isset($_GET['shopDataId']) && $_GET['shopDataId'] != ''){
	$_SESSION['shop_id'] = $_GET['shopDataId'];
	$shopid = $_SESSION['shop_id'];
	//echo "<script>alert('selected shopDateId only');</script>";
}elseif(isset($_GET['prodid']) && isset($_GET['action']) && $_GET['prodid'] != '' && $_GET['action'] == 'edit'){
	//echo "<script>alert('get prodid and action edit only');</script>";
	$findProdt = mysqli_query($db, "SELECT * from `product_details` AS pro INNER JOIN `shop_details` AS shop on pro.prodt_company_id = shop.shop_id WHERE pro.prodt_id = '".$_GET['prodid']."'");
	$editProdt = mysqli_fetch_array($findProdt);
	
	if(!isset($editProdt['shop_user_id']) && $editProdt['shop_user_id'] != $_SESSION['loginUserid']){
		header( "Location: " . $_SERVER['HTTP_REFERER'] );
		exit;
	}
	$_SESSION['shop_id'] = $editProdt['prodt_company_id'];
	$shopid = $_SESSION['shop_id'];
}


if(isset($usershoplist[0]) && !isset($_SESSION['shop_id'])){
	$shopid = $usershoplist[0];
	$_SESSION['shop_id'] = $usershoplist[0];
	//echo "<script>alert('session shop id not set, so now setting');</script>";
}elseif(isset($usershoplist[0]) && isset($_SESSION['shop_id'])){
	$shopid = $_SESSION['shop_id'];
	//echo "<script>alert('session shop_id already there');</script>";
}
//echo "<script>alert('$shopid');</script>";

$q1 = "select * from `shop_details` where `shop_status`='on' AND `shop_id`='".$shopid."'";
$Sect_cate = mysqli_query($db, $q1);
$productDataE = mysqli_fetch_array($Sect_cate);
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Add Product :: Dragon Mart Guide</title>
	<link type="text/css" rel="stylesheet" href="../css/clientstyle.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
	</style>
	
	
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	

	<!-- Theme -->
	<link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
	

	<!-- General -->
	<script type="text/javascript" src="assets/js/libs/breakpoints.js"></script>
 <script type="text/javascript" src="plugins/respond/respond.min.js"></script> 
<!--	<script type="text/javascript" src="plugins/sparkline/jquery.sparkline.min.js"></script>-->

	<script type="text/javascript" src="plugins/typeahead/typeahead.min.js"></script> <!-- AutoComplete -->
	
	<script type="text/javascript" src="plugins/tagsinput/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="plugins/select2/select2.min.js"></script>  <!--Styled select boxes -->
	<!-- App -->
	<script type="text/javascript" src="assets/js/app.js"></script>
	<script type="text/javascript" src="assets/js/plugins.js"></script>
	
  
	
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
-->
	<script type="text/javascript" src="assets/js/custom.js"></script>
	<script type="text/javascript" src="assets/js/demo/form_components.js"></script>
	
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script><!--multi select dropdonw-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" /> <!--multi select dropdonw-->
	<!-- Demo JS -->

	<style>
		
/*
		img {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 5px;
			width: 150px;
		}

		img:hover {
			box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
		}
*/
</style>

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=li1rzf765fg4td9fk6hkuanxzbrlpvt6eo0ewzo38dzdotiw"></script>
  <script>tinymce.init({ selector:'#prod_desc, #prod_spec' });</script>

</head>

<body>
<div style="background-color: aliceblue;">
<?php
echo "<pre>";
print_r($_SESSION); ?>
</div>
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
							<div class="C-dash1"><?php if(isset($shopName)) echo "Shop Name : ".$shopName; ?></div>
							<div class="C-dash1">Add Product
							<form name="work" method="post" style="display: inline;">
							
							<a href = "add_product.php" class = "btn btn-xs btn-success" style="display: inline;" title = "New Product">New Product</a>
							<a href = "product_list.php" class = "btn btn-xs btn-primary" style="display: inline;" title = "View Products">View Products</a>
							
							</form>
							</div>
						</div>
						<div class="row">
						
						
						
						
						<div class="col-lg-12 C-main-in">
								<div class="form-group">
									<form name="cngshop" method="post" enctype="multipart/form-data" action="add_product.php">
										<label for="shop_select"> Select Shop </label>
										<select name="shop_select" id="shop_select" class="form-control shpList" onchange="submit();">
										<script>
										$(document).ready(function(){
											var wheight  = $('#shop_select').width();
											$('.RRSShop').css('width', wheight);
										});
	
										</script>
										<option class="RRSShop" value="">- - - Select shop - - -</option>
											<?php
											if($_SESSION['live_user_type'] == 'adminuser'){
												$qury = "`shop_status`='on'";
											}elseif($_SESSION['live_user_type'] == 'shopuser'){
												$prmtshopids = implode("','", $_SESSION[ 'PermitedShop_ids' ]);
												$qury = "`shop_id` IN ('$prmtshopids') AND `shop_status`='on'";
											}
											
											//echo $qry = "select shop_id, shop_name, shop_number from `shop_details` where ".$qury." ORDER BY `shop_name` ASC";
											$prmt_shops = mysqli_query( $db, "select shop_id, shop_name, shop_number from `shop_details` where ".$qury." ORDER BY `shop_name` ASC" );
											
											while ( $prmt_row = mysqli_fetch_array($prmt_shops) ) {
												$prmtArray = unserialize( $prmt_row[ 'shop_number' ] );
												?>
											
											<option class="RRSShop" value="<?php if(isset($prmt_row['shop_id'])){echo $prmt_row['shop_id'];} ?>"<?php if(isset($shopid) && $shopid == $prmt_row[ 'shop_id']){echo "selected";} ?> ><?php echo $prmt_row['shop_name'] ?> (<?php sort($prmtArray); echo implode(", ",$prmtArray); ?>)
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
							
							<div class="col-lg-12">
								<div class="row">
								<?php
									if(isset($productDataE['shop_priv_type'])){$privilage = $productDataE['shop_priv_type'];}else{$privilage = '';}
									?>
									<div class="col-sm-4 col-xs-4" style="text-align: center;">
									<button class="btn btn-<?php if($privilage == ''){echo "success";}else{echo "default";} ?> btn-lg" style="width: 100%;">Free</button>
									</div>
									<div class="col-sm-4 col-xs-4" style="text-align: center;">
									<button class="btn btn-<?php if($privilage == 'regular'){echo "success";}else{echo "default";} ?> btn-lg" style="width: 100%;">Regular</button>
									 </div>
									<div class="col-sm-4 col-xs-4" style="text-align: center;">
									<button class="btn btn-<?php if($privilage == 'premium'){echo "success";}else{echo "default";} ?> btn-lg" style="width: 100%;">Premium</button>
									</div>
								</div>

							</div>

							<div class="col-lg-12 C-main-in" style="padding-top: 15px;">
							<?php
								if(isset($productDataE['shop_priv_type'])){$privilage = $productDataE['shop_priv_type'];}else{$privilage = '';}
								
								if($privilage == ''){
									$prodt_permit = 10;
								}elseif($privilage == 'regular_listing'){
									$prodt_permit = 50;
								}elseif($privilage == 'premium_listing'){
									$prodt_permit = 1000;
								}
								
								
									
									
								$ckCount = mysqli_query($db, "SELECT COUNT(*) FROM `product_details` WHERE `prodt_company_id`='$shopid' AND `prodt_status`!='delete'");
								$ckCountrow = mysqli_fetch_array($ckCount);
								if($prodt_permit > $ckCountrow[0]){
								?>
								<form name="prodCategoryForm" id="prodCategoryForm" method="post">
								<input type = "hidden" name = "productHiddenID" id = "productHiddenID" value ="<?php if(isset($prodId)) echo $prodId ;?>">
								
									<!-- shop info start -->
									<div class="col-md-12">
										<h3 class="Rh3">Add Product</h3>
										<div class="form-group">
											<label for="prod_names"> Product Name <span style="color: red"> *</span> </label>
											<input name="prod_name" id="prod_name" class="form-control" type="text" value="<?php if(isset($editProdt['prodt_name']))echo htmlentities( $editProdt['prodt_name']); ?>" required="required" placeholder="Product Name">
										</div>
										<div class="input-group">
											<span style="color: red" id="spanProductName">
												Invalid Product Name
											</span>
										</div>
										
										
										
										
										<div class="form-group C-slist" id="shoplist_div">
									 <label> Product Category </label><br>
									 <select id="framework" name="framework[]" multiple class="form-control" >
									 <?php
										if(isset($editProdt['prodt_category'])){
											$cateSelct = json_decode($editProdt['prodt_category'], true);
										}
										
										$CateArray = json_decode($productDataE['shop_category'], true);
										 if(!empty($CateArray)){
											
											 
											 foreach($CateArray as $key => $Shopcate){
												 if($Shopcate['cate_level'] == 3){
													 $cateOption = $Shopcate['cate_parent']." - ".$Shopcate['cate_main']." - ".$Shopcate['cate_list'];
												 }elseif($Shopcate['cate_level'] == 2){
													 $cateOption = $Shopcate['cate_parent']." - ".$Shopcate['cate_main'];
												 }
											 echo "<option value='".$key."'";
											if (isset($cateSelct) && array_key_exists($key, $cateSelct)){
												echo " selected ";
											}
												 
												 echo ">";
												 echo isset($cateOption)?$cateOption:'';
												// .$cateOption.
												echo "</option>";
										 	}
										 }

//										 foreach ($thishopno as $key => $value) {
//
//											echo "<option value='".$key."'>".$value."</option>";
//
//										 }
									
									?>
									 </select>
									 
									 <script>
								$(document).ready(function(){
								 $('#framework').multiselect({
								  nonSelectedText: 'Select Category',
								  enableFiltering: true,
								  enableCaseInsensitiveFiltering: true,
								  buttonWidth:'100%'
								 });

								});
								</script>
									 
									</div>
										
<!--
										<div class="form-group">
											<label for="prodCategory"> Product Category <span style="color: red"> *</span></label>
											<select class="form-control" id="prodCategory" name="prodCategory" required>
											<option value="">--Select Category--</option>
											<?php //while($category = mysqli_fetch_array($categoryData)){?>
													<option value="<?php //echo htmlspecialchars($category['cate_parent']); ?>" <?php //if(isset($productDataE['prodt_category']) && ($productDataE['prodt_category'] == $category['cate_parent']) ) echo "selected";?>><?php //echo htmlspecialchars($category['cate_parent']);?></option>
											<?php //} ?>
												
											</select>
										</div>
-->
										
										<div class="form-group" >	
											<label for="prodSize"> Product Size </label>
											<input name="prodSize" id="prodSize" class="form-control" placeholder="Eg: Width,Height" type="text" value="<?php if(isset($editProdt['prodt_size']))echo $editProdt['prodt_size']; ?>" >									
										</div>
										<div class="input-group">
											<span style="color: red" id="spanProductSize">Invalid Product Size</span>
										</div>
											
										<div class="form-group " >	
											<label for="availQty"> Available Quantity </label>
											<input name="availQty" id="availQty" class="form-control" placeholder="Available Quantity" type="text" value="<?php if(isset($editProdt['prodt_avail_quantity']))echo $editProdt['prodt_avail_quantity']; ?>" >
										</div>
											<div class="input-group">
												<span style="color: red" id="spanAvailableQty">Enter Numeric Values</span>
											</div>										
										

										<div class="form-group " >	
											<label for="availColor"> Available Color </label>
											<input name="availColor" id="availColor" class="form-control" placeholder="Separated by comma.Eg red,blue,black " type="text" value="<?php if(isset($editProdt['prodt_avail_color']))echo $editProdt['prodt_avail_color'];?>" >								
										</div>
										<div class="input-group">
												<span style="color: red" id="spanAvailableClr">Invalid Color Name</span>
										</div>	
										
										<div class="form-group " >	
											<label for="prodUnit"> Product Unit Type </label>
											<input name="prodUnit" id="prodUnit" class="form-control"  placeholder="eg : 5 pieces per unit" type="text" value="<?php if(isset($editProdt['prodt_unite_type']))echo $editProdt['prodt_unite_type']; ?>" >	
										</div>
										<div class = "input-group">
											<span style="color: red" id="spanProductUnitType">Invalid Unit</span>
										</div>
										
										<div class="form-group " >	
											<label for="prodBrand"> Product Brand </label>
											<input name="prodBrand" id="prodBrand" class="form-control"  placeholder="Product Brand" type="text" value="<?php if(isset($editProdt['prodt_brand']))echo $editProdt['prodt_brand']; ?>" >
											</div>
										<div class = "input-group">
											<span style="color: red" id="spanProductBrand">This field is required</span>
										</div>
												
										<div class="form-group">
											<label for="prodDesc"> Product Description </label>
<textarea class="form-control" name="prod_desc" id="prod_desc" rows="5"><?php if(isset($editProdt['prodt_description']))echo stripslashes($editProdt['prodt_description']); ?></textarea>	
										</div>
										
										<div class="form-group">
											<label for="prodDesc"> Product Specification </label>
<textarea class="form-control" name="prod_spec" id="prod_spec" rows="5"><?php if(isset($editProdt['prodt_specifications']))echo stripslashes($editProdt['prodt_specifications']); ?></textarea>	
										</div>										
								
										
										<div class="form-group">
											<label for="prod_image"> Product Image <span class="text-info">File: .jpg, .png and .gif only allowed </span></label>
											
											<input class="form-control" type="text" name="productimg" id="productimg" value="<?php if(isset($editProdt['prodt_picture']))echo htmlentities( $editProdt['prodt_picture']); ?>"  data-toggle="modal" data-target="#exampleModal" data-whatever="productimg" readonly placeholder="Click to select picture"/>
										</div>
										<div id = "addFile"></div>
										<div id = 'Add Remove Image'>							
											<div id="addImage" class = "pull-right" style = "cursor: pointer;color: blue" title="Add Image">
												+ Add Image 
											</div>
											<div id="removeImage" class = "pull-left" style = "cursor: pointer;color: red;margin-bottom: 10px;" title = "Remove Image">
												- Remove Image
											</div>
											<input type = "hidden" name = "hiddenImgVal" id = "hiddenImgVal">
										</div>
										
										<div class="form-group"  >
											<?php
											if(isset($editProdt['prodt_newpics'])){
												$thumbPics = json_decode($editProdt['prodt_newpics'], true);
											}else{
												$thumbPics = '';
											}
													
													$imgCount = 0;
													if(!empty($thumbPics)){
													foreach($thumbPics as $thumbPic){ 
														
															$imgCount++;
															?>
															<div class="newPictures" id = "i_<?php echo $imgCount; ?>" style="display: inline; float: left; text-align: center; margin-right: 7px; margin-bottom: 10px;">
															
															<?php
														if($thumbPic != ''){ ?>
															<img src="<?php echo $thumbPic;?>" alt="Product picture" style="width:100px;height:100px;">
																<input type = "hidden" name = "productnewpics[]" value = "<?php echo $thumbPic ?>"> <br/>

																<button type="button" name= 'btnImgClose' value='Close' class = "label label-primary glyphicon glyphicon-remove btnImgClose" id = "i_<?php echo $imgCount; ?>" title="Close">Close</button>
															<?php
														}
														?>
																


															</div>
														<?php }?>
													<?php } ?>
											
										</div>
									
		
									<?php
										$token = uniqid( '', true );
										$_SESSION['token'] = $token;
									?>
										<input readonly type="hidden" name="token" value="<?php echo $token; ?>"/>
										<input readonly type="hidden" name="Prodts_id" value="<?php if(isset($editProdt['prodt_id'])) {echo $editProdt['prodt_id'];} ?>"/>
										<input readonly type="hidden" name="shop_id" value="<?php echo $shopid; ?>"/>
								   
									   <div class="col-lg-12" style="border-top:solid 1px #ccc; text-align: right; padding: 15px 0 15px 0;">
										<?php
										   //if(isset($editProdt['prodt_id'])){
										   ?>
										<input class="btn btn-warning btn-lg" type="submit" name="submit" id="submit"  value="Submit Form" title = "Submit">
										<?php
										   //}else{echo "<span style='color:red;'> Please select shop</span>";}
										   ?>
										<input class="btn btn-default btn-lg" type="reset" name="reset" value="Reset Form" title = "Reset">

									</div>
									<!-- Button end -->
										
									</div>
						
						

									<!-- uploads start -->
					
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
        </div>
          </div>
          						
								</form>
								<?php
								}else{echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>PLEASE UPGRADE YOUR PACKAGE TO ADD MORE PRODUCTS. <strong>CONTACT THE ADMINISTRATOR</strong> <a href='mailto:info@dragonmartguide.com?subject=Upgrading%20request'>info@dragonmartguide.com</a></div>";}
									?>
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
	<script type="text/javascript" src="js/product_category.js">
	</script>
</body>

</html>