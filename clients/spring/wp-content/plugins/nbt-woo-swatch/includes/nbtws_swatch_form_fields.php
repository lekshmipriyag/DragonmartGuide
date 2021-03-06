<?php
class nbtws_swatch_form_fields {
	/*
	* Load colored select
	* since 1.0.0
	*/
	public function nbtws_load_colored_select($name, $options, $_coloredvariables, $newvalues, $selected_value ) {
		if ( is_array( $options ) ) { ?> 
			<div class="attribute-swatch">
			<?php
			if ( taxonomy_exists( $name ) ) {
				$terms = get_terms( $name , array('menu_order' => 'ASC') );
				foreach ( $terms as $term ) {
					if ( ! in_array( $term->slug, $options ) ) continue; {
						$this->nbtws_display_image_select_block1( $selected_value, $name, $term, $_coloredvariables, $newvalues );
					}
				}
			} else {
				foreach ( $options as $option ) {
					$this->nbtws_display_image_select_block2( $selected_value, $name, $option, $_coloredvariables, $newvalues );
				}
			}
			?>
			</div>
		<?php }
	}
	
	/*
	* Load colored select for global display type
	* since 1.0.0
	*/
	public function nbtws_load_colored_select2($name, $options, $newvalues, $selected_value) {
		if ( is_array( $options ) ) { ?> 
		<div class="attribute-swatch">
		<?php
		if ( taxonomy_exists( $name ) ) {
			$terms = get_terms( $name , array('menu_order' => 'ASC') );
			foreach ( $terms as $term ) {
				if ( ! in_array( $term->slug, $options ) ) continue; {
					$this->nbtws_display_image_select_block3( $selected_value, $name, $term, $newvalues);
				}
			}
		} 
		?>
		</div>
		<?php }
	} 
	
	/*
	* Get Image display
	* since 1.0.2
	*/
	public function nbtws_display_image_select_block1( $selected_value, $name, $option, $_coloredvariables, $newvalues ){
		$globalthumbnail_id       = ''; 
		$globaldisplay_type       = 'Color';
		$globalcolor              =  'grey';     
		$labelid                  = sanitize_title( $name );
		$nbtws_global_activation   =  get_option("nbtws_woocommerce_global_activation");
		$nbtws_global              =  get_option("nbtws_global");
		
		foreach ( $newvalues as $newvalue ) {
			if ( isset( $newvalue->slug ) && ( strtolower( $newvalue->slug ) == strtolower( $option->slug ) ) ) {
				$globalthumbnail_id = absint( get_woocommerce_term_meta( $newvalue->term_id, 'thumbnail_id', true ) );
				$globaldisplay_type = get_woocommerce_term_meta( $newvalue->term_id, 'display_type', true );
				$globalcolor 	    = get_woocommerce_term_meta( $newvalue->term_id, 'color', true );
			}
		}
		
		if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option->slug]['image']))) {
			$thumb_id = $_coloredvariables[$name]['values'][$option->slug]['image']; 
			$url = wp_get_attachment_thumb_url( $thumb_id );
		} elseif (isset($globalthumbnail_id)) {
			$thumb_id = $globalthumbnail_id; 
			$url = wp_get_attachment_thumb_url( $globalthumbnail_id );
		}
		
		if ( ( isset( $_coloredvariables[$name]['values'] ) ) && ( isset( $_coloredvariables[$name]['values'][$option->slug]['type'] ) ) ) {
			$attrdisplaytype = $_coloredvariables[$name]['values'][$option->slug]['type'];
		} elseif (isset($globaldisplay_type)) {
			$attrdisplaytype = $globaldisplay_type;
		}
		
		if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option->slug]['color']))) {
			$attrcolor = $_coloredvariables[$name]['values'][$option->slug]['color'];
		} elseif (isset($globalcolor)) {
			$attrcolor = $globalcolor;
		}
		
		if (isset($selected_value) && ($selected_value == esc_attr( sanitize_title( $option->slug ) ) ))  {
			$labelclass="selectedswatch";
		} else {
			$labelclass="nbtwsswatchlabel";
		}				 
		
		if (isset($_coloredvariables[$name]['size'])) {
			$thumbsize   = $_coloredvariables[$name]['size']; 
			$displaytype = $_coloredvariables[$name]['displaytype']; 
			$showname    = $_coloredvariables[$name]['show_name'];
		} elseif ((isset($nbtws_global_activation)) && ($nbtws_global_activation == "yes")) {
			$thumbsize   = $nbtws_global[$name]['size']; 
			$displaytype = $nbtws_global[$name]['displaytype']; 
			$showname    = $nbtws_global[$name]['show_name'];
		} else {
			$thumbsize   = 'small';
			$displaytype = 'square';
			$showname    = 'no';
		}
		
		$imageheight = $this->nbtws_get_image_height($thumbsize); 
		$imagewidth  = $this->nbtws_get_image_width($thumbsize);
		?>          
		<div class="swatchinput">
		<?php 
		switch($attrdisplaytype) {
			case "Color":
			?>
				<label selectid="<?php echo rawurldecode($labelid); ?>"  class="attribute_<?php echo rawurldecode($labelid); ?>_<?php echo esc_attr( sanitize_title( $option->slug ) ); ?> <?php echo $labelclass; ?> <?php if ($displaytype == "round") { echo 'nbtwsaround'; } else { echo 'nbtwssquare';} ?>" data-option="<?php echo esc_attr( sanitize_title( $option->slug ) ); ?>"  title="<?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?>" style="background-color:<?php if (isset($attrcolor)) { echo $attrcolor; } else { echo '#ffffff'; } ?>; width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
				<?php if (isset($showname) && ($showname == "yes")) { ?>
					<span class="belowtext"><?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?></span>
				<?php }
				break;
			case "Image":
			?>
				<label  selectid="<?php echo rawurldecode($labelid); ?>" class="attribute_<?php echo rawurldecode($labelid); ?>_<?php echo esc_attr( sanitize_title( $option->slug ) ); ?> <?php echo $labelclass; ?> <?php if ($displaytype == "round") { echo 'nbtwsaround'; } else { echo 'nbtwssquare';} ?>" data-option="<?php echo esc_attr( sanitize_title( $option->slug ) ); ?>"  title="<?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?>" style="background-image:url(<?php if (isset($url)) { echo $url; } ?>); width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
				<?php if (isset($showname) && ($showname == "yes")) { ?>
					<span class="belowtext"><?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?></span>
				<?php }
				break;
		} 
		?>
		</div>
	<?php }
	
	/*
	* Get Image display
	* since 1.0.0
	*/
	public function nbtws_display_image_select_block2($selected_value, $name, $option, $_coloredvariables, $newvalues){
		$globalthumbnail_id       = ''; 
		$globaldisplay_type       = 'Color';
		$globalcolor              =  'grey';     
		$labelid                  = sanitize_title( $name );
		
		foreach ($newvalues as $newvalue) { 
			if (isset($newvalue->slug) && (strtolower($newvalue->slug) == strtolower($option))) {
				$globalthumbnail_id = absint( get_woocommerce_term_meta( $newvalue->term_id, 'thumbnail_id', true ) );
				$globaldisplay_type = get_woocommerce_term_meta($newvalue->term_id, 'display_type', true );
				$globalcolor 	    = get_woocommerce_term_meta($newvalue->term_id, 'color', true );
			}
		}
		
		if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option]['image']))) {
			$thumb_id = $_coloredvariables[$name]['values'][$option]['image']; $url = wp_get_attachment_thumb_url( $thumb_id ); 
		} elseif (isset($globalthumbnail_id)) {
			$thumb_id=$globalthumbnail_id; $url = wp_get_attachment_thumb_url( $globalthumbnail_id );
		}
		
		if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option]['type']))) {
			$attrdisplaytype = $_coloredvariables[$name]['values'][$option]['type'];
		} elseif (isset($globaldisplay_type)) {
			$attrdisplaytype = $globaldisplay_type;
		}
		
		if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option]['color']))) {
			$attrcolor = $_coloredvariables[$name]['values'][$option]['color'];
		} elseif (isset($globalcolor)) {
			$attrcolor = $globalcolor;
		}
		
		if (isset($selected_value) && $selected_value == $option)  {
			$labelclass="selectedswatch";
		} else {
			$labelclass="nbtwsswatchlabel";
		}
		
		if (isset($_coloredvariables[$name]['size'])) {
			$thumbsize   = $_coloredvariables[$name]['size']; 
			$displaytype = $_coloredvariables[$name]['displaytype']; 
			$showname = $_coloredvariables[$name]['show_name'];
		} else {
			$thumbsize   = 'small';
			$displaytype = 'square';
			$showname = 'no';
		}
		
		$imageheight = $this->nbtws_get_image_height($thumbsize); 
		$imagewidth = $this->nbtws_get_image_width($thumbsize);
		?>          
		<div class="swatchinput">
		<?php
		switch($attrdisplaytype) {
			case "Color":
			?>
				<label  selectid="<?php echo rawurldecode($labelid); ?>" class="attribute_<?php echo rawurldecode($labelid); ?>_<?php echo esc_attr( $option  ); ?> <?php echo $labelclass; ?> <?php if ($displaytype == "round") { echo 'nbtwsaround'; } else { echo 'nbtwssquare';} ?>" data-option="<?php echo esc_attr( $option  ); ?>" title="<?php echo rawurldecode($option); ?>" style="background-color:<?php if (isset($attrcolor)) { echo $attrcolor; } else { echo '#ffffff'; } ?>; width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
				<?php if (isset($showname) && ($showname == "yes")) { ?>
					<span class="belowtext"><?php echo $option; ?></span>
				<?php }
				break;
			case "Image":
			?>
				<label  selectid="<?php echo rawurldecode($labelid); ?>" class="attribute_<?php echo rawurldecode($labelid); ?>_<?php echo esc_attr( $option  ); ?> <?php echo $labelclass; ?> <?php if ($displaytype == "round") { echo 'nbtwsaround'; } else { echo 'nbtwssquare';} ?>" data-option="<?php echo esc_attr( $option  ); ?>" title="<?php echo rawurldecode($option); ?>" style="background-image:url(<?php if (isset($url)) { echo $url; } ?>); width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
				<?php if (isset($showname) && ($showname == "yes")) { ?>
					<span class="belowtext"><?php echo $option; ?></span>
				<?php }
				break;
		} ?>
		</div>
	<?php }
	
	/*
	* Get Image display
	* since 1.0.2
	*/
	public function nbtws_display_image_select_block3($selected_value, $name, $option, $newvalues){
	$globalthumbnail_id      = ''; 
	$globaldisplay_type      = 'Color';
	$globalcolor             =  'grey';     
	$labelid                 = sanitize_title( $name );
	$nbtws_global_activation =  get_option("nbtws_woocommerce_global_activation");
	$nbtws_global            =  get_option("nbtws_global");
	
	foreach ($newvalues as $newvalue) {
		if (isset($newvalue->slug) && (strtolower($newvalue->slug) == strtolower($option->slug))) {
			$globalthumbnail_id = absint( get_woocommerce_term_meta( $newvalue->term_id, 'thumbnail_id', true ) );
			$globaldisplay_type = get_woocommerce_term_meta($newvalue->term_id, 'display_type', true );
			$globalcolor 	    = get_woocommerce_term_meta($newvalue->term_id, 'color', true );
		}
	}
		
	if (isset($globalthumbnail_id)) {
		$thumb_id=$globalthumbnail_id; $url = wp_get_attachment_thumb_url( $globalthumbnail_id );
	}
		
	if (isset($globaldisplay_type)) {
		$attrdisplaytype = $globaldisplay_type;
	}
		
	if (isset($globalcolor)) {
		$attrcolor = $globalcolor;
	}
	
	if (isset($selected_value) && ($selected_value == esc_attr( sanitize_title( $option->slug ) ) ))  {
		$labelclass="selectedswatch";
	} else {
		$labelclass="nbtwsswatchlabel";
	}				 
		
	if ((isset($nbtws_global_activation)) && ($nbtws_global_activation == "yes")) {
		$thumbsize   = $nbtws_global[$name]['size']; 
		$displaytype = $nbtws_global[$name]['displaytype']; 
		$showname    = $nbtws_global[$name]['show_name'];
	}
		
	$imageheight = $this->nbtws_get_image_height($thumbsize); 
	$imagewidth  = $this->nbtws_get_image_width($thumbsize);
	?>
	<div class="swatchinput">
	<?php
	switch($attrdisplaytype) {
		case "Color":
		?>
			<label selectid="<?php echo rawurldecode($labelid); ?>"  class="attribute_<?php echo rawurldecode($labelid); ?>_<?php echo esc_attr( sanitize_title( $option->slug ) ); ?> <?php echo $labelclass; ?> <?php if ($displaytype == "round") { echo 'nbtwsaround'; } else { echo 'nbtwssquare';} ?>" data-option="<?php echo esc_attr( sanitize_title( $option->slug ) ); ?>"  title="<?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?>" style="background-color:<?php if (isset($attrcolor)) { echo $attrcolor; } else { echo '#ffffff'; } ?>; width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
			<?php if (isset($showname) && ($showname == "yes")) { ?>
				<span class="belowtext"><?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?></span>
			<?php }
			break;
		case "Image":
		?>
			<label  selectid="<?php echo rawurldecode($labelid); ?>" class="attribute_<?php echo rawurldecode($labelid); ?>_<?php echo esc_attr( sanitize_title( $option->slug ) ); ?> <?php echo $labelclass; ?> <?php if ($displaytype == "round") { echo 'nbtwsaround'; } else { echo 'nbtwssquare';} ?>" data-option="<?php echo esc_attr( sanitize_title( $option->slug ) ); ?>"  title="<?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?>" style="background-image:url(<?php if (isset($url)) { echo $url; } ?>); width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
			<?php if (isset($showname) && ($showname == "yes")) { ?>
				<span class="belowtext"><?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?></span>
			<?php }
			break;
	} ?>
	</div>
	<?php }
	
	/*
	* Get Image Height
	* since 1.0.0
	*/
	public function nbtws_get_image_height($thumbsize) {
		$height=32;
		
		switch($thumbsize) {
			case "small":
				$height=32;
				break;
			case "extrasmall":
				$height=22;
				break;
			case "medium":
				$height=40;
				break;
			case "big":
				$height=60;
				break;
			case "extrabig":
				$height=90;
				break;
			case "custom":
				$height=get_option('woocommerce_custom_swatch_height');
				break;
			default : 
				$height=32;
		}
		
		return $height;
	}
	
	/*
	* Get Image Width
	* since 1.0.0
	*/
	public function nbtws_get_image_width($thumbsize) {
		$width=32;
		
		switch($thumbsize) {
			case "small":
				$width=32;
				break;
			case "extrasmall":
				$width=22;
				break;
			case "medium":
				$width=40;
				break;
			case "big":
				$width=60;
				break;
			case "extrabig":
				$width=90;
				break;
			case "custom":
				$width=get_option('woocommerce_custom_swatch_width');
				break;
			default : 
			$width=32;
		}
		
		return $width;
	}
}