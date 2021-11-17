<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$your_email = '';
$email_subject = '';
$email_content = '';
$headers = '';

if(!$_POST) exit;
$email = "enquiry@dragonmartguide.com";
//$bookdate = $row_apro['book_dat_time'];
//$approvedate = $row_apro['app_dat_time'];

if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
$local_date_time_24 = date('d-m-Y H:i:s'); 


//$error[] = preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email']) ? '' : 'INVALID EMAIL ADDRESS';
if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*" ."@"."([a-z0-9]+([\.-][a-z0-9]+)*)+"."\\.[a-z]{2,}"."$", $this->reg_username)){
	$error.="Invalid email address entered";
	$errors=1;
}

if(isset($errors) && $errors==1) echo $error;
else{ 
	 
	$your_email = $email."\r\n";
	$email_subject = "New shop user registration mail";
	$email_content = "New user sign up:\n";
		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8\r\n";
		$headers .= "From: web@dragonmartguide.com\r\n";
		$headers .= "Reply-To: $this->reg_username\r\n";
		$email_content .= "<html><body>";

        

$email_content .= "<div style='border:solid 1px #dfdfdf;color:#686868;font:13px Arial'>";
$email_content .= "<div style='background-color:#fff;padding:20px'>";
$email_content .= "<table cellspacing='0' cellpadding='0'><tbody><tr>";
$email_content .= "<td></td>";
$email_content .= "<td style='width:578px;color:#333;font:13px Arial;vertical-align:top;color:#686868;font:16px Arial'>You received a new user sign up notification";
$email_content .= "<div style='width:578px;font:13px Arial;vertical-align:top;padding-top:10px'>$this->reg_username</div>";
$email_content .= "<div style='width:578px;color:#333;font:13px Arial;vertical-align:top;padding-top:10px; font-weight: bold;'>shops </div>";

$email_content .= "</td></tr><tr>";
$email_content .= "<td style='padding-right:15px;vertical-align:top'>&nbsp;</td>";
$email_content .= "<td style='width:578px;color:#333;font:13px Arial;vertical-align:top;color:#686868;font:16px Arial'>&nbsp;</td>";
$email_content .= "</tr><tr>";
$email_content .= "<td colspan='2' style='padding-right:15px;vertical-align:top'><table width='100%'>";
$email_content .= "<tbody><tr><td>Name</td><td>:</td><td>$this->reg_firstname $this->reg_lastname</td></tr>";
$email_content .= "<tr><td>Gender</td><td>:</td><td>$this->reg_gender</td></tr>";
$email_content .= "<tr><td>Designation</td><td>:</td><td>$this->reg_designation</td></tr>";
$email_content .= "<tr><td>Address</td><td>:</td><td>$this->reg_address</td></tr>";
$email_content .= "<tr><td>Mobile No</td><td>:</td><td>$this->reg_mobile</td></tr>";
$email_content .= "<tr><td>Message</td><td>:</td><td style='color:#237DE9'>$this->reg_msg</td></tr>";
$email_content .= "</tbody></table></td></tr>";
$email_content .= "<tr><td style='padding-right:15px;vertical-align:top'>&nbsp;</td>";
$email_content .= "<td style='width:578px;color:#333;font:13px Arial;vertical-align:top;color:#686868;font:16px Arial'><div style='margin-top:10px'><a target='_blank' rel='acb115192299471299755247' style='background-color:#d44b38;border:solid 1px #dfdfdf;border-radius:3px;color:#fff;display:inline-block;font-family:Arial;font-size:13px;min-height:30px;line-height:30px;min-width:54px;padding:1px 20px;text-align:center;text-decoration:none;white-space:nowrap' href='http://".$_SERVER['HTTP_HOST']."/admin/updates.php'>View &amp; Approval</a></div></td>";
$email_content .= "</tr></tbody></table>";
$email_content .= "<div style='width:578px;color:#333;font:13px Arial;vertical-align:top;color:#686868;font:16px Arial;font:14px Arial;margin-top:10px;background-color:#fcf6e1;padding:5px'><b>This email generated only for verification Purposes.</b> Be careful to avoid issuing mail on your name in the future. This will help you in improving your reliability in the company.</div>";
$email_content .= "</div><div style='border-top:solid 1px #dfdfdf;padding:0 20px;background-color:#f5f5f5'>";
$email_content .= "<table cellspacing='0' cellpadding='0' style='height:50px'><tbody><tr>";
$email_content .= "<td style='vertical-align:middle;width:100%;color:#636363;font:11px Arial;line-height:120%'>You received this mail because you are a admin member of DMG.<br></td>";
$email_content .= "<td style='padding:0px'><span style='font-size:11px; color:#636363;'>Powered by</span>";
$email_content .= "<a target='_blank' style='color:#3366cc;text-decoration:none' href='http://".$_SERVER['HTTP_HOST']."/'><img src='http://".$_SERVER['HTTP_HOST']."/images/EmailSignlogo.jpg'></a>";
$email_content .= "</td></tr></tbody></table></div></div></body></html>";
	
	if(@mail($your_email,$email_subject,$email_content,$headers)) {
		//echo 'Message sent!'; 
	} else {
		echo 'ERROR!';
	}
}

	?>