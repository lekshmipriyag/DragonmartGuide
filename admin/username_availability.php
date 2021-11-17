    <?php
    include('../Connections/dragonmartguide.php');                                 

if(!empty($_POST["username"])) {
$result = mysqli_query($db, "SELECT count(*) FROM user_dmg WHERE user_username='" . $_POST["username"] . "'");
$row = mysqli_fetch_row($result);
$user_count = $row[0];
if($user_count>0) {echo "<span class='status-not-available'> Username Not Available.</span>";
				   echo "<script>$('#submit').hide();</script>";
				  }
else {echo "<span class='status-available'> Username Available.</span>"; 
	  echo "<script>$('#submit').show();</script>";
	 }
}
    ?>