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



if (!class_exists('Nbt_WC_Brands_Carousel_Widget')) :



    class Nbt_WC_Brands_Carousel_Widget extends WP_Widget {



        public function __construct() {

            parent::__construct(

                    'nbt_wc_brands_carousel_widget', esc_html('Woocommerce brands carousel widget'), array('description' => esc_html__('Display woocommerce brands carousel widget', 'nbt-woocommerce-brands'),)

            );

        }



        public function form($instance) {

            $default = array(

                'title' => 'Brands Carousel',

                'featured' => 'false',

                'number' => 2,

                'height' => 300,

                'item_margin' => 5,

                'autoplaytimeout' => 3000,

                'limit' => 'all',

                'item_row' => 1,

                'show_name' => 'true',

                'nav_show' => 'false',

                'autoplay' => 1,

                'show_count' => 'true',

                'image_show' => 1,

                'hide_brand' => 1,

                'orderby' => 'name',

                'ver_hor' => 'hor',

                'loop' => 'no',

                'order' => 'ASC'

            );

            

            $instance = wp_parse_args((array) $instance, $default);



            $title = esc_attr($instance['title']);

            $featured = esc_attr($instance['featured']);

            $show_name = esc_attr($instance['show_name']);

            $show_count = esc_attr($instance['show_count']);

            $image_show = esc_attr($instance['image_show']);

            $nav_show = esc_attr($instance['nav_show']);

            $autoplay = esc_attr($instance['autoplay']);

            $hide_brand = esc_attr($instance['hide_brand']);



            $number = $instance['number'];

            $autoplaytimeout = $instance['autoplaytimeout'];

            $item_margin = $instance['item_margin'];

            $limit = $instance['limit'];

            $item_row = $instance['item_row'];

            $height = $instance['height'];

            $orderby = $instance['orderby'];

            $ver_hor = $instance['ver_hor'];

            $loop = $instance['loop'];

            $order = $instance['order'];

            

            ?>

            <p>

                <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Widget Title', 'nbt-woocommerce-brands'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />

            </p>

            <p>

                <input class="widefat" id="<?php echo $this->get_field_id('featured'); ?>" name="<?php echo $this->get_field_name('featured'); ?>" type="checkbox" <?php checked($instance['featured'], 'on'); ?> />

                <label for="<?php echo $this->get_field_id('featured'); ?>"><?php echo esc_html__('Only display brand featured', 'nbt-woocommerce-brands'); ?></label>

            </p>

            <p>

                <input class="widefat" id="<?php echo $this->get_field_id('show_name'); ?>" name="<?php echo $this->get_field_name('show_name'); ?>" type="checkbox" <?php checked($instance['show_name'], 'on'); ?> />

                <label for="<?php echo $this->get_field_id('show_name'); ?>"><?php echo esc_html__('Name show', 'nbt-woocommerce-brands'); ?></label>

            </p>

            <p>

                <input class="widefat" id="<?php echo $this->get_field_id('image_show'); ?>" name="<?php echo $this->get_field_name('image_show'); ?>" type="checkbox" <?php checked($instance['image_show'], 'on'); ?> />

                <label for="<?php echo $this->get_field_id('image_show'); ?>"><?php echo esc_html__('Image show', 'nbt-woocommerce-brands'); ?></label>

            </p>

            <p>

                <input class="widefat" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" type="checkbox" <?php checked($instance['show_count'], 'on'); ?> />

                <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php echo esc_html__('Count product show', 'nbt-woocommerce-brands'); ?></label>

            </p>

            <p>

                <input class="widefat" id="<?php echo $this->get_field_id('hide_brand'); ?>" name="<?php echo $this->get_field_name('hide_brand'); ?>" type="checkbox" <?php checked($instance['hide_brand'], 'on'); ?> />

                <label for="<?php echo $this->get_field_id('hide_brand'); ?>"><?php echo esc_html__('Hiden empty brands', 'nbt-woocommerce-brands'); ?></label>

            </p>

            <p>

                <input class="widefat" id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" <?php checked($instance['autoplay'], 'on'); ?> />

                <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php echo esc_html__('Auto play', 'nbt-woocommerce-brands'); ?></label>

            </p>

            <p>

                <input class="widefat" id="<?php echo $this->get_field_id('nav_show'); ?>" name="<?php echo $this->get_field_name('nav_show'); ?>" type="checkbox" <?php checked($instance['nav_show'], 'on'); ?> />

                <label for="<?php echo $this->get_field_id('nav_show'); ?>"><?php echo esc_html__('Display prev/next button', 'nbt-woocommerce-brands'); ?></label>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('number'); ?>"><?php echo esc_html__('Item in slider ', 'nbt-woocommerce-brands'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>"/>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('limit'); ?>"><?php echo esc_html__('Limit (Accepts 0 (all) or any positive number)', 'nbt-woocommerce-brands'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>"/>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('item_row'); ?>"><?php echo esc_html__('Limit (Accepts 0 (all) or any positive number)', 'nbt-woocommerce-brands'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('item_row'); ?>" name="<?php echo $this->get_field_name('item_row'); ?>" type="text" value="<?php echo $item_row; ?>"/>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('autoplaytimeout'); ?>"><?php echo esc_html__('Autoplay interval timeout.', 'nbt-woocommerce-brands'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('autoplaytimeout'); ?>" name="<?php echo $this->get_field_name('autoplaytimeout'); ?>" type="text" value="<?php echo $autoplaytimeout; ?>"/>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('ver_hor'); ?>"><?php echo esc_html__('Display Vertical/Horizontal type', 'nbt-woocommerce-brands'); ?></label>

                <select class="widefat" name="<?php echo $this->get_field_name('ver_hor'); ?>" id="orderby">

                    <option value="ver" <?php if ($ver_hor == 'ver') echo 'selected="selected"'; ?>><?php echo esc_html__('Vertical', 'nbt-woocommerce-brands'); ?></option>

                    <option value="hor" <?php if ($ver_hor == 'hor') echo 'selected="selected"'; ?>><?php echo esc_html__('Horizontal ', 'nbt-woocommerce-brands'); ?></option>

                </select>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('loop'); ?>"><?php echo esc_html__('Loop', 'nbt-woocommerce-brands'); ?></label>

                <select class="widefat" name="<?php echo $this->get_field_name('loop'); ?>" id="orderby">

                    <option value="yes" <?php if ($loop == 'yes') echo 'selected="selected"'; ?>><?php echo esc_html__('Yes', 'nbt-woocommerce-brands'); ?></option>

                    <option value="no" <?php if ($loop == 'no') echo 'selected="selected"'; ?>><?php echo esc_html__('No ', 'nbt-woocommerce-brands'); ?></option>

                </select>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('item_margin'); ?>"><?php echo esc_html__('Margin-right(px) on brand item', 'nbt-woocommerce-brands'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('item_margin'); ?>" name="<?php echo $this->get_field_name('item_margin'); ?>" type="text" value="<?php echo $item_margin; ?>"/>

            </p>

            <p>

                <label for="<?php echo $this->get_field_id('height'); ?>"><?php echo esc_html__('Height carousel (only accept number and vertical style)', 'nbt-woocommerce-brands'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>"/>

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



        public function update($new_instance, $old_instance) {

            $instance = $old_instance;

            $instance['title'] = strip_tags($new_instance['title']);

            $instance['featured'] = $new_instance['featured'];

            $instance['show_name'] = $new_instance['show_name'];

            $instance['show_count'] = $new_instance['show_count'];

            $instance['image_show'] = $new_instance['image_show'];

            $instance['nav_show'] = $new_instance['nav_show'];

            $instance['autoplay'] = $new_instance['autoplay'];

            $instance['center'] = $new_instance['center'];

            $instance['hide_brand'] = $new_instance['hide_brand'];

            $instance['number'] = strip_tags($new_instance['number']);

            $instance['limit'] = strip_tags($new_instance['limit']);

            $instance['item_row'] = strip_tags($new_instance['item_row']);

            $instance['height'] = strip_tags($new_instance['height']);

            $instance['autoplaytimeout'] = strip_tags($new_instance['autoplaytimeout']);

            $instance['item_margin'] = strip_tags($new_instance['item_margin']);

            $instance['ver_hor'] = $new_instance['ver_hor'];

            $instance['loop'] = $new_instance['loop'];

            $instance['orderby'] = $new_instance['orderby'];

            $instance['order'] = $new_instance['order'];



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



            $limit = $instance['limit'];

            if ($instance['limit'] == '' || $instance['limit'] == 'all')

                $limit = 0;

            $nav_show = !empty($instance['nav_show']) ? 'true' : 'false';

            $number = !empty($instance['number']) ? $instance['number'] : 2;

            $item_row = !empty($instance['item_row']) ? $instance['item_row'] : 1;

            $autoplay = '';

            if ($instance['autoplay']) $autoplay = !empty($instance['autoplaytimeout']) ? 'autoplay: '.$instance['autoplaytimeout'] : '';

            

            $hide_empty = !empty($instance['hide_brand']) ? 1 : 0;

            $loop = 'false';

            if($instance['loop'] == 'yes') $loop = 'true';



            $brands_list = get_terms(

                    array(

                        'taxonomy' => 'product_brand',

                        'hide_empty' => $hide_empty,

                        'orderby' => $instance['orderby'],

                        'order' => $instance['order'],

                        'number' => $limit

            ));

            if(count($brands_list)  < $number ) $number = count($brands_list);

            

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

                

                $ver_hor = 'horizontal';

                if($instance['ver_hor'] == 'ver') $ver_hor = 'vertical';

                

                $height = '';

                 if($instance['ver_hor'] == 'ver') $height = 'style="height:'.$instance['height'].'px;"';

                

                echo '<div class="nbt-wc-brand-swiper-carousel-wapper">';

                echo '<div class="nbt-wc-brand-swiper-carousel" '.$height.'>';

                echo '<div class="'. $args['widget_id'] . ' swiper-container swiper-container-'.$ver_hor.' nbt-wc-brand-swiper-carousel">';

                echo '<ul class="swiper-wrapper">';

                

                foreach ($brands_list as $brand) {

                

                    $url_check = get_woocommerce_term_meta($brand->term_id, 'brand_url', true);

                    $image_default_id = '';

                    if (get_option('nbt_woocommerce_brands_image_default'))

                        $image_default_id = get_option('nbt_woocommerce_brands_image_default');



                    $thumbnail_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true) ? get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true) : $image_default_id;

                    $image_brand = '';

                    if($thumbnail_id) $image_brand = '<img src="'.wp_get_attachment_image_url($thumbnail_id, '').'" />';

                    $brand_count = !empty($instance['show_count']) ? ' (' . $brand->count . ') ' : '';



                    echo '<li class="swiper-slide">';

                    echo '<div class="brand-slide-item">';

                    if ($url_check) {

                        if ($instance['image_show'])

                            echo '<a target="_blank" href="' . $url_check . '">' . $image_brand . '</a>';

                        if ($instance['show_name'])

                            echo '<div class="brand-name"><a target="_blank" href="' . $url_check . '">' . $brand->name . '</a>' . $brand_count. '</div>';

                    }else {

                        if ($instance['image_show'])

                            echo '<a href="' . get_term_link($brand->slug, 'product_brand') . '">' . $image_brand . '</a>';

                        if ($instance['show_name'])

                            echo '<div class="brand-name"><a href="' . get_term_link($brand->slug, 'product_brand') . '">' . $brand->name . '</a>' . $brand_count. '</div>';

                    }

                    echo '</div>';

                    echo '</li>';

                }

                

                echo '</ul>';

                echo '</div>';

                echo '</div>';

                

                if($instance['nav_show']){ 

                echo '<div class="nbt-brand-swiper-nav">';

                echo '<div class="swiper-button-next"></div>';

                echo '<div class="swiper-button-prev"></div>';

                echo '</div>';

                }

                

                echo '<div class="nbt-brand-swiper-pagination"></div>';

                echo '</div>';

                

                

                

            }

            ?>

            <script type='text/javascript'>

                jQuery(document).ready(function () {

                    var swiper = new Swiper('.<?php echo $args['widget_id'];?>', {

                        pagination: '.nbt-brand-swiper-pagination',
                        slidesPerView: <?php echo $number;?>,
                        paginationClickable: true,
                        direction: '<?php echo $ver_hor;?>',
                        spaceBetween: <?php echo $instance['item_margin']?>,
                        // Responsive breakpoints
                        breakpoints: {
                        // when window width is <= 320px
                            320: {
                              slidesPerView: 2,
                              spaceBetween: 10
                            },
                            // when window width is <= 480px
                            480: {
                              slidesPerView: 2,
                              spaceBetween: 20
                            },
                            // when window width is <= 640px
                            640: {
                              slidesPerView: 3,
                              spaceBetween: 30
                            }
                        },

                        loop: <?php echo $loop;?>,

                        slidesPerColumn: <?php echo $item_row;?>,

                        nextButton: '.swiper-button-next',

                        prevButton: '.swiper-button-prev',

                        <?php echo $autoplay;?>

                    });

                });

            </script>   

           

        <?php

            echo $args['after_widget'];

        }



    }



    add_action('widgets_init', 'create_nbtbrandcarousel_widget');



    function create_nbtbrandcarousel_widget() {

        register_widget('Nbt_WC_Brands_Carousel_Widget');

    }



    add_action('wp_enqueue_scripts', 'nbt_brand_carousel_media');



    function nbt_brand_carousel_media() {

        wp_register_style('brandcarousel_style', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/css/brand-carousel/brandcarousel_style.css');

        wp_enqueue_style('brandcarousel_style');

        wp_register_style('swiper_style', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/css/brand-carousel/swiper.min.css');

        wp_enqueue_style('swiper_style');

        wp_register_script('swiper_jquery', plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/js/swiper.min.js', array('jquery'));

        wp_enqueue_script('swiper_jquery');

    }





    

endif;