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
$page_name = "category";
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
include('../Connections/dragonmartguide.php');



?>
<?php
if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}

$UcalmN = "";

if(isset($_GET['pid'])){$UcalmN 	= "cate_parent";	$tid = $_GET['pid']; $cm_get_id = $_GET['pid'];}
if(isset($_GET['cid'])){$UcalmN 	= "cate_main";		$tid = $_GET['cid']; $tid = $_GET['cid'];}
if(isset($_GET['sid'])){$UcalmN 	= "cate_list";		$tid = $_GET['sid']; $tid = $_GET['sid'];}

	
	if(isset($_GET['f']) && $_GET['f'] == "edit"){
		$selt_cat = mysqli_query($db, "select * from `categories` where `categories`.`id`='$tid'");
		$row_seltCat = mysqli_fetch_array($selt_cat);
	}
	if(isset($_GET['f'])){$f = $_GET['f'];}

	if(isset($_POST['categoryname']) &&  $session_tokens == $tokens && isset($_GET['f']) && $f == 'edit'){
		$Ucat = new category;
		$Ucat->cat_id		= $_POST['cate_id'];
		$Ucat->cat_prid 	= $_POST['cateprnt']; 		//table with prnt id
		$Ucat->cat_name 	= $_POST['categoryname'];	//Category Name	
		$Ucat->U_cate();
	}elseif(isset($_POST['categoryname']) &&  $session_tokens == $tokens){
		$Ccat = new category;
		$Ccat->cat_prid 	= $_POST['cateprnt']; 		//table with prnt id
		$Ccat->cat_name 	= $_POST['categoryname'];	//Category Name
		$Ccat->C_cate();
	}elseif(isset($_GET['f']) && $f == 'del'){
		$Dcat = new category;
		$Dcat->cat_id = $tid;
		$Dcat->D_cate();
	}



?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Category :: Dragon Mart Guide</title>
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
							<div class="C-dash1">Category Settings</div>
							<div class="C-dash2">view and edit</div>
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

							<div class="col-md-6 col-xs-12" style="padding-top: 15px;">

								<form name="register_form" id="register_form" method="post" enctype="multipart/form-data">
								
									<!-- user registration start -->
									
										<h3 class="Rh3">Category <a href="category.php" class="btn btn-xs btn-success">Add New</a></h3>
										<div class="form-group">
											<label for="categoryname"> Category Name </label>
											
										<input class="form-control" id="categoryname" name="categoryname" type="text" value="<?php if(isset($_GET['f']) && $_GET['f'] == "edit") {echo $row_seltCat[$UcalmN];} ?>" required="required" placeholder="Category Name" />
										</div>
<?php

//SELECT par.catepr_name from category_pr par left join category_min min on min.catemin_id = par.catepr_id inner join category_sub sub on sub.catesub_id = min.catemin_id 									
									
	/*$catRslt	 = mysqli_query($db,"SELECT * from category_pr pr left join category_min cm on cm.catemin_id = pr.catepr_id inner join category_sub cs on cs.catesub_id = cm.catemin_id order by pr.catepr_name, cm.catemin_name, cs.catesub_name " );*/							
///////////									

//$catRslt = mysqli_query($db, "SELECT *
//FROM category_pr pr
//  left Join category_min cm 
//      On cm.catemin_prid  = pr.catepr_id
//  Join category_sub cs 
//      On cm.catemin_id  = cs.catesub_minid
//ORDER BY
//      pr.catepr_name, cm.catemin_name, cs.catesub_name");
$catRslt = mysqli_query($db, "SELECT * FROM `categories` where `categories`.`status`='on' ORDER BY `cate_parent`, `cate_main`, `cate_list` ASC");
while($catfull = mysqli_fetch_assoc($catRslt)){
	$catrow[] = $catfull;
}
									//print_r($catrow);
?>
										<div class="form-group">
											<label for="cateprnt">Select Parent Category</label>
											<select name="cateprnt" id="cateprnt" class="form-control" required>
												<option value="cp_0" class="showSingle" target="0">- - - None - - - </option>
												
<?php
												
	$catPrntIDR = 0;
	$catmainIDR = 0;
foreach($catrow as $catrowR){
	
//	if(isset($pr_get_id)){
//		$select = "";
//	}elseif(isset($cm_get_id) && $cm_get_id == $catrowR['catemin_id']){
//		$select = "cp_".$catrowR['catepr_id'];
//	}elseif(isset($sm_get_id) && $sm_get_id == $catrowR['catesub_id']){
//		$select = "cm_".$catrowR['catemin_id'];
//	}
	
	if($catrowR['cate_level'] == '1' && $catrowR['cate_main'] == '999'){
		?>

		<option value="cp_<?php echo $catrowR['id']; ?>" <?php //if(isset($select) && $select == $catrowR['id']) {echo "selected" ;} ?> class="cat_prnt"><?php echo $catrowR['cate_parent']; ?></option>
		
		<?php
		//$catPrntIDR = $catrowR['id'];
	} 
	if ($catrowR['cate_level'] == 2 && $catrowR['cate_list'] == '999'){
		if(isset($_GET['cid']) && $catrowR['id'] == $_GET['cid']){
			$select = "cp_".$catrowR['cate_pid'];
		}
	?>
		
		<option value="cm_<?php echo $catrowR['id']; ?>" <?php //if(isset($select) && $select == $catrowR['id']) {echo "selected" ;} ?> class="cat_sub"><?php echo $catrowR['cate_main']; ?></option>
		<?php
		//$catmainIDR = $catrowR['id'];
	}
	//if(isset($catrowR['catesub_name'])){echo "<li class='subCl'>".$catrowR['catesub_name']."</li>"; }
	
	if($catrowR['cate_level'] == 3){
		if(isset($_GET['sid']) && $catrowR['id'] == $_GET['sid']){
			$select = "cm_".$catrowR['cate_mid'];
		}
	?>
	<option value="cs_<?php echo $catrowR['id']; ?>"  class="cat_subsub" disabled><?php echo $catrowR['cate_list']; ?></option>
	<?php
	}
}

?>
<script>
	
$("div.form-group select").val("<?php if(isset($select)){echo $select;} ?>");
</script>
											</select>
										</div>
										<div class="form-group">
											<label for="purchase">Category Details</label>
											<textarea class="form-control" name="catedetails" id="catedetails" rows="5"><?php if(isset($row_seltCat['cate_details']))echo $row_seltCat['cate_details']?></textarea>
										</div>

									<?php
										$token = uniqid( '', true );
										$_SESSION[ 'token' ] = $token;
									?>
								
								<input type="hidden" name="token" value="<?php echo $token; ?>"/>
									<input type="hidden" name="cate_Prntid" value="<?php if(isset($select)){echo $select;} ?>"/>
									<input type="hidden" name="cate_id" value="<?php if(isset($tid)){echo $tid;} ?>">
									<input type="hidden" name="cate_Oldname" value="<?php if(isset($row_seltCat[$UcalmN])) {echo $row_seltCat[$UcalmN];} ?>"/>

									<!-- Button start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc; text-align: center; padding: 15px 0 15px 0;">

										<input class="btn btn-warning btn-lg" type="submit" id="submit" name="submit" value="Submit Form">
										<input class="btn btn-default btn-lg" type="reset" name="reset" value="Reset Form">
										
									</div>
									<!-- Button end -->
									
									
									
									
									
									
								
								</form>
							</div>
							
							<div class="col-md-6 col-xs-12 C-main-in-half">
							<h3>Category List</h3>
							<?php
//	$catPrntID = 0;
//	$catmainID = 0;
echo "<ul class='Cl_ul'>";
foreach($catrow as $catrow){
	
	if($catrow['cate_level'] == '1' && $catrow['cate_main'] == '999'){
		echo "<li class='prntCl'>".$catrow['cate_parent']." <span> <a href='category.php?f=edit&pid=".$catrow['id']."'>Edit</a></span> <span class='remove'> <a href='category.php?f=del&pid=".$catrow['id']."' onClick=\"return confirm('Are you sure! Must delete this record?');\">Remove</a></span></li>";
		//echo $catrow['catepr_name']."<br/>";
		//$catPrntID = $catrow['id'];
		//echo "<script>alert($catPrntID);</script>";
	} 
	if ($catrow['cate_level'] == 2 && $catrow['cate_list'] == '999'){
		echo "<li class='mainCl'>".$catrow['cate_main']." <span> <a href='category.php?f=edit&cid=".$catrow['id']."'>Edit</a></span> <span class='remove'> <a href='category.php?f=del&cid=".$catrow['id']."' onClick=\"return confirm('Are you sure! Must delete this record?');\">Remove</a></span></li>";
		//echo $catrow['catemin_name']."<br/>";
		//$catmainID = $catrow['catemin_id'];
	}
	if($catrow['cate_level'] == 3){
		echo "<li class='subCl'>".$catrow['cate_list']." <span><a href='category.php?f=edit&sid=".$catrow['id']."'>Edit</a></span> <span class='remove'> <a href='category.php?f=del&sid=".$catrow['id']."' onClick=\"return confirm('Are you sure! Must delete this record?');\">Remove</a></span></li>"; }
//	print_r($catrow);
//	echo "<br/><br/>";
}
echo "</ul>";
						?>
							
							</div>
							
						</div>
						
						<!--Testing -->
						
<!--						Testing-->
						
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





	
</script>