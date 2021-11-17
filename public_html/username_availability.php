 <?php
if ( !isset( $_SESSION ) ) {
	session_start();
}

if(isset($_POST['userName']) && $_POST['userName'] != ""){
	include('Connections/dragonmartguide.php');
	$username =  $_POST['userName'];
	$result = mysqli_query($db, "SELECT count(*) FROM user_dmg WHERE user_username='" . $username . "'");
	$row = mysqli_fetch_row($result);
	$user_count = $row[0];
	
	
	$resultdata 		= mysqli_query($db, "SELECT * FROM user_register WHERE reg_username='" . $username . "'");
	 $loginUserNameCount	= mysqli_num_rows($resultdata);
	
	 
	if($user_count>0) {
					   echo "<span class='status-not-available' style='color:red;'> Username Not Available.</span>";
					   echo "<script>$('#submit').hide();</script>";
					  }
	else if( $loginUserNameCount > 0){
			echo "<span class='status-not-available' style='color:red;'> Username Not Available.</span>";
			echo "<script>$('#submit').hide();</script>";
	}
	else {
		echo "<span class='status-available' style='color:green;'> Username Available.</span>"; 
		echo "<script>$('#submit').show();</script>";
		 }
	}

?> 
   
   
   
   
   