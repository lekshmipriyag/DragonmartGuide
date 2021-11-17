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



if (!class_exists('Nbt_WC_Brands_Hooks')) :



    class Nbt_WC_Brands_Hooks {



        public function __construct() {

            $this->add_hooks();

        }



        public function add_hooks() {



            $show_page = get_option('nbt_woocommerce_brand_show_on_page');

            if ($show_page == 'all') {

                add_action('woocommerce_before_single_product', array($this, 'single_product_content'));

                add_action('woocommerce_after_shop_loop_item', array($this, 'category_product_content'));

            } else if ($show_page == 'c') {

                add_action('woocommerce_after_shop_loop_item', array($this, 'category_product_content'));

            } else {

                add_action('woocommerce_before_single_product', array($this, 'single_product_content'));

            }

        }



        /*

         * Single product content 

         */



        public function single_product_content() {



            global $post;

            $product_id = $post->ID;





            $brand_name = get_option('nbt_woocommerce_brand_name') ? get_option('nbt_woocommerce_brand_name') : '';



            $brand_title_show = get_option('nbt_woocommerce_brand_single_title');

            $brand_image_show = get_option('nbt_woocommerce_brand_single_image');

            $brand_desc_show = get_option('nbt_woocommerce_brand_single_desc');



            $brands = wp_get_object_terms($post->ID, 'product_brand');



            foreach ($brands as $key => $brand) {

                $check_publish = get_woocommerce_term_meta($brand->term_id, 'brand_status', true);

                if (empty($check_publish)) {

                    unset($brands[$key]);

                }

            }



            $html_brand = '<div class="nbt-woocommerce-brands single-page">';

            if ($brands) {

                $html_brand .= '<span class="nbt-woocommerce-brand brand-name">' . $brand_name;

                    

                if ($brand_title_show == 'yes') {

                    $i = 0;

                    foreach ($brands as $brand) {



                        $html_brand .= '<a href="' . get_term_link($brand->slug, 'product_brand') . '"> ' . $brand->name . '</a>';



                        if ($i < (count($brands) - 1)) {



                            $html_brand .= ', ';

                        }

                        $i++;

                    }

                }



                $html_brand .= '</span>';



                if ($brand_image_show == 'yes') {

                    $brand_detail_size = get_option('nbt_woocommerce_brand_single_size');

                    $upload_url = wp_upload_dir();



                    $html_brand .= '<div class="nbt-woocommerce-brands-image">';

                    foreach ($brands as $key => $brand) {



                        $thumbnail_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true);

                        $thumb = '';

                        if ($thumbnail_id) {

                            $thumb = '<img src="' . wp_get_attachment_image_url($thumbnail_id, '') . '" style="width:' . $brand_detail_size['width'] . 'px;height:' . $brand_detail_size['height'] . 'px"/>';

                            if (!empty($brand_detail_size['crop']))

                                $thumb = '<img src="' . $upload_url['baseurl'] . '/nbt-brands/brand-detail/' . $brand->slug . $brand_detail_size['width'] . 'x' . $brand_detail_size['height'] . '.png" />';

                        } else {

                            $thumb = '<img src="' . wp_get_attachment_image_url(get_option('nbt_woocommerce_brands_image_default'), '') . '" style="width:' . $brand_detail_size['width'] . 'px;height:' . $brand_detail_size['height'] . 'px"/>';

                            if (!empty($brand_detail_size['crop']))

                                $thumb = '<img src="' . $upload_url['baseurl'] . '/nbt-brands/brand-default/' . 'brand-detail' . $brand_detail_size['width'] . 'x' . $brand_detail_size['height'] . '.png" />';

                        }



                        if ($thumb) {

                            $brand_url = get_woocommerce_term_meta($brand->term_id, 'brand_url', true);

                            if ($brand_url)

                                $html_brand .= '<span><a target="_blank" href="' . $brand_url . '">' . $thumb . '</a></span>';

                            else

                                $html_brand .= '<span><a href="' . get_term_link($brand->slug, 'product_brand') . '">' . $thumb . '</a></span>';

                        }

                    }

                    $html_brand .= '</div>';

                }



                if ($brand_desc_show == 'yes') {

                    $html_brand .= '<div class="nbt-woocommerce-brands-description">';

                    foreach ($brands as $key => $brand) {

                        $html_brand .= '<span class="brand-description ' . $brand->name . '">';

                        $html_brand .= wpautop(wptexturize(term_description($brand->term_id, 'product_brand')));

                        $html_brand .= '</span>';

                    }

                    $html_brand .= '</div>';

                }

            }

            $html_brand .= '</div>';



            $brand_single_position = get_option('nbt_woocommerce_brand_single_position');

            switch ($brand_single_position) {

                case '0':

                    echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertBefore('div.post-" . $product_id . " .entry-summary h1');

                                    });

                                 </script>

                                 ";

                    break;

                case '1':

                    echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertAfter('div.post-" . $product_id . " .entry-summary h1');

                                    });

                                 </script>

                                 ";

                    break;

                case '2':

                    echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertBefore('div.post-" . $product_id . " .entry-summary .price');

                                    });

                                 </script>

                                 ";

                    break;

                case '3':

                    echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertAfter('div.post-" . $product_id . " .entry-summary .price');

                                    });

                                 </script>

                                 ";

                    break;

                case '4':

                    echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertBefore('div.post-" . $product_id . " .entry-summary div[itemprop=\"description\"]');

                                    });

                                 </script>

                                 ";

                    break;

                case '5':

                    echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertAfter('div.post-" . $product_id . " .entry-summary div[itemprop=\"description\"]');

                                    });

                                 </script>

                                 ";

                    break;

                case '6':

                     echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertBefore('div.post-" . $product_id . " .entry-summary form.cart');

                                    });

                                 </script>

                                 ";

                    break;

                case '7':

                     echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertAfter('div.post-" . $product_id . " .entry-summary form.cart');

                                    });

                                 </script>

                                 ";

                    break;

                case '8':

                     echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertBefore('div.post-" . $product_id . " .entry-summary .product_meta .posted_in');

                                    });

                                 </script>

                                 ";

                    break;

                case '9':

                     echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertAfter('div.post-" . $product_id . " .entry-summary .product_meta .posted_in');

                                    });

                                 </script>

                                 ";

                    break;

                case '10':

                     echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertBefore('div.post-" . $product_id . " .entry-summary .woocommerce-product-rating');

                                    });

                                 </script>

                                 ";

                    break;

                case '11':

                     echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertAfter('div.post-" . $product_id . " .entry-summary .woocommerce-product-rating');

                                    });

                                 </script>

                                 ";

                    break;

                default :

                    echo "

                                <script type='text/javascript'>

                                    jQuery(document).ready(function(){

                                            jQuery('" . $html_brand . "').insertAfter('div.post-" . $product_id . " .entry-summary form.cart');

                                    });

                                 </script>

                                 ";

                    break;

            }

        }



        /*

         * Category product content 

         */



        public function category_product_content() {



            global $post;

            $product_id = $post->ID;

            

            $brand_name = get_option('nbt_woocommerce_brand_name') ? get_option('nbt_woocommerce_brand_name') : 'Brand: ';

            $brands = wp_get_object_terms($post->ID, 'product_brand');

            

            if ($brands) {

                foreach ($brands as $key => $brand) {

                    $check_publish = get_woocommerce_term_meta($brand->term_id, 'brand_status', true);

                    if (empty($check_publish)) {

                        unset($brands[$key]);

                    }

                }



                $html = '<div class="nbt-woocommerce-brands category-page">';

                $html .= '<span class="nbt-woocommerce-brand brand-name">' . $brand_name;



                

                if (get_option('nbt_woocommerce_brand_category_title') == 'yes') {

                    $html .= '<span class="nbt-woocommerce-brands-name">';

                    $i = 0;

                    foreach ($brands as $brand) {

                        $html .= '<a href="' . get_term_link($brand->slug, 'product_brand') . '"> ' . $brand->name . '</a>';

                        if ($i < (count($brands) - 1)) {

                            $html .= ', ';

                        }

                        $i++;

                    }

                    $html .= '</span>';

                }

                $html .= '</span>';

                if (get_option('nbt_woocommerce_brand_category_image') == 'yes') {



                    $brand_category_size = get_option('nbt_woocommerce_brand_category_size');

                    $upload_url = wp_upload_dir();



                    $html .= '<div class="nbt-woocommerce-brands-image">';

                    foreach ($brands as $key => $brand) {

                        $thumbnail_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true);

                        $thumb = '';

                        if ($thumbnail_id) {

                            $thumb = '<img src="' . wp_get_attachment_image_url($thumbnail_id, '') . '" style="width:' . $brand_category_size['width'] . 'px;height:' . $brand_category_size['height'] . 'px"/>';

                            if (!empty($brand_category_size['crop']))

                                $thumb = '<img src="' . $upload_url['baseurl'] . '/nbt-brands/brand-cats/' . $brand->slug . $brand_category_size['width'] . 'x' . $brand_category_size['height'] . '.png" />';

                        } else {

                            $thumb = '<img src="' . wp_get_attachment_image_url(get_option('nbt_woocommerce_brands_image_default'), '') . '" style="width:' . $brand_category_size['width'] . 'px;height:' . $brand_category_size['height'] . 'px"/>';

                            if (!empty($brand_category_size['crop']))

                                $thumb = '<img src="' . $upload_url['baseurl'] . '/nbt-brands/brand-default/' . 'brand-cat' . $brand_category_size['width'] . 'x' . $brand_category_size['height'] . '.png" />';

                        }



                        if ($thumb) {

                            $brand_url = get_woocommerce_term_meta($brand->term_id, 'brand_url', true);

                            if ($brand_url)

                                $html .= '<span><a target="_blank" href="' . $brand_url . '">' . $thumb . '</a></span>';

                            else

                                $html .= '<span><a href="' . get_term_link($brand->slug, 'product_brand') . '">' . $thumb . '</a></span>';

                        }

                    }

                    $html .= '</div>';

                }





                $html .= '</div>';



                $brand_category_position = get_option('nbt_woocommerce_brand_category_position');



                switch ($brand_category_position) {

                    case '0':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertBefore('li.post-" . $product_id . " a.add_to_cart_button');

                                });

                             </script>

                             ";

                        break;

                    case '1':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertAfter('li.post-" . $product_id . " a.add_to_cart_button');

                                });

                             </script>

                             ";

                        break;

                    case '2':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertBefore('li.post-" . $product_id . " .price');

                                });

                             </script>

                             ";

                        break;

                    case '3':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertAfter('li.post-" . $product_id . " .price');

                                });

                             </script>

                             ";

                        break;

                    case '4':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertBefore('li.post-" . $product_id . " h3');

                                });

                             </script>

                             ";

                        break;

                    case '5':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertAfter('li.post-" . $product_id . " h3');

                                });

                             </script>

                             ";

                        break;

                    case '6':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertBefore('li.post-" . $product_id . " .star-rating');

                                });

                             </script>

                             ";

                        break;

                    case '7':

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertAfter('li.post-" . $product_id . " .star-rating');

                                });

                             </script>

                             ";

                        break;

                    default :

                        echo "

                            <script type='text/javascript'>

                                jQuery(document).ready(function(){

                                        jQuery('" . $html . "').insertAfter('li.post-" . $product_id . " .price');

                                });

                             </script>

                             ";

                        break;

                }

            }

        }



    }



    new Nbt_WC_Brands_Hooks();

endif;