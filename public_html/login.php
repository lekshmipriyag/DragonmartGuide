<?php require_once('Connections/dragonmartguide.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['pscode'];
  $MM_fldUserAuthorization = "user_status";
  $MM_redirectLoginSuccess = "admin/index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_dragonmartguide, $dragonmartguide);
  	
  $LoginRS__query=sprintf("SELECT user_username, user_password, user_status FROM user_dmg WHERE user_username=%s AND user_password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $dragonmartguide) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'user_status');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dragon Mart :: Dubai</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <div class="row" style="margin-top:25px;">
        <div class="col-md-8 col-md-offset-2 text-center">
        	<h2>Dragon Mart Guide</h2>
            <span class="text-hint">Dubai</span>
        </div>
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" style="border:solid 1px #ccc; padding:20px 15px; margin-top:25px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
        	<div style="text-align: center;"><a href="index.php"><img src="images/EmailSignlogo.jpg" alt="logo" /></a></div>
        	<h2 class="text-center">Dragon Mart</h2>
            <div class="text-hint" style="width:100%; text-align:center;">Login</div>
            <form name="userlogin" ACTION="<?php echo $loginFormAction; ?>" METHOD="POST">
			<div class="form-group">
            	<label for="username" class="control-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="User Name">
            </div>
            <div class="form-group">
            	<label for="pscode" class="control-label">Password</label>
                <input type="password" class="form-control" id="pscode" name="pscode" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary pull-right col-md-6  col-sm-6  col-xs-6" id="submit" name="submit" value="Login">
                <input type="reset" class="btn btn-default pull-right col-md-6  col-sm-6  col-xs-6" id="reset" name="reset" value="Cancel">
            </div>
            </form>
        </div>
    </div>
</div>

	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
<?php
	unset($_SESSION);
?>
</body>
</html>