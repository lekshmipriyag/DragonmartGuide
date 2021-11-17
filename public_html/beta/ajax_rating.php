<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

$pID			= isset($_POST['productId'])?$_POST['productId']:'';
$CookieNewName = 'DMGrate-'.$pID;
//$CookieValue  = $_SESSION['now'];
//setcookie($CookieNewName,$CookieValue,time() + (30));

if(isset($_POST['productId']) && $_POST['productId'] != "" && isset($_POST['shopId']) && $_POST['shopId'] != "" ){
	
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('Connections/dragonmartguide.php');

	 $productId 	= $_POST['productId'];
	 $shopId 		= $_POST['shopId'];
	 $rating 		= $_POST['rating'];
	 $userId 		= '';
	 $createdAt		= $national_date_time_24;
	 $ranking 		= array('userid'=>$userId,'createdAt'=>$createdAt,'rating'=>$rating);
	 $rankingdata	=  serialize($ranking);
	 
	 $selectData 	= mysqli_query($db,"SELECT prodt_ranking FROM product_details WHERE prodt_id = '$productId' AND 					prodt_company_id = '$shopId'");
	 if(mysqli_num_rows($selectData) > 0){
		 $resultData	=	mysqli_fetch_array($selectData);
		 $dbRanking		=	unserialize($resultData['prodt_ranking']);	
		 
		 if(!isset($_COOKIE[$CookieNewName])){
		 $dbRanking[]	=  $ranking;
		 }
		 
		 $data	=	serialize($dbRanking);
		 rsort($dbRanking);
		 $fivecount  = 0;
		 $fourCount	 = 0;
		 $threeCount = 0;
		 $twoCount	 = 0;
		 $oneCount	 = 0;
		 $rateCount	 = 0;
		 $totArrayCount = count($dbRanking);
		 $dbRanking1 = $dbRanking;
		 
		 $filterData = array_slice($dbRanking, 0,15);
		 foreach($filterData as $item => $val){
			 $ratingRank = $val['rating'];
			 $badgeClr = 'badge rcolor'.$ratingRank;
			 echo "<span id = 'ratevalue' class='".$badgeClr."'>".$ratingRank."</span>";
			 
		 }
		 foreach($dbRanking as $dbRank =>$value){
			$rateData = $value['rating'];
			 $rateCount++;
			 if($rateData == '5'){
				 $fivecount++;
			 }
			 if($rateData == '4'){
				 $fourCount++;
			 }
			 if($rateData == '3'){
				 $threeCount++;
			 }
			 if($rateData == '2'){
				 $twoCount++;
			 }
			 if($rateData == '1'){
				 $oneCount++;
			 }
			 

		 }
		 $sumOfCount	=	(1*$oneCount)+(2*$twoCount)+(3*$threeCount)+(4*$fourCount)+(5*$fivecount);
		 $averageRate	=	$sumOfCount/$totArrayCount;
		 $avgRate		=	round($averageRate,2);
		 
			$totalArrayCount	=	count($dbRanking);
			$totalArraySliceCount	= count($filterData)	;	 
			if($totalArrayCount > 15){
				$newCount	=	$totalArrayCount-$totalArraySliceCount;
				echo "...+(".$newCount.")";
			} 
		 ?>
		 <script>
			$('#visitRate').text('<?php echo $avgRate ?>');
			 
		 </script>
		<?php
		 	
		 
			 if(!isset($_COOKIE[$CookieNewName])){
				 $sqlquery = "UPDATE `product_details` SET `prodt_ranking` = '$data' 
						     WHERE `prodt_id` = '$productId' AND `prodt_company_id` = '$shopId' ";
				 mysqli_query($db,$sqlquery);
				 echo "<script>alert('Thank you for rating us!');</script>";
			 } 
		 
	 }else{
		if(!isset($_COOKIE[$CookieNewName])){
			 $sqlquery = "UPDATE `product_details` SET `prodt_ranking` = '$rankingdata' 
								 WHERE `prodt_id` = '$productId' AND `prodt_company_id` = '$shopId' ";
			 mysqli_query($db,$sqlquery); 
		}
	 }

}

if(!isset($_COOKIE[$CookieNewName])){
$cookie_name 	= 'DMGrate-'.$pID;
$cookie_value 	= $pID;
setcookie($cookie_name, $cookie_value, time() + (43200), "/"); // 86400 = 1 day*/
}

else{
	?>
	<script>
	//	$('#visitRate').text('<?php echo $avgRate ?>');
	</script>	
	<?php }?>


<style>
.rcolor {
	background-color: #006838;
	color: #fff;
	font-size:16px;
	font-size:25px;
}
.rcolor5 {
	background-color: #006838;
	color: #fff;
	margin-right: 4px;
}
.rcolor4 {
	background-color: #009444;
	color: #fff;
	margin-right: 4px;
}
.rcolor3 {
	background-color: #8DC63F;
	color: #000;
	margin-right: 4px;
}
.rcolor2 {
	background-color: #F7941E;
	color: #fff;
	margin-right: 4px;
}
.rcolor1 {
	background-color: #ED1C24;
	color: #fff;
	margin-right: 4px;
}
</style>