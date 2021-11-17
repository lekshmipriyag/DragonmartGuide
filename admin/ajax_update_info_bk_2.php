<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

//for permanent delete
if(isset($_POST['status']) && $_POST['status'] == "permanentDelete" && $_SESSION['MM_Username'] != "")
{
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	 $delTableId 	= $_POST['perDelTableID'];
	mysqli_query($db,"DELETE FROM updt_info WHERE updt_id = '$delTableId' ");
	
}

//for reject
if(isset($_POST['updateId']) && $_POST['updateId'] != "" && $_SESSION['MM_Username'] != ""){
	
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	
	$updateId = $_POST['updateId'];
	
	 $sqlquery = "UPDATE `updt_info` SET `updt_viewstatus` = 'viewed' 
						     WHERE `updt_id` = '$updateId' AND `updt_viewstatus` = 'not viewed' ";
	 mysqli_query($db,$sqlquery); 
	
	 $selectQuery	= 	"SELECT `updt_rowid`,`updt_tablename`,`updt_data` FROM `updt_info` WHERE `updt_id` = '$updateId'";
	  $selectedData = 	mysqli_query($db,$selectQuery);
	  $resultData	=   mysqli_fetch_array($selectedData);
	  $updateTable  =   $resultData['updt_tablename'];	
	  $updatRowID	=	$resultData['updt_rowid'];
	  $resultImagedata  = '';
	  $imageData		= '';
	  $image			= '';	
	 $username			= '';
	?>
	 <div class="modal-header">
          <button type="button" class="close" title = "close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:#41B0E5"><?php echo ucwords($updateTable);?></h4>
       </div>
       <div class="modal-body" id = 'modalMessage'>
       <?php
	  if($updateTable != ''){ ?>
		<?php /*if($updateTable == 'offer_dmg'){
		   $resultImagedata = 	mysqli_query($db,"SELECT * FROM offer_dmg WHERE offer_id = '$updatRowID'");
		   $imageData 		= 	mysqli_fetch_array($resultImagedata);
		   $image			=	$imageData['offer_picture'];

	  }*/
		
		if($updateTable == 'user_register'){ ?>
			
		 <?php  $resultImagedata = mysqli_query($db,"SELECT * FROM user_register WHERE reg_id = '$updatRowID'");
		   $imageData = mysqli_fetch_array($resultImagedata);
		   $image		= $imageData['reg_pic'];?>
	
			
			 <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
	   			<?php echo "Created ". date('d-m-Y h:i a',strtotime($imageData['reg_cre_date']));?> 
			 </div>
        	 <table id = 'tbl_enquiry'>
        	  <?php 
				if($imageData['reg_id'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Reg ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['reg_id'];?></td>
					  </tr>
				   <?php } 
				  if($imageData['reg_username'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>User Name</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['reg_username'];?></td>
					  </tr>
				   <?php } ?>
			<?php 
				  if($imageData['reg_firstname'] != ''){?>   
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Name</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['reg_firstname']." ".$imageData['reg_lastname'];?></td>
					  </tr>
			   <?php } ?>
			   <?php 
				  if($imageData['reg_designation'] != ''){?>
					  	  <tr id ='tr_enquiry'>
							  <th id ='th_enquiry'>Designation</th>
								  <th>:</th>
							  <td id ='td_enquiry'><?php echo $imageData['reg_designation'];?></td>
						  </tr>
				  <?php } ?>
			  <?php 
				  if($imageData['reg_gender'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Gender</th>
						  <th>:</th>
					  <td id ='td_enquiry'><?php echo $imageData['reg_gender'];?></td>
				  </tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['reg_mallname'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Mall Name</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['reg_mallname'];?></td>
					  </tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['reg_address'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Address</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['reg_address'];?></td>
				</tr>
				 <?php } ?>
			  <?php 
				  if($imageData['reg_mobile'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Contact No</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['reg_mobile'];?></td>
					  </tr> 
				 <?php } ?>
			    <?php 
				  if($imageData['reg_shopnumber'] != ''){?>
				  <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Shop Number(s)</th>
						  <th>:</th>
					  <td id ='td_enquiry'><?php 
					   $rshopNum = $imageData['reg_shopnumber'].",";
					  		echo rtrim($rshopNum,",");
						  ?></td>
				  </tr>
				   <?php } ?>
				 
			   
			   <?php 
				  if($imageData['reg_shopnumber'] != ''){?>
				  <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Shop Name(s) </th>
						  <th>:</th>
					  <td id ='td_enquiry'>
					  <?php 
					      $regShopNums = explode(',',  $imageData['reg_shopnumber']);
					  foreach($regShopNums as $regShopNum){
						  $fetchShopNames = mysqli_query($db,"SELECT shop_name FROM shop_details WHERE shop_number like '%".'"'.$regShopNum.'"'.";%'");
						 $fetchNames =  mysqli_fetch_array($fetchShopNames);
						echo $sName = $fetchNames['shop_name']."<br>";
						//echo rtrim($sName,',');
					  }
					 
						?></td>
				  </tr>
				   <?php } ?>
				 	   
			   <?php 
				  if($imageData['reg_cateroty'] != '' && !empty($imageData['reg_cateroty'])){?>
				  <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Categories</th>
						  <th>:</th>
					  <td id ='td_enquiry'>
					  <?php 
					  $shopCategory = $imageData['reg_cateroty'];
						 $jsons = json_decode($shopCategory); 
						  foreach($jsons as $data => $value){
							  if($value->cate_level == 2){
								  $val =  $value->cate_main.", ";
								   echo  $val = rtrim($val, ',');
							  }else if($value->cate_level == 3){
								  $val = $value->cate_list.", ";
								  echo  $val = rtrim($val, ',');
							  	}
							}
					 
						?></td>
				  </tr>
				   <?php } ?>
			  
			 <?php 
				if($imageData['reg_pic'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Profile Picture </th>

						  <th>:</th>
					  <td id ='td_enquiry'>
					  <img src="<?php echo "../images/login/".$imageData['reg_pic']?>" alt="<?php echo $imageData['reg_pic']?>" style="width:100px;height:100px;">
					  </td>
				  </tr>
		     <?php } ?>
		      
			   <?php 
				if($imageData['reg_msg'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Message</th>
					 <th>:</th>
					  <td id ='td_enquiry'  style="color: dodgerblue"><?php echo $imageData['reg_msg'];?></td>
				  </tr>
			    <?php } ?>
			    <?php 
				if($imageData['reg_cre_date'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Created Date</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['reg_cre_date'])) ;?></td>
				  </tr>
				<?php } ?>
		    
			  <?php 
				if($imageData['reg_adminId'] != '' && $imageData['reg_adminId'] != 0){?>
			     <tr id ='tr_enquiry'>
				  <th id ='th_enquiry'>Admin ID</th>
				 <th>:</th>
				  <td id ='td_enquiry'><?php echo $imageData['reg_adminId'];?></td>
			  </tr>
			  <?php } ?>

     </table>	
		    
 
	 <?php }
		
							 
		else if($updateTable == 'enquiry_dmg'){ ?>
			
		 <?php  $resultImagedata = mysqli_query($db,"SELECT * FROM enquiry_dmg WHERE em_id = '$updatRowID'");
		   $imageData = mysqli_fetch_array($resultImagedata);
		 ?>
	
			
			 <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
	   			<?php echo "Created ". date('d-m-Y h:i a',strtotime($imageData['em_createdAt']));?> 
			 </div>
        	 <table id = 'tbl_enquiry'>
        	  <?php 
				  if($imageData['em_shopid'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Shop ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['em_shopid'];?></td>
					  </tr>
				   <?php } ?>
			<?php 
				  if($imageData['em_product_id'] != '' && $imageData['em_product_id'] != 0){?>   
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Product ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['em_product_id'];?></td>
					  </tr>
			   <?php } ?>
			   <?php 
				  if($imageData['em_userid'] != ''){?>
					  	  <tr id ='tr_enquiry'>
							  <th id ='th_enquiry'>User ID</th>
								  <th>:</th>
							  <td id ='td_enquiry'><?php echo $imageData['em_userid'];?></td>
						  </tr>
				  <?php } ?>
			  <?php 
				  if($imageData['em_name'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Name</th>
						  <th>:</th>
					  <td id ='td_enquiry'><?php echo $imageData['em_name'];?></td>
				  </tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['em_contactno'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Contact Number</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['em_contactno'];?></td>
					  </tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['em_email'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Email</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['em_email'];?></td>
				</tr>
				 <?php } ?>
			  <?php 
				  if($imageData['em_message'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Message</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['em_message'];?></td>
					  </tr> 
				 <?php } ?>
		    
		
			    <?php 
				if($imageData['em_createdAt'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Created Date</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['em_createdAt'])) ;?></td>
				  </tr>
				<?php } ?>
		    
     </table>	
		    
 
	 <?php }
							 						 
		else if($updateTable == 'pictures'){ ?>
			
		 <?php  $resultImagedata = mysqli_query($db,"SELECT * FROM pictures WHERE pic_id = '$updatRowID'");
		   $imageData = mysqli_fetch_array($resultImagedata);
		 ?>
	
			
			 <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
	   			<?php echo "Created ". date('d-m-Y h:i a',strtotime($imageData['pic_cre']));?> 
			 </div>
        	 <table id = 'tbl_enquiry'>
        	  <?php 
				  if($imageData['pic_id'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Picture ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['pic_id'];?></td>
					  </tr>
				   <?php } ?>
			<?php 
				  if($imageData['pic_category'] != ''){?>   
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Picture Category</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['pic_category'];?></td>
					  </tr>
			   <?php } ?>
			   <?php 
				  if($imageData['pic_userid'] != ''){?>
					  	  <tr id ='tr_enquiry'>
							  <th id ='th_enquiry'>User ID</th>
								  <th>:</th>
							  <td id ='td_enquiry'><?php echo $imageData['pic_userid'];?></td>
						  </tr>
				  <?php } ?>
			  <?php 
				  if($imageData['pic_username'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>User Name</th>
						  <th>:</th>
					  <td id ='td_enquiry'><?php echo $imageData['pic_username'];?></td>
				  </tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['pic_picture'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Picture Name</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['pic_picture'];?></td>
					  </tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['pic_type'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Type</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['pic_type'];?></td>
				</tr>
				 <?php } ?>
		    
			    <?php 
				if($imageData['pic_cre'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Created Date</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['pic_cre'])) ;?></td>
				  </tr>
				<?php } ?>
		    
     </table>	
	 <?php }
							 
		else if($updateTable == 'offer_dmg'){ ?>
			
		 <?php  $resultImagedata = mysqli_query($db,"SELECT * FROM offer_dmg WHERE offer_id = '$updatRowID'");
		   $imageData = mysqli_fetch_array($resultImagedata);
		 ?>
	
			
			 <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
	   			<?php echo "Created ". date('d-m-Y h:i a',strtotime($imageData['offer_cre']));?> 
			 </div>
        	 <table id = 'tbl_enquiry'>
        	  <?php 
				  if($imageData['offer_id'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Offer ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['offer_id'];?></td>
					  </tr>
				   <?php } ?>
			<?php 
				  if($imageData['offer_shop_id'] != ''){?>   
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Shop ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['offer_shop_id'];?></td>
					  </tr>
			   <?php } ?>
			   <?php 
				  if($imageData['offer_user_id'] != ''){?>
					  	  <tr id ='tr_enquiry'>
							  <th id ='th_enquiry'>User ID</th>
								  <th>:</th>
							  <td id ='td_enquiry'><?php echo $imageData['offer_user_id'];?></td>
						  </tr>
				  <?php } ?>
			  <?php 
				  if($imageData['offer_name'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Offer Name</th>
						  <th>:</th>
					  <td id ='td_enquiry'><?php echo $imageData['offer_name'];?></td>
				  </tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['offer_type'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Offer Type</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['offer_type'];?></td>
					  </tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['offer_details'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Offer Details</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['offer_details'];?></td>
				</tr>
				 <?php } ?>
		    
			    <?php 
				if($imageData['offer_start'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Offer Start</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['offer_start'])) ;?></td>
				  </tr>
				<?php } ?>
	    
	       <?php 
				if($imageData['offer_end'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Offer End</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['offer_end'])) ;?></td>
				  </tr>
				<?php } ?>
	    
	     	<?php 
				  if($imageData['offer_picture'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Picture</th>
					  <th>:</th>
				   <td id ='td_enquiry'>
				   <img src="<?php			
					echo $imageData['offer_picture'];?> " alt="Image" style="width:100px;height:100px;">	
				   </td>
				</tr>
				 <?php } ?>
				 
				 <?php
				  if($imageData['offer_views'] != '0'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Offer Views Count</th>
					  <th>:</th>
				   <td id ='td_enquiry'>
				   <img src="<?php			
					echo $imageData['offer_views'];?> " alt="Image" style="width:100px;height:100px;">	
				   </td>
				</tr>
				 <?php } ?>
				 
				   <?php 
				if($imageData['offer_cre'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Created Date</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['offer_cre'])) ;?></td>
				  </tr>
				<?php } ?>
		    
     </table>	
	 <?php }					 
							 
							 
		else if($updateTable == 'advertisement'){ ?>
			
		 <?php  $resultImagedata = mysqli_query($db,"SELECT * FROM advertisement WHERE Ad_Id = '$updatRowID'");
		   $imageData = mysqli_fetch_array($resultImagedata);
		 ?>
	
			
			 <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
	   			<?php echo "Created ". date('d-m-Y h:i a',strtotime($imageData['Ad_Createddate']));?> 
			 </div>
        	 <table id = 'tbl_enquiry'>
        	  <?php 
				  if($imageData['Ad_Id'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Advertisement ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['Ad_Id'];?></td>
					  </tr>
				   <?php } ?>
			<?php 
				  if($imageData['Ad_Type'] != ''){?>   
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Advertisement Type</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['Ad_Type'];?></td>
					  </tr>
			   <?php } ?>
			   <?php 
				  if($imageData['Ad_Name'] != ''){?>
					  	  <tr id ='tr_enquiry'>
							  <th id ='th_enquiry'>Ad Name</th>
								  <th>:</th>
							  <td id ='td_enquiry'><?php echo $imageData['Ad_Name'];?></td>
						  </tr>
				  <?php } ?>
			  <?php 
				  if($imageData['Ad_Shopid'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Shop ID</th>
						  <th>:</th>
					  <td id ='td_enquiry'><?php echo $imageData['Ad_Shopid'];?></td>
				  </tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['Ad_Shopname'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Shopname</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['Ad_Shopname'];?></td>
					  </tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['Ad_Description'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Ad Description</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['Ad_Description'];?></td>
				</tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['Ad_Pagename'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Page Name</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['Ad_Pagename'];?></td>
				</tr>
				 <?php } ?>
		    
		    	<?php 
				  if($imageData['Ad_Startdate'] != '0000-00-00 00:00:00'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Start Date</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php 
						echo date('d-m-Y h:i a',strtotime($imageData['Ad_Startdate'])) ;								  ?>
						</td>
				</tr>
				 <?php } ?>
		    
		    	
		    	<?php 
				  if($imageData['Ad_Enddate'] != '0000-00-00 00:00:00'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>End Date</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php 
							echo date('d-m-Y h:i a',strtotime($imageData['Ad_Enddate'])) ;?>
										</td>
				</tr>
				 <?php } ?>
		    
		      	<?php 
				  if($imageData['Ad_Picture'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Picture</th>
					  <th>:</th>
				   <td id ='td_enquiry'>
				   <img src="<?php			
					echo $imageData['Ad_Picture'];?> " alt="Image" style="width:100px;height:100px;">	
				   </td>
				</tr>
				 <?php } ?>
	    		
	    			<?php 
				  if($imageData['Ad_Url'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Url</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['Ad_Url'];?></td>
				</tr>
				 <?php } ?>
	    		<?php 
				  if($imageData['Ad_Views'] != '0'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Views Count</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['Ad_Views'];?></td>
				</tr>
				 <?php } ?>
	    		
	    		<?php 
				  if($imageData['Ad_Clicks'] != '0'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Clicks Count</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['Ad_Clicks'];?></td>
				</tr>
				 <?php } ?>
		    		
			    <?php 
				if($imageData['Ad_Createddate'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Created Date</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['Ad_Createddate'])) ;?></td>
				  </tr>
				<?php } ?>
		    
     </table>	
	 <?php }					 

							 						 									 
		else if($updateTable == 'product_details'){ ?>
		
		  
		 <?php  $resultImagedata = mysqli_query($db,"SELECT * FROM product_details WHERE prodt_id = '$updatRowID'");
		   $imageData = mysqli_fetch_array($resultImagedata);
			 $image		= $imageData['prodt_picture'];
		 ?>
	
			
			 <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
	   			<?php echo "Created ". date('d-m-Y h:i a',strtotime($imageData['prodt_cre']));?> 
			 </div>
        	 <table id = 'tbl_enquiry'>
        	  <?php 
				  if($imageData['prodt_id'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Product ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['prodt_id'];?></td>
					  </tr>
				   <?php } ?>
			<?php 
				  if($imageData['prodt_category'] != ''){?>   
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Product Category</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php 
														 //echo $imageData['pic_category'];
															$jsons = json_decode($imageData['prodt_category']); 
													  foreach($jsons as $data => $value){
														   echo "Parent Category : ".$value->cate_parent."<br>";
														  echo $value->cate_main.", ";
														  echo $value->cate_list.", ";
														}
							  ?></td>
					  </tr>
			   <?php } ?>
			   <?php 
				  if($imageData['prodt_name'] != ''){?>
					  	  <tr id ='tr_enquiry'>
							  <th id ='th_enquiry'>Product Name</th>
								  <th>:</th>
							  <td id ='td_enquiry'><?php echo $imageData['prodt_name'];?></td>
						  </tr>
				  <?php } ?>
			  <?php 
				  if($imageData['prodt_picture'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Product Picture</th>
						  <th>:</th>
					  <td id ='td_enquiry'>
					
						<img src="<?php			
					echo $imageData['prodt_picture'];?> " alt="Image" style="width:100px;height:100px;">	
				 </td>
				  </tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['prodt_description'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Product Description</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['prodt_description'];?></td>
					  </tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['prodt_offer_from'] != '0000-00-00 00:00:00'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Product Offer Start Date</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['prodt_offer_from']));
					 ?></td>
				</tr>
				 <?php } ?>
				 
				 	<?php 
				  if($imageData['prodt_offer_to'] != '0000-00-00 00:00:00'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Product Offer End Date</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php 
					  echo date('d-m-Y h:i a',strtotime($imageData['prodt_offer_to']));
					  ?></td>
				</tr>
				 <?php } ?>
				 
				  	<?php 
				  if($imageData['prodt_company_id'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Shop ID</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['prodt_company_id'];?></td>
				</tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['prodt_views_count'] != '0' && $imageData['prodt_views_count'] != '' ){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Product Views Count</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['prodt_views_count'];?></td>
				</tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['prodt_click_count'] != '0' && $imageData['prodt_click_count'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Product Clicks Count</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['prodt_click_count'];?></td>
				</tr>
				 <?php } ?>
		    
			    <?php 
				if($imageData['prodt_cre'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Created Date</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['prodt_cre'])) ;?></td>
				  </tr>
				<?php } ?>
		    
     </table>	
		    
 
	 <?php }
							 
        else if($updateTable == 'shop_details'){ ?>
		   
		 <?php  $resultImagedata = mysqli_query($db,"SELECT * FROM shop_details WHERE shop_id = '$updatRowID'");
		   $imageData = mysqli_fetch_array($resultImagedata);
			$image		= $imageData['shop_picture'];
		 ?>
	
			
			 <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
	   			<?php echo "Created ". date('d-m-Y h:i a',strtotime($imageData['shop_cre']));?> 
			 </div>
        	 <table id = 'tbl_enquiry'>
        	  <?php 
				  if($imageData['shop_id'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Shop ID</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php echo $imageData['shop_id'];?></td>
					  </tr>
				   <?php } ?>
			<?php 
				  if($imageData['shop_category'] != ''){?>   
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Shop Category</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php 
														 //echo $imageData['pic_category'];
															$jsons = json_decode($imageData['shop_category']); 
													  foreach($jsons as $data => $value){
														   echo "Parent Category : ".$value->cate_parent."<br>";
														  echo "Sub Categories : ".$value->cate_main.", ";
														  echo $value->cate_list.", "."<br>";
														}
							  ?></td>
					  </tr>
			   <?php } ?>
			   <?php 
				  if($imageData['shop_name'] != ''){?>
					  	  <tr id ='tr_enquiry'>
							  <th id ='th_enquiry'>Shop Name</th>
								  <th>:</th>
							  <td id ='td_enquiry'><?php echo $imageData['shop_name'];?></td>
						  </tr>
				  <?php } ?>
			  <?php 
				  if($imageData['shop_user_id'] != ''){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>User ID</th>
						  <th>:</th>
					  <td id ='td_enquiry'>
					
						<img src="<?php			
					echo $imageData['shop_user_id'];?> " alt="Image" style="width:100px;height:100px;">	
				 </td>
				  </tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['shop_number'] != ''){?>
					  <tr id ='tr_enquiry'>
						  <th id ='th_enquiry'>Shop Number(s)</th>
							  <th>:</th>
						  <td id ='td_enquiry'><?php $numberData = unserialize($imageData['shop_number']);
							  foreach($numberData as $shopNumber){
								  echo $shopNumber.", ";
							  }
							  ?></td>
						 
					  </tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['shop_mall'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Shop Mall</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['shop_mall'];?></td>
				</tr>
				 <?php } ?>
				 
				 	<?php 
				  if($imageData['shop_maincontact'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Contact Number</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['shop_maincontact'];?></td>
				</tr>
				 <?php } ?>
				 
				<?php 
				  if($imageData['shop_email'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Email</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['shop_email'];?></td>
				</tr>
				 <?php } ?>
				 
			<?php 
				  if($imageData['shop_website'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Website</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['shop_website'];?></td>
				</tr>
				 <?php } ?>
				 
			<?php 
				  if($imageData['shop_address'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Address</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php 
					   echo $imageData['shop_address']."<br>";
					   echo $imageData['shop_city']."<br>";
					   echo $imageData['shop_state']."<br>";
					    echo $imageData['shop_country'];
					   ?></td>
				</tr>
				 <?php } ?>
				 
				 	<?php 
				  if($imageData['shop_picture'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Picture</th>
					  <th>:</th>
				   <td id ='td_enquiry'>
					   <img src="<?php echo $image;?> " alt="Image" style="width:100px;height:100px;">
					  </td>
				</tr>
				 <?php } ?>
				 
				  <?php 
				  if($imageData['shop_description'] != ''){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Shop Description</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['shop_description'];?></td>
				</tr>
				 <?php } ?>
				 
				  	<?php 
				  if($imageData['shop_priv_start'] != '0000-00-00 00:00:00'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Privilage Start Date</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime( $imageData['shop_priv_start']));
					 ?></td>
				</tr>
				 <?php } ?>
				 
				  	<?php 
				  if($imageData['shop_priv_end'] != '0000-00-00 00:00:00'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Privilage End Date</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php
									echo date('d-m-Y h:i a',strtotime( $imageData['shop_priv_end']));
					   ?></td>
				</tr>
				 <?php } ?>
				 
				 	  
				 <?php 
				  if($imageData['shop_view_count'] != '0'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Shop Views Count</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php 
								echo $imageData['shop_view_count'];
					   
					   ?></td>
				</tr>
				 <?php } ?>
				 
				 <?php 
				  if($imageData['shop_click_count'] != '0'){?>
				 <tr id ='tr_enquiry'>
				   <th id ='th_enquiry'>Shop Clicks Count</th>
					  <th>:</th>
				   <td id ='td_enquiry'><?php echo $imageData['shop_click_count'];?></td>
				</tr>
				 <?php } ?>
		    
			    <?php 
				if($imageData['shop_cre'] != '0000-00-00 00:00:00'){?>
				   <tr id ='tr_enquiry'>
					  <th id ='th_enquiry'>Created Date</th>
					 <th>:</th>
					  <td id ='td_enquiry'><?php echo date('d-m-Y h:i a',strtotime($imageData['shop_cre'])) ;?></td>
				  </tr>
				<?php } ?>
		    
     </table>	
		    
 
	 <?php }
	}  
	 ?>
	       <?php  echo "<h3 style='color:green;'>Updated Query</h3>"."<br><details>". $resultData['updt_data']."</details>"; 
	   	?>
  </div>
	
	 
				
<?php }  ?>
<?php
//for accept
if(isset($_POST['status']) && $_POST['status'] == "Accept" && $_SESSION['MM_Username'] != ""){
   
	
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	define('BASE_URL', '/dragonmartguide.com');
	
	$upTableId 		= $_POST['upTableID'];
	$tblName		=	'';
	$statusName 	= 	'';
	$idName			= 	'';
	$selectData		=	mysqli_query($db,"SELECT * FROM updt_info WHERE updt_id = '$upTableId'");
	$fetchData		=	mysqli_fetch_array($selectData);
	$colID			=	$fetchData['updt_rowid'];
	$tblName		= 	$fetchData['updt_tablename'];
	$loginuserID 	=  $_SESSION['loginUserid'];
	if($tblName == 'advertisement'){
		$statusName		=	'Ad_Status';
		$idName			=	'Ad_Id';
	}else if($tblName == 'offer_dmg'){
		$statusName		=	'offer_status';
		$idName			=	'offer_id';
	}else if($tblName == 'product_details'){
		$statusName		=	'prodt_status';
		$idName			=	'prodt_id';
	}
	else if($tblName == 'enquiry_dmg'){
		$statusName		=	'em_status';
		$idName			=	'em_id';
	}
	else if($tblName == 'pictures'){
		$statusName		=	'pic_status';
		$idName			=	'pic_id';
	}
	else if($tblName == 'shop_details'){
		$statusName		=	'shop_status';
		$idName			=	'shop_id';
	}
	
	else if($tblName == 'user_register'){
		$statusName		=	'reg_status';
		$idName			=	'reg_id';
		$selectRegisterUserData = mysqli_query($db,"SELECT * FROM user_register WHERE reg_id = '$colID'");
		if(mysqli_num_rows($selectRegisterUserData)>0){
			$fetchRegistreUserData 	= mysqli_fetch_array($selectRegisterUserData);
			
			$regUserName 			= $fetchRegistreUserData['reg_username'];
			$regFirstName 			= $fetchRegistreUserData['reg_firstname'];
			$regLastName 			= $fetchRegistreUserData['reg_lastname'];
			$regAddress 			= $fetchRegistreUserData['reg_address'];
			$regMobile 				= $fetchRegistreUserData['reg_mobile'];
			//$regCategory   			= $fetchRegistreUserData['reg_cateroty'];
			//$regShopNumber 			= $fetchRegistreUserData['reg_shopnumber'];
			$regMallname 			= $fetchRegistreUserData['reg_mallname'];
			$personName = $regFirstName." ".$regLastName;
			
			$regShopNumber = explode(',',  $fetchRegistreUserData['reg_shopnumber']);
	//,`shop_category` = '$regCategory'
			
			foreach($regShopNumber as $shpNum){
				
				$updateShopData	=	mysqli_query($db,"update `shop_details` SET 
				`shop_contact_person` = '$personName',
				`shop_mobile1` = '$regMobile',
				`shop_email` = '$regUserName',
				`shop_zone` = '$regMallname',
				`shop_landmark` = '$regAddress'
			 
				WHERE shop_number LIKE '%".'"'.$shpNum.'";'."%'"); 
			}
			
		}
	}
	if($tblName == 'user_register'){
	 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'on', `reg_adminid` = '$loginuserID'
						     WHERE `$idName` = '$colID' AND (`$statusName` = 'approval' OR `$statusName` = 'on')";
	mysqli_query($db,$sqlquery);
		
	    $selectDataQuery = mysqli_query($db,"select * from user_register where reg_id = '$colID' and reg_status = 'on'");
		if(mysqli_num_rows($selectDataQuery) >0){
			$selectData  = mysqli_fetch_array($selectDataQuery);
			$userLoginName 	=   $selectData['reg_username'];
			$passwd			=	$selectData['reg_password'];
			$uName			=	$selectData['reg_firstname'];
			$gender			=	$selectData['reg_gender'];	
			$addr			=	$selectData['reg_address'];
			$userMob		=	$selectData['reg_mobile'];
			$type			=	'shopuser';
			$userShops		=	unserialize($selectData['reg_shopselected']);
			$shopNumberData[] =  $userShops['shopid'];
			$selectedShops	=	 serialize($shopNumberData);
			$userPerm		=	'';
			$userPics		=	$selectData['reg_pic'];
			$imagePic		=	"http://" . $_SERVER['SERVER_NAME']. BASE_URL."/images/login/".$userPics;
			$userCre		=	$selectData['reg_cre_date'];
			$userModi		=	$selectData['reg_modi_date'];
			$userStat		=	$selectData['reg_status'];
			
			
			//for update user_dmg
			$sqlInsertRegisterData		=	"INSERT INTO `user_dmg`							      
																(
																	`user_username`,
																	`user_password`,
																	`user_name`,
																	`user_gender`,
																	`user_address`,
																	`user_mobile`,
																	`user_type`,
																	`user_shops`,
																	`user_permission`,
																	`user_pic`,
																	`user_cre`,
																	`user_modi`,
																	`user_status`
																	
																)VALUES (
																	 '$userLoginName',
																	 '$passwd',
																	 '$uName',
																	 '$gender', 
														 			 '$addr',
																	 '$userMob',
																	 '$type',
																	 '$selectedShops',
																	 '$userPerm',
																	 '$imagePic',
																	 '$userCre',
																	 '$userModi',
																	 '$userStat'
																	 )";
			
			//user_dmg end
			mysqli_query($db, $sqlInsertRegisterData) or die(mysqli_error($db));
			$last_insert_id	= mysqli_insert_id($db);
			$shpID	=	$userShops['shopid'];
			$updateShopData	=	mysqli_query($db,"update `shop_details` SET `shop_user_id` = '$last_insert_id' WHERE  shop_id = '$shpID'");
			
		
			
			
				//move image from temporary folder to permanent folder
			if($userPics != ''){
				$temporaryPath	=	$_SERVER['DOCUMENT_ROOT']."/dragonmartguide.com/images/login/".$userPics;
				
				if (file_exists($temporaryPath))
					{
						$imageAfterunderscore = substr($userPics, strpos($userPics, "_") + 1);
						$newName = $last_insert_id."_".$imageAfterunderscore;
						
						$renamePath	=	$_SERVER['DOCUMENT_ROOT']."/dragonmartguide.com/images/login/".$newName;
						rename($temporaryPath, $renamePath);
						$permanentPath	=	$_SERVER['DOCUMENT_ROOT']."/dragonmartguide.com/images/products/".$newName;	
						copy($renamePath,$permanentPath);
						unlink($renamePath);
						$imgType	=	'image/jpeg';
						$sqlPicturequery = "INSERT INTO `pictures` (
															`pic_id`, 
															`pic_category`,
															`pic_userid`, 
															`pic_username`, 
															`pic_picture`,
															`pic_type`,
															`pic_linked`,
															`pic_cre`, 
															`pic_status`) 
													VALUES 
													(NULL,
													'profile', 
													'".$_SESSION[ 'loginUserid' ]."', 
													'".$_SESSION[ 'MM_Username' ]."',
													'$newName', 
													'$imgType',
													'', 
													'$national_date_time_24',
													'on')";
						$queryresult=mysqli_query($db, $sqlPicturequery) or die(mysqli_error());
					}
				}
			
			include('../Connections/email_newUserShopApproved.php');
		}
		
		
		
		
	}else{
		 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'on'
						     WHERE `$idName` = '$colID' AND (`$statusName` = 'approval' OR `$statusName` = 'on')";
	     mysqli_query($db,$sqlquery);
	}
	?>

	<?php
	
	$sqlquery2 = "UPDATE `updt_info` SET `updt_viewstatus` = 'on' 
						     WHERE `updt_rowid` = '$colID' ";
	 mysqli_query($db,$sqlquery2); 
		
}

//for reject
if(isset($_POST['status']) && $_POST['status'] == "Reject" && $_SESSION['MM_Username'] != ""){
   
	
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	
	$upTableId 	= $_POST['upTableID'];
	$tblName	=	'';
	$statusName = 	'';
	$idName		= 	'';
	$selectData	=	mysqli_query($db,"SELECT * FROM updt_info WHERE updt_id = '$upTableId'");
	$fetchData	=	mysqli_fetch_array($selectData);
	$colID		=	$fetchData['updt_rowid'];
	$tblName	= 	$fetchData['updt_tablename'];
	$loginuserID 	=  $_SESSION['loginUserid'];
	
	if($tblName == 'advertisement'){
		$statusName		=	'Ad_Status';
		$idName			=	'Ad_Id';
	}else if($tblName == 'offer_dmg'){
		$statusName		=	'offer_status';
		$idName			=	'offer_id';
	}else if($tblName == 'product_details'){
		$statusName		=	'prodt_status';
		$idName			=	'prodt_id';
	}else if($tblName == 'enquiry_dmg'){
		$statusName		=	'em_status';
		$idName			=	'em_id';
	}else if($tblName == 'user_register'){
		$statusName		=	'reg_status';
		$idName			=	'reg_id';
	}
	
	if($tblName == 'user_register'){
	 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'delete', `reg_adminid` = '$loginuserID'
						     WHERE `$idName` = '$colID' AND (`$statusName` = 'approval' OR `$statusName` = 'on')";
	mysqli_query($db,$sqlquery);
	}else{
	
	 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'delete' 
						     WHERE `$idName` = '$colID' AND (`$statusName` = 'approval' OR `$statusName` = 'on' )";
	mysqli_query($db,$sqlquery);
	}
		
	$sqlquery2 = "UPDATE `updt_info` SET `updt_viewstatus` = 'delete' 
						     WHERE `updt_rowid` = '$colID' ";
	 mysqli_query($db,$sqlquery2); 
		
}


//for userstatus Ajax
if(isset($_POST['userstatus'])){
	require_once('../Connections/dragonmartguide.php');
	include( '../Connections/functionsL.php' );
	$objJoin = new common();
	$userStatus = $_POST['userstatus'];


	$_SESSION['userupdatestatus'] = isset($_POST['userstatus'])?$_POST['userstatus']:'';
	if($_SESSION['userupdatestatus'] == 'select')
		unset($_SESSION['userupdatestatus']);
?>
						
		<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" data-page-length="25">
			<thead>
				<tr>
					<th>User Id</th>
					<th>Pic/Data</th>
					<th>Type</th>
					<th>Page</th>
					<th>Table</th>
											<!--<th>Time</th> -->
					<th>Status</th>
					<th>Action</th>
											
				</tr>
		  </thead>
		  	<tbody>
		  	<?php
				$updatedList = "SELECT * FROM `updt_info` ";
				if(isset($_SESSION['userupdatestatus'])){
					$updtStatus = $_SESSION['userupdatestatus'];
					$updatedList .= "WHERE `updt_viewstatus` = '$updtStatus'";
				}
				 else if($userStatus == 'on') {
					$updtStatus	= 'on';
					$updatedList .= " WHERE `updt_viewstatus` = '$updtStatus'";
				}else if($userStatus == 'delete'){
					$updtStatus	= 'delete';
					$updatedList .= " WHERE `updt_viewstatus` = '$updtStatus'";
					
				}else if($userStatus == 'viewed'){
					$updtStatus	= 'viewed';
					$updatedList .= " WHERE `updt_viewstatus` = '$updtStatus'";
					
				}else if($userStatus == 'not viewed'){
					$updtStatus	  = 'not viewed';
					$updatedList .= " WHERE `updt_viewstatus` = '$updtStatus'";
				}
				 else {
						$updatedList .= " WHERE `updt_viewstatus` = 'viewed' OR `updt_viewstatus` = 'not viewed'";
					}
				$updatedList .= " ORDER BY `updt_info`.`updt_time` DESC LIMIT 100"; 
	
						/*$updatedList = "SELECT * FROM `updt_info` WHERE `updt_viewstatus` = '$updtStatus' ORDER BY `updt_info`.`updt_time` DESC LIMIT 100"; */
	
						$statusList	=	mysqli_query($db,$updatedList);
						$rowCount = mysqli_num_rows($statusList);
							if($rowCount > 0){
								while ($updateData = mysqli_fetch_array($statusList)){
								
								  if( $updateData['updt_pagename'] == 'userlogin'){ ?>
									<tr style="background-color:orange">
										  <?php }else{ ?>
										  <tr>	 
									<?php } ?>					 
									<?php $updateId = $updateData['updt_id']; 
										  $updtUserId = $updateData['updt_userid']; 
									?>
									
									<td><?php echo $updateData['updt_userid']; ?></td>
									<td>
										
										<?php 
												 $rowID = $updateData['updt_rowid'];
														if($updateData['updt_tablename'] == 'user_register'){
															
															$resultData = $objJoin->joinWithEnquiry('user_register',$rowID);
															
														if($resultData!=''){ ?>
															<img src="<?php echo "../images/login/".$resultData?>" alt="<?php echo $resultData?>" style="width:100px;height:100px;">
															<?php }else{
														    echo $updateData['updt_rowid'];
														 }
												  } 
											
										/*			else if($updateData['updt_tablename'] == 'advertisement'){
												$resultData = $objJoin->joinWithEnquiry('advertisement',$rowID);
														if($resultData!=''){ ?>
															<img src="<?php echo $resultData?>" alt="<?php echo $resultData?>" style="width:100px;height:100px;">
															<?php }else{
														    echo $updateData['updt_rowid'];
														 }
												  } 
												*/
												else{echo $updateData['updt_rowid'];} ?>
									</td>
									<td><?php echo $updateData['updt_type']; ?></td>
									<td><?php echo $updateData['updt_pagename']; ?></td>
									<td><?php echo $updateData['updt_tablename']; ?></td>
									<td>
													<?php 
														$viewstatus =  $updateData['updt_viewstatus'];
														if($viewstatus == 'viewed'){?>
															<button type="button" class="btn btn-info glyphicon glyphicon-eye-open  viewBtn" data-toggle="modal" data-target="#myModal" data-id = "<?php echo $updateId;?>" value = "Viewed" title = "Viewed"></button>
													<?php }else {?>
															<button type="button" class="btn btn-warning glyphicon glyphicon-eye-close  viewBtn" data-toggle="modal" data-target="#myModal" data-id = "<?php echo $updateId;?>" value = "Not Viewed" title = "Not Viewed"></button>
												<?php }?>
									</td>
									<td>
									<?php 
									if($userStatus == 'on') {?>
										
										<button type="button" class="btn btn-danger glyphicon glyphicon-remove-circle rejectlive" id = "<?php echo $updateId;?>" title = "Reject"></button>
									
									<?php }?>
									<?php 
									if($userStatus == 'delete') {?>
										
										<button type="button" class="btn btn-info fa fa-undo restoreBtn " id = "<?php echo $updateId;?>" title = "Restore"> </button>
									
									<?php }?>
									
									<?php 
									if($userStatus != 'delete' && $userStatus != 'on') {?>
										
										<button type="button" class="btn btn-success glyphicon glyphicon-ok Acceptdata" id = "<?php echo $updateId;?>" title = "Accept" ></button>
										<button type="button" class="btn btn-danger glyphicon glyphicon-remove-circle Rejectdata" id = "<?php echo $updateId;?>" title = "Reject" ></button>
										<!-- <button type="button" class="btn btn-primary glyphicon glyphicon-question-sign actionBtn" id = "viewAction" data-toggle="modal" data-target="#myModalAction" data-id = "<?php //echo $updateId;?>" data-table = "<?php //echo $updateData['updt_tablename']?>" data-rowid = "<?php //echo $updateData['updt_rowid']?> " title = "Accept"> Approve</button>-->
									
									<?php }?> 
									 
									  <button type="button" class="btn btn-danger glyphicon glyphicon- glyphicon-trash deleteBtn" id =  "<?php echo $updateId;?>" title = "Delete"></button>
								</td>	
							   </tr> 
								<?php }
							}else{ ?>
									<tr>
										<td><span style="color: red;"><?php echo "No Records found";?></span>
										</td>
									</tr>				
							<?php } ?>

			</tbody>
		</table> 
									
<?php								
	
}?>

<?php
//for reject live
if(isset($_POST['status'])  && $_POST['status'] == "rejectlive"){
		if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	
	$upTableId 	= $_POST['rejectRowId'];
	$tblName	=	'';
	$statusName = 	'';
	$idName		= 	'';
	$selectData	=	mysqli_query($db,"SELECT * FROM updt_info WHERE updt_id = '$upTableId'");
	$fetchData	=	mysqli_fetch_array($selectData);
	$colID		=	$fetchData['updt_rowid'];
	$tblName	= 	$fetchData['updt_tablename'];
	
	if($tblName == 'advertisement'){
		$statusName		=	'Ad_Status';
		$idName			=	'Ad_Id';
	}else if($tblName == 'offer_dmg'){
		$statusName		=	'offer_status';
		$idName			=	'offer_id';
	}else if($tblName == 'product_details'){
		$statusName		=	'prodt_status';
		$idName			=	'prodt_id';
	}else if($tblName == 'enquiry_dmg'){
		$statusName		=	'em_status';
		$idName			=	'em_id';
	}
	else if($tblName == 'user_register'){
		$statusName		=	'reg_status';
		$idName			=	'reg_id';
	}
	
	 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'delete' 
						     WHERE `$idName` = '$colID' AND `$statusName` = 'on'";
	mysqli_query($db,$sqlquery);
		
	$sqlquery2 = "UPDATE `updt_info` SET `updt_viewstatus` = 'delete' 
						     WHERE `updt_rowid` = '$colID' ";
	 mysqli_query($db,$sqlquery2); 
}

//for restore

if(isset($_POST['status'])  && $_POST['status'] == "restore"){
		if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	
	$upTableId 	= $_POST['rejectRowId'];
	$tblName	=	'';
	$statusName = 	'';
	$idName		= 	'';
	$selectData	=	mysqli_query($db,"SELECT * FROM updt_info WHERE updt_id = '$upTableId'");
	$fetchData	=	mysqli_fetch_array($selectData);
	$colID		=	$fetchData['updt_rowid'];
	$tblName	= 	$fetchData['updt_tablename'];
	
	if($tblName == 'advertisement'){
		$statusName		=	'Ad_Status';
		$idName			=	'Ad_Id';
	}else if($tblName == 'offer_dmg'){
		$statusName		=	'offer_status';
		$idName			=	'offer_id';
	}else if($tblName == 'product_details'){
		$statusName		=	'prodt_status';
		$idName			=	'prodt_id';
	}else if($tblName == 'enquiry_dmg'){
		$statusName		=	'em_status';
		$idName			=	'em_id';
	}
	
	 $sqlquery = "UPDATE `$tblName` SET `$statusName` = 'on' 
						     WHERE `$idName` = '$colID' AND `$statusName` = 'delete'";
	mysqli_query($db,$sqlquery);
		
	$sqlquery2 = "UPDATE `updt_info` SET `updt_viewstatus` = 'on' 
						     WHERE `updt_rowid` = '$colID' ";
	 mysqli_query($db,$sqlquery2); 
}
?>

<style>
	#tbl_enquiry {
		font-family: arial, sans-serif;
		width: 100%;	
		border: solid 1px #ccc;
	}
	#th_enquiry,#td_enquiry {
		border-bottom: solid 1px #ccc;
	}
	#td_enquiry, #th_enquiry {
		text-align: left;
		padding: 8px;
	}
	#td_flag{
		text-align: center;
		color: gray;
		font-size: 20px
	}
	
	#td_date{
		text-align: right;
		color:darkgray;
	}
	
</style>



<script>
$(document).on('click touchstart', '.rejectlive', function() {
	//$('.rejectlive').click(function(){
		rejectRowId =  this.id ;
	//if (confirm('Are you sure to delete this ?')) {
				$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"		:"rejectlive",
							"rejectRowId"	:rejectRowId
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							
							location.reload();
						}	
			        });
	//}
	});
	
	//restoreBtn
	$(document).on('click touchstart', '.restoreBtn', function() {
	//$('.restoreBtn').click(function(){
		restoreRowId =  this.id ;
		
				$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"		:"restore",
							"rejectRowId"	:restoreRowId
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							location.reload();
						}	
			        });
		
	});
	
/*	$('.deleteData').click(function(){
			permanentDelete = $(this).attr('data-id');
		   $('#txtDeleteID').val(permanentDelete);  	
	  });*/
	
	
		//permanent Delete
	$(document).on('click touchstart', '.deleteBtn', function() {
	//$('.deleteBtn').click(function(){
		delRowId =  $(this).attr('id');
		if (confirm('Are you sure to delete this ?')) {
			$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"	:"permanentDelete",
							"perDelTableID"	:delRowId
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							location.reload();
						}	
			        }); 
		}
	});
	
	$(document).on('click touchstart', '.Acceptdata', function() {	
	//$('.Acceptdata').click(function(){
		upTableID = $(this).attr('id');
		
     		//upTableID = $(this).attr('id');
					$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"	:"Accept",
							"upTableID"	:upTableID
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							alert(1);
							alert(data);
							//location.reload();
						}	
			        }); 
    
		
	});
	
      $(document).on('click touchstart', '.Rejectdata', function() {	
	//for reject
	//$('.Rejectdata').click(function(){
		upTableID = $(this).attr('id');
		//upTableID	= $('#txtUpID').val();
	 
					$.ajax({
			        	url:"ajax_update_info.php",
			        	data:{
							"status"	:"Reject",
							"upTableID"	:upTableID
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							
							location.reload();
						}	
			        }); 
	 
	});
	
/*	//permanent delete
	
		$('.<strong><strong>deleteBtn</strong></strong>').click(function(){
		delRowId =  this.id ;
				
				$.ajax({
			        	url:"ajax_update_info.php",						
			        	data:{
							"status"	:"permanentDelete",
							"perDelTableID"	:delRowId
						},
			        	async:false,
			        	method: 'POST',
			        	success: function(data)
						{
							
							location.reload();
						}	
			        }); 
		
	});*/
	
	$('.actionBtn').click(function(){
			updateId = $(this).attr('data-id');
		   $('#txtUpID').val(updateId);  
	  });
	
</script>