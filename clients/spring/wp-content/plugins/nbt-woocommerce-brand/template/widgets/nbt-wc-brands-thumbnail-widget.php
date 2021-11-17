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

if (!class_exists('Nbt_WC_Brands_Thumbnail_Widget')) :

    class Nbt_WC_Brands_Thumbnail_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                    'nbt_wc_brands_thumbnail_widget', esc_html('Woocommerce brands thumbnail widget'), array('description' => esc_html__('Display woocommerce brands thumbnail widget', 'nbt-woocommerce-brands'),)
            );
        }

        public function form($instance) {
            $default = array(
                'title' => 'Brands Thumbnail',
                'hide_brand' => 'true',
                'col' => 2,
                'number_tablets' => 2,
                'number_phone' => 1,
                'tooltip' => 'true',
                'featured' => 'true',
                'brand_count' => 'true',
                'name_show' => 'false',
                'orderby' => 'name',
                'order' => 'ASC'
            );

            $instance = wp_parse_args((array) $instance, $default);

            $title = esc_attr($instance['title']);
            $col = $instance['col'];
            $number_tablets = $instance['number_tablets'];
            $number_phone = $instance['number_phone'];
            $hide_brand = esc_attr($instance['hide_brand']);
            $tooltip = esc_attr($instance['tooltip']);
            $brand_count = esc_attr($instance['brand_count']);
            $name_show = esc_attr($instance['name_show']);
            $featured = esc_attr($instance['featured']);
            $orderby = $instance['orderby'];
            $order = $instance['order'];
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Widget Title', 'nbt-woocommerce-brands'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('name_show'); ?>" name="<?php echo $this->get_field_name('name_show'); ?>" type="checkbox" <?php checked($instance['name_show'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('name_show'); ?>"><?php echo esc_html__('Show name', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('tooltip'); ?>" name="<?php echo $this->get_field_name('tooltip'); ?>" type="checkbox" <?php checked($instance['tooltip'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('tooltip'); ?>"><?php echo esc_html__('Show tooltip', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('hide_brand'); ?>" name="<?php echo $this->get_field_name('hide_brand'); ?>" type="checkbox" <?php checked($instance['hide_brand'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('hide_brand'); ?>"><?php echo esc_html__('Hiden empty brands', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('brand_count'); ?>" name="<?php echo $this->get_field_name('brand_count'); ?>" type="checkbox" <?php checked($instance['brand_count'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('brand_count'); ?>"><?php echo esc_html__('Show brand count', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id('featured'); ?>" name="<?php echo $this->get_field_name('featured'); ?>" type="checkbox" <?php checked($instance['featured'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('featured'); ?>"><?php echo esc_html__('Only display brand featured', 'nbt-woocommerce-brands'); ?></label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('col'); ?>"><?php echo esc_html__('Select brand show in devices desktops ', 'nbt-woocommerce-brands'); ?></label>
                <select class="widefat" name="<?php echo $this->get_field_name('col'); ?>" id="orderby">
                    <option value="1" <?php if ($col == '1') echo 'selected="selected"'; ?>><?php echo esc_html__('1', 'nbt-woocommerce-brands'); ?></option>
                    <option value="2" <?php if ($col == '2') echo 'selected="selected"'; ?>><?php echo esc_html__('2', 'nbt-woocommerce-brands'); ?></option>
                    <option value="3" <?php if ($col == '3') echo 'selected="selected"'; ?>><?php echo esc_html__('3', 'nbt-woocommerce-brands'); ?></option>
                    <option value="4" <?php if ($col == '4') echo 'selected="selected"'; ?>><?php echo esc_html__('4', 'nbt-woocommerce-brands'); ?></option>
                    <option value="5" <?php if ($col == '5') echo 'selected="selected"'; ?>><?php echo esc_html__('5', 'nbt-woocommerce-brands'); ?></option>
                    <option value="6" <?php if ($col == '6') echo 'selected="selected"'; ?>><?php echo esc_html__('6', 'nbt-woocommerce-brands'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('number_tablets'); ?>"><?php echo esc_html__('Select brand show in devices tablets ', 'nbt-woocommerce-brands'); ?></label>
                <select class="widefat" name="<?php echo $this->get_field_name('number_tablets'); ?>" id="orderby">
                    <option value="1" <?php if ($number_tablets == '1') echo 'selected="selected"'; ?>><?php echo esc_html__('1', 'nbt-woocommerce-brands'); ?></option>
                    <option value="2" <?php if ($number_tablets == '2') echo 'selected="selected"'; ?>><?php echo esc_html__('2', 'nbt-woocommerce-brands'); ?></option>
                    <option value="3" <?php if ($number_tablets == '3') echo 'selected="selected"'; ?>><?php echo esc_html__('3', 'nbt-woocommerce-brands'); ?></option>
                    <option value="4" <?php if ($number_tablets == '4') echo 'selected="selected"'; ?>><?php echo esc_html__('4', 'nbt-woocommerce-brands'); ?></option>
                    <option value="5" <?php if ($number_tablets == '5') echo 'selected="selected"'; ?>><?php echo esc_html__('5', 'nbt-woocommerce-brands'); ?></option>
                    <option value="6" <?php if ($number_tablets == '6') echo 'selected="selected"'; ?>><?php echo esc_html__('6', 'nbt-woocommerce-brands'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('number_phone'); ?>"><?php echo esc_html__('Select brand show in devices phone', 'nbt-woocommerce-brands'); ?></label>
                <select class="widefat" name="<?php echo $this->get_field_name('number_phone'); ?>" id="orderby">
                    <option value="1" <?php if ($number_phone == '1') echo 'selected="selected"'; ?>><?php echo esc_html__('1', 'nbt-woocommerce-brands'); ?></option>
                    <option value="2" <?php if ($number_phone == '2') echo 'selected="selected"'; ?>><?php echo esc_html__('2', 'nbt-woocommerce-brands'); ?></option>
                    <option value="3" <?php if ($number_phone == '3') echo 'selected="selected"'; ?>><?php echo esc_html__('3', 'nbt-woocommerce-brands'); ?></option>
                    <option value="4" <?php if ($number_phone == '4') echo 'selected="selected"'; ?>><?php echo esc_html__('4', 'nbt-woocommerce-brands'); ?></option>
                    <option value="5" <?php if ($number_phone == '5') echo 'selected="selected"'; ?>><?php echo esc_html__('5', 'nbt-woocommerce-brands'); ?></option>
                    <option value="6" <?php if ($number_phone == '6') echo 'selected="selected"'; ?>><?php echo esc_html__('6', 'nbt-woocommerce-brands'); ?></option>
                </select>
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
                <label for="<?php echo $this->get_field_id('order'); ?>"><?php echo esc_html__('Order by', 'nbt-woocommerce-brands'); ?></label>
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
            $instance['tooltip'] = $new_instance['tooltip'];
            $instance['brand_count'] = $new_instance['brand_count'];
            $instance['name_show'] = $new_instance['name_show'];
            $instance['col'] = $new_instance['col'];
            $instance['number_tablets'] = $new_instance['number_tablets'];
            $instance['number_phone'] = $new_instance['number_phone'];
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

                echo '<div class="nbt-woocommer-brands-thumbnail-widget">';
                foreach ($brands_list as $brand) {
                    echo '<div class="brand-item-col brand-col-md-' . $instance['col'] . ' brand-col-sm-'.$instance['number_tablets']. ' brand-col-xs-'.$instance['number_phone'].'">';
                    $url_check = get_woocommerce_term_meta($brand->term_id, 'brand_url', true);
                    $brand_count = !empty($instance['brand_count']) ? ' (' . $brand->count . ')' : '';
                    $image_default_id = '';
                    if (get_option('nbt_woocommerce_brands_image_default'))
                        $image_default_id = get_option('nbt_woocommerce_brands_image_default');

                    $thumbnail_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true) ? get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true) : $image_default_id;
                    $image_brand = '';
                    if ($thumbnail_id)
                        $image_brand = '<img src="'.wp_get_attachment_image_url($thumbnail_id, '').'" />';
                    $tooltip = !empty($instance['tooltip']) ? 'nbt-brand-tooltip' : '';
                    $title = !empty($instance['tooltip']) ? 'title="' . $brand->name . '"' : '';

                    if ($url_check) {
                        echo '<div class="brand-item ' . $tooltip . '" ' . $title . '><a target="_blank" href="' . $url_check . '">' . $image_brand . '</a>';
                        if ($instance['name_show'])
                            echo '<div class="brand-name"><a target="_blank" href="' . $url_check . '">' . $brand->name . '</a>' . $brand_count . '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="brand-item ' . $tooltip . '" ' . $title . '><a href="' . get_term_link($brand->slug, 'product_brand') . '">' . $image_brand . '</a>';
                        if ($instance['name_show'])
                            echo '<div class="brand-name"><a href="' . get_term_link($brand->slug, 'product_brand') . '">' . $brand->name . '</a>' . $brand_count . '</div>';
                        echo '</div>';
                    }

                    echo '</div>';
                }
            }
            ?>

            <script type='text/javascript'>
                jQuery(document).ready(function () {
                    jQuery('.nbt-brand-tooltip').tooltipster({theme: 'tooltipster-borderless'});
                });
            </script>  
            <?php
            echo '</div>';
            echo $args['after_widget'];
        }

    }

    add_action('widgets_init', 'create_nbtbrandthumbnail_widget');

    function create_nbtbrandthumbnail_widget() {
        register_widget('Nbt_WC_Brands_Thumbnail_Widget');
    }

    add_action('wp_enqueue_scripts', 'nbt_brand_thumbnail_media');

    function nbt_brand_thumbnail_media() {
        wp_register_style('brand_thumbnail_style', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/css/brand-thumbnail/brand_thumbnail_style.css');
        wp_enqueue_style('brand_thumbnail_style');
        wp_register_style('tooltipster_style', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/css/brand-thumbnail/tooltipster.bundle.min.css');
        wp_enqueue_style('tooltipster_style');
        wp_register_style('borderless_style', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/css/brand-thumbnail/tooltipster-sideTip-borderless.min.css');
        wp_enqueue_style('borderless_style');
        wp_register_script('tooltipster_js', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/js/tooltipster.bundle.min.js', array('jquery'));
        wp_enqueue_script('tooltipster_js');
    }






    
endif;