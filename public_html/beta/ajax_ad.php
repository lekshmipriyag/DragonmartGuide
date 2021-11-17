<?php
if ( !isset( $_SESSION ) ) {
	session_start();
}

if(isset($_POST['imageID']) && $_POST['imageID'] != ""){
	include('Connections/dragonmartguide.php');
	$AdID = $_POST['imageID'];
	$selectData		=	mysqli_query($db,"SELECT Ad_Url FROM advertisement WHERE Ad_Id = '$AdID' AND Ad_Status = 'on'");
	$resultData 	=  mysqli_fetch_array($selectData);
	echo $imageUrl		=	$resultData['Ad_Url'];
	mysqli_query($db,"UPDATE `advertisement` SET `Ad_Clicks` = `Ad_Clicks`+1 WHERE `Ad_Id` = '$AdID' AND Ad_Status = 'on'");
}

