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
 *
 * @package Nbt-WooCommerce-Brands
 * @category Core
 * @author NetbaseTeam
 */

if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Nbt_WC_Brands')) :

    class Nbt_WC_Brands {

        /**
         * Nbt_WC_Brands Constructor.
         */
        public function __construct() {
            $this->includes();
            $this->init_hooks();
        }

        /**
         * Hook into actions and filters.
         * @since  2.3
         */
        private function init_hooks() {
            register_activation_hook(__FILE__, array( $this, 'wc_install'));
			register_activation_hook(__FILE__, array($this, 'update_settings_default'));
            
            add_action('init', array( $this, 'nbt_brand_media'));
            add_action( 'admin_enqueue_scripts', array($this,'nbt_brand_media_admin' ));
            include_once( 'includes/nbt-woocommerce-brands-hooks.php' );
        }
		
		/**
         * add default option 
         */
        public function update_settings_default() {
            update_option('nbt_woocommerce_brand_name', 'Brand:');
            update_option('nbt_woocommerce_brand_show_on_page', 'p');
            update_option('nbt_woocommerce_brands_image_default', '');
            update_option('nbt_woocommerce_brand_single_title', 'yes');
            update_option('nbt_woocommerce_brand_single_image', 'no');
            update_option('nbt_woocommerce_brand_single_desc', 'no');
            update_option('nbt_woocommerce_brand_single_position', '7');

            $brand_default_size = array(
                'width' => '150',
                'height' => '100',
                'crop' => '1'
            );
            update_option('nbt_woocommerce_brand_single_size', $default_size);
            update_option('nbt_woocommerce_brand_category_size', $default_size);

            update_option('nbt_woocommerce_brand_category_title', 'yes');
            update_option('nbt_woocommerce_brand_category_image', 'no');
            update_option('nbt_woocommerce_brand_category_position', '0');
            update_option('nbt_woocommerce_brand_banner_show', 'yes');
            update_option('nbt_woocommerce_brand_image_show', 'yes');
            update_option('nbt_woocommerce_brand_desc_show', 'yes');

            $brand_thumbnail_size = array(
                'width' => '95',
                'height' => '25',
                'crop' => '1'
            );
            update_option('nbt_woocommerce_brand_thumbnail_size', $brand_thumbnail_size);

            $brand_banner_size = array(
                'width' => '890',
                'height' => '560',
                'crop' => '1'
            );
            update_option('nbt_woocommerce_brand_banner_size', $brand_banner_size);
        }

        /**
         * Include required core files used in admin and on the frontend.
         */
        public function includes() {
            if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
                return '';
            }
            include_once( 'includes/class-wc-product_brands.php' );
            include_once( 'includes/nbt-woocommerce-brands-taxonomies.php' );
            include_once( 'includes/nbt-woocommerce-brands-settings.php' );
            include_once( 'includes/nbt-woocommerce-brands-image-resize.php' );
            include_once( 'template/widgets/nbt-wc-brands-carousel-widget.php' );
            include_once( 'template/widgets/nbt-wc-brands-list-widget.php' );
            include_once( 'template/widgets/nbt-wc-brands-thumbnail-widget.php' );
            include_once( 'template/widgets/nbt-wc-brands-filter-select-widget.php' );
            include_once( 'template/widgets/nbt-wc-brands-az-filter-widget.php' );
        }

        public function wc_install() {
            global $wp_version;

            If (version_compare($wp_version, '2.9', '<')) {
                deactivate_plugins(basename(__FILE__)); // Deactivate our plugin
                wp_die("This plugin requires WordPress version 2.9 or higher.");
            }

            if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                deactivate_plugins(basename(__FILE__)); // Deactivate our plugin
                wp_die("This plugin required WooCommerce plugin installed and activated. Please <a target='_blank' href='https://wordpress.org/plugins/woocommerce/'>download and install WooCommerce plugin</a>.");
            }
        }
        
        function nbt_brand_media() {
            wp_register_style('nbt_wc_brand', plugin_dir_url(__FILE__) . 'assets/css/style.css');
            wp_enqueue_style('nbt_wc_brand');
        }   
        
        function nbt_brand_media_admin() {
            wp_register_style('nbt_wc_brand_admin', plugin_dir_url(__FILE__) . 'assets/css/admin_style.css');
            wp_enqueue_style('nbt_wc_brand_admin');
        }   

    }

    $GLOBALS['Nbt_WC_Brands'] = new Nbt_WC_Brands();
endif;