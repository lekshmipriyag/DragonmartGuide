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
$page_type = "admin_side";
$page_name = "privilege_list";
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
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Privilege List :: Dragon Mart Guide</title>
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
							<div class="C-dash1">Privilege List
							<a href = "privilege_settings.php" class = "btn btn-xs btn-success" style="display: inline;" title = "New privilege">New Privilege</a>
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
							<div class="col-lg-12 C-main-in" style="padding-top: 15px;">
								<!--=== Responsive DataTable start ===-->
								<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25">
									<thead>
										<tr>
											<th>Shop Name</th>
											<th>Shop Number</th>
											<th>Privilege Type</th>
											<th>Privilege Start</th>
											<th>Privilege End</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if($_SESSION['live_user_type'] == "adminuser"){
																			$previlageList = mysqli_query($db, "SELECT * FROM shop_details
																			WHERE shop_status != 'delete' AND shop_priv_type != '' 
											  								ORDER BY shop_cre DESC");
											
										}
										 $rowCount = mysqli_num_rows($previlageList);
										if($rowCount > 0){
											while ($privilageDataL = mysqli_fetch_array($previlageList)){ 
												$shopNumberSeries 	=  implode(',',unserialize($privilageDataL['shop_number']));
										   	$dateNow	=	$_SESSION['now'];
											$endDate	=	$privilageDataL['shop_priv_end'];
											$date1			=	date_create($endDate);
											$date2			=	date_create($dateNow);
											$diff			=	date_diff($date1,$date2);
											$expireDate		= 	$diff->format("%a");	
												if($endDate < $dateNow){?>
													<tr style="color:#ccc">
											<?php }else if($expireDate <= 10){?>
													<tr style="color:#FF0000">
											<?php }else{?>
											<tr>
											<?php } ?>								 
												<?php $shopId 			= $privilageDataL['shop_id']; 
													  $shopUserId 		= $privilageDataL['shop_user_id']; 
												?>
												<td><?php echo $privilageDataL['shop_name'];?></td>
												<td><?php echo $shopNumberSeries;?></td>
												<td><?php echo $privilageDataL['shop_priv_type']; ?></td>
												<td><?php echo $privilageDataL['shop_priv_start']; ?></td>
												<td><?php echo $privilageDataL['shop_priv_end']; ?></td>
												<td>
													<a href = "privilege_settings.php?f=edit&shpid=<?php echo $shopId;?>" class = "glyphicon glyphicon-pencil" title="Edit">Edit</a>
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