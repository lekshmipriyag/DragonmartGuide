<?php
/**
 * Plugin Name: NetbaseTeam Woocommerce Brands
 * Plugin URI: https://netbaseteam.com/
 * Description: NetbaseTeam Woocommerce Brands.
 * Version: 1.0.0
 * Author: NetbaseTeam
 * Author URI: https://netbaseteam.com/
 * License: GPLv2 or later
 * Text Domain: NetbaseTeam Woocommerce Brand
 */

if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

if (!class_exists('Nbt_WC_Brands_Filter_Select_Widget')) :

    class Nbt_WC_Brands_Filter_Select_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                    'nbt_wc_brands_filter_select_widget', esc_html('Woocommerce brands filter select widget'), array('description' => esc_html__('Display woocommerce brands filter select widget', 'nbt-woocommerce-brands'),)
            );
        }

        public function form($instance) {
            $default = array(
                'title' => 'Brands Filter Select',
                'placeholder' => 'Select a brand',
                'width' => '100%',
                'show_count' => 'true',
                'hide_brand' => 'true',
                'featured' => 'false',
                'orderby' => 'name',
                'order' => 'ASC'
            );

            $instance = wp_parse_args((array) $instance, $default);

            $title = esc_attr($instance['title']);
            $width = esc_attr($instance['width']);
            $placeholder = esc_attr($instance['placeholder']);
            $show_count = esc_attr($instance['show_count']);
            $hide_brand = esc_attr($instance['hide_brand']);
            $featured = esc_attr($instance['featured']);
            $orderby = $instance['orderby'];
            $order = $instance['order'];
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Widget title', 'nbt-woocommerce-brands'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('placeholder'); ?>"><?php echo esc_html__('Enter placeholder', 'nbt-woocommerce-brands'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('placeholder'); ?>" name="<?php echo $this->get_field_name('placeholder'); ?>" type="text" value="<?php echo $placeholder; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('width'); ?>"><?php echo esc_html__('Width px/% ( Only enter number )', 'nbt-woocommerce-brands'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('featured'); ?>" name="<?php echo $this->get_field_name('featured'); ?>" type="checkbox" <?php checked($instance['featured'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('featured'); ?>"><?php echo esc_html__('Only display brand featured', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" type="checkbox" <?php checked($instance['show_count'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php echo esc_html__('Display product count', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('hide_brand'); ?>" name="<?php echo $this->get_field_name('hide_brand'); ?>" type="checkbox" <?php checked($instance['hide_brand'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('hide_brand'); ?>"><?php echo esc_html__('Hiden empty brands', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php echo esc_html__('Order by', 'nbt-woocommerce-brands'); ?></label>
                <select class="widefat" name="<?php echo $this->get_field_name('orderby'); ?>" id="orderby">
                    <option value=""><?php echo esc_html__('No order', 'nbt-woocommerce-brands'); ?></option>
                    <option value="id" <?php if ($orderby == 'ID') echo 'selected="selected"'; ?>><?php echo esc_html__('ID', 'nbt-woocommerce-brands'); ?></option>
                    <option value="slug" <?php if ($orderby == 'slug') echo 'selected="selected"'; ?>><?php echo esc_html__('Slug', 'nbt-woocommerce-brands'); ?></option>
                    <option value="name" <?php if ($orderby == 'name') echo 'selected="selected"'; ?>><?php echo esc_html__('Name', 'nbt-woocommerce-brands'); ?></option>
                    <option value="count" <?php if ($orderby == 'count') echo 'selected="selected"'; ?>><?php echo esc_html__('Count', 'nbt-woocommerce-brands'); ?></option>
               </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('order'); ?>"><?php echo esc_html__('Order', 'nbt-woocommerce-brands'); ?></label>
                <select class="widefat" name="<?php echo $this->get_field_name('order'); ?>" id="order">
                    <option value=""><?php echo esc_html__('No order', 'nbt-woocommerce-brands'); ?></option>
                    <option value="ASC" <?php if ($order == 'ASC') echo 'selected="selected"'; ?>><?php echo esc_html__('ASC', 'nbt-woocommerce-brands'); ?></option>
                    <option value="DESC" <?php if ($order == 'DESC') echo 'selected="selected"'; ?>><?php echo esc_html__('DESC', 'nbt-woocommerce-brands'); ?></option>
                </select>
            </p>
            <?php
        }

        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['placeholder'] = strip_tags($new_instance['placeholder']);
            $instance['width'] = strip_tags($new_instance['width']);
            $instance['show_count'] = $new_instance['show_count'];
            $instance['hide_brand'] = $new_instance['hide_brand'];
            $instance['orderby'] = $new_instance['orderby'];
            $instance['order'] = $new_instance['order'];
            $instance['featured'] = $new_instance['featured'];

            return $instance;
        }

        /*
         * Output the content widget
         * 
         * @param array $args
         * @param array $instance
         */

        function widget($args, $instance) {
            echo $args['before_widget'];

            if (!empty($instance['title'])) {
                echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
            }

            $hide_empty = !empty($instance['hide_brand']) ? 1 : 0;

            $brands_list = get_terms(
                    array(
                        'taxonomy' => 'product_brand',
                        'hide_empty' => $hide_empty,
                        'orderby' => $instance['orderby'],
                        'order' => $instance['order'],
            ));
            if ($brands_list) {
                foreach ($brands_list as $key => $brand) {
                    // check brand publish
                    $check_publish = get_woocommerce_term_meta($brand->term_id, 'brand_status', true);
                    if (empty($check_publish)) {
                        unset($brands_list[$key]);
                    }

                    // check brand featured
                    if ($instance['featured']) {
                        $check_featured = get_woocommerce_term_meta($brand->term_id, 'brand_featured', true);
                        if (empty($check_featured)) {
                            unset($brands_list[$key]);
                        }
                    }
                }

                echo '<div class="nbt-woocommer-brands-filter-widget">';
                echo '<select class="nbt-wc-brand-select">';
                echo '<option value=""></option>';
                foreach ($brands_list as $brand) {
                    $check_publish = get_woocommerce_term_meta($brand->term_id, 'brand_status', true);
                    $url_check = get_woocommerce_term_meta($brand->term_id, 'brand_url', true);
                    $brand_count = !empty($instance['show_count']) ? ' (' . $brand->count . ') ' : '';

                    if ($check_publish) {
                        if ($url_check) {
                            echo '<option data-href="' . $url_check . '" value="'.$brand->term_id.'"><a target="_blank" href="' . $url_check . '">' . $brand->name . '</a>' . $brand_count . '</option>';
                        } else {
                            echo '<option data-href="' . get_term_link($brand->slug, 'product_brand') . '" value="'.$brand->term_id.'"><a href="' . get_term_link($brand->slug, 'product_brand') . '">' . $brand->name . '</a>' . $brand_count . '</option>';
                        }
                    }
                }

                echo '</select>';
                echo '</div>';
            }
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery(".nbt-wc-brand-select").select2({
                        placeholder: "<?php echo $instance['placeholder'];?>",
                    });
                    
                    var BrandSelected = localStorage.getItem("BrandSelected"); 
                    jQuery(".nbt-wc-brand-select").change(function() {
                        location = jQuery(".nbt-wc-brand-select option:selected").attr('data-href');
                        localStorage.setItem("BrandSelected", jQuery(this).val());
                    });
                    jQuery(".nbt-wc-brand-select option").each(function(){
                        if(jQuery(this).val() == BrandSelected){
                            jQuery('.select2-selection__placeholder').text(jQuery(this).text());
                        }
                    });
                    localStorage.removeItem('BrandSelected');
                    
                    jQuery(".nbt-woocommer-brands-filter-widget .select2-container").css({'width':'<?php echo $instance['width'];?>','transform':' translateX(-50%)','left':'50%'});
                });
            </script>
            <?php
            echo $args['after_widget'];
        }

    }

    add_action('widgets_init', 'create_nbtbrandfilterselect_widget');

    function create_nbtbrandfilterselect_widget() {
        register_widget('Nbt_WC_Brands_Filter_Select_Widget');
    }

    add_action('wp_enqueue_scripts', 'nbt_brand_filter_select_media');

    function nbt_brand_filter_select_media() {
        wp_register_style('select2_css', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/css/brand-select/select2.min.css');
        wp_enqueue_style('select2_css');
        wp_register_script('select2_js', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/js/select2.js', array('jquery'));
        wp_enqueue_script('select2_js');
    }


    
endif;