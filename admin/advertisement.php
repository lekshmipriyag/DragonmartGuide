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
$page_name = "advertisement";
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
include('../Connections/functionsL.php');
?>
<?php
if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}

if($_SESSION['live_user_type'] == 'adminuser'){
	
	
	$getAdType	=	"SELECT * FROM settings WHERE sett_type = 'advertisement' AND status = 'on' ";
	$getResult	=	mysqli_query($db,$getAdType);
	$adObject	=	new Ad();
	$shopData	=	$adObject->getShopWithNumber();
	$notAvailableAd	= array();
	
	if(isset($_POST['adname']) &&  $session_tokens == $tokens){
	
		$hiddenAdId 	= '';
		$adIdByUrl		=	'';
		$flag 			= 0;
		$hiddenAdId 	= (isset($_POST['adHiddenID'])) ? $_POST['adHiddenID']:'No hidden id';
		$adIdByUrl  	= (isset($_GET['adId'])) ? $_GET['adId']:'No url ID';
		if($hiddenAdId == $adIdByUrl ){
					if(isset($_POST['adtype'])){$adType = $_POST['adtype'];}else{$adType = "";}
					$adType = explode('_', $adType);
					$selectQuery	= "select s.*, ad.* from settings s inner join advertisement ad ON ad.Ad_Type = s.sett_id where s.sett_id = '$adType[0]' AND ad.Ad_Status != 'delete' AND ad.Ad_Status != 'off'";

					$selectData		=   mysqli_query($db, $selectQuery);
					$rowCount = mysqli_num_rows($selectData);
					if(isset($adType[1])){$adType2 = $adType[1];}else{$adType2 = "";}

					$adDate 						= explode(' - ', $_POST['daterange']);	
					$startDate 						= strtr($adDate[0], '/', '-');
					$startDate						= date('Y-m-d H:i:s', strtotime($startDate));
					$endDate   						= strtr($adDate[1], '/', '-');
					$endDate						= date('Y-m-d H:i:s', strtotime($endDate));
					//echo $adType2."<br>";
					//echo $rowCount;
					if($rowCount >= $adType2){
						//echo "greater";
							// if existing advertisement count more than allowed value, then check the date here start
							while($row_available = mysqli_fetch_array($selectData)){

							// if overlaping other period dates is true or else
							$DBstartDate = date('Y-m-d H:i:s', strtotime($row_available['Ad_Startdate']));
							$DBendDate = date('Y-m-d H:i:s', strtotime($row_available['Ad_Enddate']));


							if( ((strtotime($startDate) <= strtotime($DBstartDate) && strtotime($startDate) <= 		    strtotime($DBendDate)) &&
							 (strtotime($endDate) <= strtotime($DBstartDate) && strtotime($endDate) <= strtotime($DBendDate))) ||
							  ((strtotime($startDate) >= strtotime($DBstartDate) && strtotime($startDate) >= strtotime($DBendDate)) &&
							  (strtotime($endDate) >= strtotime($DBstartDate) && strtotime($endDate) >= strtotime($DBendDate)) )
							  ){
								$flag = 1;
								
							}else{
									$flag = 0; 
								$notAvailableAd[] =  array(	  'id' 		=>$row_available['Ad_Id'],
															  'name'	=>$row_available['Ad_Name'],
															  'type'	=>$row_available['sett_where'],
														   	  'image'	=>$row_available['Ad_Picture'],
															  'startD'	=>$row_available['Ad_Startdate'],
															  'endD'	=>$row_available['Ad_Enddate']);
								$url_id = mysql_real_escape_string($_GET['adId']);
								$DBstart	=	$row_available['Ad_Startdate'];
								$DBend		=	$row_available['Ad_Enddate'];
								$dbADType	=	$row_available['Ad_Type'];
								if(($DBstart == $startDate) && ($DBend == $endDate) && ($adType == $dbADType )){
									$flag = 1;
								}else{
									
									  $sql = "SELECT * FROM advertisement WHERE Ad_Type = '$dbADType' AND ((Ad_Startdate BETWEEN '$startDate' AND '$endDate') OR  (Ad_Enddate  BETWEEN '$DBstart' AND '$DBend' )) ";
								
									$result = mysqli_query($db,$sql);
									if(mysqli_num_rows($result) >=1){
										$flag = 0;
									}else{
										$flag = 1;
									}
									
								}

							 }	
						  }//while end
						
						  if($flag == 1){
							  /*echo $row_available['Ad_Enddate'];
							  die('Somrthing wrng');*/
							  $adObject->updateAdData($adType[0]);
								header("Location: ad_list.php");
						  }else{
							  $flag = 0;
							  if(isset($flag) && $flag == 0){
								 /* echo "<pre>";
								  		print_r($notAvailableAd);
								  die;*/
											echo "<div class='modal-content' id = 'modalId'>
											<div class='modal-header'>
										  		<button type='button' class='close' title = 'close' data-dismiss='modal'>&times;</button>
												<h4 class='modal-title'>Advertisement already exist in this duration.</h4>
											</div>
											<div class='modal-body' id = 'modalMessage'> ";
												?>
											   <table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25"><thead>
												   <tr>		   
													   <th>Ad Name</th>
													   <th>Ad Type</th>
													   <th>Image</th>
													   <th>Start Date</th>
													   <th>End Date</th>
													   <th></th>
												   </tr>
											   <thead>
											   <tbody>
												   <?php
													foreach($notAvailableAd as $newData){
								  					
													$modalStartD   		= strtr($newData['startD'], '-', '/');
													$modalStartDate 	= date('d-m-Y H:ia', strtotime($modalStartD));
														
													$modalEndD   		= strtr($newData['endD'], '-', '/');
													$modalEndDate 	= date('d-m-Y H:ia', strtotime($modalEndD));
												   ?>
													
													 <tr>
													   <td><?php echo isset($newData['name'])?$newData['name']:''?></td>
													   <td><?php echo isset($newData['type'])?$newData['type']:''?></td>
														<td><img src="<?php echo $newData['image']?> " alt="Ad Image" style="width:50px;height:50px;"></td>
													   <td><?php echo isset($newData['startD'])?$modalStartDate:''?></td>
													   <td><?php echo isset($newData['endD'])?$modalEndDate:''?></td>
													   <td> <a href = "advertisement.php?action=editAd&adId=<?php echo $newData['id'] ?>" class = "glyphicon glyphicon-pencil" title ="Edit">Edit</a>
													   </td>
													  </tr>
													<?php } ?>

											   </tbody>
											   
											 </table>
											<?php echo "</div>
											<div class='modal-footer'>
										  		<button type='button' class='btn btn-default' data-dismiss='modal' id = 'btnClose' title = 'Close'>Close</button>
											</div>
									  </div>";

								  
							  }
						  }		
						// if existing advertisement count more than allowed value, then check the date here end
			}else{
						$adObject->updateAdData($adType[0]);
						header("Location: ad_list.php");	
					}
			
		}
		else{
					if(isset($_POST['adtype'])){$adType = $_POST['adtype'];}else{$adType = "";}
					$adType = explode('_', $adType);
				    $selectQuery	= "select s.*, ad.* from settings s inner join advertisement ad ON ad.Ad_Type = s.sett_id where s.sett_id = '$adType[0]' AND ad.Ad_Status != 'delete' AND ad.Ad_Status != 'off'";

					$selectData		=   mysqli_query($db, $selectQuery);
					$rowCount = mysqli_num_rows($selectData);
					if(isset($adType[1])){$adType2 = $adType[1];}else{$adType2 = "";}

					$adDate 						= explode(' - ', $_POST['daterange']);	
					$startDate 						= strtr($adDate[0], '/', '-');
					$startDate						= date('Y-m-d H:i:s', strtotime($startDate));
					$endDate   						= strtr($adDate[1], '/', '-');
					$endDate						= date('Y-m-d H:i:s', strtotime($endDate));
					//echo $adType2;
					//echo $rowCount;
					if($rowCount >= $adType2){
							// if existing advertisement count more than allowed value, then check the date here start
							while($row_available = mysqli_fetch_array($selectData)){

							// if overlaping other period dates is true or else
							$DBstartDate = date('Y-m-d H:i:s', strtotime($row_available['Ad_Startdate']));
							$DBendDate = date('Y-m-d H:i:s', strtotime($row_available['Ad_Enddate']));


							if( ((strtotime($startDate) <= strtotime($DBstartDate) && strtotime($startDate) <= 		    strtotime($DBendDate)) &&
							 (strtotime($endDate) <= strtotime($DBstartDate) && strtotime($endDate) <= strtotime($DBendDate))) ||
							  ((strtotime($startDate) >= strtotime($DBstartDate) && strtotime($startDate) >= strtotime($DBendDate)) &&
							  (strtotime($endDate) >= strtotime($DBstartDate) && strtotime($endDate) >= strtotime($DBendDate)) )
							  ){
								$flag = 1;
							}else{
									$flag = 0; 
									//echo "<script> alert('Date Not Available');</script>";
									 $notAvailableAd[] =  array('id' 		=>$row_available['Ad_Id'],
															  'name'	=>$row_available['Ad_Name'],
															  'type'	=>$row_available['sett_where'],
															  'image'	=>$row_available['Ad_Picture'],
															  'startD'	=>$row_available['Ad_Startdate'],
															  'endD'	=>$row_available['Ad_Enddate']);
								    //$adCount	=	count($notAvailableAd);
		

							 }	
						  }
						  if($flag == 1){
							 
							  $adObject->insertAdData($adType[0]);
									echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
									<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
									<strong>inserted! </strong>Successfully.</div>";
						  }else{
							  $flag = 0;
							  
							  if(isset($flag) && $flag == 0){
								  		
											echo "<div class='modal-content' id = 'modalId'>
											<div class='modal-header'>
										  		<button type='button' class='close' title = 'close' data-dismiss='modal'>&times;</button>
												<h4 class='modal-title'>Advertisement already exist in this duration.</h4>
											</div>
											<div class='modal-body' id = 'modalMessage'> ";
												?>
											   <table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25" style="border:none;"><thead>
												   <tr>
													   <th>Ad Name</th>
													   <th>Ad Type</th>
													   <th>Image</th>
													   <th>Start Date</th>
													   <th>End Date</th>
													   <th></th>
												   </tr>
											   <thead>
											   <tbody>
												   <?php
													foreach($notAvailableAd as $newData){
													$modalStartD   		= strtr($newData['startD'], '-', '/');
													$modalStartDate 	= date('d-m-Y H:ia', strtotime($modalStartD));
														
													$modalEndD   		= strtr($newData['endD'], '-', '/');
													$modalEndDate 	= date('d-m-Y H:ia', strtotime($modalEndD));
														
												   ?>
													
													 <tr>
													   <td><?php echo isset($newData['name'])?$newData['name']:''?></td>
													   <td><?php echo isset($newData['type'])?$newData['type']:''?></td>
													   <td><img src="<?php echo $newData['image']?> " alt="Ad Image" style="width:50px;height:50px;"></td>
													   <td><?php echo isset($newData['startD'])?$modalStartDate:''?></td>
													   <td><?php echo isset($newData['endD'])?$modalEndDate:''?></td>
													   <td> <a href = "advertisement.php?action=editAd&adId=<?php echo $newData['id'] ?>" class = "glyphicon glyphicon-pencil" title ="Edit">Edit</a>
													   </td>
													  </tr>
													<?php } ?>

											   </tbody>
											   
											 </table>
											<?php echo "</div>
											<div class='modal-footer'>
										  		<button type='button' class='btn btn-default' data-dismiss='modal' id = 'btnClose' title = 'Close'>Close</button>
											</div>
									  </div>";

								  
							  }
							  
						  }		
						// if existing advertisement count more than allowed value, then check the date here end
			}else{
						//die('');
						$adObject->insertAdData($adType[0]);
						echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
							  <button type='button' id='close' class='close' data-dismiss='alert'>x</button>
							  <strong>inserted! </strong>Successfully.</div>";
					}
	}
		
	}
	
	if(!empty($_GET['adId']) && $_GET['action'] == 'editAd'){
		$adId		= $_GET['adId'];
		$result = mysqli_query($db,"SELECT * FROM `advertisement` WHERE `Ad_Id` = '$adId' ");
		$adData = mysqli_fetch_array($result);	
		$startDate	= $adData['Ad_Startdate'];
		$endDate	= $adData['Ad_Enddate'];	

		$adStart	=	strtr($startDate, '-', '/');
		$adEnd		=	strtr($endDate, '-', '/');

		$advStart 	= date('d/m/Y H:i:s', strtotime($adStart));
		$advEnd 	= date('d/m/Y H:i:s', strtotime($adEnd));
		$advDaterange	= $advStart." - ".$advEnd;
		
		//echo $adData['Ad_Shopid'];
		//die;
	}
}
else{
	header("Location: ../index.php");
	exit;
}


//................................................New COde.........................................

/*if($tokens == $session_tokens){
	
	if(isset($_POST['adtype'])){$adType = $_POST['adtype'];}else{$adType = "";}
	echo $adType."<br/>";
	$adType = explode('_', $adType);
	
	$selectQuery	= "select s.*, ad.* from settings s inner join advertisement ad ON ad.Ad_Type = s.sett_id where s.sett_id = '$adType[0]' AND ad.Ad_Status != 'delete' AND ad.Ad_Status != 'off'";
	
		$selectData		=   mysqli_query($db, $selectQuery);
		$rowCount = mysqli_num_rows($selectData);
	if(isset($adType[1])){$adType2 = $adType[1];}else{$adType2 = "";}
	
	$adDate 						= explode(' - ', $_POST['daterange']);	
	$startDate 						= strtr($adDate[0], '/', '-');
	$startDate						= date('Y-m-d H:i:s', strtotime($startDate));
	$endDate   						= strtr($adDate[1], '/', '-');
	$endDate						= date('Y-m-d H:i:s', strtotime($endDate));
	
	if($rowCount >= $adType2){
		// if existing advertisement count more than allowed value, then check the date here start
		while($row_available = mysqli_fetch_array($selectData)){
			
			// if overlaping other period dates is true or else
			$DBstartDate = date('Y-m-d H:i:s', strtotime($row_available['Ad_Startdate']));
			$DBendDate = date('Y-m-d H:i:s', strtotime($row_available['Ad_Enddate']));
			
			
			if( ((strtotime($startDate) <= strtotime($DBstartDate) && strtotime($startDate) <= strtotime($DBendDate)) &&
			   (strtotime($endDate) <= strtotime($DBstartDate) && strtotime($endDate) <= strtotime($DBendDate))) ||
			  ((strtotime($startDate) >= strtotime($DBstartDate) && strtotime($startDate) >= strtotime($DBendDate)) &&
			  (strtotime($endDate) >= strtotime($DBstartDate) && strtotime($endDate) >= strtotime($DBendDate)) )
			  ){
				echo "available";
			}else{
				echo "not available";
			}
				
				
			
			
			
		}
		// if existing advertisement count more than allowed value, then check the date here end
	}else{
		echo "Direct Inserting code";
	}
}
echo "<br/>";
echo "Given Days: ".strtotime($startDate)." / ".strtotime($endDate);
//is_array($dateNotAvailable);
if(!empty($dateNotAvailable)){
	echo "<br/> Not Available Days: ";
	print_r($dateNotAvailable);
}
if(!empty($dateAvailable)){
	echo "<br/> Available Days: ";
	print_r($dateAvailable);
}*/

?>

<html>

<head>

	<meta charset="utf-8">
	<title>Advertisement :: Dragon Mart Guide</title>
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
							<div class="C-dash1">Advertisement
							<form name="work" method="post" style="display: inline;">
							
							<a href = "advertisement.php" class = "btn btn-xs btn-success" style="display: inline;" title = "New Ad">New Ad</a>
							<a href = "ad_list.php" class = "btn btn-xs btn-primary" style="display: inline;" title = "View Ads">View Ads</a>
							
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

								<form name="register_form" id="register_form" method="post" enctype="multipart/form-data">
								<input type = "hidden" name = "adHiddenID" id = "adHiddenID" value ="<?php if(isset($adId)) echo $adId ;?>">
									<!-- user registration start -->
										<h3 class="Rh3">Advertisement</h3>
										<div class="form-group">
											<label for="adShopName">Shop Name</label>
											<style>
												.shpList option {
													padding: 4px 0px 4px 10px;
												}
											</style>
											<select name="adShopName" id="adShopName" class="form-control shpList">
											<script>
										$(document).ready(function(){
											var wheight  = $('#adShopName').width();
											$('.RRSShop').css('width', wheight);
										});
	
										</script>
												<option value="" class="showSingle" target="0">- - - Select Shop - - -</option>
												<?php
												while($resultData	=	mysqli_fetch_array($shopData)){ 
												$shopNumberSeries =  implode(',',unserialize($resultData['shop_number'])); ?>
													<option class="RRSShop" value = "<?php echo $resultData['shop_id']; ?>" <?php if(isset($adData['Ad_Shopid']) && $resultData['shop_id'] == $adData['Ad_Shopid']) echo "selected"; ?>><?php echo $resultData['shop_name']." ( ".$shopNumberSeries." )" ?></option>
												<?php	}?>
											</select>
										</div>
										<div id = "newShop">
											<div class="form-group">
											<input class="form-control" id="newShopName" name="newShopName" type="text" value="<?php if (isset($adData['Ad_Shopname'])) echo $adData['Ad_Shopname'];?>"  placeholder="New Shop Name" />
											</div>
										</div>
										<div class="input-group">
											<span style="color: red" id="spanNewShop">Shop Name Required</span>
										</div>
										<div class="form-group">
											<label for="adname"> Advertisement Name </label>
											<input class="form-control" id="adname" name="adname" type="text" value="<?php if (isset($adData['Ad_Name'])) echo $adData['Ad_Name'];?>" required="required" placeholder="Advertisement Name" />
										</div>
										<div class="input-group">
											<span style="color: red" id="spanAdName">Invalid Name</span>
										</div>
										
										<div class="form-group">
											<label for="adname"> Ad Url </label>
											<input class="form-control" id="adurl" name="adurl" type="url" value="<?php if (isset($adData['Ad_Url'])) echo $adData['Ad_Url'];?>" required="required" placeholder="Advertisement Url" />
										</div>
										
										<div class="form-group">
											<label for="adtype">Ad Type</label>
											<select name="adtype" id="adtype" class="form-control" required>
												<option value="" class="showSingle" target="0">- - - Select Ad type - - -
												</option>
												<?php while($resultData = mysqli_fetch_array($getResult)){?>
												<option value = "<?php echo $resultData['sett_id']."_".$resultData['sett_val1'];?>"<?php if(isset($adData['Ad_Type']) && $resultData['sett_id']== $adData['Ad_Type']) echo 'selected'?>><?php echo ucwords(str_replace('_', ' ', $resultData['sett_where']))." - ".$resultData['sett_val2']; ?></option>
												<?php }?>
											</select>
										</div>
										
								
								
										<div class="form-group">
											<label for="purchase">Ad Details</label>
											<textarea class="form-control" name="addesc" id="addesc" rows="5"><?php if(isset($adData['Ad_Description'])) echo $adData['Ad_Description'];?></textarea>
										</div>
										<div class="form-group">
											<label for="daterange"> Advertisement Date <span class="text-info">Select date from to</span></label>

											<input class="form-control" type="text" name="daterange" value="<?php if(isset($advDaterange)) echo $advDaterange;?>" />
 
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
										
										<!-- uploads start -->
									<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">-->
										<div class="form-group">
											<label for="comp_bannerimg"> Image <span class="text-info">File: .jpg, .png and .gif only allowed </span></label>
											<!--<input class="form-control" type="file" name="bannerimg" id="bannerimg"/>-->
											<input class="form-control" type="text" name="bannerimg" id="bannerimg" value="<?php if(isset($adData['Ad_Picture'])) echo $adData['Ad_Picture'];  ?>"  data-toggle="modal" data-target="#exampleModal" data-whatever="bannerimg" readonly placeholder="Click to select picture"/>
											
											<div class="testimg1" id="testimg1">
												<img id="bannerimg1" class="testimage" src="<?php if(isset($adData['Ad_Picture'])) echo $adData['Ad_Picture'];  ?>">

											</div>
											<div class="input-group">
											<span style="color: red" id="spanIdAdImage">
												Please select image
											</span>
											</div>
										</div>
									<!--</div>-->
									
									<script>
										$( '#bannerimg' ).focusin( function ( e ) {
											var rurl = $('#bannerimg').val();
											$('#bannerimg1').attr("src",rurl);
											if(rurl == ''){
												var usrpic = $('#userpic_old').val();
												$('#bannerimg1').attr("src",usrpic);
											}
										} );


									</script>
									
										
										
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
	<script src="js/ad.js"></script>
	
</body>
</html>


