<?php

/************************************************************************/
/* @category 	Multi cms with multi permissions 						*/
/* @package 	Shop listing portal 									*/
/* @author 		Original Author Raja Ram R <rajaram234r@gmail.com>		*/
/* @author 		Another Author Farook <mohamedfarooks@gmail.com> 		*/
/* @copyright 	2016 - 2017 ewebeye.com 								*/
/* @license 	Lekshmipriya												*/
/* @since 		This file available since 2.10 							*/
/* @date 		Created date 09/08/2017 								*/
/* @modify 		Latest modified date 09/08/2017						*/
/* @code 		PHP 5.7 												*/
/************************************************************************/
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

/* ---------- common functions --------------------*/
		//$timezone = $_SESSION['comData']['timesone'];
		if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
		$national_date_time_24	= date('Y-m-d H:i:s');
		$_SESSION['now'] 		= $national_date_time_24;
/* ---------- common functions --------------------*/


?>
<?php

class Contact{
	public $em_id;
	public $em_name;
	public $em_contactno;
	public $em_email;
	public $em_website;
	public $em_message;
	public $em_status;
	public $em_shopid;
	public $em_prodid;
	public $em_userid;
	public $em_createdAt;
	public $em_flag;
	public $page_name;
	public $tableName;
	
	public function sendEmail(){
		include('Connections/dragonmartguide.php');
		$this->em_name			=	isset($_POST['emailname'])?$_POST['emailname']:'';
		$this->em_contactno		=   isset($_POST['emailcontact'])?$_POST['emailcontact']:'';
		$this->em_email			=	isset($_POST['emailid'])?$_POST['emailid']:'';
		$this->em_website		=	isset($_POST['website'])?$_POST['website']:'';
		$this->em_message		=	isset($_POST['message'])?$_POST['message']:'';
		$this->em_status		=	'approval';
		$this->em_createdAt		=   $_SESSION['now'];
		$this->page_name		=	'productdetails.php';
		$this->tableName		=	'enquiry_dmg';
		$this->em_userid		=	'';
		$sqlInsertEmailData		=	"INSERT INTO `enquiry_dmg`							      
																(
																	`em_shopid`,
																	`em_product_id`,
																	`em_userid`,
																	`em_name`,
																	`em_contactno`,
																	`em_email`,
																	`em_ipaddress`,
																	`em_website`,
																	`em_message`,
																	`em_flag`,
																	`em_createdAt`,
																	`em_status`
																	
																)VALUES (
																	 '$this->em_shopid',
																	 '$this->em_prodid',
																	 '$this->em_userid',
																	 '$this->em_name', 
														 			 '$this->em_contactno',
																	 '$this->em_email',
																	 '$this->em_ipaddress',
																	 '$this->em_website',
																	 '$this->em_message',
																	 '$this->em_flag',
																	 '$this->em_createdAt',
																	 '$this->em_status'
																	)";
		mysqli_query($db,$sqlInsertEmailData);
		$this->last_insert_id	= mysqli_insert_id($db);
		$insertData				= mysql_real_escape_string($sqlInsertEmailData);
		
		$updateInfoObj = new Updates();
					 $updateInfoObj->processInformation(
												'insert',
												 $this->page_name,
												 $this->tableName,
												 $this->last_insert_id,
												 '',
												 $insertData,
												 $_SESSION['now']
											  );
		
	}
	
		public function get_client_ip() { //get the client ip address
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}
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
		
		include('Connections/dragonmartguide.php');
		$sqlqueryForUpdateInfo 			= "INSERT INTO `updt_info`							      
																(
																	`updt_id`,
																	`updt_type`,
																	`updt_pagename`,
																	`updt_tablename`,
																	`updt_rowid`,
																	`updt_userid`,
																	`updt_data`,
																	`updt_time`,
													 				`updt_viewstatus`
																)VALUES (
																	 NULL,
																	 '$action', 
																	 '$pageName',
																	 '$tableName',
																	 '$rowId',
																	 '$userId',
																	 '$data',
																	 '".$updateTime."',
																	 'not viewed')";
		
			
		mysqli_query($db, $sqlqueryForUpdateInfo) or die(mysqli_error($db));
	}
}
?>		
			

		

