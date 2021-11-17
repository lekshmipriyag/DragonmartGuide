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

if (!class_exists('Nbt_WC_Brands_Image_Resize')):

    class Nbt_WC_Brands_Image_Resize {

        public function __construct() {
            add_action('init', array($this, 'nbt_wc_brands_image_resize'));
        }

        public function nbt_wc_brands_image_resize() {
            $brands_list = get_terms(
                    array(
                        'taxonomy' => 'product_brand',
                        'hide_empty' => false,
            ));
            
            foreach ($brands_list as $key => $brand) {
                if(get_option('nbt_woocommerce_brand_single_image') == 'yes')
                    $this->nbt_brands_single_resize($brand);
                if(get_option('nbt_woocommerce_brand_category_image') == 'yes')
                    $this->nbt_brands_category_resize($brand);
                $this->nbt_brands_page_resize($brand);
            }
            
            if(get_option('nbt_woocommerce_brands_image_default'))
                $this->nbt_brands_image_default_resize(get_option('nbt_woocommerce_brands_image_default'));
        }
        
        public function nbt_brands_image_default_resize($image_default_id){
            $path_thumb = get_attached_file($image_default_id);
            
            if (file_exists($path_thumb)) {
                $brand_thumb = wp_get_image_editor($path_thumb);
                $single_size = get_option('nbt_woocommerce_brand_single_size');
                $category_size = get_option('nbt_woocommerce_brand_category_size');
                
                $width = 150;
                $height = 100;
                $quality = 76;
                $crop = 1;
                
                if ($single_size) {
                    $width = $single_size['width'];
                    $height = $single_size['height'];
                    $crop = !empty($single_size['crop']) ? $single_size['crop'] : 0;
                    
                    $basedir = wp_upload_dir()['basedir'] . '/nbt-brands';
                    $basedir_default = $basedir . '/brand-default/';

                    if (!file_exists($basedir) && !is_dir($basedir)) {
                        mkdir($basedir , 0775, true);
                    }
                    if (!file_exists($basedir_default) && !is_dir($basedir_default)) {
                        mkdir($basedir_default , 0775, true);
                    }

                    $brand_resize = $basedir_default . '/brand-detail'  .$width . 'x' . $height . '.png';
                    
                    
                    $brand_thumb->resize($width, $height, $crop);
                    $brand_thumb->set_quality($quality);
                    $brand_thumb->save($brand_resize, 'image/png');
                }
                
                if($category_size){
                    $width = $category_size['width'];
                    $height = $category_size['height'];
                    $crop = !empty($category_size['crop']) ? $category_size['crop'] : 0;
                    
                    $basedir = wp_upload_dir()['basedir'] . '/nbt-brands';
                    $basedir_default = $basedir . '/brand-default/';

                    if (!file_exists($basedir) && !is_dir($basedir)) {
                        mkdir($basedir , 0775, true);
                    }
                    if (!file_exists($basedir_default) && !is_dir($basedir_default)) {
                        mkdir($basedir_default , 0775, true);
                    }

                    $brand_resize = $basedir_default . '/brand-cat'  .$width . 'x' . $height . '.png';
                    
                    
                    $brand_thumb->resize($width, $height, $crop);
                    $brand_thumb->set_quality($quality);
                    $brand_thumb->save($brand_resize, 'image/png');
                }
            }
        }

        public function nbt_brands_single_resize($brand) {
            $thumbnail_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true);
            
            if ($thumbnail_id) {
                $path_thumb = get_attached_file($thumbnail_id);
                
                if (file_exists($path_thumb)) {
                    
                    $brand_thumb = wp_get_image_editor($path_thumb);

                    $single_size = get_option('nbt_woocommerce_brand_single_size');
                    $width = 150;
                    $height = 100;
                    $quality = 76;
                    $crop = 1;
                    if ($single_size) {
                        $width = $single_size['width'];
                        $height = $single_size['height'];
                        $crop = !empty($single_size['crop']) ? $single_size['crop'] : 0;
                    }

                    $basedir = wp_upload_dir()['basedir'] . '/nbt-brands';
                    $basedir_single = $basedir . '/brand-detail';

                    if (!file_exists($basedir) && !is_dir($basedir)) {
                        mkdir($basedir , 0775, true);
                    }
                    if (!file_exists($basedir_single) && !is_dir($basedir_single)) {
                        mkdir($basedir_single , 0775, true);
                    }

                    $brand_resize = $basedir_single . '/' . $brand->slug .$width . 'x' . $height . '.png';
                    
                    
                    $brand_thumb->resize($width, $height, $crop);
                    $brand_thumb->set_quality($quality);
                    $brand_thumb->save($brand_resize, 'image/png');
                }
            }
        }
        
        public function nbt_brands_category_resize($brand) {
            $thumbnail_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true);
            
            if ($thumbnail_id) {
                $path_thumb = get_attached_file($thumbnail_id);
                
                if (file_exists($path_thumb)) {
                    
                    $brand_thumb = wp_get_image_editor($path_thumb);

                    $category_size = get_option('nbt_woocommerce_brand_category_size');
                    $width = 150;
                    $height = 100;
                    $quality = 76;
                    $crop = 1;
                    if ($category_size) {
                        $width = $category_size['width'];
                        $height = $category_size['height'];
                        $crop = !empty($category_size['crop']) ? $category_size['crop'] : 0;
                    }

                    $basedir = wp_upload_dir()['basedir'] . '/nbt-brands';
                    $basedir_cat = $basedir . '/brand-cats';

                    if (!file_exists($basedir) && !is_dir($basedir)) {
                        mkdir($basedir , 0775, true);
                    }
                    if (!file_exists($basedir_cat) && !is_dir($basedir_cat)) {
                        mkdir($basedir_cat , 0775, true);
                    }

                    $brand_resize = $basedir_cat . '/' . $brand->slug .$width . 'x' . $height . '.png';
                    
                    $brand_thumb->resize($width, $height, $crop);
                    $brand_thumb->set_quality($quality);
                    $brand_thumb->save($brand_resize, 'image/png');
                }
            }
        }
        
        public function nbt_brands_page_resize($brand) {
            $banner_id = get_woocommerce_term_meta($brand->term_id, 'banner_id', true);
            $thumbnail_id = get_woocommerce_term_meta($brand->term_id, 'thumbnail_id', true);
            
            if ($banner_id) {
                $path_thumb = get_attached_file($banner_id);
                
                if (file_exists($path_thumb)) {
                    
                    $brand_thumb = wp_get_image_editor($path_thumb);

                    $banner_size = get_option('nbt_woocommerce_brand_banner_size');
                    $width = 150;
                    $height = 100;
                    $quality = 76;
                    $crop = 1;
                    if ($banner_size) {
                        $width = $banner_size['width'];
                        $height = $banner_size['height'];
                        $crop = !empty($banner_size['crop']) ? $banner_size['crop'] : 0;
                    }

                    $basedir = wp_upload_dir()['basedir'] . '/nbt-brands/brand-page';
                    $basedir_banner = $basedir . '/banner';

                    if (!file_exists($basedir) && !is_dir($basedir)) {
                        mkdir($basedir , 0775, true);
                    }
                    if (!file_exists($basedir_banner) && !is_dir($basedir_banner)) {
                        mkdir($basedir_banner , 0775, true);
                    }

                    $brand_resize = $basedir_banner . '/' . $brand->slug .$width . 'x' . $height .'.png';
                    
                    $brand_thumb->resize($width, $height, $crop);
                    $brand_thumb->set_quality($quality);
                    $brand_thumb->save($brand_resize, 'image/png');
                }
            }
            
            if ($thumbnail_id) {
                $path_thumb = get_attached_file($thumbnail_id);
                
                if (file_exists($path_thumb)) {
                    
                    $brand_thumb = wp_get_image_editor($path_thumb);

                    $thumbnail_size = get_option('nbt_woocommerce_brand_thumbnail_size');
                    
                    $width = 150;
                    $height = 100;
                    $quality = 76;
                    $crop = 1;
                    if ($thumbnail_size) {
                        $width = $thumbnail_size['width'];
                        $height = $thumbnail_size['height'];
                        $crop = !empty($thumbnail_size['crop']) ? $thumbnail_size['crop'] : 0;
                    }

                    $basedir = wp_upload_dir()['basedir'] . '/nbt-brands/brand-page';
                    $basedir_thumbnail = $basedir . '/thumb/';

                    if (!file_exists($basedir) && !is_dir($basedir)) {
                        mkdir($basedir , 0775, true);
                    }
                    if (!file_exists($basedir_thumbnail) && !is_dir($basedir_thumbnail)) {
                        mkdir($basedir_thumbnail, 0775, true);
                    }

                    $brand_resize = $basedir_thumbnail . '/' . $brand->slug .$width . 'x' . $height .'.png';
                    
                    $brand_thumb->resize($width, $height, $crop);
                    $brand_thumb->set_quality($quality);
                    $brand_thumb->save($brand_resize, 'image/png');
                }
            }
        }

    }

    new Nbt_WC_Brands_Image_Resize();
    
    
endif;