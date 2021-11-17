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
$page_name = "updates";
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

$objJoin = new common();

//Delete offer based on offerId and action = deloffer
/*
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
*/

?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Updated List :: Dragon Mart Guide</title>
	<meta http-equiv="refresh" content="180">
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css">
<!--	<link type="text/css" rel="stylesheet" href="../css/clientstyle.css">-->
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
	<script type="text/javascript" src="js/jquery-confirm.min.js"></script>
<!--	<script type="text/javascript" src="js/jquery.mobile-1.1.1.js"></script>-->
	<!-- DataTables -->
	<link type="text/css" rel="stylesheet" href="../css/clientstyle.css">
	<style>
		.force-select {  
			  -webkit-user-select: all;  /* Chrome 49+ */
			  -moz-user-select: all;     /* Firefox 43+ */
			  -ms-user-select: all;      /* No support yet */
			  user-select: all;          /* Likely future */   
			}
		
		.textStatus{
			display: block;
			width:20%;
			height: 34px;
			padding: 6px 12px;
			font-size: 14px;
			line-height:1.42857143;
			color: #555;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 4px;
		}
	</style>
	
	
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
							<div class="C-dash1">Updated Information List</div>
						</div>
						<div class="row">						
			<!--				<div class="col-lg-12 C-main-in">
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
								
							</div>-->
							<!-- For status filters-->
							<div class="col-lg-12 C-main-in">
							<div class="C-infoC"> User Status</div>
								<div id = "userstatus">
								<select class="textStatus" id="txt_userstatus" name="txt_userstatus"  >
									<option value = "select">--Select Status--</option>
									<option value = "on" <?php if(isset($_SESSION['userupdatestatus']) && $_SESSION['userupdatestatus']== 'on') echo "selected" ;?>>Live</option>
									<option value = "delete" <?php if(isset($_SESSION['userupdatestatus']) && $_SESSION['userupdatestatus']== 'delete') echo "selected" ;?>>Reject</option>
									<option value = "not viewed" <?php if(isset($_SESSION['userupdatestatus']) && $_SESSION['userupdatestatus']== 'not viewed') echo "selected" ;?>>Not Viewed by admin</option>
									<option value = "viewed" <?php if(isset($_SESSION['userupdatestatus']) && $_SESSION['userupdatestatus']== 'viewed') echo "selected" ;?>>Viewed by admin</option>
								</select>
								</div>
							</div>
							<div class="col-lg-12 C-main-in" style="padding-top: 15px;" id="updateUserList">
								<!--=== Responsive DataTable start ===-->
								<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25">
									<thead>
										<tr>
											<th>Id</th>
										
											<th>Pic/Data</th>
											<th>Type</th>
											<th>Page</th>
											<th>Table</th>
											<th>Status</th>			
											<th style = "text-align: center">Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
										
										if(isset($_SESSION['userupdatestatus'])){
											 $sessionStatus = $_SESSION['userupdatestatus'];
											 $updatedList = mysqli_query($db,"SELECT * FROM `updt_info` WHERE 			`updt_viewstatus` = '$sessionStatus'
																			 ORDER BY `updt_info`.`updt_time` DESC LIMIT 100");
										}else{
											$updatedList = mysqli_query($db,"SELECT * FROM `updt_info` WHERE 			`updt_viewstatus` = 'viewed' OR `updt_viewstatus` = 'not viewed'
																			 ORDER BY `updt_info`.`updt_time` DESC LIMIT 100");
										}
											 
										 /*$updatedList = mysqli_query($db,"SELECT * FROM `updt_info` WHERE 				`updt_viewstatus` = 'viewed' OR `updt_viewstatus` = 'not viewed'
										  ORDER BY `updt_info`.`updt_time` DESC LIMIT 100");*/
										
										$rowCount = mysqli_num_rows($updatedList);
										if($rowCount > 0){
											while ($updateData = mysqli_fetch_array($updatedList)){
										  if( $updateData['updt_pagename'] == 'userlogin'){ ?>
											 <tr style="background-color:orange">
										  <?php }else{ ?>
											 <tr>	 
										<?php }?>
																	 
												<?php $updateId = $updateData['updt_id']; 
													  $updtUserId = $updateData['updt_userid']; 
												?>
												<td><?php echo $updateData['updt_userid']; ?></td>
         									
											    <td><?php 
												 $rowID = $updateData['updt_rowid'];
														if($updateData['updt_tablename'] == 'user_register'){
															
															$resultData = $objJoin->joinWithEnquiry('user_register',$rowID);
															
														if($resultData!=''){ ?>
															<img src="<?php echo "../images/login/".$resultData?>" alt="<?php echo $resultData?>" style="width:100px;height:100px;">
															<?php }else{
														    echo $updateData['updt_rowid'];
														 }
												  } 
											
										
												else{echo $updateData['updt_rowid'];} ?>
												 </td>
												<td><?php echo $updateData['updt_type']; ?></td>
												<td><?php echo $updateData['updt_pagename']; ?></td>
												<td><?php echo $updateData['updt_tablename']; ?></td>
												<td>
												<?php 
													$viewstatus =  $updateData['updt_viewstatus'];
													if($viewstatus == 'viewed'){?>
														<button type="button" class="btn btn-info glyphicon glyphicon-eye-open  viewBtn" data-toggle="modal" data-target="#myModal" data-id = "<?php echo $updateId;?>" value = "Viewed" title = "Viewed"></button>
												<?php }else {?>
														<button type="button" class="btn btn-warning glyphicon glyphicon-eye-close  viewBtn" data-toggle="modal" data-target="#myModal" data-id = "<?php echo $updateId;?>" value = "Not Viewed" title = "Not Viewed"></button>
											<?php }?>
												</td>
												<td>
												<?php 
											if($viewstatus == 'on') {?>
												
												<button type="button" class="btn btn-danger glyphicon glyphicon-remove-circle rejectlive" id = "<?php echo $updateId;?>" title = "Reject"></button>
												
											<?php }?>
										
											<?php 
											if($viewstatus == 'delete') {?>
												
												<button type="button" class="btn btn-info fa fa-undo restoreBtn " id = "<?php echo $updateId;?>" title = "Restore"> </button>
											
											<?php }?>
										 <?php 
											if($viewstatus != 'delete' && $viewstatus != 'on') {?>
												
													
													<button type="button" class="btn btn-success glyphicon glyphicon-ok Acceptdata" id = "<?php echo $updateId;?>" title = "Accept" ></button>
													<button type="button" class="btn btn-danger glyphicon glyphicon-remove-circle Rejectdata" id = "<?php echo $updateId;?>" title = "Reject" ></button>
												
											<?php
										 }?>
												 
												 <button type="button" class="btn btn-danger glyphicon glyphicon- glyphicon-trash deleteBtn" id =  "<?php echo $updateId;?>" title = "Delete"></button>
		
										</td>
										<?php }?>
										
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
	$('.viewBtn').click(function(){
		updateId = $(this).attr('data-id');
			$.ajax({
			        	url:"ajax_update_info.php",
			        	data:"updateId="+updateId,
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							//$('#modalMessage').html(data);
							$('#modal-data').html(data);
							$('#btnClose').click(function(){
							    location.reload();
							});
						}	
			        }); 
	});
	
	</script>
<script>
	$(document).ready(function() {
    $('#example').DataTable();
	} );
</script>

<!-- for viewed or not viewed-->
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
       	<div id = "modal-data">
      	

		</div>
<!--       <div class="modal-header">
          <button type="button" class="close" title = "close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Updated Information</h4>
        </div>
       <div class="modal-body" id = 'modalMessage'>
        
        </div>-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id = "btnClose" title = "Close">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- end -->
  



<script>
	
	
		//permanent Delete
	$(document).on('click touchstart', '.deleteBtn', function() {
	//$('.deleteBtn').click(function(){
		delRowId =  $(this).attr('id');
		if (confirm('Are you sure to delete?')) {
			$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"	:"permanentDelete",
							"perDelTableID"	:delRowId
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							location.reload();
						}	
			        }); 
		}
	});
	
		$(document).on('click touchstart', '.Acceptdata', function() {
		upTableID = $(this).attr('id');

		  if (confirm('Are you sure to accept this?')) {
     		//upTableID = $(this).attr('id');
					$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"	:"Accept",
							"upTableID"	:upTableID
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							
							location.reload();
						}	
			     }); 
		}
		
	});
	

	//for reject
	$(document).on('click touchstart','.Rejectdata',function(){
	//$('.Rejectdata').click(function(){
		upTableID = $(this).attr('id');
		//upTableID	= $('#txtUpID').val();
	 if (confirm('Are you sure to reject this?')) {
					$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"	:"Reject",
							"upTableID"	:upTableID
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							
							location.reload();
						}	
			        }); 
	 }
	});
	
	//user status ajax
	//$(document).on('change touchstart','#txt_userstatus',function(){
		 //$('#txt_userstatus').change(function(){
		//$(document).on('change', 'select', function (e) {
	 //  $(document).on("change touchstart","#txt_userstatus",function(){
	$(document).on("change touchstart","#txt_userstatus",function(){
	 userstatus = $('#txt_userstatus').val();
		 $.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"userstatus"	:userstatus
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							$("#updateUserList").html(data);
							$('.viewBtn').click(function(){
										updateId = $(this).attr('data-id');
											$.ajax({
												url:"ajax_update_info.php",
												data:"updateId="+updateId,
												async:false,
												method: 'POST',
												success: function(data)
												{
													//$('#modalMessage').html(data);
													$('#modal-data').html(data);
													$('#btnClose').click(function(){
														location.reload();
													});
												}	
											}); 
							 });

						}	
			        });
	 }); 
	
	$(document).on('click touchstart','.rejectlive',function(){
	//$('.rejectlive').click(function(){
		rejectRowId =  this.id ;
				$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"		:"rejectlive",
							"rejectRowId"	:rejectRowId
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							
							location.reload();
						}	
			        });
		
	});
	
	//restoreBtn
	$(document).on('click touchstart','.restoreBtn',function(){
	//$('.restoreBtn').click(function(){
		restoreRowId =  this.id ;
				$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"		:"restore",
							"rejectRowId"	:restoreRowId
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							
							location.reload();
						}	
			        });
		
	});

</script>
</body>

</html>