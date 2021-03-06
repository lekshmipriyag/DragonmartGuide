<?php
/*
Plugin Name: NBT Ajax Search
Plugin URI: http://netbaseteam.com
Description: The most powerful ajax powered search engine for WordPress.
Version: 4.6.6
Author: Netbaseteam
Author URI: http://netbaseteam.com
Text Domain: nbt-ajax-search
Domain Path: /languages/
*/
?>
<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

define('ASL_PATH', plugin_dir_path(__FILE__));
define('ASL_FILE', __FILE__);
define('ASL_INCLUDES_PATH', plugin_dir_path(__FILE__)."/includes/");
define('ASL_CLASSES_PATH', plugin_dir_path(__FILE__)."/includes/classes/");
define('ASL_FUNCTIONS_PATH', plugin_dir_path(__FILE__)."/includes/functions/");
define('ASL_DIR', 'nbt-ajax-search');
define('ASL_URL',  plugin_dir_url(__FILE__));
define('ASL_CURRENT_VERSION', 4660);
define('ASL_CURR_VER_STRING', "4.6.6");
define('ASL_DEBUG', 0);
define('ASL_DEMO', get_option('wd_asl_demo', 0) );

// The one and most important global
global $wd_asl;

require_once(ASL_CLASSES_PATH . "core/core.inc.php");
/**
 *  wd_asl()->_prefix   => correct DB prefix for ASP databases
 *  wd_asl()->tables    => table names
 *  wd_asl()->db        => DB manager
 *  wd_asl()->options   => array of default option arrays
 *  wd_asl()->o         => alias of wd_asl()->options
 *  wd_asl()->instances => array of search instances and data
 *  wd_asl()->init      => initialization object
 *  wd_asl()->manager   => main manager object
 *  wd_asl()->session   => the WP_Session object (shared)
 */
$wd_asl = new WD_ASL_Globals();

if ( !function_exists("wd_asl") ) {
    /**
     * Easy access of the global variable reference
     *
     * @return WD_ASL_Globals
     */
    function wd_asl() {
        global $wd_asl;
        return $wd_asl;
    }
}

// Initialize the plugin
$wd_asl->manager = WD_ASL_Manager::getInstance();