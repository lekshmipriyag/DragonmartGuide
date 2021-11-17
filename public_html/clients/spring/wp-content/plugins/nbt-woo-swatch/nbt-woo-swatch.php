<?php
/*
  Plugin Name: NetbaseTeam Woocommerce Swatch
  Plugin URI: http://netbaseteam.com
  Description: Replace simple select box in variation product with color or images
  Version: 1.0.1
  Author: Netbase Team
  Author URI: http://netbaseteam.com
*/

 if( !defined( 'NBTWS_PLUGIN_URL' ) )
          define( 'NBTWS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	  
 
 if( !defined( 'NBTWS_BASE_URL' ) )
          define( 'NBTWS_BASE_URL', plugin_basename(__FILE__) );
	/*
	 * localization
	 */
/*	load_plugin_textdomain( 'nbtws', false, basename( dirname(__FILE__) ).'/languages' );*/
 include_once( ABSPATH . 'wp-admin/includes/plugin.php' );	
	
 /*
  * check woocommerce is active or not
  */

if (is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
          require 'classes/class_create_variations_metabox.php';
		  require 'classes/class_override_woocommerce_variable_tamplate.php';
		  require 'classes/class_nbtws_register_scripts_styles.php';
		  require 'classes/class_attribute_global_values.php';
		  require 'classes/class_shop_page_swatchs.php';
		  require 'includes/nbtws_common_functions.php';
		  require 'includes/nbtws_swatch_form_fields.php';
		  require 'includes/admin/class_add_plugin_settings_field.php';
 
} else {
    
    /*
	 * Display Notice if woocommerce is not installed
	 */
     
     function nbtws_installation_notice() {
         echo '<div class="updated" style="padding:15px; position:relative;"><a href="http://wordpress.org/plugins/woocommerce/">'.__('Woocommerce','dpta').'</a>  must be installed and activated before using this plugin. </div>';
       }

        add_action('admin_notices', 'nbtws_installation_notice');
       return;

     }
	 
    /*
	 * Gets absolute path for plugin
	 */
    function nbtws_plugin_path() {
  
       return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }
    
	/*
	 * Get woocommerce version 
	 */
	function nbtws_get_woo_version_number() {
       
	   if ( ! function_exists( 'get_plugins' ) )
		 require_once( ABSPATH . 'wp-admin/includes/plugin.php' );	
       
	   $plugin_folder = get_plugins( '/' . 'woocommerce' );
	   $plugin_file = 'woocommerce.php';	
	
	   if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
		  return $plugin_folder[$plugin_file]['Version'];

	   } else {
	
		return NULL;
	   }
    }	