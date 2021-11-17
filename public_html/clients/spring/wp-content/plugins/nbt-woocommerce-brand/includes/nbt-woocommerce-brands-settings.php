<?php
/**
 * Handles taxonomies in admin
 *
 * @class    Nbt_WC_Brands_Settings
 * @version  1.0.0
 * @package  Nbt-Woocommerce-Brands-Settings/Admin
 * @category Class
 * @author   NetbaseTeam
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('Nbt_WC_Brands_Settings')) :

    class Nbt_WC_Brands_Settings {

        public function __construct() {

            add_action('woocommerce_settings_tabs_nbt_brand_settings_tab', array($this, 'settings_tab'));
            add_action('woocommerce_update_options_nbt_brand_settings_tab', array($this, 'update_settings'));

            add_filter('woocommerce_settings_tabs_array', array($this, 'add_nbt_brand_settings_tab'), 50);
            add_action('woocommerce_admin_field_single_size', array( $this, 'nbt_brand_image_single_size' ));
            add_action('woocommerce_admin_field_category_size', array( $this, 'nbt_brand_image_category_size' ));
            add_action('woocommerce_admin_field_brand_thumbnail_size', array( $this, 'nbt_brand_brand_thumbnail_size' ));
            add_action('woocommerce_admin_field_banner_size', array( $this, 'nbt_brand_image_banner_size' ));
            add_action('woocommerce_admin_field_upload', array($this, 'wc_brand_image_default'));

            $this->get_settings();
        }

        /**
         * Create Brands setting tab
         */
        public function add_nbt_brand_settings_tab($settings_tabs) {
            $settings_tabs['nbt_brand_settings_tab'] = __('Brands', 'nbt-woocommerce-brand');
            return $settings_tabs;
        }

        /**
         * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
         *
         * @uses woocommerce_admin_fields()
         * @uses $this->get_settings()
         */
        public function settings_tab() {
            woocommerce_admin_fields($this->get_settings());
        }

        /**
         * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
         *
         * @uses woocommerce_update_options()
         * @uses $this->get_settings()
         */
        public function update_settings() {
            woocommerce_update_options($this->get_settings());
        }

        /**
         * Add Options in Brands settings tab
         */
        public function get_settings() {
            $settings = array(
                /*
                 * General setting
                 */
                array(
                    'title' => __('General Settings', 'nbt-nbt-woocommerce-brands'),
                    'type' => 'title',
                    'desc' => '',
                    'id' => 'nbt_woocommerce_general_setting'
                ),
                array(
                    'title' => __('Brand Name', 'nbt-nbt-woocommerce-brands'),
                    'desc' => __('Brand name.', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_name',
                    'type' => 'text',
                    'default' => 'Brand:',
                    'css' => 'width: 250px;',
                    'autoload' => false,
                    'desc_tip' => true
                ),
                array(
                    'title' => __('Brand Show On Page', 'nbt-nbt-woocommerce-brands'),
                    'desc' => __('Brand show on page.', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_show_on_page',
                    'default' => 'p',
                    'type' => 'radio',
                    'options' => array(
                        'all' => __('Both categories and product detail page', 'nbt-nbt-woocommerce-brands'),
                        'c' => __('Categories page', 'nbt-nbt-woocommerce-brands'),
                        'p' => __('Product detail page', 'nbt-nbt-woocommerce-brands'),
                    ),
                    'autoload' => false,
                    'desc_tip' => true,
                    'show_if_checked' => 'option',
                ),
                array(
                    'title' => __('Brand Default Thumbnail', 'nbt-nbt-woocommerce-brands'),
                    'desc' => '',
                    'id' => 'nbt_woocommerce_brands_image_default',
                    'type' => 'upload',
                    'default' => ''
                ),
                array(
                    'type' => 'sectionend',
                    'id' => 'nbt_woocommerce_general_setting'
                ),
                /*
                 * Product detail page setting
                 */
                array(
                    'title' => __('Product Detail Page', 'nbt-nbt-woocommerce-brands'),
                    'type' => 'title',
                    'id' => 'nbt_woocommerce_product_setting'
                ),
                array(
                    'title' => __('Brand Type Show', 'nbt-nbt-woocommerce-brands'),
                    'desc' => __('Brand name', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_single_title',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'checkboxgroup' => 'start',
                    'autoload' => false,
                ),
                array(
                    'desc' => __('Brand thumbnail', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_single_image',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'checkboxgroup' => '',
                    'show_if_checked' => 'yes',
                    'autoload' => false,
                ),
                array(
                    'desc' => __('Brand description', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_single_desc',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'checkboxgroup' => 'end',
                    'show_if_checked' => 'yes',
                    'autoload' => false,
                ),
                array(
                    'title' => __('Position Display', 'nbt-nbt-woocommerce-brands'),
                    'desc' => __('Position display brand in single product.', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_single_position',
                    'default' => '7',
                    'type' => 'radio',
                    'options' => array(
                        '0' => __('Above product name', 'nbt-nbt-woocommerce-brands'),
                        '1' => __('Below product name', 'nbt-nbt-woocommerce-brands'),
                        '2' => __('Above price', 'nbt-nbt-woocommerce-brands'),
                        '3' => __('Below price', 'nbt-nbt-woocommerce-brands'),
                        '4' => __('Above short description', 'nbt-nbt-woocommerce-brands'),
                        '5' => __('Below short description', 'nbt-nbt-woocommerce-brands'),
                        '6' => __('Above "Add to cart"', 'nbt-nbt-woocommerce-brands'),
                        '7' => __('Below "Add to cart"', 'nbt-nbt-woocommerce-brands'),
                        '8' => __('Above categories list', 'nbt-nbt-woocommerce-brands'),
                        '9' => __('Below categories list', 'nbt-nbt-woocommerce-brands'),
                        '10' => __('Above rating', 'nbt-nbt-woocommerce-brands'),
                        '11' => __('Below rating', 'nbt-nbt-woocommerce-brands'),
                    ),
                    'autoload' => false,
                    'desc_tip' => true,
                    'show_if_checked' => 'option',
                ),
                array(
                    'title' => __('Brand Thumbnail Size', 'woocommerce'),
                    'desc' => __('This size is usually used in brand single', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_single_size',
                    'css' => '',
                    'type' => 'single_size',
                    'default' => array(
                        'width' => '150',
                        'height' => '100',
                        'crop' => 1
                    ),
                    'desc_tip' => true,
                ),
                array(
                    'type' => 'sectionend',
                    'id' => 'nbt_woocommerce_product_detail_setting'
                ),
                /*
                 * Category page setting
                 */
                array(
                    'title' => __('Product Category Page', 'nbt-nbt-woocommerce-brands'),
                    'type' => 'title',
                    'desc' => '',
                    'id' => 'nbt_woocommerce_category_page_setting'
                ),
                array(
                    'title' => __('Brand Type Show', 'nbt-nbt-woocommerce-brands'),
                    'desc' => __('Brand name', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_category_title',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'checkboxgroup' => 'start',
                    'autoload' => false,
                ),
                array(
                    'desc' => __('Brand thumbnail', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_category_image',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'checkboxgroup' => 'end',
                    'show_if_checked' => 'yes',
                    'autoload' => false,
                ),
                array(
                    'title' => __('Position Display', 'nbt-nbt-woocommerce-brands'),
                    'desc' => __('Position display brand in cateogry page.', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_category_position',
                    'default' => '0',
                    'type' => 'radio',
                    'options' => array(
                        '0' => __('Above "Add to cart"', 'nbt-nbt-woocommerce-brands'),
                        '1' => __('Below "Add to cart"', 'nbt-nbt-woocommerce-brands'),
                        '2' => __('Above price', 'nbt-nbt-woocommerce-brands'),
                        '3' => __('Below price', 'nbt-nbt-woocommerce-brands'),
                        '4' => __('Above product name', 'nbt-nbt-woocommerce-brands'),
                        '5' => __('Below product name', 'nbt-nbt-woocommerce-brands'),
                        '6' => __('Above rating', 'nbt-nbt-woocommerce-brands'),
                        '7' => __('Below rating', 'nbt-nbt-woocommerce-brands'),
                    ),
                    'autoload' => false,
                    'desc_tip' => true,
                    'show_if_checked' => 'option',
                ),
                array(
                    'title' => __('Brand Thumbnail Size', 'woocommerce'),
                    'desc' => __('This size is usually used in product category page', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_category_size',
                    'css' => '',
                    'type' => 'category_size',
                    'default' => array(
                        'width' => '150',
                        'height' => '100',
                        'crop' => 1
                    ),
                    'desc_tip' => true,
                ),
                array(
                    'type' => 'sectionend',
                    'id' => 'nbt_woocommerce_category_page_setting'
                ),
                /*
                 * Brand page setting
                 */
                array(
                    'title' => __('Brand Page', 'nbt-nbt-woocommerce-brands'),
                    'type' => 'title',
                    'desc' => '',
                    'id' => 'nbt_woocommerce_brand_page_setting'
                ),
                array(
                    'title' => __('Brand Type Show', 'nbt-nbt-woocommerce-brands'),
                    'desc' => __('Brand banner', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_banner_show',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'checkboxgroup' => 'start',
                    'autoload'      => false
                ),
                array(
                    'desc' => __('Brand thumbnail', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_image_show',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'checkboxgroup' => '',
                    'autoload' => false,
                ),
                array(
                    'desc' => __('Brand description', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_desc_show',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'checkboxgroup' => 'end',
                    'autoload' => false,
                ),
                array(
                    'title' => __('Thumbnail Size', 'woocommerce'),
                    'desc' => __('This size is usually used in brand page', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_thumbnail_size',
                    'css' => '',
                    'type' => 'brand_thumbnail_size',
                    'default' => array(
                        'width' => '95',
                        'height' => '25',
                        'crop' => 1
                    ),
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Banner Size', 'woocommerce'),
                    'desc' => __('This size is usually used in brand page', 'nbt-nbt-woocommerce-brands'),
                    'id' => 'nbt_woocommerce_brand_banner_size',
                    'css' => '',
                    'type' => 'banner_size',
                    'default' => array(
                        'width' => '845',
                        'height' => '250',
                        'crop' => 1
                    ),
                    'desc_tip' => true,
                ),
                array(
                    'type' => 'sectionend',
                    'id' => 'nbt_woocommerce_brand_page_setting'
                ),
            );

            return apply_filters('wc_settings_tab_brand_settings', $settings);
        }
        
        public function nbt_brand_image_single_size($value){
            
            $single_size = get_option('nbt_woocommerce_brand_single_size');
            if($single_size){
                $width = $single_size['width'];
                $height = $single_size['height'];
                $check_crop = !empty($single_size['crop']) ? 'checked="checked"' : '';
            }  else {
                $width = $value['default']['width'];
                $height = $value['default']['height'];
                $check_crop = !empty($value['default']['crop']) ? 'checked="checked"' : '';
            }
            
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr($value['id']); ?>"><?php echo $value['title']; ?></label>
                </th>
                <td class="forminp image_width_settings">
                    <input id="<?php echo esc_attr($value['id']); ?>-width" name="<?php echo esc_attr($value['id']); ?>[width]" size="3" value="<?php echo $width;?>" type="text">
                    <?php _e('×', 'nbt-woocommerce-brands'); ?>
                    <input id="<?php echo esc_attr($value['id']); ?>-height" name="<?php echo esc_attr($value['id']); ?>[height]" size="3" value="<?php echo  $height;?>" type="text">
                    <?php _e('px', 'nbt-woocommerce-brands'); ?>
                    <label><input name="<?php echo esc_attr($value['id']); ?>[crop]" id="<?php echo esc_attr($value['id']); ?>-crop" value="1" <?php echo $check_crop;?> type="checkbox"><?php _e('Hard Crop?', 'nbt-woocommerce-brands'); ?></label>
                </td>
            </tr>
            <?php
        }
        
        public function nbt_brand_image_category_size($value){
            
            $single_size = get_option('nbt_woocommerce_brand_category_size');
            if($single_size){
                $width = $single_size['width'];
                $height = $single_size['height'];
                $check_crop = !empty($single_size['crop']) ? 'checked="checked"' : '';
            }  else {
                $width = $value['default']['width'];
                $height = $value['default']['height'];
                $check_crop = !empty($value['default']['crop']) ? 'checked="checked"' : '';
            }
            
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr($value['id']); ?>"><?php echo $value['title']; ?></label>
                </th>
                <td class="forminp image_width_settings">
                    <input id="<?php echo esc_attr($value['id']); ?>-width" name="<?php echo esc_attr($value['id']); ?>[width]" size="3" value="<?php echo $width;?>" type="text">
                    <?php _e('×', 'nbt-woocommerce-brands'); ?>
                    <input id="<?php echo esc_attr($value['id']); ?>-height" name="<?php echo esc_attr($value['id']); ?>[height]" size="3" value="<?php echo  $height;?>" type="text">
                    <?php _e('px', 'nbt-woocommerce-brands'); ?>
                    <label><input name="<?php echo esc_attr($value['id']); ?>[crop]" id="<?php echo esc_attr($value['id']); ?>-crop" value="1" <?php echo $check_crop;?> type="checkbox"><?php _e('Hard Crop?', 'nbt-woocommerce-brands'); ?></label>
                </td>
            </tr>
            <?php
        }
        
        public function nbt_brand_brand_thumbnail_size($value){
            
            $single_size = get_option('nbt_woocommerce_brand_thumbnail_size');
            if($single_size){
                $width = $single_size['width'];
                $height = $single_size['height'];
                $check_crop = !empty($single_size['crop']) ? 'checked="checked"' : '';
            }  else {
                $width = $value['default']['width'];
                $height = $value['default']['height'];
                $check_crop = !empty($value['default']['crop']) ? 'checked="checked"' : '';
            }
            
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr($value['id']); ?>"><?php echo $value['title']; ?></label>
                </th>
                <td class="forminp image_width_settings">
                    <input id="<?php echo esc_attr($value['id']); ?>-width" name="<?php echo esc_attr($value['id']); ?>[width]" size="3" value="<?php echo $width;?>" type="text">
                    <?php _e('×', 'nbt-woocommerce-brands'); ?>
                    <input id="<?php echo esc_attr($value['id']); ?>-height" name="<?php echo esc_attr($value['id']); ?>[height]" size="3" value="<?php echo  $height;?>" type="text">
                    <?php _e('px', 'nbt-woocommerce-brands'); ?>
                    <label><input name="<?php echo esc_attr($value['id']); ?>[crop]" id="<?php echo esc_attr($value['id']); ?>-crop" value="1" <?php echo $check_crop;?> type="checkbox"><?php _e('Hard Crop?', 'nbt-woocommerce-brands'); ?></label>
                </td>
            </tr>
            <?php
        }
        
        public function nbt_brand_image_banner_size($value){
            
            $single_size = get_option('nbt_woocommerce_brand_banner_size');
            if($single_size){
                $width = $single_size['width'];
                $height = $single_size['height'];
                $check_crop = !empty($single_size['crop']) ? 'checked="checked"' : '';
            }  else {
                $width = $value['default']['width'];
                $height = $value['default']['height'];
                $check_crop = !empty($value['default']['crop']) ? 'checked="checked"' : '';
            }
            
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr($value['id']); ?>"><?php echo $value['title']; ?></label>
                </th>
                <td class="forminp image_width_settings">
                    <input id="<?php echo esc_attr($value['id']); ?>-width" name="<?php echo esc_attr($value['id']); ?>[width]" size="3" value="<?php echo $width;?>" type="text">
                    <?php _e('×', 'nbt-woocommerce-brands'); ?>
                    <input id="<?php echo esc_attr($value['id']); ?>-height" name="<?php echo esc_attr($value['id']); ?>[height]" size="3" value="<?php echo  $height;?>" type="text">
                    <?php _e('px', 'nbt-woocommerce-brands'); ?>
                    <label><input name="<?php echo esc_attr($value['id']); ?>[crop]" id="<?php echo esc_attr($value['id']); ?>-crop" value="1" <?php echo $check_crop;?> type="checkbox"><?php _e('Hard Crop?', 'nbt-woocommerce-brands'); ?></label>
                </td>
            </tr>
            <?php
        }

        public function wc_brand_image_default($value) {
            $thumbnail_id = '';
            if($value){
                $thumbnail_id = get_option($value['id']);
            }
            
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr($value['id']); ?>"><?php echo $value['title']; ?></label>
                </th>
                <td class="forminp">
                    <div class="form-field">
                        <div id="brands_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo ( $thumbnail_id != '' ? wp_get_attachment_thumb_url($thumbnail_id) : wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
                        <div style="line-height:60px;">
                            <input type="hidden" id="<?php echo esc_attr($value['id']); ?>" name="<?php echo esc_attr($value['id']); ?>" value="<?php echo $thumbnail_id; ?>" />
                            <button type="button" class="upload_image_button button"><?php _e('Upload/Add image', 'nbt-woocommerce-brands'); ?></button>
                            <button type="button" class="remove_image_button button"><?php _e('Remove image', 'nbt-woocommerce-brands'); ?></button>
                        </div>

                        <div class="clear"></div>
                    </div>	
                    <?php echo $value['desc']; ?>
                </td>
            </tr>



            <script type="text/javascript">
                // Only show the "remove image" button when needed
                if (!jQuery('#nbt_woocommerce_brands_image_default').val())
                    jQuery('.remove_image_button').hide();

                // Uploading files
                var file_frame;

                jQuery(document).on('click', '.upload_image_button', function (event) {


                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if (file_frame) {
                        file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.downloadable_file = wp.media({
                        title: '<?php _e('Choose an image', 'nbt-woocommerce-brands'); ?>',
                        button: {
                            text: '<?php _e('Use image', 'nbt-woocommerce-brands'); ?>',
                        },
                        multiple: false
                    });

                    // When an image is selected, run a callback.
                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();

                        jQuery('#nbt_woocommerce_brands_image_default').val(attachment.id);
                        jQuery('#brands_thumbnail img').attr('src', attachment.url);
                        jQuery('.remove_image_button').show();
                    });

                    // Finally, open the modal.
                    file_frame.open();
                });

                jQuery(document).on('click', '.remove_image_button', function (event) {
                    jQuery('#brands_thumbnail img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
                    jQuery('#nbt_woocommerce_brands_image_default').val('');
                    jQuery('.remove_image_button').hide();
                    return false;
                });

            </script>

            <?php
        }

    }

    new Nbt_WC_Brands_Settings();
    
endif;

