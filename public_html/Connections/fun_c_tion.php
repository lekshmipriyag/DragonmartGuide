<?php
/************************************************************************/
/* @category 	Multi cms with multi permissions 						*/
/* @package 	Shop listing portal 									*/
/* @author 		Original Author Raja Ram R <rajaram234r@gmail.com>		*/
/* @author 		Another Author Farook <mohamedfarooks@gmail.com> 		*/
/* @copyright 	2016 - 2017 ewebeye.com 								*/
/* @license 	Raja Ram R 												*/
/* @since 		This file available since 2.10 							*/
/* @date 		Created date 03/07/2017 								*/
/* @modify 		Latest modified date 27/07/2017 						*/
/* @code 		PHP 5.7 												*/
/************************************************************************/
?>
<?php

//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}

/* ---------- common functions --------------------*/
//$timezone = $_SESSION['comData']['timesone'];
if ( function_exists( 'date_default_timezone_set' ) )date_default_timezone_set( 'Asia/Dubai' );
$national_date_time_24 = date( 'Y-m-d H:i:s' );
$_SESSION[ 'now' ] = $national_date_time_24;
/* ---------- common functions --------------------*/
?>
<?php
class Updates{  
	
	public $updateId;
	public $action;
	public $pageName;
	public $tableName;
	public $rowId;
	public $userId;
	public $data;
	public $updateTime;
	public $viewStatus;
	
	public function processInformation($action,$pageName,$tableName,$rowId,$userId,$data,$updateTime){			
		
		include( '../Connections/dragonmartguide.php' );
		
		$sqlqueryForUpdateInfo = "INSERT INTO `updt_info` (`updt_id`, `updt_type`, `updt_pagename`, `updt_tablename`, `updt_rowid`, `updt_userid`, `updt_data`, `updt_time`, `updt_viewstatus`)VALUES (NULL, '$action', '$pageName', '$tableName', '$rowId', '$userId', '$data', '".$updateTime."', 'not viewed')";
			
		mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));
	}
}

?>
<?php
class SHOP {
	public $sp_id;
	public $sp_category;
	public $sp_name;
	public $sp_license_no;
	public $sp_number;
	public $sp_old_number;
	public $sp_mall;
	public $sp_zone;
	public $sp_floor;
	public $sp_landmark;
	public $sp_near_parking;
	public $sp_near_gate;
	public $sp_contact_person;
	public $sp_maincontact;
	public $sp_mobile1;
	public $sp_mobile2;
	public $sp_whatsapp;
	public $sp_wechat;
	public $sp_tel;
	public $sp_email;
	public $sp_website;
	public $sp_socialmedia;
	public $sp_bus_type;
	public $sp_address;
	public $sp_city;
	public $sp_state;
	public $sp_country;
	public $sp_delivery;
	public $sp_expt;
	public $sp_paytype;
	public $sp_logo;
	public $sp_picture;
	public $sp_keywords;
	public $sp_description;
	public $sp_profile;
	public $sp_offer;
	public $sp_future_list;
	public $sp_event;
	public $sp_cre;
	public $sp_modi;
	public $sp_status;

	public
	function m_shop() {
		include( '../Connections/dragonmartguide.php' );
		//include( '../Connections/picture_handling.php' );
		$this->sp_id = $_POST[ 'shopid' ];
		//$this->sp_category = $_POST[''];
		$this->sp_name = $_POST[ 'comp_name' ];
		//$this->sp_license_no = $_POST[''];

		$compno = explode( ",", $_POST[ 'comp_no' ] );
		$compno = array_map( 'trim', $compno );
		$this->sp_number = serialize( $compno );

		$compold = serialize( array_map( 'trim', explode( ',', $_POST[ 'shopnos_old' ] ) ) );

		$this->sp_mall = $_POST[ 'comp_location' ];
		$this->sp_zone = $_POST[ 'comp_zone' ];
		$this->sp_floor = $_POST[ 'comp_floor' ];
		$this->sp_landmark = $_POST[ 'comp_landmart' ];
		$this->sp_near_parking = $_POST[ 'comp_parking' ];
		$this->sp_near_gate = $_POST[ 'comp_parking' ];
		$this->sp_contact_person = $_POST[ 'comp_person' ];
		$this->sp_maincontact = $_POST[ 'comp_primary' ];
		$this->sp_mobile1 = $_POST[ 'comp_contact1' ];
		$this->sp_mobile2 = $_POST[ 'comp_contact2' ];

		/*Whatsapp area*/
		if ( isset( $_POST[ 'comp_contact1Wa' ] ) && $this->sp_mobile1 != "" ) {
			$wats1 = "mobile1";
		} else {
			$wats1 = "na";
		}
		if ( isset( $_POST[ 'comp_contact2Wa' ] ) && $this->sp_mobile2 != "" ) {
			$wats2 = "mobile2";
		} else {
			$wats2 = "na";
		}
		$wats = $wats1 . "," . $wats2;
		$whatsapp = serialize( explode( ",", $wats ) );
		$this->sp_whatsapp = $whatsapp;

		/*Wechat area*/
		if ( isset( $_POST[ 'comp_contact1Wc' ] ) && $this->sp_mobile1 != "" ) {
			$wect1 = "mobile1";
		} else {
			$wect1 = "na";
		}
		if ( isset( $_POST[ 'comp_contact2Wc' ] ) && $this->sp_mobile2 != "" ) {
			$wect2 = "mobile2";
		} else {
			$wect2 = "na";
		}
		$wect = $wect1 . "," . $wect2;
		$wechat = serialize( explode( ",", $wect ) );
		$this->sp_wechat = $wechat;

		$this->sp_tel = $_POST[ 'comp_tel' ];
		$this->sp_email = $_POST[ 'comp_email' ];
		$this->sp_website = $_POST[ 'comp_website' ];

		if ( isset( $_POST[ 'comp_twitter' ] ) ) {
			$twiter = $_POST[ 'comp_twitter' ];
		} else {
			$twiter = "na";
		}
		if ( isset( $_POST[ 'comp_facebook' ] ) ) {
			$facbok = $_POST[ 'comp_facebook' ];
		} else {
			$facbok = "na";
		}
		if ( isset( $_POST[ 'comp_instagram' ] ) ) {
			$intstgrm = $_POST[ 'comp_instagram' ];
		} else {
			$intstgrm = "na";
		}
		if ( isset( $_POST[ 'comp_google' ] ) ) {
			$gplus = $_POST[ 'comp_google' ];
		} else {
			$gplus = "na";
		}
		if ( isset( $_POST[ 'comp_pinterest' ] ) ) {
			$pntrst = $_POST[ 'comp_pinterest' ];
		} else {
			$pntrst = "na";
		}
		if ( isset( $_POST[ 'comp_youtube' ] ) ) {
			$youtb = $_POST[ 'comp_youtube' ];
		} else {
			$youtb = "na";
		}


		$social = array( "twitter" => $twiter, "facebook" => $facbok, "instagram" => $intstgrm, "googleplus" => $gplus, "pinterest" => $pntrst, "youtube" => $youtb );

		$this->sp_socialmedia = serialize( $social );

		$this->sp_bus_type = $_POST[ 'comp_bis_type' ];
		//$this->sp_address = $_POST[''];
		$this->sp_city = $_POST[ 'comp_city' ];
		$this->sp_state = $_POST[ 'comp_emirate' ];
		$this->sp_country = $_POST[ 'comp_country' ];
		if(isset($_POST[ 'delivery' ])){$this->sp_delivery = $_POST[ 'delivery' ];}else{$this->sp_delivery = '';}
		
		$this->sp_expt = $_POST[ 'comp_export' ];

		if ( isset( $_POST[ 'cash' ] ) ) {
			$cash = $_POST[ 'cash' ];
		} else {
			$cash = "na";
		}
		if ( isset( $_POST[ 'cheque' ] ) ) {
			$cheque = $_POST[ 'cheque' ];
		} else {
			$cheque = "na";
		}
		if ( isset( $_POST[ 'cards' ] ) ) {
			$cards = $_POST[ 'cards' ];
		} else {
			$cards = "na";
		}

		$payment = $cash . "," . $cheque . "," . $cards;
		$payment = explode( ',', $payment );
		$this->sp_paytype = serialize( $payment );
		$this->sp_keywords = addslashes($_POST[ 'keywords' ]);
		$this->sp_description = addslashes($_POST[ 'description' ]);
		$this->sp_profile = addslashes($_POST[ 'profile' ]);
		//$this->sp_offer = $_POST[''];
		//$this->sp_future_list = $_POST[''];
		//$this->sp_event = $_POST[''];
		//$this->sp_cre = $_POST[''];
		//$this->sp_modi = $_POST[''];
		$this->sp_status = $_POST['shopstatus'];

		if (isset($_POST['bannerimg']) && $_POST['bannerimg'] != '') {
			$this->sp_picture = $_POST['bannerimg'];
		} else {
			$this->sp_picture = $_POST['bannerimgold'];
		}

		if (isset($_POST['logoimg']) && $_POST['logoimg'] != '') {
			$this->sp_logo = $_POST['logoimg'];
		} else {
			$this->sp_logo = $_POST['logoimgold'];
		}
		//echo $this->sp_picture." :main pic<br>";
		//echo $this->sp_logo." :logo pic<br>";
		//die;
		if(isset($_POST['cate'])){$this->sp_category = $_POST['cate'];}else{$this->sp_category[] = 0;}
		
		$this->sp_category = implode("','",$this->sp_category);
		$catArray = array();
		//echo "selected: ". $this->sp_category;
		
		$Cquery = "select * from `categories` where `id` IN ('$this->sp_category') AND `status`='on'";
		//die();
		$cart_select = mysqli_query($db, $Cquery);
		while($cate_row = mysqli_fetch_assoc($cart_select)){
			$ids = $cate_row['id'];
	
			$catArray[$ids] = array("cate_parent" => $cate_row['cate_parent'], "cate_main" => $cate_row['cate_main'], "cate_list" => $cate_row['cate_list'], "cate_subcategory" => $cate_row['cate_subcategory'], "cate_level" => $cate_row['cate_level'], "cate_pid" => $cate_row['cate_pid'], "cate_mid" => $cate_row['cate_mid']);
		}
		$this->sp_category = json_encode($catArray);
		
		
		
		$sqlquery = "UPDATE `shop_details` SET `shop_category` = '$this->sp_category', `shop_name` = '$this->sp_name', `shop_number` = '$this->sp_number', `shop_mall` = '$this->sp_mall', `shop_zone` = '$this->sp_zone', `shop_floor` = '$this->sp_floor', `shop_landmark` = '$this->sp_landmark', `shop_near_parking` = '$this->sp_near_parking', `shop_near_gate` = '$this->sp_near_gate', `shop_contact_person` = '$this->sp_contact_person', `shop_maincontact` = '$this->sp_maincontact', `shop_mobile1` = '$this->sp_mobile1', `shop_mobile2` = '$this->sp_mobile2', `shop_whatsapp` = '$this->sp_whatsapp', `shop_wechat` = '$this->sp_wechat', `shop_tel` = '$this->sp_tel', `shop_email` = '$this->sp_email', `shop_website` = '$this->sp_website', `shop_socialmedia` = '$this->sp_socialmedia', `shop_bus_type` = '$this->sp_bus_type', `shop_address` = '$this->sp_address', `shop_city` = '$this->sp_city', `shop_state` = '$this->sp_state', `shop_country` = '$this->sp_country', `shop_delivery` = '$this->sp_delivery', `shop_expt` = '$this->sp_expt', `shop_paytype` = '$this->sp_paytype', `shop_logo` = '$this->sp_logo', `shop_picture` = '$this->sp_picture', `shop_keywords` = '$this->sp_keywords', `shop_description` = '$this->sp_description', `shop_profile` = '$this->sp_profile', `shop_offer` = '$this->sp_offer', `shop_feature_list` = '$this->sp_future_list', `shop_event` = 'event', `shop_modi` = '" . $_SESSION[ 'now' ] . "' WHERE `shop_details`.`shop_id` = '$this->sp_id'";
		//echo $sqlquery;
		
		$queryresult = mysqli_query( $db, $sqlquery )or die( mysqli_error() );
		
		if ( $this->sp_number != $compold ) {
			$this->sp_old_number = unserialize( $compold );
			foreach ( $this->sp_old_number as $compold_1 ) {
				/*echo "<script>alert('$this->sp_id');</script>";*/

				$sqlquery1 = "UPDATE `shop_number` SET `sno_shopid` = '0' WHERE `shop_number`.`sno_number` = '$compold_1'";
				$queryresult = mysqli_query( $db, $sqlquery1 )or die( mysqli_error() );
			}

			$this->sp_number = unserialize( $this->sp_number );
			foreach ( $this->sp_number as $compNew ) {

				$sqlquery2 = "UPDATE `shop_number` SET `sno_shopid` = '$this->sp_id' WHERE `shop_number`.`sno_number` = '$compNew'";
				$queryresult = mysqli_query( $db, $sqlquery2 )or die( mysqli_error() );
			}
		}
		
		$last_insert_id	= $this->shop_id;
			$insertData		= mysql_real_escape_string($sqlquery);
			$tableName		= 'shop_details';
			$page_name		= 'newshop';
			 $updateInfoObj = new Updates();
			  $a = $updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
		print_r( $a );
		
		
		echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Your shop details updated successfully.</div>";

	}



	public
	function C_shop() {
		include( '../Connections/dragonmartguide.php' );

		$this->sp_name = $_POST[ 'comp_name' ];

		$compno = explode( ",", $_POST[ 'comp_no' ] );
		$compno = array_map( 'trim', $compno );
		$this->sp_number = serialize( $compno );


		$this->sp_mall = $_POST[ 'comp_location' ];
		$this->sp_zone = $_POST[ 'comp_zone' ];
		$this->sp_near_parking = $_POST[ 'comp_parking' ];
		$this->sp_floor = $_POST[ 'comp_floor' ];
		$this->sp_landmark = $_POST[ 'comp_landmart' ];
		$this->sp_city = $_POST[ 'comp_city' ];
		$this->sp_state = $_POST[ 'comp_emirate' ];
		$this->sp_country = $_POST[ 'comp_country' ];
		$this->sp_contact_person = $_POST[ 'comp_person' ];
		$this->sp_maincontact = $_POST[ 'comp_primary' ];
		$this->sp_mobile1 = $_POST[ 'comp_contact1' ];
		$this->sp_mobile2 = $_POST[ 'comp_contact2' ];

		/*Whatsapp area*/
		if ( isset( $_POST[ 'comp_contact1Wa' ] ) && $this->sp_mobile1 != "" ) {
			$wats1 = "mobile1";
		} else {
			$wats1 = "na";
		}
		if ( isset( $_POST[ 'comp_contact2Wa' ] ) && $this->sp_mobile2 != "" ) {
			$wats2 = "mobile2";
		} else {
			$wats2 = "na";
		}
		$wats = $wats1 . "," . $wats2;
		$whatsapp = serialize( explode( ",", $wats ) );
		$this->sp_whatsapp = $whatsapp;
		/*Whatsapp area*/

		/*Wechat area*/
		if ( isset( $_POST[ 'comp_contact1Wc' ] ) && $this->sp_mobile1 != "" ) {
			$wect1 = "mobile1";
		} else {
			$wect1 = "na";
		}
		if ( isset( $_POST[ 'comp_contact2Wc' ] ) && $this->sp_mobile2 != "" ) {
			$wect2 = "mobile2";
		} else {
			$wect2 = "na";
		}
		$wect = $wect1 . "," . $wect2;
		$wechat = serialize( explode( ",", $wect ) );
		$this->sp_wechat = $wechat;
		/*Wechat area*/

		$this->sp_tel = $_POST[ 'comp_tel' ];
		$this->sp_email = $_POST[ 'comp_email' ];
		$this->sp_website = $_POST[ 'comp_website' ];
		$this->sp_bus_type = $_POST[ 'comp_bis_type' ];
		$this->sp_delivery = $_POST[ 'delivery' ];
		$this->sp_expt = $_POST[ 'comp_export' ];

		/*social media area*/
		if ( isset( $_POST[ 'comp_twitter' ] ) ) {
			$twiter = $_POST[ 'comp_twitter' ];
		} else {
			$twiter = "na";
		}
		if ( isset( $_POST[ 'comp_facebook' ] ) ) {
			$facbok = $_POST[ 'comp_facebook' ];
		} else {
			$facbok = "na";
		}
		if ( isset( $_POST[ 'comp_instagram' ] ) ) {
			$intstgrm = $_POST[ 'comp_instagram' ];
		} else {
			$intstgrm = "na";
		}
		if ( isset( $_POST[ 'comp_google' ] ) ) {
			$gplus = $_POST[ 'comp_google' ];
		} else {
			$gplus = "na";
		}
		if ( isset( $_POST[ 'comp_pinterest' ] ) ) {
			$pntrst = $_POST[ 'comp_pinterest' ];
		} else {
			$pntrst = "na";
		}
		if ( isset( $_POST[ 'comp_youtube' ] ) ) {
			$youtb = $_POST[ 'comp_youtube' ];
		} else {
			$youtb = "na";
		}

		$social = array( "twitter" => $twiter, "facebook" => $facbok, "instagram" => $intstgrm, "googleplus" => $gplus, "pinterest" => $pntrst, "youtube" => $youtb );

		$this->sp_socialmedia = serialize( $social );
		/*social media area*/


		$this->sp_keywords = htmlentities( $_POST[ 'keywords' ] );
		$this->sp_keywords = mysql_real_escape_string( $this->sp_keywords );

		$this->sp_description = htmlentities( $_POST[ 'description' ] );
		$this->sp_description = mysql_real_escape_string( $this->sp_description );

		$this->sp_profile = htmlentities( $_POST[ 'profile' ] );
		$this->sp_profile = mysql_real_escape_string( $this->sp_profile );

		$this->sp_logo = $_POST[ 'logoimg' ];
		$this->sp_picture = $_POST[ 'bannerimg' ];

		/*payment mode area*/
		if ( isset( $_POST[ 'cash' ] ) ) {
			$cash = $_POST[ 'cash' ];
		} else {
			$cash = "na";
		}
		if ( isset( $_POST[ 'cheque' ] ) ) {
			$cheque = $_POST[ 'cheque' ];
		} else {
			$cheque = "na";
		}
		if ( isset( $_POST[ 'cards' ] ) ) {
			$cards = $_POST[ 'cards' ];
		} else {
			$cards = "na";
		}
		$payment = $cash . "," . $cheque . "," . $cards;
		$payment = explode( ',', $payment );
		$this->sp_paytype = serialize( $payment );
		/*payment mode area*/


		$sqlquery = "INSERT INTO `shop_details` (`shop_id`, `shop_category`, `shop_name`, `shop_user_id`, `shop_number`, `shop_mall`, `shop_zone`, `shop_floor`, `shop_landmark`, `shop_near_parking`, `shop_near_gate`, `shop_contact_person`, `shop_maincontact`, `shop_mobile1`, `shop_mobile2`, `shop_whatsapp`, `shop_wechat`, `shop_tel`, `shop_email`, `shop_website`, `shop_socialmedia`, `shop_bus_type`, `shop_address`, `shop_city`, `shop_state`, `shop_country`, `shop_delivery`, `shop_expt`, `shop_paytype`, `shop_logo`, `shop_picture`, `shop_keywords`, `shop_description`, `shop_profile`, `shop_priv_start`, `shop_priv_end`, `shop_priv_type`, `shop_offer`, `shop_feature_list`, `shop_event`, `shop_cre`, `shop_modi`, `shop_status`) VALUES (NULL, 'shop_category', '$this->sp_name', '', '$this->sp_number', '$this->sp_mall', '$this->sp_zone', '$this->sp_floor', '$this->sp_landmark', '$this->sp_near_parking', '', '$this->sp_contact_person', '$this->sp_maincontact', '$this->sp_mobile1', '$this->sp_mobile2', '$this->sp_whatsapp', '$this->sp_wechat', '$this->sp_tel', '$this->sp_email', '$this->sp_website', '$this->sp_socialmedia', '$this->sp_bus_type', '', '$this->sp_city', '$this->sp_state', '$this->sp_country', '$this->sp_delivery', '$this->sp_expt', '$this->sp_paytype', '$this->sp_logo', '$this->sp_picture', '$this->sp_keywords', '$this->sp_description', '$this->sp_profile', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', CURRENT_TIMESTAMP, '0000-00-00 00:00:00', 'approval')";

		$queryresult = mysqli_query( $db, $sqlquery )or die( mysqli_error() );

		$this->sp_id = mysqli_insert_id( $db );
		$this->sp_number = unserialize( $this->sp_number );
		foreach ( $this->sp_number as $compNew ) {

			$sqlquery2 = "UPDATE `shop_number` SET `sno_shopid` = '$this->sp_id' WHERE `shop_number`.`sno_number` = '$compNew'";
			$queryresult = mysqli_query( $db, $sqlquery2 )or die( mysqli_error() );
		}

		
		//for update data to update-ino table
		  $last_insert_id	= $this->shop_id;
			$insertData		= mysql_real_escape_string($sqlquery);
			$tableName		= 'shop_details';
			$page_name		= 'newshop';
			 $updateInfoObj = new Updates();
			  $a = $updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
		print_r( $a );
		//print_r('testing');
		//ends here//
		
		
		echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Your shop details created successfully.</div>";
	}
}
?>

<?php
class users {
	public $userid;
	public $user_username;
	public $user_password;
	public $user_oldpassword;
	public $user_name;
	public $user_gender;
	public $user_address;
	public $user_mobile;
	public $user_type; //adminuser & shopuser
	public $user_shops; // in array format
	public $user_shops_old; // old shops data
	public $user_permission; //page and function permission
	public $user_pic;
	public $user_pic_old; // old picture name
	public $user_modi;
	public $user_status;

	public
	function C_user() {
		include( '../Connections/dragonmartguide.php' );

		$this->user_username = $_POST[ 'username' ];
		$this->user_password = $_POST[ 'password' ];
		$this->user_oldpassword = $_POST[ 'confirm_password' ];
		if ( $this->user_password != $this->user_oldpassword ) {
			$errors = 1;
		} else {
			$errors = 0;
		}
		$this->user_name = $_POST[ 'name' ];
		$this->user_gender = $_POST[ 'gender' ];
		$this->user_address = $_POST[ 'address' ];

		$this->user_mobile = $_POST[ 'mobile' ];
		$this->user_type = $_POST[ 'usertype' ];


		if ( $this->user_type != "adminuser" ) {
			$this->user_permission = "";
		} else {
			$this->user_permission = serialize( $_POST[ 'pagenames' ] );
		}

		$this->user_shops_old = $_POST[ 'shopids_old' ];

		if ( isset( $_POST[ 'framework' ] ) ) {
			$this->user_shops = $_POST[ 'framework' ];
			sort( $this->user_shops );
			$this->user_shops = serialize( $this->user_shops );
		} else {
			$this->user_shops = "";
		}

		if ( isset( $_POST[ 'bannerimg' ] ) ) {
			$this->sp_picture = $_POST[ 'bannerimg' ];
		} else {
			$this->sp_picture = $_POST[ 'userpic_old' ];
		}


		if ( $errors != 1 ) {



			$sqlquery = "INSERT INTO `user_dmg` (`user_id`, `user_username`, `user_password`, `user_name`, `user_gender`, `user_address`, `user_mobile`, `user_type`, `user_shops`, `user_permission`, `user_pic`, `user_cre`, `user_modi`, `user_status`) VALUES (NULL, '$this->user_username', '$this->user_password', '$this->user_name', '$this->user_gender', '$this->user_address', '$this->user_mobile', '$this->user_type', '$this->user_shops', '$this->user_permission', '$this->sp_picture', '" . $_SESSION[ 'now' ] . "', '', 'approval')";
			$queryresult = mysqli_query( $db, $sqlquery )or die( mysqli_error() );

			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>User account created successfully.</div>";

			if ( $this->user_shops_old != $this->user_shops ) { // if both not equal update the new one
				$this->userid = mysqli_insert_id( $db );
				/* $shoplistingOld = unserialize($this->user_shops_old);

				foreach($shoplistingOld as $dellist){
					$sqlquery1 = "UPDATE `shop_details` SET `shop_user_id` = '' WHERE `shop_details`.`shop_id` = '$dellist'";
					$queryresult=mysqli_query($db, $sqlquery1) or die(mysqli_error());
				} */

				$shoplisting = unserialize( $this->user_shops );

				foreach ( $shoplisting as $newlist ) {
					$sqlquery1 = "UPDATE `shop_details` SET `shop_user_id` = '$this->userid', `shop_modi` = '" . $_SESSION[ 'now' ] . "' WHERE `shop_details`.`shop_id` = '$newlist'";
					$queryresult = mysqli_query( $db, $sqlquery1 )or die( mysqli_error() );
				}

			}

		} else {
			echo "<div class='alert alert-danger' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Problem! </strong>User account not created check data.</div>";

		}

	}

	public
	function U_user() {
		include( '../Connections/dragonmartguide.php' );

		$this->user_username = $_POST[ 'username' ];
		$this->user_password = $_POST[ 'password' ];
		$this->user_oldpassword = $_POST[ 'confirm_password' ];
		if ( $this->user_password != $this->user_oldpassword ) {
			$errors = 1;
		} else {
			$errors = 0;
		}
		if ( $this->user_password != "" ) {
			$sqldata = "`user_password` = '$this->user_password',";
		} else {
			$sqldata = "";
		}
		$this->user_name = $_POST[ 'name' ];
		$this->user_gender = $_POST[ 'gender' ];
		$this->user_address = $_POST[ 'address' ];

		$this->user_mobile = $_POST[ 'mobile' ];
		$this->user_type = $_POST[ 'usertype' ];


		if ( $this->user_type == "adminuser" ) {
			if ( isset( $_POST[ 'pagenames' ] ) ) {
				$this->user_permission = serialize( $_POST[ 'pagenames' ] );
			} else {
				$this->user_permission = "";
			}


		} else {
			$this->user_permission = "";
			if ( isset( $_POST[ 'framework' ] ) ) {
				$this->user_shops = $_POST[ 'framework' ];
				sort( $this->user_shops );
				$this->user_shops = serialize( $this->user_shops );
			} else {
				$this->user_shops = "";
			}

		}

		if ( isset( $_POST[ 'shopids_old' ] ) ) {
			$this->user_shops_old = $_POST[ 'shopids_old' ];
		}


		//if(isset($_POST['bannerimg'])){$this->sp_picture = $_POST['bannerimg'];}else{$this->sp_picture = $_POST['userpic_old'];}



		if ( $errors != 1 ) {
			/*---------------------- picture Handling 1 --------------------------*/
			//$picBnr1 = new picture;
			//$picBnr1->single_picture_named("user_id", "user_dmg", "bannerimg", "userpic_old", "../images/profile/", "/dragonmartguide.com/images/profile/", "5242880", "$this->userid");
			//table name--input nm---old name-----store path---Del path--size----if id---
			//$this->sp_picture = $picBnr1->picturenameP;
			/*---------------------- picture Handling 1 --------------------------*/


			$sqlquery = "UPDATE `user_dmg` SET $sqldata `user_name` = '$this->user_name', `user_gender` = '$this->user_gender', `user_address` = '$this->user_address', `user_mobile` = '$this->user_mobile', `user_type` = '$this->user_type', `user_permission` = '$this->user_permission', `user_shops` = '$this->user_shops', `user_pic` = '$this->sp_picture', `user_modi` = '" . $_SESSION[ 'now' ] . "' WHERE `user_dmg`.`user_id` = '$this->userid'";

			$queryresult = mysqli_query( $db, $sqlquery )or die( mysqli_error() );



			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>User account created successfully.</div>";
			//$this->user_shops = unserialize($this->user_shops);

			if ( $this->user_shops_old != $this->user_shops ) {

				// if both not equal update the new one
				if ( $this->user_shops_old != "" ) {
					$shoplistingOld = unserialize( $this->user_shops_old );
					foreach ( $shoplistingOld as $dellist ) {
						$sqlquery1 = "UPDATE `shop_details` SET `shop_user_id` = '' WHERE `shop_details`.`shop_id` = '$dellist'";
						$queryresult = mysqli_query( $db, $sqlquery1 )or die( mysqli_error() );
					}
				}
				if ( $this->user_shops != "" ) {
					$shoplisting = unserialize( $this->user_shops );
					foreach ( $shoplisting as $newlist ) {
						$sqlquery1 = "UPDATE `shop_details` SET `shop_user_id` = '$this->userid', `shop_modi` = '" . $_SESSION[ 'now' ] . "' WHERE `shop_details`.`shop_id` = '$newlist'";
						$queryresult = mysqli_query( $db, $sqlquery1 )or die( mysqli_error() );
					}
				}

			}

		} else {
			echo "<div class='alert alert-danger' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Problem! </strong>User account not created check data.</div>";

		}
	} // function U_user close

	
	
	public
	function UU_user() {
		include( '../Connections/dragonmartguide.php' );


		$this->user_password = $_POST[ 'password' ];
		$this->user_oldpassword = $_POST[ 'confirm_password' ];
		if ( $this->user_password != $this->user_oldpassword ) {
			$errors = 1;
		} else {
			$errors = 0;
		}
		if ( $this->user_password != "" ) {
			$sqldata = "`user_password` = '$this->user_password',";
		} else {
			$sqldata = "";
		}
		$this->user_name = $_POST[ 'name' ];
		$this->user_gender = $_POST[ 'gender' ];
		$this->user_address = $_POST[ 'address' ];

		$this->user_mobile = $_POST[ 'mobile' ];
		//$this->user_type = $_POST[ 'usertype' ];


		if ( $errors != 1 ) {

			$sqlquery = "UPDATE `user_dmg` SET $sqldata `user_name` = '$this->user_name', `user_gender` = '$this->user_gender', `user_address` = '$this->user_address', `user_mobile` = '$this->user_mobile', `user_pic` = '$this->sp_picture', `user_modi` = '" . $_SESSION[ 'now' ] . "' WHERE `user_dmg`.`user_id` = '$this->userid'";

			$queryresult = mysqli_query( $db, $sqlquery )or die( mysqli_error() );

			
			$last_insert_id	= $this->userid;
			$insertData		= mysql_real_escape_string($sqlquery);
			$tableName		= 'user_dmg';
			$page_name		= 'myaccount';
			 $updateInfoObj = new Updates();
			  $updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
			

			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>User account created successfully.</div>";
			//$this->user_shops = unserialize($this->user_shops);

		} else {
			echo "<div class='alert alert-danger' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Problem! </strong>User account not created check data.</div>";

		}
	} // function UU_user close

} // class user close
?>



<?php
class category {
	public $cat_id;
	public $cat_prid;
	public $cat_cmid;
	public $cat_name;
	public $cat_details;
	public $cat_views;

	public $OLD_cat_id;
	public $OLD_cat_prid;
	public $OLD_cat_cmid;
	public $OLD_cat_name;
	public $OLD_cat_views;


	public
	function C_cate() {

				include('../Connections/dragonmartguide.php');
				
		
		//print_r($_POST);
		//die();
				$this->cat_prid = explode('_', $this->cat_prid);
				
				$Mtble = $this->cat_prid[0];
				$Pid = $this->cat_prid[1];
		
				$this->cat_details = $_POST['catedetails'];
		
				
				if($Mtble == "cp" && $Pid == 0){
					$qry = "INSERT INTO `categories` (`id`, `cate_parent`, `cate_main`, `cate_list`, `cate_subcategory`, `cate_level`, `cate_pid`, `cate_mid`, `cate_clicks`, `cate_details`, `status`) VALUES (NULL, '$this->cat_name', '999', '999', '999', '1', '0', '0', '0', '$this->cat_details', 'on')";
					echo "<script>alert('$Mtble');</script>";
					
				}elseif($Mtble == "cp" && $Pid >= 1){
					
					$SLdata = mysqli_query($db, "SELECT * FROM `categories` WHERE `id`='$Pid'");
					$SLrow = mysqli_fetch_array($SLdata);
					
					
					$qry = "INSERT INTO `categories` (`id`, `cate_parent`, `cate_main`, `cate_list`, `cate_subcategory`, `cate_level`, `cate_pid`, `cate_mid`, `cate_clicks`, `cate_details`, `status`) VALUES (NULL, '".$SLrow['cate_parent']."', '$this->cat_name', '999', '999', '2', '$Pid', '0', '0', '$this->cat_details', 'on')";
				}elseif($Mtble == "cm" && $Pid >= 1){
					
					$SLdata = mysqli_query($db, "SELECT * FROM `categories` WHERE `id`='$Pid'");
					$SLrow = mysqli_fetch_array($SLdata);
					
					
					$qry = "INSERT INTO `categories` (`id`, `cate_parent`, `cate_main`, `cate_list`, `cate_subcategory`, `cate_level`, `cate_pid`, `cate_mid`, `cate_clicks`, `cate_details`, `status`) VALUES (NULL, '".$SLrow['cate_parent']."', '".$SLrow['cate_main']."', '$this->cat_name', '999', '3', '".$SLrow['cate_pid']."', '$Pid', '0', '$this->cat_details', 'on')";
				}
				$queryresult=mysqli_query($db, $qry) or die(mysqli_error());
			
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>New category created successfully.</div>";
		
			$last_insert_id	= mysqli_insert_id($db);
			$insertData		=	 mysql_real_escape_string($qry);
			$tableName		= 'categories';
			$page_name		= 'category.php';
			 $updateInfoObj = new Updates();
$updateInfoObj->processInformation('insert',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
	}


	public
	function U_cate() {
		include( '../Connections/dragonmartguide.php' );

		$this->cat_prid = explode( '_', $this->cat_prid );
		$Mclm = $this->cat_prid[ 0 ];
		$Pid = $this->cat_prid[ 1 ];

		$this->cat_id		= $_POST['cate_id'];
		$this->cat_name		= $_POST['categoryname'];
		$this->OLD_cat_name = $_POST[ 'cate_Oldname' ];
		
		//if($this->cat_name != $this->OLD_cat_name && $this->cat_name != "" && $this->OLD_cat_name != ""){
			
			if($Mclm == 'cp'){
				$qury = " `cate_main`='$this->cat_name', ";
				$Squry = " `cate_main`='$this->OLD_cat_name' ";
			}elseif($Mclm == 'cm'){
				$qury = " `cate_list`='$this->cat_name', ";
				$Squry = " `cate_list`='$this->OLD_cat_name' ";
			}else{
				$qury = " `cate_parent`='$this->cat_name', ";
				$Squry = " `cate_parent`='$this->OLD_cat_name' ";
			}

			//echo $qury;
			//die;
		$this->cat_details = $_POST['catedetails'];
		$q = "SELECT * FROM `categories` where `categories`.`status`='on'  AND $Squry";
		$cateSlt = mysqli_query($db, $q);
		while($Sltrow = mysqli_fetch_array($cateSlt)){
			$SltId = $Sltrow['id'];
			$Cquery = "UPDATE `categories` SET $qury `cate_details`= '$this->cat_details' WHERE `categories`.`id` = $SltId";
			$sqlquery2 = mysqli_query($db, $Cquery);
			
			$CqueryR.= $Cquery."<br/><br/>";
		}
			
			
			
			//select and change category details in shop and product detials db start
			$this->OLD_cat_name = '"'.$this->OLD_cat_name.'"';
			$this->cat_name = '"'.$this->cat_name.'"';
			
			$find_shopCate = mysqli_query($db, "update `shop_details` set `shop_category` = replace(shop_category,'$this->OLD_cat_name','$this->cat_name');");
			
			
			$find_productCate = mysqli_query($db, "update `product_details` set `prodt_category` = replace(prodt_category,'$this->OLD_cat_name','$this->cat_name');");
			
			//select and change category details in shop and product detials db start
			
			
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Category updated successfully.</div>";
			
			
			$last_insert_id	= mysqli_insert_id($db);
			$insertData		=	 mysql_real_escape_string($CqueryR);
			$tableName		= 'categories';
			$page_name		= 'category.php';
			 $updateInfoObj = new Updates();
$updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
		
			
		//}else{
			//echo "<div class='alert alert-danger' id='success-alert' style='text-align:center;'>
			//<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			//<strong>Problem! </strong>Category not updated check data.</div>";
		//}
	}
	
	
	public
	function D_cate() {
		include( '../Connections/dragonmartguide.php' );
		//$this->cat_id		= $_POST['cate_id'];
		
		
		$CKselect = mysqli_query($db, "SELECT * FROM `categories` WHERE `cate_pid` = '$this->cat_id' or `cate_mid` = '$this->cat_id' AND `status` != 'del' ");
		$CKcount = mysqli_num_rows($CKselect);
		if($CKcount > 0){
			echo "<div class='alert alert-danger' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Problem! </strong>You do not remove this Category! There is <strong>child data!</strong>.</div>";
		}else{
			
			$RMcate = "UPDATE `categories` SET `status` = 'del' WHERE `categories`.`id` = $this->cat_id";
			$queryresult = mysqli_query( $db, $RMcate )or die( mysqli_error() );
			
			$cat_idQUT = '"'.$this->cat_id.'"';
		
			$CTchecking1 = mysqli_query($db, "SELECT prodt_id, prodt_category FROM product_details WHERE prodt_category LIKE '%".$cat_idQUT."%'");
			
			while($CTrow1 = mysqli_fetch_array($CTchecking1)){
				$chkID1	= $CTrow1['prodt_id'];
				$chk1	= $CTrow1['prodt_category'];
				$jonEn1 = json_decode($chk1, true);
				unset($jonEn1[$this->cat_id]);
				$jonEn1	= json_encode($jonEn1);
				$find_shopCate = mysqli_query($db, "update `product_details` set `prodt_category` = '$jonEn1' where `prodt_id`= '$chkID1' ");
			}
			
			$CTchecking2 = mysqli_query($db, "SELECT shop_id, shop_category FROM shop_details WHERE shop_category LIKE '%".$cat_idQUT."%' ") ;
			while($CTrow2 = mysqli_fetch_array($CTchecking2)){
				
				$chkID2	= $CTrow2['shop_id'];
				$chk2	= $CTrow2['shop_category'];
				$jonEn2 = json_decode($chk2, true);
				unset($jonEn2[$this->cat_id]);
				$jonEn2	= json_encode($jonEn2);
				$find_shopCate = mysqli_query($db, "update `shop_details` set `shop_category` = '$jonEn2' where `shop_id`= '$chkID2' ");
					
			}		
			
			$last_insert_id	= mysqli_insert_id($db);
			$insertData		=	 mysql_real_escape_string($RMcate);
			$tableName		= 'categories';
			$page_name		= 'category.php';
			 $updateInfoObj = new Updates();
$updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
			
			
			echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Category has been removed successfully.</div>";
			header("location: category.php");
		}
	}
}
?>


<?php
class Protuct{
	public $pro_id;
	public $pro_category;
	public $pro_name;
	public $pro_picture;
	public $pro_newpics;
	public $pro_description;
	public $pro_specification;
	public $pro_size;
	public $pro_avail_qty;
	public $pro_unit_type;
	public $pro_avail_colors;
	public $pro_brand;
	public $pro_shop_id;
	public $pro_fav_count;
	public $pro_view_count;
	public $pro_offer_view;
	public $pro_click_count;
	public $pro_ranking;
	public $pro_cre;
	public $pro_modi;
	public $pro_status;
	
	public function Cproduct(){
		include( '../Connections/dragonmartguide.php' );
		
		//$this->pro_id			= $_POST['shop_id'];
		$this->pro_category		= $_POST['framework']; // back work is there
		$this->pro_name			= $_POST['prod_name'];
		$this->pro_picture		= $_POST['productimg'];
		//$this->pro_newpics		= $_POST['productnewpics']; // back work is there
		$this->pro_description	= addslashes($_POST['prod_desc']);
		$this->pro_specification= addslashes($_POST['prod_spec']);
		$this->pro_size			= addslashes($_POST['prodSize']);
		$this->pro_avail_qty	= $_POST['availQty'];
		$this->pro_unit_type	= $_POST['prodUnit'];
		$this->pro_avail_colors	= $_POST['availColor']; // back work is there
		$this->pro_brand		= $_POST['prodBrand'];
		$this->pro_shop_id		= $_POST['shop_id'];
		$this->pro_cre			= $_SESSION[ 'now' ];
		$this->pro_status		= 'approval';
		
		$this->pro_category		= implode("','",$this->pro_category);
		$catArray = array();
		
		$Cquery = "select * from `categories` where `id` IN ('$this->pro_category') AND `status`='on'";
		$cart_select = mysqli_query($db, $Cquery);
		while($cate_row = mysqli_fetch_assoc($cart_select)){
			$ids = $cate_row['id'];
			$catArray[$ids] = array("cate_parent" => $cate_row['cate_parent'], "cate_main" => $cate_row['cate_main'], "cate_list" => $cate_row['cate_list'], "cate_subcategory" => $cate_row['cate_subcategory'], "cate_level" => $cate_row['cate_level'], "cate_pid" => $cate_row['cate_pid'], "cate_mid" => $cate_row['cate_mid']);
		}
		$this->pro_category = json_encode($catArray);
		
		if(isset($_POST['productnewpics'])){$this->pro_newpics = json_encode($_POST['productnewpics']);} // New pictures
		
		
		
		$Pqry = "INSERT INTO `product_details` (`prodt_id`, `prodt_category`, `prodt_codeno`, `prodt_name`, `prodt_picture`, `prodt_newpics`, `prodt_description`, `prodt_specifications`, `prodt_price`, `prodt_size`, `prodt_avail_quantity`, `prodt_unite_type`, `prodt_avail_color`, `prodt_brand`, `prodt_offer_type`, `prodt_offer`, `prodt_offer_from`, `prodt_offer_to`, `prodt_offer_times`, `prodt_company_id`, `prodt_fav_count`, `prodt_views_count`, `prodt_offer_views`, `prodt_click_count`, `prodt_ranking`, `prodt_cre`, `prodt_modi`, `prodt_status`) VALUES (NULL, '$this->pro_category', '', '$this->pro_name', '$this->pro_picture', '$this->pro_newpics', '$this->pro_description', '$this->pro_specification', '0', '$this->pro_size', '$this->pro_avail_qty', '$this->pro_unit_type', '$this->pro_avail_colors', '$this->pro_brand', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '$this->pro_shop_id', '0', '0', '0', '0', '', '$this->pro_cre', '0000-00-00 00:00:00', 'approval')";
		$queryresult=mysqli_query($db, $Pqry) or die(mysqli_error());
		
		echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Product has been created successfully.</div>";
		
		
			$last_insert_id	= mysqli_insert_id($db);
			$insertData		=	 mysql_real_escape_string($Pqry);
			$tableName		= 'product_details';
			$page_name		= 'add_product';
			 $updateInfoObj = new Updates();
$updateInfoObj->processInformation('insert',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
			
	}
	
	public function Uproduct(){
		include( '../Connections/dragonmartguide.php' );
		
		
		$this->pro_id			= $_POST['Prodts_id'];
		$this->pro_category		= $_POST['framework']; // back work is there
		$this->pro_name			= $_POST['prod_name'];
		$this->pro_picture		= $_POST['productimg'];
		//if(isset($_POST['productnewpics'])){$this->pro_newpics = $_POST['productnewpics'];} // back work is there
		
		$this->pro_description	= addslashes($_POST['prod_desc']);
		$this->pro_specification= addslashes($_POST['prod_spec']);
		$this->pro_size			= addslashes($_POST['prodSize']);
		$this->pro_avail_qty	= $_POST['availQty'];
		$this->pro_unit_type	= $_POST['prodUnit'];
		$this->pro_avail_colors	= $_POST['availColor']; // back work is there
		$this->pro_brand		= $_POST['prodBrand'];
		//$this->pro_shop_id		= $_POST['shop_id'];
		$this->pro_modi			= $_SESSION[ 'now' ];
		$this->pro_status		= 'approval';
		
		$this->pro_category		= implode("','",$this->pro_category);
		$catArray = array();
		
		$Cquery = "select * from `categories` where `id` IN ('$this->pro_category') AND `status`='on'";
		$cart_select = mysqli_query($db, $Cquery);
		while($cate_row = mysqli_fetch_assoc($cart_select)){
			$ids = $cate_row['id'];
			$catArray[$ids] = array("cate_parent" => $cate_row['cate_parent'], "cate_main" => $cate_row['cate_main'], "cate_list" => $cate_row['cate_list'], "cate_subcategory" => $cate_row['cate_subcategory'], "cate_level" => $cate_row['cate_level'], "cate_pid" => $cate_row['cate_pid'], "cate_mid" => $cate_row['cate_mid']);
		}
		$this->pro_category = json_encode($catArray);
		
		 // New pictures
		if(isset($_POST['productnewpics'])){$this->pro_newpics = json_encode($_POST['productnewpics']);}
		

		$Pqry = "UPDATE `product_details` SET `prodt_category` = '$this->pro_category', `prodt_name` = '$this->pro_name', `prodt_picture` = '$this->pro_picture', `prodt_newpics` = '$this->pro_newpics', `prodt_description` = '$this->pro_description', `prodt_specifications` = '$this->pro_specification', `prodt_size` = '$this->pro_size', `prodt_avail_quantity` = '$this->pro_avail_qty', `prodt_unite_type` = '$this->pro_unit_type', `prodt_avail_color` = '$this->pro_avail_colors', `prodt_brand` = '$this->pro_brand', `prodt_modi` = '$this->pro_modi', `prodt_status` = 'approval' WHERE `product_details`.`prodt_id` = '$this->pro_id'";
			
		$queryresult=mysqli_query($db, $Pqry) or die(mysqli_error());
		
		echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Product has been updated successfully.</div>";
		
			$last_insert_id	= $this->pro_id;
			$insertData		= mysql_real_escape_string($Pqry);
			$tableName		= 'product_details';
			$page_name		= '';
			 $updateInfoObj = new Updates();
			  $updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
	}
}
?>


<?php
class privileges
{
	public $shop_id;
	public $startdate;
	public $enddate;
	public $privType;
	
	public function Cprivileges(){
		include( '../Connections/dragonmartguide.php' );
		
		$pQry = "UPDATE `shop_details` SET `shop_priv_start` = '$this->startdate', `shop_priv_end` = '$this->enddate', `shop_priv_type` = '$this->privType', `shop_modi` = '".$_SESSION['now']."' WHERE `shop_details`.`shop_id` = '$this->shop_id'";
		$queyupdate = mysqli_query($db, $pQry) or die(mysqli_error());
		
		echo "<div class='alert alert-success' id='success-alert' style='text-align:center;'>
			<button type='button' id='close' class='close' data-dismiss='alert'>x</button>
			<strong>Success! </strong>Privilege has been updated successfully.</div>";
		
			$last_insert_id	= $this->shop_id;
			$insertData		= mysql_real_escape_string($pQry);
			$tableName		= 'shop_details';
			$page_name		= 'privilege_settings.php';
			 $updateInfoObj = new Updates();
			  $updateInfoObj->processInformation('update',$page_name,$tableName,$last_insert_id,$_SESSION['loginUserid'],$insertData,$_SESSION['now']);
		
		
	}
}
?>