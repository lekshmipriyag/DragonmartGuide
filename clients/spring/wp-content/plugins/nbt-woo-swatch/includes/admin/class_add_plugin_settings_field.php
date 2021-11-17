<?php
class NBTWS_nbtws_settings {

    /**
     * Bootstraps the class and hooks required actions & filters.
     */
    public static function init() {
	    add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
	    add_action( 'woocommerce_settings_tabs_nbtws_settings', __CLASS__ . '::settings_tab' );
	    add_filter( 'plugin_action_links_' . NBTWS_BASE_URL , __CLASS__ . '::nbtws_add_action_links' );
	    add_action( 'woocommerce_update_options_nbtws_settings', __CLASS__ . '::update_settings' );
		add_action( 'woocommerce_admin_field_nbtws_global', __CLASS__ . '::nbtws_global_settings' );
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::nbtws_admin_scripts' );
    }
	
	public static function nbtws_admin_scripts() {
		if ((isset($_GET['page']) && ($_GET['page'] == "wc-settings")) && (isset($_GET['tab']) && ($_GET['tab'] == "nbtws_settings"))) {
			 wp_register_script( 'nbtws-admin', NBTWS_PLUGIN_URL . 'js/nbtws-admin.js' , array( 'jquery' ), false, true);
			 wp_enqueue_script ('nbtws-admin');
		}
	}
    
     public static function nbtws_add_action_links ( $links ) {
           $mylinks = array(
              '<a href="' . admin_url( '/admin.php?page=wc-settings&tab=nbtws_settings' ) . '">Settings</a>',
		   );
           return array_merge( $links, $mylinks );
	 }

    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['nbtws_settings'] = __( 'Swatches', 'nbtws' );
        return $settings_tabs;
    }
  
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }

    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }

    public static function get_settings() {
        $settings = array(
            array(
                'name'     => __( 'Color/image Swatches Settings', 'nbtws' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_nbtws_settings_section'
            ),
			array(
				'name'     => __( 'Product page custom swatches height', 'nbtws' ),
				'desc_tip' => __( 'Custom swatch height on product page.you will need to chose custom as display type in variation select tab.', 'nbtws' ),
				'id'       => 'woocommerce_custom_swatch_height',
				'type'     => 'text',
				'css'      => 'width:35px;',
				'default'  => '32',
				'desc'     => 'px'
			),
			 array(
				'name'     => __( 'Product page custom swatches width', 'nbtws' ),
				'desc_tip' => __( 'Custom swatch height on product page.you will need to chose custom as display type in variation select tab.', 'nbtws' ),
				'id'       => 'woocommerce_custom_swatch_width',
				'type'     => 'text',
				'css'      => 'width:35px;',
				'default'  => '32',
				'desc'     => 'px'
            ),
			array(
				'name'     => __( 'Enable tooltip on swatches', 'nbtws' ),
				'id'       => 'woocommerce_nbtws_swatch_tooltip',
				'type'     => 'checkbox',
				'default'  => 'no'
            ),
			array(
				'title'    => __( 'Shop swatches location', 'nbtws' ),
				'desc'     => __( 'This controls location of shop swatches on shop/category/archive pages.', 'nbtws' ),
				'id'       => 'woocommerce_shop_swatches_display',
				'class'    => 'chosen_select',
				'css'      => 'min-width:300px;',
				'default'  => '01',
				'type'     => 'select',
				'options'  => array(
				'01'       => __( 'After Item Title and Price', 'nbtws' ),
				'02'       => __( 'Before Item Title and Price', 'nbtws' ),
				'03'       => __( 'After Select Options button', 'nbtws' ),
				),
				'desc_tip' =>  true,
			),
			array(
				'name'     => __( 'Shop swatches height', 'nbtws' ),
				'desc_tip' => __( 'Swatches height on shop page.', 'nbtws' ),
				'id'       => 'woocommerce_shop_swatch_height',
				'type'     => 'text',
				'css'      => 'width:35px;',
				'default'  => '32',
				'desc'     => 'px'
			),
			array(
				'name'     => __( 'Shop swatches width', 'nbtws' ),
				'desc_tip' => __( 'Swatches width on shop page.', 'nbtws' ),
				'id'       => 'woocommerce_shop_swatch_width',
				'type'     => 'text',
				'css'      => 'width:35px;',
				'default'  => '32',
				'desc'     => 'px'
			),
			array(
				'name'     => __( 'Enable default attribute options', 'nbtws' ),
				'id'       => 'nbtws_woocommerce_global_activation',
				'type'     => 'checkbox',
				'default'  => 'no',
				'desc_tip' => 'if enabled all those product attributes which does not have display type set under variation select tab will inherit the display type value from below given "default attribute options" table.you will still be able to override the value on product edit page.'
			),
			array(
				'type'    => 'nbtws_global',
				'id'      => 'nbtws_global'
			),
            'section_end' => array(
                 'type'   => 'sectionend',
                 'id'     => 'wc_nbtws_settings_section'
            )
        );
	
        return apply_filters( 'wc_nbtws_settings_settings', $settings );
    }
	
   public function nbtws_global_settings() {
	   $attribute_taxonomies = wc_get_attribute_taxonomies();
	   $global_activation    = get_option("nbtws_woocommerce_global_activation");
	   $nbtws_global          = get_option("nbtws_global");
	   ?>
		<tr valign="top" style="<?php if (isset($global_activation) && ($global_activation == "yes")) { echo 'display:;'; } else {echo 'display:none;';} ?>">
			<th scope="row" class="titledesc"><?php _e( 'Default attribute options', 'nbtws' ) ?></th>
			<td class="forminp">
				<table class="widefat wp-list-table" cellspacing="0">
					<thead>
						<tr>
							<th width="15%" class="name">&emsp;<?php _e( 'Attribute', 'nbtws' ); ?></th>
							<th>&emsp;<?php _e( 'Display Type', 'nbtws' ); ?></th>
							<th width="40%">&emsp;<?php _e( 'Size', 'nbtws' ); ?></th>
							<th>&emsp;<?php _e( 'Show Name', 'nbtws' ); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ((!empty($attribute_taxonomies)) && (sizeof($attribute_taxonomies) >0)) :
						foreach ($attribute_taxonomies as $value) :
							$value = json_decode(json_encode($value), True);
							$attribute_name = $value['attribute_name'];
							$global_attribute_name = 'pa_'.$value['attribute_name'].''; ?>
							<tr>
								<td width="15%" class="name">&emsp;
									<span class="name"><?php echo $attribute_name; ?></span>
								</td>
								<td class="status">
									<select name="nbtws_global[pa_<?php echo $attribute_name; ?>][display_type]">
										<option value="none"><span class="nbtws_formfield"><?php echo __('Dropdown Select','nbtws'); ?></span></option>
										<option value="colororimage" <?php if ((isset($nbtws_global[$global_attribute_name]['display_type'])) && ($nbtws_global[$global_attribute_name]['display_type'] == "colororimage")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Color or Image','nbtws'); ?></span></option>
									</select>
								</td>
								<td width="40%">
									<select name="nbtws_global[pa_<?php echo $attribute_name; ?>][size]">
										<option value="small"  <?php if ((isset($nbtws_global[$global_attribute_name]['size'])) && ($nbtws_global[$global_attribute_name]['size'] == "small")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Small (32px * 32px)','nbtws'); ?></span></option>
										<option value="extrasmall" <?php if ((isset($nbtws_global[$global_attribute_name]['size'])) && ($nbtws_global[$global_attribute_name]['size'] == "extrasmall")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Extra Small (22px * 22px)','nbtws'); ?></span></option>
										<option value="medium" <?php if ((isset($nbtws_global[$global_attribute_name]['size'])) && ($nbtws_global[$global_attribute_name]['size'] == "medium")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Middle (40px * 40px)','nbtws'); ?></span></option>
										<option value="big" <?php if ((isset($nbtws_global[$global_attribute_name]['size'])) && ($nbtws_global[$global_attribute_name]['size'] == "big")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Big (60px * 60px)','nbtws'); ?></span></option>
										<option value="extrabig" <?php if ((isset($nbtws_global[$global_attribute_name]['size'])) && ($nbtws_global[$global_attribute_name]['size'] == "extrabig")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Extra Big (90px * 90px)','nbtws'); ?></span></option>
										<option value="custom" <?php if ((isset($nbtws_global[$global_attribute_name]['size'])) && ($nbtws_global[$global_attribute_name]['size'] == "custom")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Custom','nbtws'); ?></span></option>
									</select>
									<select name="nbtws_global[pa_<?php echo $attribute_name; ?>][displaytype]">
										<option value="square" <?php if ((isset($nbtws_global[$global_attribute_name]['displaytype'])) && ($nbtws_global[$global_attribute_name]['displaytype'] == "square")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Square','nbtws'); ?></span></option>
										<option value="round" <?php if ((isset($nbtws_global[$global_attribute_name]['displaytype'])) && ($nbtws_global[$global_attribute_name]['displaytype'] == "round")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Round','nbtws'); ?></span></option>
									</select>
								</td>
								<td>
									<select name="nbtws_global[pa_<?php echo $attribute_name; ?>][show_name]" class="nbtws_displaytype">
										<option value="no" <?php if ((isset($nbtws_global[$global_attribute_name]['show_name'])) && ($nbtws_global[$global_attribute_name]['show_name'] == "no")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('No','nbtws'); ?></span></option>
										<option value="yes" <?php if ((isset($nbtws_global[$global_attribute_name]['show_name'])) && ($nbtws_global[$global_attribute_name]['show_name'] == "yes")) {echo "selected";} ?>><span class="nbtws_formfield"><?php echo __('Yes','nbtws'); ?></span></option>
									</select>
								</td>
								<td>
									<a href="edit-tags.php?taxonomy=<?php echo wc_attribute_taxonomy_name($attribute_name); ?>&amp;post_type=product" class="button alignright configure-terms"><?php echo __('Set color/images','nbtws'); ?></a>
								</td>
							</tr>
						<?php
						endforeach;
						endif;?>
					</tbody>
				</table>
			</td>
		</tr>
	<?php }	
}

NBTWS_nbtws_settings::init();