<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}
?>

<?php
if(!isset($shopId)){
	$shopId = ''; //dummy value otherwise empty
}
$shopID				=	isset($_GET['sh'])?$_GET['sh']:$shopId;
$productID			=	isset($_GET['pt'])?$_GET['pt']:'';
$objShop 			= 	new Product();
$objShop->shopid	=	$shopID;
$getShopData		=	$objShop->getShopDetails();
$fetchShopData		=	mysqli_fetch_array($getShopData);

?>
 <div class="row">
  <div class="col-md-12"> </div>
  
  <!-- Menu Start -->
  <div class="col-md-12" style="padding:0px;">
    <ul class="company_menu">
    <a href="companydetails.php?sh=<?php echo $shopID; ?>"><li class="<?php if(basename($_SERVER['PHP_SELF']) == "companydetails.php"){echo " active";} ?>">Home</li></a>
<!--      <li>Profile</li>-->
		<a href="products.php?sh=<?php echo $shopID; ?>"><li class="<?php if(basename($_SERVER['PHP_SELF']) == "products.php"){echo " active";} ?>">Products</li></a>
<!--      <li>Contact</li>-->
    </ul>
  </div>
  <!-- Menu end --> 
  
  <!-- Quote start -->
  <div class="col-md-12" style="padding:0px;">
    <blockquote>
      <p> 
		  <?php
		  if($fetchShopData['shop_description'] != ''){
			  $inputstring = $fetchShopData['shop_description']; 
		  		$pieces = explode(" ", $inputstring);
		  		echo $first_part = implode(" ", array_splice($pieces, 0, 20)); ?></p>
     			 <small>Admin Says <cite>about this...</cite></small> </blockquote>
		  <?php } ?>
		  		
  </div>
  <!-- Quote end --> 
  
  <!-- shop details end -->
  <div class="col-md-12" style="padding:0px;">
    <div class="row Rhead">
      <div class="col-md-12">
        <h3>Shop Details</h3>
      </div>
    </div>
    <ul class="RlftLst">
     
		<li class="Rhd">Shop Number</li>
			<li class="Rdtl"><?php echo $fetchShopData['sno_number']; ?></li>
			<li class="Rhd">Location</li>
      		<li class="Rdtl"><?php echo $fetchShopData['shop_city']; ?></li>
      		<li class="Rdtl"><?php echo $fetchShopData['shop_state']; ?></li>
      		<li class="Rdtl"><?php echo $fetchShopData['shop_country']; ?></li>
	
      
	 <?php if($fetchShopData['shop_priv_type'] == 'regular' || $fetchShopData['shop_priv_type'] == 'premium' ){?>
<!--
			<li class="Rhd">Shop Number</li>
			<li class="Rdtl"><?php //echo $fetchShopData['sno_number']; ?></li>
			<li class="Rhd">Location</li>
      		<li class="Rdtl"><?php //echo $fetchShopData['shop_city']; ?></li>
      		<li class="Rdtl"><?php //echo $fetchShopData['shop_state']; ?></li>
      		<li class="Rdtl"><?php //echo $fetchShopData['shop_country']; ?></li>
-->
     
			<li class="Rhd">Get In Touch</li>
        	<li class="Rdtl"><?php echo $fetchShopData['shop_maincontact']; ?></li>
        	<li class="Rdtl"><?php echo $fetchShopData['shop_mobile1']; ?></li>
       		<li class="Rdtl"><?php echo $fetchShopData['shop_mobile2']; ?></li>
	  <?php }else{?>
				<li class="Rdtl"><?php echo "Limited Details (Restricted)"; ?></li>
				<?php } ?>
      
    </ul>
  </div>
  <!-- shop details end --> 
  
  <!-- Categories start -->
  <div class="col-md-12" style="padding:0px;">
    <div class="row Rhead">
      <div class="col-md-12">
        <h3>Categories</h3>
      </div>
    </div>
    <ul class="RlftLst">
     
      <!--<li class="Rdtl">Electronics, Mobiles, TV, Radio, Remote</li> -->
      <li class="Rdtl">
      <?php 
		 
		  if(isset($fetchShopData['shop_category'])){$shopCategory = $fetchShopData['shop_category'];}else{$shopCategory = '';}
		  
		  if($shopCategory != '' && $shopCategory != 'shop_category'){
			   $jsons = json_decode($shopCategory); 
				  foreach($jsons as $data => $value){
					  if($value->cate_level == 2){
						  echo $value->cate_main.", ";
					  }else if($value->cate_level == 3){
						 echo $value->cate_list.", ";}
					}
		  }
		 
	 ?></li>
    </ul>
  </div>
  <!-- Categories end --> 
  
  
<!--  Side Ads start-->
  <div class="col-com-12 hidden-xs">
  	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Front page - 1 (dragonmartguide.com) -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1972450229731838"
     data-ad-slot="5058938508"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
  </div>
<!--  Side Ads start-->
  
  
</div>