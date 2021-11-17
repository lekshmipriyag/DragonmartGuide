<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
include('../Connections/dragonmartguide.php');
$userName = $_SESSION['MM_Username'];

$chPermision = mysqli_query($db, "select * from `user_dmg` where `user_username` = '$userName' AND `user_status` = 'on'");
$check_permission = mysqli_fetch_array($chPermision);
// if don't have permission, this will throw to out
if(!isset($check_permission['user_id'])){
	$permission = "off";
	header("Location: ../index.php");
	exit();
}


$profilePic = $check_permission['user_pic'];
$userloginID = $check_permission['user_id'];
$_SESSION['loginUserid'] = $check_permission['user_id'];
$userName = $check_permission['user_username'];
$_SESSION['live_user_type'] = $check_permission['user_type'];
	
if(isset($check_permission['user_shops'])){
	$_SESSION['PermitedShop_ids'] = unserialize($check_permission['user_shops']);
}

	
if($check_permission['user_type'] == "adminuser"){$usershoplist = array(0=>1);}else{$usershoplist = $_SESSION['PermitedShop_ids'];}

//if(!isset($_SESSION['shop_id']) && isset($check_permission['user_shops'])){$usershoplist = unserialize($check_permission['user_shops']);}

$_SESSION['permission_set'] = unserialize($check_permission['user_permission']);
$permission_set = $_SESSION['permission_set'];


if($check_permission['user_type'] == "adminuser"){

	// admin side users area start
	if((in_array($page_name, $permission_set)) || ($page_name == "index")){
		$permission = "on";
	}else{
		$permission = "off";
		header("Location: ../index.php");
		exit();
	}
	// admin side users area end
}elseif($check_permission['user_type'] == "shopuser"){
	// shop user side users area start
	if(($page_type == "shop_side" && $_SESSION['PermitedShop_ids'] != "") || $page_name == "index"){
		$permission = "on";
		$usershoplist = $_SESSION['PermitedShop_ids'];
	}else{
		$permission = "off";
		header("Location: ../index.php");
		exit();
	}
	// shop user side users area end
}





/*echo "<script>alert('$test');</script>";*/
//if(in_array($page_name, $permission_set)){
//	$permission = "on";
//	if($check_permission['user_type'] == "adminuser" && ($page_type == "admin_side" || $page_type == "shop_side")){}
//	elseif($check_permission['user_type'] == "adminuser" && $page_type == ""){
//		header("Location: company.php");
//	}elseif($check_permission['user_type'] == "shopuser" && ($page_type == "" || $page_type == "admin_side")){
//		$_SESSION['PermitedShop_ids'] = unserialize($check_permission['user_shops']);
//		header("Location: shop_home.php");
//	}elseif($check_permission['user_type'] == "shopuser" && $page_type == "shop_side"){
//		$_SESSION['PermitedShop_ids'] = unserialize($check_permission['user_shops']);
//	}
//}else{
//	$permission = "off";
//}

?>