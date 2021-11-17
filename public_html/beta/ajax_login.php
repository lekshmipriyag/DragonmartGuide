<?php
if ( !isset( $_SESSION ) ) {
	session_start();
}
if(isset($_POST['shopNum']) && $_POST['shopNum'] != ""){
	include('Connections/dragonmartguide.php');

	$trimdata = str_replace(' ', '', $_POST['shopNum']);
	$inputData1	=	explode(',',$trimdata);
	$inputData1 = array_filter($inputData1);
	$arrayCount = count($inputData1);
	
	$forCount	=	'1';
	foreach($inputData1 as $inputData){

		 if($forCount == '1'){
			 $shopNum =  'shop_number LIKE '."'".'%"'.$inputData.'";%'."'"; 
		 }else{
			  $shopNum.=  ' OR shop_number LIKE '."'".'%"'.$inputData.'";%'."'"; 
		 }
		++$forCount;
				
		
		$shopNumberData =  'shop_number LIKE '."'".'%"'.$inputData.'";%'."'"; 
		$selectSData = mysqli_query($db,"SELECT * FROM shop_details WHERE shop_status = 'on' AND $shopNumberData AND shop_user_id = '' ");
		$selectSDataCount = mysqli_num_rows($selectSData);
		if($selectSDataCount <= 0){?>
			<script>
					$('#txt_Message').append('<?php echo $inputData.",";?>');
			</script>
			<?php }
	
		
	}
	
  	$selectData = mysqli_query($db,"SELECT * FROM shop_details WHERE shop_status = 'on' AND $shopNum AND shop_user_id = '' ");
	$selectDataCount = mysqli_num_rows($selectData);
	if($selectDataCount > 0){
		while($fetchData = mysqli_fetch_array($selectData)){
		$shopId		=	$fetchData['shop_id'];	
		$shoppName	=	$fetchData['shop_name'];
    	$shopNumberSeries = implode(',',unserialize($fetchData['shop_number']));?>
		<script>	
			$('#dataShopID').val('<?php echo $shopId;?>');
			$('#dataShopName').val('<?php echo $shoppName;?>');
			$('#dataShopNumber').val('<?php echo $shopNumberSeries;?>');
		</script>	
		<?php 
			
			 $data = $shoppName."(".$shopNumberSeries.")" ;?>
			 <span class="btn btn-default shopdata" id = "shopdata">
				 <i class="glyphicon glyphicon-ok" style = "color: green"></i>
			 	<?php 
						echo $data = $shoppName." ( ".$shopNumberSeries." )<br>" ;?>
			 </span> 
			 <?php
		}
	}else{
		
		?>
 			<span class="btn btn-default">
				 <i class="glyphicon glyphicon-ok shopdata" style = "color: red"></i>
			 	<?php echo "No Data";?>
			 </span>
	<?php }
	
	if($arrayCount != $selectDataCount){?>
		<script>
				
				$('#enquiry').show();
				$('#shopMsg').show();
				$('#emptyMsg').text('');
				$('#shopMsg').css("color","red");
				$('#shopMsg').html("( Above some shops are currently unavailable. )");
				var msgVal = $('#txt_Message').val();
				var len = $("#txt_Message").val().length;
				if(msgVal != '' && len >= 15){
					$('#emptyMsg').hide();
					$('#submit').show();
				}else if(msgVal != '' && len <= 15  ){ // validation for ad image
					$('#emptyMsg').show();
					$('#emptyMsg').css('color','red');
					$('#emptyMsg').text('Message Must be minimum of 15 characters');
					$('#submit').hide();
				}else if(msgVal === ''){
					$('#emptyMsg').show();
					$('#submit').hide();
				}else{
					$('#emptyMsg').hide();
					$('#submit').show();
				}
			
		</script>
	<?php }else{ ?>
		<script>
			$('#emptyMsg').text('');
			$('#enquiry').hide();
			$('#txt_Message').text('');
		</script>
	<?php }
  
}

?>