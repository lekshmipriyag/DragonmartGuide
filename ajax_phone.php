<?php
if ( !isset( $_SESSION ) ) {
	session_start();
}

if(isset($_POST['shopID']) && $_POST['shopID'] != ""){
	include('Connections/dragonmartguide.php');
	$shopID = $_POST['shopID'];
	mysqli_query($db,"UPDATE `shop_details` SET `shop_offer` = `shop_offer`+1 WHERE `shop_id` = '$shopID'");
}
?>