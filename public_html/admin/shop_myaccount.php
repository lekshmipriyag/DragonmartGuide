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
$page_name = "shop_settings";
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

if(isset($_POST[ 'user_select' ])){$_SESSION[ 'user_select' ] = $_POST[ 'user_select' ];}
if(isset($_POST[ 'newuser' ])){$_SESSION[ 'work' ] = "newuser";}
if(isset($_POST[ 'edituser' ])){$_SESSION[ 'work' ] = "edituser";}
if(isset($_SESSION[ 'work' ])){$work = $_SESSION[ 'work' ];}else{$work = "newuser";}

if(isset($_SESSION['user_select'])){$userSid = $_SESSION['user_select'];}


if(isset($_SESSION['token'])){$session_tokens = $_SESSION['token'];}
if(isset($_POST['token'])){$tokens = $_POST['token'];}else{$tokens=0;}

if(isset($userSid) && $work == "newuser" && $session_tokens == $tokens){
	$crtusr = new users;
	$crtusr->userid =  $userSid;
	$crtusr->C_user();
}

if(isset($userSid) && $work == "edituser" && $session_tokens == $tokens){
	$crtusr = new users;
	$crtusr->userid =  $userSid;
	
	if($_POST['bannerimg'] != ""){$crtusr->sp_picture = $_POST['bannerimg'];}else{$crtusr->sp_picture = $_POST['userpic_old'];}
	
	$crtusr->U_user();
}



if(isset($userSid) && $userSid > 0 && $work == "edituser"){
$user_result = mysqli_query( $db, "select * from `user_dmg` where `user_dmg`.`user_id`='$userSid'" );
$userRow = mysqli_fetch_array( $user_result );
	$_SESSION['shop_username'] = $userRow['user_username'];

$shop_result = mysqli_query($db, "SELECT * FROM `shop_details` WHERE `shop_user_id` in ('', 0, $userSid) AND `shop_status`='on' ORDER BY `shop_details`.`shop_name` ASC");
}else{
	$shop_result = mysqli_query($db, "SELECT * FROM `shop_details` WHERE `shop_user_id` in ('', 0) AND `shop_status`='on' ORDER BY `shop_details`.`shop_name` ASC");
}
while($shopRow = mysqli_fetch_array( $shop_result )){

	if(isset($userSid) && $shopRow['shop_user_id'] == $userSid){
		$thishopnoSelt[$shopRow['shop_id']] = $shopRow['shop_name']." (".implode(',', unserialize($shopRow['shop_number'])).")";
	}else{
	$thishopno[$shopRow['shop_id']] = $shopRow['shop_name']." (".implode(',', unserialize($shopRow['shop_number'])).")";
		}
}

?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>My Account :: Dragon Mart Guide</title>
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
							<div class="C-dash1">User Settings 
							<form name="work" method="post" style="display: inline;">
							<input class="btn btn-xs btn-success" type="submit" name="newuser" value="New User"  style="display: inline;" onclick="submit();"/>
							<input class="btn btn-xs btn-primary" type="submit" name="edituser" value="Edit User"  style="display: inline;" onclick="submit();"/>
							</form>
							</div>
							<div class="C-dash2">view and edit</div>
						</div>
						<div class="row">
						<?php if($work == "edituser"){ ?>
							<div class="col-lg-12 C-main-in">
								<div class="form-group">
									<form name="cngshop" method="post" enctype="multipart/form-data" data-toggle="validator" role="form">
										<label for="user_select"> Select User Name </label>
										<select name="user_select" id="user_select" class="form-control" onchange="submit();">
											<option value="0">--- Create New User ---</option>

											<?php
											$prmt_user = mysqli_query( $db, "select * from `user_dmg`" );
											while ( $prmt_row = mysqli_fetch_array($prmt_user) ) {
												?>

											<option value="<?php echo $prmt_row['user_id']; ?>" <?php if(isset($userSid) && $prmt_row[ 'user_id'] == $userSid){echo "selected";} ?> >
												<?php echo $prmt_row['user_name']; ?> (
												<?php echo $prmt_row['user_username']; ?> )
											</option>
											<?php
											}
											?>
										</select>
									</form>
								</div>
							</div>
						<?php } ?>
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
								<input name="foilautofill" style="display: none;" type="password" />
									<!-- user registration start -->
									
										<h3 class="Rh3">User Info</h3>
										<div class="form-group">
											<label for="username"> User Name <span class="text-info">Email: username@domain.com </span></label>
											<input class="form-control" id="username" name="username" type="email" value="<?php if(isset($userRow['user_username'])){echo $userRow['user_username'];} ?>" required="required" placeholder="Email: name@domain.com" onBlur="checkAvailability();" <?php if($work == "edituser"){echo "readonly";} ?>  />
											<span id="user-availability-status"></span>
											<img src="../images/LoaderIcon.gif" id="loaderIcon" style="display:none" />
										</div>
										<div class="form-group">
											<label for="password"> Password <span class="text-info">Minimum 6 : Atleast 1 Number </span></label>
											
											<input class="form-control" id="password" name="password" type="password" value="" placeholder="Minimum 6 : Atleast 1 Number " <?php if(isset($_SESSION['work']) && $_SESSION['work'] == "newuser"){echo "required='required'";} ?>  autocomplete="off" />
										</div>
										<div class="form-group">
											<label for="confirm_password"> Confirm Password <button type="button" class="btn btn-success btn-xs" onClick="generatePass();">Password Generator</button> <div id="gpass" class="text-danger" style="display: inline; margin-left: 25px;"></div></label>
											<script>
												function generatePass(){
												var randomstring = Math.random().toString(36).slice(-8);
												$('#gpass').html(randomstring);
												};
											</script>
											
											<input class="form-control" id="confirm_password" name="confirm_password" type="password" data-match="#password" data-match-error="Whoops, these don't match" placeholder="Confirm" <?php if(isset($_SESSION['work']) && $_SESSION['work'] == "newuser"){echo "required='required'";} ?> />
										</div>
										
										<div class="form-group">
											<label for="name"> Contact Name </label>
											<input class="form-control" id="name" name="name" type="text" value="<?php if(isset($userRow['user_name'])){echo $userRow['user_name'];}  ?>" required="required" />
										</div>
										
										<div class="form-group">
											<label for="gender"> Gender </label>
											<select class="form-control" name="gender" id="gender">
												<option value="">--- Select Gender ---</option>
												
												<?php if(isset($userRow['user_gender'])){$gender = $userRow['user_gender'];}else{$gender = "Nil";} ?>
												
												<option <?php if($gender == "Male"){echo "selected";} ?> value="Male">Male</option>
												
												<option <?php if($gender == "Female"){echo "selected";} ?> value="Female" >Female</option>
												
											</select>
											
										</div>
										
										<div class="form-group">
											<label for="address"> Address </label>
											<input class="form-control" id="address" name="address" type="text" value="<?php if(isset($userRow['user_address'])){echo $userRow['user_address'];}  ?>" required="required" rows="2" />
										</div>
										
										<div class="form-group">
											<label for="address"> Mobile No </label>
											<input class="form-control" id="mobile" name="mobile" type="tel" value="<?php if(isset($userRow['user_mobile'])){echo $userRow['user_mobile'];}  ?>" required="required" />
										</div>
										
										<div class="form-group">
											<label for="gender"> Type of User </label>
											<select class="form-control" name="usertype" id="usertype" onChange="pagecontrol();">
												<option value="">--- Select Type ---</option>
												
												<?php if(isset($userRow['user_type'])){$usertype = $userRow['user_type'];}else{$usertype = "Nil";} ?>
												
												<option <?php if($usertype == "shopuser"){echo "selected";} ?> value="shopuser">Shop User</option>
												
												<option <?php if($usertype == "adminuser"){echo "selected";} ?> value="adminuser">Admin User</option>
												
											</select>
											
										</div>
									<div class="form-group" id="pagecontrol" <?php if($usertype == "shopuser"){echo "style='display: none;'";} ?> >
										<?php
										$pageresult = mysqli_query($db, "select * from `pages` where `pages`.`page_type`='pagepermission' and `page_status`='on' ORDER BY `pages`.`page_name` ASC");
										while($pagelist = mysqli_fetch_array($pageresult)){
											if($pagelist['page_function'] == "admin_side"){
												$admin_side[] = $pagelist['page_name'];
											}
											else{
												$shop_side[] = $pagelist['page_name'];
											}
										}
										?>
										<fieldset style="border: solid 1px #ccc;">
											<legend>Admin Pages</legend>
										<?php
										
											if(isset($userRow['user_permission'])){
												$permisnArray = unserialize($userRow['user_permission']);
											}else{
												$permisnArray = array(0=>1);
											}
											

											foreach($admin_side as $admin_side1){
												$admin_side2 = ucwords(str_replace('_', ' ', $admin_side1));
										?>
										<div class="col-lg-3 col-sm-4 col-xs-12"><label><input type="checkbox" name="pagenames[]" value="<?php echo $admin_side1; ?>" <?php if(is_array($permisnArray) && in_array($admin_side1, $permisnArray)){echo "checked";} ?> /> <?php echo $admin_side2; ?></label></div>
										<?php
												
											}
										?>
	
										</fieldset>
										<fieldset style="border: solid 1px #ccc;">
											<legend>Shop Pages</legend>
										<?php
										foreach($shop_side as $shop_side1){
										$shop_side2 = ucwords(str_replace('_', ' ', $shop_side1));
										?>
										<div class="col-lg-3 col-sm-4 col-xs-12"><label><input type="checkbox" name="pagenames[]" value="<?php echo $shop_side1; ?>" <?php if(is_array($permisnArray) && in_array($shop_side1, $permisnArray)){echo "checked";} ?> /> <?php echo $shop_side2; ?></label></div>
										<?php
												
											}
										?>
										
										</fieldset>
										
									</div>
									
									<div class="form-group C-slist" id="shoplist_div" <?php if($usertype == "adminuser"){echo "style='display: none;'";} ?> >
									 <label> Shop List </label><br>
									 <select id="framework" name="framework[]" multiple class="form-control" >
									 <?php
										 if(isset($thishopnoSelt)){
											 foreach($thishopnoSelt as $key => $value){
											 echo "<option value='".$key."' selected>".$value."</option>";
										 	}
										 }
										 
										 foreach ($thishopno as $key => $value) {

											echo "<option value='".$key."'>".$value."</option>";

										 }
									?>
									 </select>
									 
									 <script>
								$(document).ready(function(){
								 $('#framework').multiselect({
								  nonSelectedText: 'Select Shops',
								  enableFiltering: true,
								  enableCaseInsensitiveFiltering: true,
								  buttonWidth:'100%'
								 });

								// $('#framework_form').on('submit', function(event){
								//  event.preventDefault();
								//  var form_data = $(this).serialize();
								//  $.ajax({
								//   url:"insert.php",
								//   method:"POST",
								//   data:form_data,
								//   success:function(data)
								//   {
								//    $('#framework option:selected').each(function(){
								//     $(this).prop('selected', false);
								//    });
								//    $('#framework').multiselect('refresh');
								//    alert(data);
								//   }
								//  });
								// });


								});
								</script>
									 
									</div> 
									<script>
									function pagecontrol(){
										var pager = $('#usertype').val();
										if(pager == 'adminuser'){
											$('#pagecontrol').show();
											$('#shoplist_div').hide();
										}else if(pager == 'shopuser'){
											$('#pagecontrol').hide();
											$('#shoplist_div').show();
										}else if(pager == ''){
											$('#shoplist_div').hide();
											$('#pagecontrol').hide();
										}
									}
									
										$(document).ready(function(){
											var pager = $('#usertype').val();
											if(pager == ""){
												$('#shoplist_div').hide();
												$('#pagecontrol').hide();
											}
										});

									</script>

																	
									

									<!-- uploads start -->
									<!--<div class="col-lg-12" style="border-top:solid 1px #ccc;">
										<h3 class="Rh3">Uploads</h3>
									</div>-->
									<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">-->
										<div class="form-group">
											<label for="comp_bannerimg"> Profile Picture <span class="text-info">File: .jpg, .png and .gif only allowed </span></label>
											<!--<input class="form-control" type="file" name="bannerimg" id="bannerimg"/>-->
											<input class="form-control" type="text" name="bannerimg" id="bannerimg" value=""  data-toggle="modal" data-target="#exampleModal" data-whatever="bannerimg" readonly placeholder="Click to select picture" />
											
											<div class="testimg1" id="testimg1">
												<img id="bannerimg1" class="testimage" src="<?php if(isset($userRow['user_pic'])){echo $userRow['user_pic'];} ?>">

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
									
									
									<!-- uploads end -->
									
									
									<div class="col-lg-12">
								
								<?php
								$token = uniqid( '', true );
								$_SESSION[ 'token' ] = $token;
								?>
								
								<input type="hidden" name="token" value="<?php echo $token; ?>" >
								<input type="hidden" name="userID" value="<?php if(isset($userRow['user_id'])){echo $userRow['user_id'];} ?>" >
								
								<input type="hidden" name="userpic_old" id="userpic_old" value="<?php if(isset($userRow['user_pic'])){echo $userRow['user_pic'];} ?>" >
								<textarea name="shopids_old" style="display: none;"><?php if(isset($userRow['user_shops'])){echo $userRow['user_shops'];} ?></textarea>
								
									</div>
									
									
									<!-- Button start -->
									<div class="col-lg-12" style="border-top:solid 1px #ccc; text-align: right; padding: 15px 0 15px 0;">

										<input class="btn btn-warning btn-lg" type="submit" id="submit" name="submit" value="Submit Form">
										<input class="btn btn-default btn-lg" type="reset" name="reset" value="Reset Form">
										
									</div>
									<!-- Button end -->
									
									
									
									
									
									
								
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
	<script>
		$(document).ready (function(){
			$("#success-alert").delay(5000).hide(500);
		 });
		

		// condirm password validation script start								
		var password = document.getElementById("password") , confirm_password = document.getElementById("confirm_password");

		function validatePassword(){
		  if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
			confirm_password.setCustomValidity('');
		  }
		}
		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
		// condirm password validation script end
		
		
		// username availability checking start
		function checkAvailability() {
			var newbox = $("#username").val();
			var sesnusr = '<?php echo $_SESSION['shop_username']; ?>';
		if(newbox != sesnusr){

		$("#loaderIcon").show();
		jQuery.ajax({
		url: "username_availability.php",
		data:'username='+$("#username").val(),
		type: "POST",
		success:function(data){
		$("#user-availability-status").html(data);
		$("#loaderIcon").hide();
		},
		error:function (){}
		});
		}	
		}
		// username availability checking end

	</script>
	
</body>

</html>