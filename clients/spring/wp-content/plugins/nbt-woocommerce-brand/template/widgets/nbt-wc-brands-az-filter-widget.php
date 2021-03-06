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

if (!class_exists('Nbt_WC_Brands_AZ_Filter_Widget')) :

    class Nbt_WC_Brands_AZ_Filter_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                    'nbt_wc_brands_az_filter_widget', esc_html('Woocommerce brands a-z filter widget'), array('description' => esc_html__('Display woocommerce brands a-z filter widget', 'nbt-woocommerce-brands'),)
            );
        }

        public function form($instance) {
            $default = array(
                'title' => 'Brands A-Z Filter',
                'show_count' => 'true',
                'text_all' => 'All',
                'hide_brand' => 'true',
                'featured' => 'true',
                'orderby' => 'name',
                'order' => 'ASC'
            );

            $instance = wp_parse_args((array) $instance, $default);

            $title = esc_attr($instance['title']);
            $text_all = esc_attr($instance['text_all']);
            $show_count = esc_attr($instance['show_count']);
            $hide_brand = esc_attr($instance['hide_brand']);
            $featured = esc_attr($instance['featured']);
            $orderby = $instance['orderby'];
            $order = $instance['order'];
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Widget Title', 'nbt-woocommerce-brands'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('text_all'); ?>"><?php echo esc_html__('Texl all', 'nbt-woocommerce-brands'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('text_all'); ?>" name="<?php echo $this->get_field_name('text_all'); ?>" type="text" value="<?php echo $text_all; ?>" />
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
                 <input class="widefat" id="<?php echo $this->get_field_id('featured'); ?>" name="<?php echo $this->get_field_name('featured'); ?>" type="checkbox" <?php checked($instance['featured'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('featured'); ?>"><?php echo esc_html__('Only display brand featured', 'nbt-woocommerce-brands'); ?></label>
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
            $instance['text_all'] = strip_tags($new_instance['text_all']);
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
                    if($instance['featured']){
                        $check_featured = get_woocommerce_term_meta($brand->term_id, 'brand_featured', true);
                        if (empty($check_featured)) {
                            unset($brands_list[$key]);
                        }
                    }
                    
                }

                $az_navs = array();
                foreach ($brands_list as $key => $brand) {
                    $conver_brand = $this->nbtConvertString($brand->name);
                    $az_navs[$key] = strtoupper(substr($conver_brand, 0, 1));
                }
                
                $az_navs = array_unique($az_navs);
                
                $group_brand = array();
                $data_brand = array();
                foreach($az_navs as $az){
                    foreach ($brands_list as $brand){
                        $conver_brand = $this->nbtConvertString($brand->name);
                        if($az == strtoupper(substr($conver_brand, 0, 1))) $group_brand[$az][$brand->slug] = $brand->name;
                        $data_brand['count'][$brand->slug] = $brand->count;
                        $data_brand['link'][$brand->slug] = get_woocommerce_term_meta($brand->term_id, 'brand_url', true);;
                    }
                }
                
                echo '<div class="nbt-woocommer-brands-filter-widget">';

                if ($group_brand) {
                    echo '<div class="brand-tab-item">';
                    echo '<div class="brand-all"><a class="active" data-toggle="tab" href="#nbt-brand_all">'. esc_html__( $instance['text_all'], 'nbt-woocommerce-brands').'</a></div>';
                    echo '<div class="brand-other">';
                    foreach ($group_brand as $key => $az) {
                        echo '<a data-toggle="tab" href="#nbt-brand_'.$key.'">' . $key . '</a>';
                    }
                    echo '</div>';
                    echo '</div>';
                    
                    echo '<div class="nbt-brand-az-filter tab-content">';
                        echo '<div id="nbt-brand_all" class="tab-pane fade in active">';
                        echo '<ul>';
                        foreach ($group_brand as $key => $brands) {
                            foreach ($brands as $slug => $brand){
                                $brand_count = !empty($instance['show_count']) ? '<span> ('.$data_brand['count'][$slug].') </span>' : '';
                                if($data_brand['link'][$slug])
                                    echo '<li><a target="_blank" href="' . $data_brand['link'][$slug] . '">'.$brand.'</a> '.$brand_count.'</li>';
                                else
                                    echo '<li><a href="' . get_term_link($slug, 'product_brand') . '">'.$brand.'</a> '.$brand_count.'</li>';
                            }
                        }
                        echo '</ul>';
                        echo '</div>';
                        foreach ($group_brand as $key => $brands) {
                            echo '<div id="nbt-brand_'.$key.'" class="tab-pane fade">';
                            echo '<ul>';
                            foreach ($brands as $slug => $brand){
                                $brand_count = !empty($instance['show_count']) ? '<span> ('.$data_brand['count'][$slug].') </span>' : '';
                                if($data_brand['link'][$slug])
                                    echo '<li><a target="_blank" href="' . $data_brand['link'][$slug] . '">'.$brand.'</a> '.$brand_count.'</li>';
                                else
                                    echo '<li><a href="' . get_term_link($slug, 'product_brand') . '">'.$brand.'</a> '.$brand_count.'</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        }
                    echo '</div>';
                }
                
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        jQuery('.brand-tab-item .brand-all a').on('click', function(){
                            jQuery('.brand-tab-item .brand-other a').removeClass('active');
                            jQuery(this).addClass('active');
                        });
                        jQuery('.brand-tab-item .brand-other a').on('click', function(){
                            jQuery('.brand-tab-item .brand-other a').removeClass('active');
                            jQuery('.brand-tab-item .brand-all a').removeClass('active');
                            jQuery(this).addClass('active');
                            
                        });
                    });
                </script>
                <?php
                
                echo '</div>';
            }
            


            echo $args['after_widget'];
        }
        
        function nbtConvertString($azbrand) {
            $transliterationCharactor = array('??' => 'a', '??' => 'A', '??' => 'a', '??' => 'A', '??' => 'a', '??' => 'A', '??' => 'a', '??' => 'A', '??' => 'a', '??' => 'A', '??' => 'a', '??' => 'A', '??' => 'a', '??' => 'A', '??' => 'a', '??' => 'A', '??' => 'ae', '??' => 'AE', '??' => 'ae', '??' => 'AE', '???' => 'b', '???' => 'B', '??' => 'c', '??' => 'C', '??' => 'c', '??' => 'C', '??' => 'c', '??' => 'C', '??' => 'c', '??' => 'C', '??' => 'c', '??' => 'C', '??' => 'd', '??' => 'D', '???' => 'd', '???' => 'D', '??' => 'd', '??' => 'D', '??' => 'dh', '??' => 'Dh', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '???' => 'f', '???' => 'F', '??' => 'f', '??' => 'F', '??' => 'g', '??' => 'G', '??' => 'g', '??' => 'G', '??' => 'g', '??' => 'G', '??' => 'g', '??' => 'G', '??' => 'h', '??' => 'H', '??' => 'h', '??' => 'H', '??' => 'i', '??' => 'I', '??' => 'i', '??' => 'I', '??' => 'i', '??' => 'I', '??' => 'i', '??' => 'I', '??' => 'i', '??' => 'I', '??' => 'i', '??' => 'I', '??' => 'i', '??' => 'I', '??' => 'j', '??' => 'J', '??' => 'k', '??' => 'K', '??' => 'l', '??' => 'L', '??' => 'l', '??' => 'L', '??' => 'l', '??' => 'L', '??' => 'l', '??' => 'L', '???' => 'm', '???' => 'M', '??' => 'n', '??' => 'N', '??' => 'n', '??' => 'N', '??' => 'n', '??' => 'N', '??' => 'n', '??' => 'N', '??' => 'o', '??' => 'O', '??' => 'o', '??' => 'O', '??' => 'o', '??' => 'O', '??' => 'o', '??' => 'O', '??' => 'o', '??' => 'O', '??' => 'oe', '??' => 'OE', '??' => 'o', '??' => 'O', '??' => 'o', '??' => 'O', '??' => 'oe', '??' => 'OE', '???' => 'p', '???' => 'P', '??' => 'r', '??' => 'R', '??' => 'r', '??' => 'R', '??' => 'r', '??' => 'R', '??' => 's', '??' => 'S', '??' => 's', '??' => 'S', '??' => 's', '??' => 'S', '???' => 's', '???' => 'S', '??' => 's', '??' => 'S', '??' => 's', '??' => 'S', '??' => 'SS', '??' => 't', '??' => 'T', '???' => 't', '???' => 'T', '??' => 't', '??' => 'T', '??' => 't', '??' => 'T', '??' => 't', '??' => 'T', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'u', '??' => 'U', '??' => 'ue', '??' => 'UE', '???' => 'w', '???' => 'W', '???' => 'w', '???' => 'W', '??' => 'w', '??' => 'W', '???' => 'w', '???' => 'W', '??' => 'y', '??' => 'Y', '???' => 'y', '???' => 'Y', '??' => 'y', '??' => 'Y', '??' => 'y', '??' => 'Y', '??' => 'z', '??' => 'Z', '??' => 'z', '??' => 'Z', '??' => 'z', '??' => 'Z', '??' => 'th', '??' => 'Th', '??' => 'u', '??' => 'a', '??' => 'a', '??' => 'b', '??' => 'b', '??' => 'v', '??' => 'v', '??' => 'g', '??' => 'g', '??' => 'd', '??' => 'd', '??' => 'e', '??' => 'E', '??' => 'e', '??' => 'E', '??' => 'zh', '??' => 'zh', '??' => 'z', '??' => 'z', '??' => 'i', '??' => 'i', '??' => 'j', '??' => 'j', '??' => 'k', '??' => 'k', '??' => 'l', '??' => 'l', '??' => 'm', '??' => 'm', '??' => 'n', '??' => 'n', '??' => 'o', '??' => 'o', '??' => 'p', '??' => 'p', '??' => 'r', '??' => 'r', '??' => 's', '??' => 's', '??' => 't', '??' => 't', '??' => 'u', '??' => 'u', '??' => 'f', '??' => 'f', '??' => 'h', '??' => 'h', '??' => 'c', '??' => 'c', '??' => 'ch', '??' => 'ch', '??' => 'sh', '??' => 'sh', '??' => 'sch', '??' => 'sch', '??' => '', '??' => '', '??' => 'y', '??' => 'y', '??' => '', '??' => '', '??' => 'e', '??' => 'e', '??' => 'ju', '??' => 'ju', '??' => 'ja', '??' => 'ja');
            return str_replace(array_keys($transliterationCharactor), array_values($transliterationCharactor), $azbrand);
        }

    }

    add_action('widgets_init', 'create_nbtbrandazfilter_widget');

    function create_nbtbrandazfilter_widget() {
        register_widget('Nbt_WC_Brands_AZ_Filter_Widget');
    }
    
    add_action( 'wp_enqueue_scripts','nbt_brand_az_filter_media');
    function nbt_brand_az_filter_media(){
        wp_register_style('az_filter_css', plugin_dir_url( dirname(dirname(__FILE__)) ).'assets/css/brand-az/azfilter.css');
        wp_enqueue_style('az_filter_css');
        wp_register_style('bootstrap_tab_css', plugin_dir_url( dirname(dirname(__FILE__)) ).'assets/css/brand-az/bootstrap_tab.css');
        wp_enqueue_style('bootstrap_tab_css');
        wp_register_script( 'bootstrap_tab_js', plugin_dir_url( dirname(dirname(__FILE__)) ).'assets/js/bootstrap_tab.js',array('jquery'));
        wp_enqueue_script('bootstrap_tab_js');
    }

endif;