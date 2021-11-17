<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Dragon mart Tools</title>
</head>

<body>
	<?php include("dragonmartguide.php");
	isset($_POST['select'])?$select = $_POST['select'] :$select = '';
	?>
	<form name="selectform" method="post" enctype="multipart/form-data">
		<select name="select" id="select" onChange="submit();">
			<option value="">- - - Select One - - -</option>
			<option value="values to serialized" <?php if($select=='values to serialized' ){echo 'selected';} ?> >values to serialized</option>
			<option value="values to Json" <?php if($select=='values to Json' ){echo 'selected';} ?> >values to Json</option>
			<option value="????">????</option>
		</select>
	</form>
	<?php
	if ( $select == "values to serialized" ) {
		?>
	<form name="colmArray" method="post" enctype="multipart/form-data">
		<lable>Site Tools - particular column comma separated values to serialized array restoring the same location</lable>
		<br>
		<lable for='tblName'>Table Name</lable>
		<input type="text" name="tblName" value="">
		<lable for='colName'>Column Name</lable>
		<input type="text" name="colName" value="">

		<lable for='IDname'>ID column Name</lable>
		<input type="text" name="IDname" value="">

		<lable for='partiID'>If, ID</lable>
		<input type="text" name="partiID" value="">

		<input type="submit" name="Submit" value="Submit">
	</form>

	<?php
	}
	?>
	<?php
	$spIDcal = '';
	if ( isset( $_POST[ 'colName' ] ) ) {
		$onecolm = $_POST[ 'colName' ];
		$table = $_POST[ 'tblName' ];

		if ( isset( $_POST[ 'IDname' ] ) ) {
			$idColumn = $_POST[ 'IDname' ];
		} else {
			$idColumn = '';
		}

		//$idColumn	= $_POST['IDname'];
		if ( isset( $_POST[ 'partiID' ] ) ) {
			$tid = $_POST[ 'partiID' ];
		} else {
			$tid = '';
		}

		//$tid 		= $_POST['partiID'];

		if ( $tid != '' ) {

			$spIDcal = "where `$table`.`$idColumn`='$tid'";
		}

		$quey = "select `$idColumn`,`$onecolm` from `$table` $spIDcal";
		echo $quey;
		$result1 = mysqli_query( $db, $quey );
		while ( $row1 = mysqli_fetch_array( $result1 ) ) {
			$myArray = explode( '^', $row1[ $onecolm ] );
			$myArray = array_map( 'trim', $myArray );
			$array1 = serialize( $myArray );

			$arrayid1 = $row1[ $idColumn ];
			//echo $arrayid1;
			//die();
			$sqlquery = "UPDATE `$table` SET `$onecolm` = '$array1' WHERE `$table`.`$idColumn` = $arrayid1";

			$queryresult = mysqli_query( $db, $sqlquery );
		}
	}
	?>
<!--	Table to table work tested by RR-->
	<?php
//	include("dragonmartguide.php");
//	$sltShop = mysqli_query($db, "SELECT shop_id, shop_number FROM shop_details where `shop_id`='501'");
//	while($RowShop = mysqli_fetch_array($sltShop)){
//		$idNo = $RowShop['shop_id'];
//		$NumbrArray = unserialize($RowShop['shop_number']);
//		foreach($NumbrArray as $Numbr){
//			echo $idNo.' | '.$Numbr;
//			echo "<br>";
//			
//			$sqlquery = mysqli_query($db, "UPDATE `shop_number` SET `sno_shopid` = '$idNo' WHERE `shop_number`.`sno_number` = '$Numbr'");
//		}
//	}
	?>
	<!--	Table to table work tested by RR-->
	
	
	<!--	Table to same table convert data to json tested by RR-->
	<?php
	
//	include("dragonmartguide.php");
//	
//	$Shop_Cate = mysqli_query($db, "select shop_id, shop_category from `shop_details` limit 1300, 100");
//	while($row_shop = mysqli_fetch_array($Shop_Cate)){
//		$catArray = array();
//		$ship_id = $row_shop['shop_id'];
//		echo $ship_id."<br/>";
//		$shop_shop = unserialize($row_shop['shop_category']);
//		
//		
//			if(!empty($shop_shop)){
//			
//
//			foreach($shop_shop as $shop){
//				$cate_slect = mysqli_query($db, "select * from `categories` where `categories`.`id`='$shop'");
//				$cate_row = mysqli_fetch_array($cate_slect);
//
//				$ids = $cate_row['id'];
//
//				$catArray[$ids] = array("cate_parent" => $cate_row['cate_parent'], "cate_main" => $cate_row['cate_main'], "cate_list" => $cate_row['cate_list'], "cate_subcategory" => $cate_row['cate_subcategory'], "cate_level" => $cate_row['cate_level'], "cate_pid" => $cate_row['cate_pid'], "cate_mid" => $cate_row['cate_mid']);
//			}
//
//			$category = json_encode($catArray);
//
//			$sqlquery1 = "UPDATE `shop_details` SET `shop_category` = '$category' WHERE `shop_details`.`shop_id` = '$ship_id'";
//				
//			$queryresult = mysqli_query( $db, $sqlquery1 )or die( mysqli_error() );
//		}
//	}
	?>
	<!--	Table to same table convert data to json tested by RR-->
</body>

</html>