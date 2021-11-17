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
$email = $userLoginName;
//$bookdate = $row_apro['book_dat_time'];
//$approvedate = $row_apro['app_dat_time'];

if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
$local_date_time_24 = date('d-m-Y H:i:s'); 


//$error[] = preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email']) ? '' : 'INVALID EMAIL ADDRESS';
if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*" ."@"."([a-z0-9]+([\.-][a-z0-9]+)*)+"."\\.[a-z]{2,}"."$", $email)){
	$error.="Invalid email address entered";
	$errors=1;
}
$headers = '';
if(isset($errors) && $errors==1) echo $error;
else{ 
	 
	$your_email = $email."\r\n";
	$email_subject = "Approved shop registration";
	//$email_content = "New user sign up:\n";
		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8\r\n";
		$headers .= "From: web@dragonmartguide.com\r\n";
		$headers .= "Reply-To: enquiry@dragonmartguide.com\r\n";
		$email_content .= "<html>

<body>
	<div style='border:solid 1px #dfdfdf;color:#686868;font:13px Arial'>
		<div style='background-color:#fff;padding:20px'>
			<table cellspacing='0' cellpadding='0'>
				<tbody>
					<tr>
						<td style='width:578px;color:#333;font:13px Arial;vertical-align:top;color:#686868;font:16px Arial'>User sign up notification
							<div style='width:578px;color:#333;font:13px Arial;vertical-align:top;padding-top:10px'>Hi, <strong>$uName</strong> <br/>
							Congratulations. You are successfully registered with Dragon Mart Guide (<a target='_blank' style='color:#3366cc;text-decoration:none' href='http://".$_SERVER['HTTP_HOST']."/'>dragonmartguide.com</a>). Enjoy using the multiple services available for you. For further assistance call our customer care representative or write us. <br/>
							
							<br/>
							User Name : $userLoginName
							<br/>
							Password : $passwd
							<br/>
							URL : http://".$_SERVER['HTTP_HOST']."/login.php
							<br/>
							Your suggestions and complaints are welcomed at enquiry@dragonmartguide.com
							</div>

							<div style='margin-top:10px'><a target='_blank' rel='acb115192299471299755247' style='background-color:#d44b38;border:solid 1px #dfdfdf;border-radius:3px;color:#fff;display:inline-block;font-family:Arial;font-size:13px;min-height:30px;line-height:30px;min-width:54px;padding:1px 20px;text-align:center;text-decoration:none;white-space:nowrap' href='http://".$_SERVER['HTTP_HOST']."/search.php'>View Shop</a>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div style='width:578px;color:#333;font:13px Arial;vertical-align:top;color:#686868;font:16px Arial;font:14px Arial;margin-top:10px;background-color:#fcf6e1;padding:5px'>-Thanks & regards-<br/><b>Mohamed Farook</b> <br/>Online Marketing Manager <br/>info@dragonmartguide.com</div>
		</div>
		<div style='border-top:solid 1px #dfdfdf;padding:0 20px;background-color:#f5f5f5'>
			<table cellspacing='0' cellpadding='0' style='height:50px'>
				<tbody>
					<tr>
						<td style='vertical-align:middle;width:100%;color:#636363;font:11px Arial;line-height:120%'>You are receiving this mail, because you registered as a user in <a target='_blank' style='color:#3366cc;text-decoration:none' href='http://".$_SERVER['HTTP_HOST']."/'>dragonmartguide.com</a>. This is an auto generated mail.<br>
						</td>
						<td style='padding:0px'>
							<span style='font-size:11px; color:#636363;'>Powered by</span>
							<a target='_blank' style='color:#3366cc;text-decoration:none' href='http://".$_SERVER['HTTP_HOST']."/'><img src='http://".$_SERVER['HTTP_HOST']."/images/EmailSignlogo.jpg'></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>

</html>";
	
	if(@mail($your_email,$email_subject,$email_content,$headers)) {
		echo 'Message sent!'; 
	} else {
		echo 'ERROR!';
	}
}

	?>