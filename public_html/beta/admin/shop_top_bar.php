				<div class="row">
					
					<div class="col-lg-12 C-main">
						<div style="position: absolute; right: 2px; top:2px; z-index: 2;"><a href="<?php echo $logoutAction ?>" title="Logout"><i class="fa fa-sign-out" aria-hidden="true" style="font-size: 25px; color: #b80b05;"></i>
</a></div>
						<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
						<img src="<?php if($profilePic == ""){echo "profile.png";}else{echo $profilePic;} ?>" class="img-circle C-profile" alt="profile picture">
					</div>
					<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
					
						<div class="row">
							<div class="C-dash1"><?php echo $check_permission['user_name']; ?> <span style="font-size: 13px;">(<?php echo $_SESSION['MM_Username']; ?>)</span></div>
							<div class="C-dash2">Admin control panel</div>
						</div>
					
					<!--<div class="row">
							<div class="C-dash1"><?php //echo $shopRow['shop_name']; ?> <span style="font-size: 13px;">(<?php //sort($thishopno); //echo implode(", ",$thishopno); ?>)</span></div>
							<div class="C-dash2">Shop owners control panel</div>
						</div>-->
						
						<div class="row C-toprow">
						<?php
							if(isset($_SESSION['live_user_type']) && $_SESSION['live_user_type'] == 'adminuser'){
							?>
						
							<a href="shop_home.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_home.php"){echo " active";} ?>">Dashboard</div></a>
							<a href="category.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "category.php"){echo " active";} ?>">Category</div></a>
							<a href="shop_myaccount.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_myaccount.php"){echo " active";} ?>">Admin Accounts</div></a>
							<a href="myaccount.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "myaccount.php"){echo " active";} ?>">My Account</div></a>
							<a href="shop_list.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_list.php"){echo " active";} ?>">Shop List</div></a>
							<a href="shop_new.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_new.php"){echo " active";} ?>">New Shop</div></a>
							<a href="add_product.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "add_product.php"){echo " active";} ?>">New Product</div></a>
							<a href="shop_offer_list.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_offer_list.php"){echo " active";} ?>">Offer List</div></a>
							<a href="advertisement.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "advertisement.php"){echo " active";} ?>">Advertisement</div></a>
							<a href="privilege_settings.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "privilege_settings.php"){echo " active";} ?>">Privilege Setting</div></a>
							
							<a href="updates.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "updates.php"){echo " active";} ?>">Live Updates</div></a>
							<a href="enquiry_list.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "enquiry_list.php"){echo " active";} ?>">Enquiry List</div></a>
							<?php
								}
							elseif(isset($_SESSION['live_user_type']) && $_SESSION['live_user_type'] == 'shopuser'){
								?>
							
							
							<a href="shop_home.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_home.php"){echo " active";} ?>">Dashboard</div></a>
							<a href="myaccount.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "myaccount.php"){echo " active";} ?>">My Account</div></a>
							<a href="shop_list.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_list.php"){echo " active";} ?>">Shop List</div></a>
							<a href="add_product.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "add_product.php"){echo " active";} ?>">New Product</div></a>
							<a href="shop_offer_list.php"><div class="C-toprowBtn<?php if(basename($_SERVER['PHP_SELF']) == "shop_offer_list.php"){echo " active";} ?>">Offer List</div></a>
							<?php
							}
								?>
							<div class="C-toprowBtn">Help</div>
						</div>
							</div>
						</div>
					</div>
				</div>
				<!-- C-main first row end -->