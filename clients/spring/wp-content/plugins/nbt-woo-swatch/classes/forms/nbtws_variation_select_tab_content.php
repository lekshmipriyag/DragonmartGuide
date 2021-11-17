<div id="nbtws_colored_variable_tab_data" class="panel woocommerce_options_panel">
	    
        <?php $product = wc_get_product($post->ID); ?>
	    <?php if ( $product->is_type('variable') ) : ?>
	    <?php $product = new WC_Product_Variable( $post->ID ); ?> 
	    <?php $attributes = $product->get_variation_attributes(); ?>
	    <?php endif;  ?>
        <?php $global_activation    = get_option("nbtws_woocommerce_global_activation"); ?>
	    
		
		
		<div class="nbtws-upper-div">
		 <table class="widefat" width="100%" style="border:none;">
		  <tr>
		   <td width="70%"><?php echo __('Display one attribute swatches on shop pages','nbtws'); ?></td>
	       <td width="30%"><input type="checkbox" id="nbtws_shop_swatches" name="shop_swatches" value="yes" <?php if (isset($shop_swatches) && ($shop_swatches == "yes")) { echo 'checked'; } ?>></td>
	      </tr>

	      <tr id="nbtws_shop_swatches_tr" style="<?php if (isset($shop_swatches) && ($shop_swatches == "yes")) { echo 'display:table-row;'; } else { echo 'display:none;'; } ?>">
	       <td width="70%">
	         <?php echo __('Select atrribute for shop swatches','nbtws'); ?>
	         
	       </td>
	       <td width="30%">
	         <?php if ((!empty($attributes)) && (sizeof($attributes) > 0)) : ?>
	         <select name="shop_swatches_attribute" class="select">
	         <?php foreach ($attributes as $key=>$values) : ?>
               <option value="<?php echo $key; ?>" <?php if (isset($shop_swatches_attribute) && ($shop_swatches_attribute == $key)) { echo 'selected'; } ?>><?php echo $key; ?></option>     
	         <?php endforeach; ?>
	         <?php endif;?>
	         </select>

	       	<img class="help_tip nbtws_help_tip" data-tip='<?php echo __('Swatches of this attribute will be displayed on shop page. This attribute must have "Custom Color or Image Swatches" as display type.','nbtws'); ?>' src="<?php echo $helpimg; ?>" height="16" width="16">
	       </td>
	      </tr>
		 </table>
		</div>
		
		
	    <div class="nbtws_colororimagediv">
	      <table class="widefat nbtws-header-table" width="100%" >
	       <tr>
	         <th width="30%" ><span class="nbtws_header"><?php echo __('Attribute','nbtws'); ?> </span></th>
	         <th width="70%" ><span class="nbtws_header"><?php echo __('Type','nbtws'); ?></span></th>
	         </tr>
	      </table>
	     
         
		<?php $attrnumber = 0; $displaytypenumber = 0; ?>
        <?php if ((!empty($attributes)) && (sizeof($attributes) > 0)) { ?>
	    <?php foreach ($attributes as $key=>$values) { ?>
	    <?php 
		
	      if ( taxonomy_exists( $key  ) ) {
			  
			      $terms = get_terms( $key, array('menu_order' => 'ASC') );
			  } 
			  
          if (isset($_coloredvariables[$key]['display_type'])) {
			  $selected_type = $_coloredvariables[$key]['display_type'];
		  } elseif (( taxonomy_exists( $key  ) ) && (isset($global_activation)) && ($global_activation == "yes")) {
			  $selected_type = "global";
		  } 
		  
		  
		  
        ?>
	
	    <div class="main-content">
	     <div class="accordion-container">
	      <div class="accordion collapsed">
		    <div class="accordion-header" data-action="accordion" style="position: relative;">
			  
			  <div class="attribute-label" style="position: absolute; top: 10px; left: 10px; font-family:Sans-serif; font-size:14px; ">
			  <?php
			  if ($woo_version <2.1) {
				  echo $woocommerce->attribute_label( $key );
			  } else {
				  echo wc_attribute_label( $key );
			  }
							
			  ?>
			  </div>
			    
			  <div class="nbtws_mainpreviewdiv" style="height: 25px; position: absolute top: 5px; right: 5px; margin-left:170px;">
                <?php
				if (isset( $selected_type)) {
				  switch($selected_type) {
				    case "global":
				     echo '<strong>'.__('Global Values','nbtws').'</strong>';
				    break;

					case "none":
				     echo '<strong>'.__('Dropdown Select','nbtws').'</strong>';
				    break;

				    case "colororimage":
				     echo '<strong>'.__('Custom Color/Image Swatches','nbtws').'</strong>';
				    break;

				 }
				}
				?>
			  </div>
		</div>

		<div class="accordion-content">
		 	<p class="form-field">
			   <label for="_display_type">
				 <span class="nbtws_formfield"><?php echo __('Display Type','nbtws'); ?></span>
			   </label>
			   <select name="coloredvariables[<?php echo $key; ?>][display_type]" class="nbtws_displaytype">
				 	<option value="none" <?php if (isset($selected_type) && ($selected_type == 'none')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Default Dropdown Select','nbtws'); ?></span></option>
				 	<?php if (( taxonomy_exists( $key  ) ) && (isset($global_activation)) && ($global_activation == "yes")) { ?>
				  	<option value="global" <?php if (isset($selected_type) && ( $selected_type == "global")) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Global Values','nbtws'); ?></span></option>
				 	<?php } ?>
				 <option value="colororimage" <?php if (isset($selected_type) && ($selected_type == 'colororimage')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Custom Color or Image Swatches','nbtws'); ?></span></option>
			   </select>
			</p>
		 
			<div class="nbtws_imageorcolordiv" style="<?php if (isset($_coloredvariables[$key]['display_type']) && ($_coloredvariables[$key]['display_type'] == 'colororimage')) { echo 'display:;'; } else { echo 'display:none;'; } ?>">

			<p class="form-field">
				 <label for="_display_size">
					 <span class="nbtws_formfield"><?php echo __('Display Size','nbtws'); ?></span>
				 </label>
				<select name="coloredvariables[<?php echo $key; ?>][size]">
				 <option value="small"  <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'small')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Small (32px * 32px)','nbtws'); ?></span></option>
				 <option value="extrasmall" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'extrasmall')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Extra Small (22px * 22px)','nbtws'); ?></span></option>
				 <option value="medium" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'medium')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Middle (40px * 40px)','nbtws'); ?></span></option>
				 <option value="big" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'big')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Big (60px * 60px)','nbtws'); ?></span></option>
				 <option value="extrabig" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'extrabig')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Extra Big (90px * 90px)','nbtws'); ?></span></option>
				 <option value="custom" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'custom')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Custom','nbtws'); ?></span></option>
				</select>

				<select name="coloredvariables[<?php echo $key; ?>][displaytype]">
				 <option value="square" <?php if (isset($_coloredvariables[$key]['displaytype']) && ($_coloredvariables[$key]['displaytype'] == 'square')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Square','nbtws'); ?></span></option>
				 <option value="round" <?php if (isset($_coloredvariables[$key]['displaytype']) && ($_coloredvariables[$key]['displaytype'] == 'round')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Round','nbtws'); ?></span></option>
				</select>
				<img class="help_tip nbtws_help_tip" data-tip='<?php echo __('These fields does not apply to shop/archive swatches.To change swatch size on archive/shop pages visit products/display tab under woocommerce->settings.If you chose custom as display type, make sure you have defined custom swatches height,width into woocommerce/settings/swatches. ','nbtws'); ?>' src="<?php echo $helpimg; ?>" height="16" width="16">
			</p>

			<p class="form-field">
				<label for="_show_name">
				  <span class="nbtws_formfield"><?php echo __('Show Attribute Name','nbtws'); ?></span>

				</label>

				<select name="coloredvariables[<?php echo $key; ?>][show_name]" class="nbtws_displaytype">
				 <option value="no" <?php if (isset($_coloredvariables[$key]['show_name']) && ($_coloredvariables[$key]['show_name'] == 'no')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('No','nbtws'); ?></span></option>
				 <option value="yes" <?php if (isset($_coloredvariables[$key]['show_name']) && ($_coloredvariables[$key]['show_name'] == 'yes')) { echo 'selected'; }?>><span class="nbtws_formfield"><?php echo __('Yes','nbtws'); ?></span></option>
				</select>
				<img class="help_tip nbtws_help_tip" data-tip='<?php echo __('This field does not apply to shop/archive swatches.','nbtws'); ?>' src="<?php echo $helpimg; ?>" height="16" width="16">
			</p>


			<table class="widefat nbtws-header-table" width="100" border="0">
				<tr>
					<th width="30%" ><span class="nbtws_header"><?php echo __('Value','nbtws'); ?> </span></th>
					<th width="70%" ><span class="nbtws_header"><?php echo __('Color/Image Preview','nbtws'); ?></span></th>
				</tr>
			</table>

			 <?php $attrsubnumber=0;
			 foreach ($values as $value) {

				 if (isset($_coloredvariables[$key]['displaytype'])) {
					$displaytype = $_coloredvariables[$key]['displaytype'];
				 } else {
					 $displaytype = '';
				 }

				 $valuetitle = $value;

				 if (isset($terms)) {
					 foreach ( $terms as $term ) {
						 if ( $term->slug != $value  ) continue; {
							$valuetitle             = $term->name;
							$globalthumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
							$globaldisplay_type 	= get_woocommerce_term_meta($term->term_id, 'display_type', true );
							$globalcolor 	        = get_woocommerce_term_meta($term->term_id, 'color', true );
						 }
					 }
				 }

				if ((isset($_coloredvariables[$key]['values'])) && (isset($_coloredvariables[$key]['values'][$value]['image']))) {
					$swatchimage = $_coloredvariables[$key]['values'][$value]['image']; $swatchurl = wp_get_attachment_thumb_url( $swatchimage );
				} elseif (isset($globalthumbnail_id)) {
					$swatchimage =$globalthumbnail_id; $swatchurl = wp_get_attachment_thumb_url( $swatchimage );
				}

				if ((isset($_coloredvariables[$key]['values'])) && (isset($_coloredvariables[$key]['values'][$value]['hoverimage']))) {
					$hoverthumb_id = $_coloredvariables[$key]['values'][$value]['hoverimage'];
					$hoverurl      = wp_get_attachment_thumb_url( $hoverthumb_id );
				}

				if ((isset($_coloredvariables[$key]['values'])) && (isset($_coloredvariables[$key]['values'][$value]['type']))) {
					$attrdisplaytype = $_coloredvariables[$key]['values'][$value]['type'];
				} elseif (isset($globaldisplay_type)) {
					$attrdisplaytype = $globaldisplay_type;
				}

				if ((isset($_coloredvariables[$key]['values'])) && (isset($_coloredvariables[$key]['values'][$value]['color']))) {
					$attrcolor = $_coloredvariables[$key]['values'][$value]['color'];
				} elseif (isset($globalcolor)) {
					$attrcolor = $globalcolor;
				}
				?>

			 <div class="accordion-container">
				<div class="accordion collapsed">
					<div class="accordion-header" data-action="accordion" style="position: relative;">
						<div class="attribute-label" style="position: absolute; top: 10px; left: 10px; font-family:Sans-serif; font-size:14px; ">
						<?php echo rawurldecode($valuetitle); ?>
						</div>
						<div class="previewdiv" style="height: 25px;height: 25px; top: 5px; right: 5px; margin-left:170px;"><?php
						if (isset($attrdisplaytype))  :
						switch($attrdisplaytype) {
						   case "Color":
							 ?>
							   <a class="imagediv_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="<?php if ($displaytype == "round") { echo '-moz-border-radius: 99em; -webkit-border-radius: 99em;'; } ?> display: inline-block; background-color: <?php if (isset($attrcolor)) { echo  $attrcolor; } else { echo 'grey'; } ?>;height: 22px;width: 22px;"></a>
							<?php
							break;
							case "Image":
							?>
							<a class="imagediv_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="<?php if ($displaytype == "round") { echo '-moz-border-radius: 99em; -webkit-border-radius: 99em;'; } ?>"><img src="<?php if (isset($swatchurl)) { echo $swatchurl; } ?>" width="22px" height="22px" style="<?php if ($displaytype == "round") { echo '-moz-border-radius: 99em; -webkit-border-radius: 99em;'; } ?>"></a>
							<?php
							break;
						  }
						endif;
						?>
						</div>
					</div>
					<div class="accordion-content">
						<table class="widefat" width="100" style="border:none;">
							<tr>
								<td width="30%"><span class="nbtws_formfield"><?php echo __('Display Type','nbtws'); ?></span></td>
								<td width="70%">
									<select name="coloredvariables[<?php echo $key; ?>][values][<?php echo $value; ?>][type]" id="coloredvariables-<?php echo $attrnumber; ?>-values-<?php echo $attrsubnumber; ?>-type" class="nbtws_colororimage">
									<option value="Color" <?php if ((isset($attrdisplaytype))  && $attrdisplaytype == "Color" ) { echo 'selected'; } ?>><?php echo __('Color','nbtws'); ?></option>
									<option value="Image" <?php if ((isset($attrdisplaytype)) && $attrdisplaytype == "Image" ) { echo 'selected'; } ?>><?php echo __('Image','nbtws'); ?></option>
									</select>
								</td>
							</tr>

							<tr class="nbtws_colordiv" id="coloredvariables-<?php echo $attrnumber; ?>-values-<?php echo $attrsubnumber; ?>-color" style="<?php if ((isset($attrdisplaytype)) && ($attrdisplaytype == "Image") ) { echo 'display:none;'; } else { echo 'display:;'; } ?>">
								 <td width="30%"> <span class="nbtws_formfield"><?php echo __('Swatch Color','nbtws'); ?></span></td>
								 <td width="70%">
									  <input name="coloredvariables[<?php echo $key; ?>][values][<?php echo $value; ?>][color]" type="text" class="nbtws_attributecolorselect"
											 value="<?php if (isset($attrcolor)) { echo  $attrcolor; } else { echo '#ffffff'; }  ?>" data-default-color="#ffffff">
								 </td>
							</tr>

							<tr class="nbtws_imagediv" id="coloredvariables-image" style="<?php if ((isset($attrdisplaytype))  && ($attrdisplaytype == "Image")) { echo 'display:;'; } else { echo 'display:none;'; } ?>">
								 <td width="30%"> <span class="nbtws_formfield"><?php echo __('Swatch Image','nbtws'); ?></span></td>
								 <td width="70%">
									  <div class="facility_thumbnail" id="facility_thumbnail_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="float:left;">
									  <img src="<?php if (isset($swatchurl)) { echo $swatchurl; }  ?>" width="60px" height="60px" />
									  <div  class="image-upload-div" idval="<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" >
											<input type="hidden" class="facility_thumbnail_id_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" name="coloredvariables[<?php echo $key; ?>][values][<?php echo $value; ?>][image]" value="<?php if (isset($swatchimage)) { echo $swatchimage; } ?>"/>
											<button type="submit" class="upload_image_button_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?> button"><?php _e( 'Upload/Add image', 'nbtws' ); ?></button>
											<button type="submit" class="remove_image_button_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?> button"><?php _e( 'Remove image', 'nbtws' ); ?></button>
									  </div>
									  </div>
								 </td>
							</tr>

							 <tr class="nbtws_hoverimagediv" id="nbtws_hoverimagediv" style="<?php if (isset($shop_swatches) && ($shop_swatches == "yes")) { echo 'display:;'; } else { echo 'display:none;'; } ?>">
								 <td width="30%"><span class="nbtws_formfield"><?php echo __('Hover Image','nbtws'); ?> <img class="help_tip" data-tip='<?php echo __('This image will replace the product image on swatch hover on shop/archive page.','nbtws'); ?>' src="<?php echo $helpimg; ?>" height="16" width="16"></span></td>
								 <td width="70%">
									   <div class="hover_facility_thumbnail" id="hover_facility_thumbnail_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="float:left;">
											<img src="<?php if (isset($hoverurl)) { echo $hoverurl; } ?>" width="60px" height="60px" />
											<div  class="hover-image-upload-div" idval="<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" >
												<input type="hidden" class="hover_facility_thumbnail_id_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" name="coloredvariables[<?php echo $key; ?>][values][<?php echo $value; ?>][hoverimage]" value="<?php if (isset($hoverthumb_id)) { echo $hoverthumb_id; } ?>"/>
												<button type="submit" class="hover_upload_image_button_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?> button"><?php _e( 'Upload/Add image', 'nbtws' ); ?></button>
												<button type="submit" class="hover_remove_image_button_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?> button"><?php _e( 'Remove image', 'nbtws' ); ?></button>
											</div>
									   </div>
								 </td>
							 </tr>

						</table>
					</div>
				</div>
			</div>
			 <?php
			 $attrsubnumber++;
			 $globalthumbnail_id = '';
			 $globaldisplay_type = 'Color';
			 $globalcolor        =  'grey';
			 } ?>
			</div>
		</div>
	</div>
 </div>
<?php $attrnumber++; ?>
</div>
<?php
} }
?>
</div>
</div>