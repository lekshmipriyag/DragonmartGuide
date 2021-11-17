<?php 
class nbtws_global_values_per_attribute {
    
	public function __construct() {
		add_action( 'admin_init', array( $this, 'nbtws_setup_texonomy_based_fields'));
		add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'admin_enqueue_scripts', array(&$this, 'nbtws_register_scripts'));
	}
	
    public function nbtws_register_scripts() {
		wp_register_script( 'nbtws-term', ''.NBTWS_PLUGIN_URL.'js/nbtws-term.js' );
	}
	
	public function nbtws_setup_texonomy_based_fields(){
		global $woocommerce;
		$woo_version =  nbtws_get_woo_version_number();

		if ($woo_version <2.1) {
			$createdattributes = $woocommerce->get_attribute_taxonomies();
		} else {
			$createdattributes=wc_get_attribute_taxonomies();
		}

		foreach ($createdattributes as $attribute) {
			add_action( 'pa_'.$attribute->attribute_name.'_add_form_fields', array( $this, 'add_category_fields' ) );
			add_action( 'pa_'.$attribute->attribute_name.'_edit_form_fields', array( $this, 'edit_category_fields' ), 10, 2 );
			add_filter( 'manage_edit-pa_'.$attribute->attribute_name.'_columns', array( $this, 'term_columns' ) );
			add_filter( 'manage_pa_'.$attribute->attribute_name.'_custom_column', array( $this, 'term_column' ), 10, 3 );
		}
	}
	
	public function add_category_fields() {
		wp_enqueue_media();
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script( 'nbtws-term' );
		wp_enqueue_style( 'wp-color-picker' );
		?>
		<div class="nbtws-category-fields" >
		    <label><?php _e( 'Display Type', 'nbtws' ); ?></label>
			<select id="display_type" name="display_type">
				<option value="Color"><?php echo __('Color','nbtws'); ?></option>
				<option value="Image"><?php echo __('Image','nbtws'); ?></option>
			</select>
			<br /><br /><br />
            <div id="nbtws_colorp" style="display:block;">
		    <label for="_chose_color"><span class="nbtws_formfield"><?php echo __('Choose Color','nbtws'); ?></span></label>
	        <input name="color" type="text" class="nbtws_attributecolorselect" value="<?php if (isset($color)) { echo $color;} else { echo '#ffffff';}  ?>" data-default-color="#ffffff">
		    </div><br /><br /><br />
			
			<div id="nbtws_imagep" style="display:none;">
			<label><?php _e( 'Thumbnail', 'nbtws' ); ?></label>
			<div id="facility_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo nbtws_placeholder_img_src(); ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="thumbnail_id" name="thumbnail_id" />
				<button type="button" class="nbtws_upload_image_button button"><?php _e( 'Upload/Add image', 'nbtws' ); ?></button>
				<button type="button" class="nbtws_remove_image_button button"><?php _e( 'Remove image', 'nbtws' ); ?></button>
			</div>
			<script type="text/javascript">
				 // Only show the "remove image" button when needed
				 if ( ! jQuery('#thumbnail_id').val() )
					 jQuery('.nbtws_remove_image_button').hide();
				 // Uploading files
				 var file_frame;
				 jQuery(document).on( 'click', '.nbtws_upload_image_button', function( event ){
					event.preventDefault();
					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}
					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( 'Choose an image', 'nbtws' ); ?>',
						button: {
							text: '<?php _e( 'Use image', 'nbtws' ); ?>',
						},
						multiple: false
					});
					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						attachment = file_frame.state().get('selection').first().toJSON();

						jQuery('#thumbnail_id').val( attachment.id );
						jQuery('#facility_thumbnail img').attr('src', attachment.url );
						jQuery('.nbtws_remove_image_button').show();
					});
					// Finally, open the modal.
					file_frame.open();
				});
				jQuery(document).on( 'click', '.nbtws_remove_image_button', function( event ){
					jQuery('#facility_thumbnail img').attr('src', '<?php echo nbtws_placeholder_img_src(); ?>');
					jQuery('#thumbnail_id').val('');
					jQuery('.nbtws_remove_image_button').hide();
					return false;
				});
			</script>
			<div class="clear"></div>
			</div>
		</div>
		<?php
	}
	
	public function edit_category_fields( $term, $taxonomy ) {
        wp_enqueue_media();
	    wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'nbtws-term' );
	    wp_enqueue_style( 'wp-color-picker' );
		
		$image 			= '';
		$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
		$display_type 	= get_woocommerce_term_meta( $term->term_id, 'display_type', true );
		$color 	        = get_woocommerce_term_meta( $term->term_id, 'color', true );
		
		if ( $thumbnail_id )
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		else
			$image = nbtws_placeholder_img_src();
		?>
		<tr class="form-field">
		   <th scope="row" valign="top"><label><?php _e( 'Display Type', 'nbtws' ); ?></label></th>
		   <td>
			<select id="display_type" name="display_type" >
			<option value="Color" <?php if (isset($display_type) && ($display_type == "Color")) { echo 'selected'; }  ?>><?php echo __('Color','nbtws'); ?></option>
			<option value="Image" <?php if (isset($display_type) && ($display_type == "Image")) { echo 'selected'; }  ?>><?php echo __('Image','nbtws'); ?></option>
			</select>
		   </td>
		</tr>
		<div id="">
		<tr class="" id="nbtws_colorp" style="<?php if (isset($display_type) && ($display_type == "Image")) { echo 'display:none;'; } else { echo 'display:;'; }  ?>">
		   <th scope="row" valign="top"><label><?php echo __('Chose Color','nbtws'); ?></label></label></th>
		   <td>
			 <input name="color" type="text" class="nbtws_attributecolorselect" value="<?php if (isset($color)) { echo $color;} else { echo '#ffffff';}  ?>" data-default-color="#ffffff">
		   </td>
		</tr>
		<tr class="form-field" id="nbtws_imagep" style="<?php if (isset($display_type) && ($display_type == "Image")) { echo 'display:;'; } else { echo 'display:none;'; }  ?>">
			<th scope="row" valign="top"><label><?php _e( 'Thumbnail', 'nbtws' ); ?></label></th>
			<td>
				<div id="facility_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
				<div style="line-height:60px;">
					<input type="hidden" id="thumbnail_id" name="thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="submit" class="nbtws_upload_image_button button"><?php _e( 'Upload/Add image', 'nbtws' ); ?></button>
					<button type="submit" class="nbtws_remove_image_button button"><?php _e( 'Remove image', 'nbtws' ); ?></button>
				</div>
				<div class="clear"></div>
			</td>
		</tr>
		<script type="text/javascript">
		// Only show the "remove image" button when needed
		if ( ! jQuery('#thumbnail_id').val() )
			jQuery('.nbtws_remove_image_button').hide();
		// Uploading files
		var file_frame;
		jQuery(document).on( 'click', '.nbtws_upload_image_button', function( event ){
			event.preventDefault();
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}
			// Create the media frame.
			file_frame = wp.media.frames.downloadable_file = wp.media({
				title: '<?php _e( 'Choose an image', 'nbtws' ); ?>',
				button: {
					text: '<?php _e( 'Use image', 'nbtws' ); ?>',
				},
				multiple: false
			});
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				attachment = file_frame.state().get('selection').first().toJSON();
				jQuery('#thumbnail_id').val( attachment.id );
				jQuery('#facility_thumbnail img').attr('src', attachment.url );
				jQuery('.nbtws_remove_image_button').show();
			});
			// Finally, open the modal.
			file_frame.open();
		});
		jQuery(document).on( 'click', '.nbtws_remove_image_button', function( event ){
			jQuery('#facility_thumbnail img').attr('src', '<?php echo nbtws_placeholder_img_src(); ?>');
			jQuery('#thumbnail_id').val('');
			jQuery('.nbtws_remove_image_button').hide();
			return false;
		});
		</script>
		<?php
	}

	public function save_category_fields( $term_id, $tt_id, $taxonomy ) {
		if ( isset( $_POST['thumbnail_id'] ) )
			update_woocommerce_term_meta( $term_id, 'thumbnail_id', absint( $_POST['thumbnail_id'] ) );
			
		if ( isset( $_POST['display_type'] ) )
			update_woocommerce_term_meta( $term_id, 'display_type',  $_POST['display_type'] );
		
		if ( isset( $_POST['color'] ) )
			update_woocommerce_term_meta( $term_id, 'color',  $_POST['color'] );

		delete_transient( 'wc_term_counts' );
	}
	
	public function term_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = __( 'Preview', 'nbtws' );

		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}
	
	public function term_column( $columns, $column, $id ) {
		if ( $column == 'thumb' ) {
			$image 			= '';
			$thumbnail_id 	= get_woocommerce_term_meta( $id, 'thumbnail_id', true );
			$color 	        = get_woocommerce_term_meta( $id, 'color', true );

			if ($thumbnail_id) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image          = nbtws_placeholder_img_src();
				$display_type 	= get_woocommerce_term_meta( $id, 'display_type', true );

				if (isset($display_type)) :
					switch($display_type){
						case "Color":
							$columns .= '<div style="background-color:'.$color.'; width:32px; height:32px;"></div>';
							break;
						case "Image":
							$columns .= '<img src="' . esc_url( $image ) . '" alt="Thumbnail" class="wp-post-image" height="32" width="32" />';
							break;
					}
				endif;
			}
		}
		return $columns;
	}
}

new nbtws_global_values_per_attribute();

function nbtws_placeholder_img_src() {
    return ''.NBTWS_PLUGIN_URL.'images/placeholder.png';
}