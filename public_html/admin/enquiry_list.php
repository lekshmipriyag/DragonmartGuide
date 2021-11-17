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
$page_name = "enquiry_list";
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
include( '../Connections/dragonmartguide.php');
include( '../Connections/functionsL.php' );


//Delete enquiry based on enquiryId and action = delenquiry
if(!empty($_GET['delenqId']) && $_GET['action'] == 'delenquiry'){
	
	$objEnq				= new Enquiry();
	$objEnq->tableName	= "enquiry_dmg";
	$objEnq->fieldName  = "em_status";	
	$objEnq->value		= 'delete';
	$objEnq->page_name	=  'enquiry_list.php';
	$emId				=	$_GET['delenqId'];
	$objEnq->em_id		=	$emId;
	$cond				=	"em_id ="  .$emId;	
	$objEnq->cond		=	$cond;	
	$objEnq->deleteEnquiry();
	echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Deleted.</div>";
}
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Updated List :: Dragon Mart Guide</title>
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
							<div class="C-dash1">Enquiry List</div>
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
							<div class="col-lg-12 C-main-in" style="padding-top: 15px;" id="updateUserList">
								<!--=== Responsive DataTable start ===-->
								<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25">
									<thead>
										<tr>
											<th>Id</th>
											<th>Name</th>
											<th>Contact Number</th>
											<th>Email</th>
											<th>IP Address</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
											$enquiryList = mysqli_query($db,"SELECT * FROM `enquiry_dmg` WHERE 			`em_status` != 'delete' ORDER BY `em_createdAt` DESC LIMIT 100");
										
										$rowCount = mysqli_num_rows($enquiryList);
										if($rowCount > 0){
											while ($enquiryData = mysqli_fetch_array($enquiryList)){ ?>
											<tr>							 
												<?php $enquiryId = $enquiryData['em_id']; 
													  $enqUserId = $enquiryData['em_userid']; 
												?>
												<td><?php echo $enquiryData['em_id']; ?></td>
												<td><?php echo $enquiryData['em_name']; ?></td>
												<td><?php echo $enquiryData['em_contactno']; ?></td>
												<td><?php echo $enquiryData['em_email']; ?></td>
												<td><?php echo $enquiryData['em_ipaddress']; ?></td>
												<td>	
													<button type="button" class="btn btn-info glyphicon glyphicon-eye-open  viewBtn" data-toggle="modal" data-target="#enquiryModal" data-id = "<?php echo $enquiryId;?>" value = "view" title = "VIew"></button>
													&nbsp
													<a href = "enquiry_list.php?action=delenquiry&delenqId=<?php echo $enquiryId;?>" class = "glyphicon glyphicon-trash" title = "Delete">Delete</a>
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

<script>
	$('.viewBtn').click(function(){
		enquiryId  = $(this).attr('data-id');
		
			$.ajax({
			        	url:"ajax_enquiry.php",
			        	data:"enquiryId="+enquiryId,
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							$('#modal-data').html(data);
							/*$('#btnPrint').click(function(){
								alert('ok');
							});*/
						}	
			        }); 
	}); 
	
	</script>

<!-- for viewed or not viewed-->
<!-- Modal -->
  <div class="modal fade" id="enquiryModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" >
      	<div id = "modal-data">
      	
		</div>
      
       	<div class="modal-footer"> 
			 <button type="button" class="glyphicon glyphicon-print btn btn-info"  data-dismiss="modal" id = "btnPrint" title = "Print">Print</button>
			  <button type="button" class="btn btn-default" data-dismiss="modal" id = "btnClose" title = "Close">Close</button>
       </div>
      </div>
     
    
    </div>
  </div>
 
 
  <!-- end -->
 
<!-- end-->  
</body>

</html>