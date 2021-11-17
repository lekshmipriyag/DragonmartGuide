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

    class Nbt_WC_Product_Brands {

        public function __construct() {
            add_action('woocommerce_archive_description', array($this, 'nbt_wc_brand_meta_data'), 5);
        }

        public function nbt_wc_brand_meta_data() {

            if (!is_tax('product_brand'))
                return;

            if (!get_query_var('term'))
                return;

            $brand = get_term_by('slug', get_query_var('term'), 'product_brand');
            
            $upload_url = wp_upload_dir();
            $brand_detail_size = get_option('nbt_woocommerce_brand_single_size');
            $brand_banner_size = get_option('nbt_woocommerce_brand_banner_size');
            $brand_thumb_size = get_option('nbt_woocommerce_brand_thumbnail_size');
            
            $image_default = '';
            if(get_option('nbt_woocommerce_brands_image_default')){
                $image_default = '<div class="nbt-brand-thumb"><img src="'.wp_get_attachment_image_url(get_option('nbt_woocommerce_brands_image_default'), '').'" /></div>';
                if(!empty($brand_thumb_size['crop']))
                    $image_default = '<div class="nbt-brand-thumb"><img src="'.$upload_url['baseurl'].'/nbt-brands/brand-default/'.'brand-detail'.$brand_thumb_size['width'].'x'.$brand_thumb_size['height'].'.png" /></div>';
                      
            }
            
            if ($brand) {
                echo '<div class="nbt-woocommerce-brand-meta">';

               
                if(get_option('nbt_woocommerce_brand_banner_show') == 'yes'){
                    $banner_id = get_woocommerce_term_meta($brand->term_id, 'banner_id', true);
                    if ($banner_id){
                        $banner = '<div class="nbt-brand-banner"><img src="'.wp_get_attachment_image_url($banner_id, '').'" style="width:'.$brand_banner_size['width'].'px;height:'.$brand_banner_size['height'].'px"/></div>';
                        if(!empty($brand_banner_size['crop']))
                            $banner = '<div class="nbt-brand-banner"><img src="'.$upload_url['baseurl'].'/nbt-brands/brand-page/banner/'.$brand->slug.$brand_banner_size['width'].'x'.$brand_banner_size['height'].'.png" /></div>';
                        echo $banner;
                    }
                }
                
                if(get_option('nbt_woocommerce_brand_image_show') == 'yes'){
                    $image_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true);
                    if ($image_id){
                        $thumb = '<div class="nbt-brand-thumb"><img src="'.wp_get_attachment_image_url($image_id, '').'" /></div>';
                        if(!empty($brand_thumb_size['crop']))
                            $thumb = '<div class="nbt-brand-thumb"><span><img src="'.$upload_url['baseurl'].'/nbt-brands/brand-page/thumb/'.$brand->slug.$brand_thumb_size['width'].'x'.$brand_thumb_size['height'].'.png" /></span></div>';
                        echo $thumb;
                    }else{    
                        echo $image_default;
                    }
                }
                
                

                echo '</div>';
                if(get_option('nbt_woocommerce_brand_desc_show') == 'yes'){
                    if ($brand->description)
                        echo  '<div class="nbt-brand-description">'.wpautop(wptexturize(term_description())).'</div>';
                }
            }
        }

    }

    new Nbt_WC_Product_Brands();
    
endif;