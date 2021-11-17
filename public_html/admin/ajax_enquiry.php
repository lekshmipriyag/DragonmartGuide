<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

//for displaying enquiry message
if(isset($_POST['enquiryId']) && $_POST['enquiryId'] != "" && $_SESSION['MM_Username'] != ""){
	
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dubai');
	$national_date_time_24 = date('Y-m-d H:i:s');
	
	include('../Connections/dragonmartguide.php');
	
	$enquiryId = $_POST['enquiryId'];
	
	$selectData = mysqli_query($db,"SELECT * FROM enquiry_dmg WHERE em_id = '$enquiryId'");
	$fetchData	=	mysqli_fetch_array($selectData);
	?>
	
	   <div class="modal-header">
          <button type="button" class="close" title = "close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:#41B0E5"><?php echo ucwords($fetchData['em_flag']." enquiry ");?></h4>
       </div>
<div class="modal-body" id = 'modalMessage'>
       
  <div class="pull-right" style="padding: 5px;color: #333;margin-bottom: 15px;">
   <?php echo "Created ". date('d-m-Y',strtotime($fetchData['em_createdAt']));?> 
    </div>
        
      <table id = 'tbl_enquiry'>
		  <tr id ='tr_enquiry'>
			  <th id ='th_enquiry'>Name</th>
				  <th>:</th>
			  <td id ='td_enquiry'><?php echo $fetchData['em_name'];?></td>
	      </tr>
		  <tr id ='tr_enquiry'>
			  <th id ='th_enquiry'>Contact Number</th>
				  <th>:</th>
			  <td id ='td_enquiry'><?php echo $fetchData['em_contactno'];?></td>
	      </tr>
		   <tr id ='tr_enquiry'>
			  <th id ='th_enquiry'>Email</th>
				  <th>:</th>
			  <td id ='td_enquiry'><?php echo $fetchData['em_email'];?></td>
	      </tr>

		  <?php
				if($fetchData['em_shopid'] != ''){
						$selectShopName = mysqli_query($db,"SELECT e.*,s.* FROM enquiry_dmg e INNER JOIN shop_details s on s.shop_id = e.em_shopid WHERE e.em_id = '$enquiryId'");
						$shopData	=	mysqli_fetch_array($selectShopName);
					?>
				<tr id ='tr_enquiry'>
				  <th id ='th_enquiry'>Shop Name</th>
				  <th>:</th>
				  <td id ='td_enquiry'><?php echo $shopData['shop_name'];?></td>
		  </tr>
		<?php } ?>
		 <?php
				if($fetchData['em_product_id'] != ''){
						$selectProductName = mysqli_query($db,"SELECT e.*,p.* FROM enquiry_dmg e INNER JOIN product_details p on p.prodt_id = e.em_product_id WHERE e.em_id = '$enquiryId'");
						$prodData	=	mysqli_fetch_array($selectProductName);
					?>
			 <tr id ='tr_enquiry'>
			   <th id ='th_enquiry'>Product Name</th>
				  <th>:</th>
			   <td id ='td_enquiry'><?php echo $prodData['prodt_name'];?></td>
		    </tr>
		 <?php } ?>
		  <tr id ='tr_enquiry'>
			  <th id ='th_enquiry'>Ip Address</th>
				  <th>:</th>
			  <td id ='td_enquiry'><?php echo $fetchData['em_ipaddress'];?></td>
	      </tr> 
		  <tr id ='tr_enquiry'>
			  <th id ='th_enquiry'>Message</th>
				  <th>:</th>
			  <td id ='td_enquiry'><?php echo $fetchData['em_message'];?></td>
	      </tr>
		  <tr id ='tr_enquiry'>
			  <th id ='th_enquiry'>Status</th>
				  <th>:</th>
			  <td id ='td_enquiry'><?php echo $fetchData['em_status'];?></td>
	      </tr>
     </table>		
  </div>
	
	<?php 
}?>
	
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
	
</script>






	