<?php
/************************************************************************/
/* @category 	picture handling script 		 						*/
/* @package 	Shop listing portal 									*/
/* @author 		Original Author Raja Ram R <rajaram234r@gmail.com>		*/
/* @author 		Another Author Farook <mohamedfarooks@gmail.com> 		*/
/* @copyright 	2016 - 2017 ewebeye.com 								*/
/* @license 	Raja Ram R 												*/
/* @since 		This file available since 2.10 							*/
/* @date 		Created date 04/07/2017 								*/
/* @modify 		Latest modified date 04/07/2017 						*/
/* @code 		PHP 5.7 												*/
/************************************************************************/

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

class picture
{
	public $fnP; // function
	public $idP; // Picture ID.
	public $userP; //User ID
	public $idname; // id field name
	public $tableP; //If need table, use it or not need.
	public $tableidP; //Record Id
	public $pictureP; //Picture Field Name.
	public $fileType; //File Type
	public $oldpictureP; // Old Picture Name field.
	public $pathP; // Storing folder path.
	public $dpathP; //delete picture path
	public $sizeP; // picture maximum size
	public $picturenameP; // Picture name for storing.
	
	/*------------------------------ Single picture start ------------------------------------*/
	public function single_picture($idname, $tableP, $pictureP, $oldpictureP, $pathP, $dpathP, $sizeP, $idP)
	{
		$this->idname = $idname;
		$this->tableP = $tableP;
		$this->pictureP = $pictureP;
		$this->oldpictureP = $oldpictureP;
		$this->pathP = $pathP;
		$this->dpathP = $dpathP;
		$this->sizeP = $sizeP;
		$this->idP = $idP;

		
		$q2 = "select MAX(".$this->idname.") from ".$this->tableP;
		$result2 = mysql_query($q2);
		$data2 = mysql_fetch_array($result2);
		
		if ($_FILES[$this->pictureP]["name"] != "")
		{
			$nid = ++$data2[0];
			if($this->idP != ""){
				$nid = $this->idP;
			}
			
		if ((($_FILES[$this->pictureP]["type"] == "image/gif")
		|| ($_FILES[$this->pictureP]["type"] == "image/jpeg")
		|| ($_FILES[$this->pictureP]["type"] == "image/ICO")
		|| ($_FILES[$this->pictureP]["type"] == "image/png")
		|| ($_FILES[$this->pictureP]["type"] == "image/pjpeg"))
		&& ($_FILES[$this->pictureP]["size"] < $this->sizeP))
		{
			if ($_FILES[$this->pictureP]["error"] > 0)
			{
				echo "Return Code: " . $_FILES[$this->pictureP]["error"] . "<br />";
			} else {
				if (file_exists($this->pathP . $nid."_" . $_FILES[$this->pictureP]["name"]))
				{
					echo "<div style=\"position:absolute; width:250px; left:50%; top:50px; margin-left:-125px; color:red; background-color:#FFEAEA; border:solid 2px red; z-index:5; text-align:center;\">". $_FILES[$this->pictureP]["name"] . " 1 already exists. </div>";
					
					echo '<meta http-equiv="Refresh" content="0; URL='.$_SERVER['HTTP_REFERER'].'">';
					exit();
					
				} else {
					$filename = preg_replace('/\s+/', '_', $_FILES[$this->pictureP]["name"]);
					move_uploaded_file($_FILES[$this->pictureP]["tmp_name"], $this->pathP . $nid."_" . $filename);
					$this->picturenameP =  $nid."_".$filename;
					
					if($_POST[$this->oldpictureP] != ""){
					unlink($_SERVER['DOCUMENT_ROOT'].$this->dpathP.$_POST[$this->oldpictureP]);
					}
				}
			}
		} else {
			$mpicture_file =  $_FILES[$this->pictureP]["name"];
			echo "<script type='text/javascript'>alert('Picture : $mpicture_file is not right picture. Sorry!');</script>"; 	
			echo '<meta http-equiv="Refresh" content="0; URL='.$_SERVER['HTTP_REFERER'].'">';
			exit();
		}
		} else {$this->picturenameP = $_POST[$this->oldpictureP];}
				
	}
	/*------------------------------ Single picture end --------------------------------------*/
	
	
	/*------------------------------ Single picture overwrite named start ------------------------------------*/
public function single_picture_named($idname, $tableP, $pictureP, $oldpictureP, $pathP, $dpathP, $sizeP, $idP)
	{
		include('../Connections/dragonmartguide.php');
		
		$this->idname = $idname;
		$this->tableP = $tableP;
		$this->pictureP = $pictureP;
		$this->oldpictureP = $oldpictureP;
		$this->pathP = $pathP;
		$this->dpathP = $dpathP;
		$this->sizeP = $sizeP;
		$this->idP = $idP;
		
		$q2 = "select MAX(".$this->idname.") from ".$this->tableP;
		$result2 = mysqli_query($db, $q2);
		$data2 = mysqli_fetch_array($result2);
		
		if ($_FILES[$this->pictureP]["name"] != "")
		{
			$nid = ++$data2[0];
			if($this->idP != ""){
				$nid = $this->idP;
			}
			
		if ((($_FILES[$this->pictureP]["type"] == "image/gif")
		|| ($_FILES[$this->pictureP]["type"] == "image/jpeg")
		|| ($_FILES[$this->pictureP]["type"] == "image/ICO")
		|| ($_FILES[$this->pictureP]["type"] == "image/png")
		|| ($_FILES[$this->pictureP]["type"] == "image/pjpeg"))
		&& ($_FILES[$this->pictureP]["size"] < $this->sizeP))
		{
			if ($_FILES[$this->pictureP]["error"] > 0)
			{
				echo "Return Code: " . $_FILES[$this->pictureP]["error"] . "<br />";
			} else {
				
					$filename = preg_replace('/\s+/', '_', $_FILES[$this->pictureP]["name"]);
					move_uploaded_file($_FILES[$this->pictureP]["tmp_name"], $this->pathP . $nid."_" . $filename);
					$this->picturenameP =  $nid."_".$filename;
					
					if($_POST[$this->oldpictureP] != ""){
					unlink($_SERVER['DOCUMENT_ROOT'].$this->dpathP.$_POST[$this->oldpictureP]);
					}
				
			}
		} else {
			$mpicture_file =  $_FILES[$this->pictureP]["name"];
			echo "<script type='text/javascript'>alert('image : $mpicture_file is not right image. Sorry!');</script>"; 	
			echo '<meta http-equiv="Refresh" content="0; URL='.$_SERVER['HTTP_REFERER'].'">';
			exit();
		}
		} else {$this->picturenameP = $_POST[$this->oldpictureP];}
				
	}	/*------------------------------ Single picture overwrite named end --------------------------------------*/
	
	 
	/*------------------------------ Additional picture start --------------------------------------*/
	public function multi_picture($idname, $tableP, $pathP, $sizeP, $picture_Feld_Nam, $tbleID, $userID)
	{							//Table---Store Path---Size--Picture Field----Table ID--User ID
		
		$this->idname = $idname;
		$this->tableP = $tableP;
		$this->userP = $userID;
		$this->pathP = $pathP;
		$this->sizeP = $sizeP;
		$this->pictureP = $picture_Feld_Nam;
		$this->tableidP = $tbleID;
		$port_count = $_POST['theValue'];
		$a = 1;
		
		$timezone = $_SESSION['comData']['timesone'];
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		$national_date_time_24 = date('Y-m-d H:i:s'); 

		
		if($this->tableidP == ""){
			$q2 = "select MAX(".$this->idname.") from ".$this->tableP;
			$result2 = mysql_query($q2);
			$data2 = mysql_fetch_array($result2);
			$nid = ++$data2[0]."_";
			$RecordId = ++$data2[0]-1;
		} elseif($this->tableidP != ""){
			$nid = $this->tableidP."_";
			$RecordId = $this->tableidP;
		}
		for($x = 0; $x<$port_count; $x++)
		{
			$wimage2 = $this->pictureP.$a;
			$path = $this->pathP;
	
		if ((($_FILES[$wimage2]["type"] == "image/gif")
		|| ($_FILES[$wimage2]["type"] == "image/jpeg")
		|| ($_FILES[$wimage2]["type"] == "image/ICO")
		|| ($_FILES[$wimage2]["type"] == "image/png")
		|| ($_FILES[$wimage2]["type"] == "image/pjpeg")
		|| ($_FILES[$wimage2]["type"] == "application/pdf")
		|| ($_FILES[$wimage2]["type"] == "application/msword")
		|| ($_FILES[$wimage2]["type"] == "application/vnd.ms-excel")
		|| ($_FILES[$wimage2]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		|| ($_FILES[$wimage2]["type"] == "application/vnd.ms-powerpoint")
		|| ($_FILES[$wimage2]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
		|| ($_FILES[$wimage2]["type"] == "application/x-msexcel")
		|| ($_FILES[$wimage2]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
		|| ($_FILES[$wimage2]["type"] == "application/rtf")
		|| ($_FILES[$wimage2]["type"] == "application/x-rtf")
		|| ($_FILES[$wimage2]["type"] == "text/richtext")
		|| ($_FILES[$wimage2]["type"] == "text/plain"))
		&& ($_FILES[$wimage2]["size"] < $this->sizeP))
		
		{
			if ($_FILES[$wimage2]["error"] > 0)
			{
				echo "Return Code: " . $_FILES[$wimage2]["error"] . "<br />";
			} else {
				if (file_exists($path . $nid . $_FILES[$wimage2]["name"]))
				{
					echo "<font color=\"red\">". $_FILES[$wimage2]["name"] . " 1 already exists. </font>";
					
				} else {
					$filename = preg_replace('/\s+/', '_', $_FILES[$wimage2]["name"]);
					move_uploaded_file($_FILES[$wimage2]["tmp_name"], $path . $nid . $filename);
					$this->picturenameP = $nid.$filename;
					$ext = pathinfo($_FILES[$wimage2]['name'], PATHINFO_EXTENSION);
					
					$c = "select MAX(id) from discu_ssion_sub";
					$resultc = mysql_query($c);
					$datac = mysql_fetch_array($resultc);
					$subid = ++$datac[0];
					if($tbleID == ""){$subid = 0;}
					$sqlquery = "INSERT INTO `attachments` (`id` ,`u_ser` ,`project_id` , `subid` ,`file_type` ,`file_name` ,`cre_date` ,`status`)VALUES (NULL , '$this->userP', '$RecordId', '$subid', '$ext', '$this->picturenameP', '$national_date_time_24', 'on')";
							$queryresult=mysql_query($sqlquery) or die(mysql_error());

				}
			}
		} else {
			echo "<script type='text/javascript'>alert('File N0: $a there is not right file. Sorry!');</script>"; 	
			echo '<meta http-equiv="Refresh" content="0; URL='.$_SERVER['HTTP_REFERER'].'">';
			//exit();
		}
		++$a;
		} // for
		
	}
	/*------------------------------ Additional picture end --------------------------------------*/
}
?>