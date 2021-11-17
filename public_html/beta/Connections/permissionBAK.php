<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
include('../Connections/dragonmartguide.php');
$userName = $_SESSION['MM_Username'];

$chPermision = mysqli_query($db, "select * from `user_dmg` where `user_username` = '$userName' AND `user_status` = 'on'");
$check_permission = mysqli_fetch_array($chPermision);
$profilePic = $check_permission['user_pic'];
$userName = $check_permission['user_username'];

if($check_permission['user_type'] == "adminuser"){$usershoplist = array(0=>1);}else{$usershoplist = unserialize($check_permission['user_shops']);}

if(!isset($_SESSION['shop_id']) && isset($check_permission['user_shops'])){$usershoplist = unserialize($check_permission['user_shops']);}

$_SESSION['permission_set'] = unserialize($check_permission['user_permission']);
$permission_set = $_SESSION['permission_set'];
/*echo "<script>alert('$test');</script>";*/
if(in_array($page_name, $permission_set)){
	$permission = "on";
	if($check_permission['user_type'] == "adminuser" && ($page_type == "admin_side" || $page_type == "shop_side")){}
	elseif($check_permission['user_type'] == "adminuser" && $page_type == ""){
		header("Location: company.php");
	}elseif($check_permission['user_type'] == "shopuser" && ($page_type == "" || $page_type == "admin_side")){
		$_SESSION['PermitedShop_ids'] = unserialize($check_permission['user_shops']);
		header("Location: shop_home.php");
	}elseif($check_permission['user_type'] == "shopuser" && $page_type == "shop_side"){
		$_SESSION['PermitedShop_ids'] = unserialize($check_permission['user_shops']);
	}
}else{
	$permission = "off";
}

?>