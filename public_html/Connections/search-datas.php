<?php


/* ---------- common functions --------------------*/
//$timezone = $_SESSION['comData']['timesone'];
if ( function_exists( 'date_default_timezone_set' ) )date_default_timezone_set( 'Asia/Dubai' );
$national_date_time_24 = date( 'Y-m-d H:i:s' );
$_SESSION[ 'now' ] = $national_date_time_24;
/* ---------- common functions --------------------*/
include('../Connections/dragonmartguide.php');

$srch_keyword = $SkeywordSearch;

$srch_ip	=	$_SERVER['REMOTE_ADDR'];

$srch_time =  date('Y-m-d H:i:s',strtotime($national_date_time_24)-60*60);
$srch_query = "select * from `user_search`  where `srch_word` = '$srch_keyword' AND `srch_ip`='$srch_ip' AND `cre_date` > '$srch_time'";

$srch_result1 = mysqli_query($db, $srch_query);

$srch_row1 = mysqli_fetch_array($srch_result1);

if(isset($srch_row1['srch_id'])){
	$srch_update = "UPDATE `user_search` SET `srch_count` = srch_count +1, `mod_date` = '$national_date_time_24' WHERE `user_search`.`srch_id` = ".$srch_row1['srch_id'];
	mysqli_query($db, $srch_update) or die(mysqli_error($db));
}else{
	$srch_insert = "INSERT INTO `user_search` (`srch_id`, `srch_word`, `srch_count`, `srch_ip`, `result_count`, `cre_date`, `mod_date`) VALUES (NULL, '$srch_keyword', '1', '$srch_ip', '$total', '$national_date_time_24', '')";
	mysqli_query($db, $srch_insert) or die(mysqli_error($db));
}
?>




