<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

/**
 * Class WD_ASL_init
 *
 * AJAX SEARCH initializator Class
 */
class WD_ASL_Init {

    /**
     * Core singleton class
     * @var WD_ASL_Init self
     */
    private static $_instance;

    private function __construct() {
        wd_asl()->db = WD_ASL_DBMan::getInstance();

        load_plugin_textdomain( 'nbt-ajax-search', false, ASL_DIR . '/languages' );
    }

    /**
     * Runs on activation
     */
    public function activate() {

        WD_ASL_DBMan::getInstance()->create();

        $this->chmod();

        /**
         * Store the version number after everything is done. This is going to help distinguishing
         * stored asl_version from the ASL_CURR_VER variable. These two are different in cases:
         *  - Uninstalling, installing new versions
         *  - Uploading and overwriting old version with a new one
         */
        update_option('asl_version', ASL_CURRENT_VERSION);
    }

    /**
     *  Checks if the user correctly updated the plugin and fixes if not
     */
    public function safety_check() {
        $curr_stored_ver = get_option('asl_version', 0);

        // Run the re-activation actions if this is actually a newer version
        if ($curr_stored_ver != ASL_CURRENT_VERSION) {
            $this->activate();
            //asl_generate_the_css();
        }
    }

    /**
     * Extra styles if needed..
     */
    public function styles() {
        // Fallback on IE<=8
        if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(?i)msie [6-8]/',$_SERVER['HTTP_USER_AGENT']) ) {
            // Oh, this is IE 8 or below, abort mission
            return;
        }
    }

    /**
     * Prints the scripts
     */
    public function scripts() {

        // ------------ Dequeue some scripts causing issues on the back-end --------------
        wp_dequeue_script( 'otw-admin-colorpicker' );
        wp_dequeue_script( 'otw-admin-select2' );
        wp_dequeue_script( 'otw-admin-otwpreview' );
        wp_dequeue_script( 'otw-admin-fonts');
        wp_dequeue_script( 'otw-admin-functions');
        wp_dequeue_script( 'otw-admin-variables');

        $com_opt = wd_asl()->o['asl_compatibility'];
        $performance_options = wd_asl()->o['asl_performance'];

        $prereq = 'jquery';
        $js_source = $com_opt['js_source'];

        $load_in_footer = w_isset_def($performance_options['load_in_footer'], 1) == 1 ? true : false;
        $load_mcustom = w_isset_def($com_opt['load_mcustom_js'], "yes") == "yes";

        if ($js_source == 'nomin' || $js_source == 'nomin-scoped') {
            if ($js_source == "nomin-scoped") {
                $prereq = "wpnetbase-asljquery";
                wp_register_script('wpnetbase-asljquery', ASL_URL . 'js/' . $js_source . '/asljquery.js', array(), ASL_CURR_VER_STRING, $load_in_footer);
                wp_enqueue_script('wpnetbase-asljquery');
            }
            wp_register_script('wpnetbase-gestures', ASL_URL . 'js/' . $js_source . '/jquery.gestures.js', array($prereq), ASL_CURR_VER_STRING, $load_in_footer);
            wp_enqueue_script('wpnetbase-gestures');
            wp_register_script('wpnetbase-highlight', ASL_URL . 'js/' . $js_source . '/jquery.highlight.js', array($prereq), ASL_CURR_VER_STRING, $load_in_footer);
            wp_enqueue_script('wpnetbase-highlight');
            if ($load_mcustom) {
                wp_register_script('wpnetbase-scroll', ASL_URL . 'js/' . $js_source . '/jquery.mCustomScrollbar.js', array($prereq), ASL_CURR_VER_STRING, $load_in_footer);
                wp_enqueue_script('wpnetbase-scroll');
            }
            wp_register_script('wpnetbase-ajaxsearchlite', ASL_URL . 'js/' . $js_source . '/jquery.ajaxsearchlite.js', array($prereq), ASL_CURR_VER_STRING, $load_in_footer);
            wp_enqueue_script('wpnetbase-ajaxsearchlite');
            wp_register_script('wpnetbase-asl-wrapper', ASL_URL . 'js/' . $js_source . '/asl_wrapper.js', array($prereq, "wpnetbase-ajaxsearchlite"), ASL_CURR_VER_STRING, $load_in_footer);
            wp_enqueue_script('wpnetbase-asl-wrapper');
        } 
        else {
            wp_enqueue_script('jquery');
            wp_register_script('wpnetbase-ajaxsearchlite', ASL_URL . "js/" . $js_source . "/jquery.ajaxsearchlite.min.js", array(), ASL_CURR_VER_STRING, $load_in_footer);
            wp_enqueue_script('wpnetbase-ajaxsearchlite');
        }

        $ajax_url = admin_url('admin-ajax.php');
        if ( w_isset_def($performance_options['use_custom_ajax_handler'], 0) == 1 )
            $ajax_url = ASL_URL . 'ajax_search.php';

        if (strpos($com_opt['js_source'], 'min-scoped') !== false) {
            $scope = "asljQuery";
        } else {
            $scope = "jQuery";
        }

        // @deprecated
        wp_localize_script( 'wpnetbase-ajaxsearchlite', 'ajaxsearchlite', array(
            'ajaxurl' => $ajax_url,
            'backend_ajaxurl' => admin_url( 'admin-ajax.php'),
            'js_scope' => $scope
        ));

        wp_localize_script( 'wpnetbase-ajaxsearchlite', 'ASL', array(
            'ajaxurl' => $ajax_url,
            'backend_ajaxurl' => admin_url( 'admin-ajax.php'),
            'js_scope' => $scope,
            'detect_ajax' => $com_opt['detect_ajax'],
            'scrollbar' => $load_mcustom,
            'version' => ASL_CURRENT_VERSION
        ));

    }

    /**
     *  Tries to chmod the CSS and CACHE directories
     */
    public function chmod() {
        // Nothing to do here yet :)
    }


    /**
     *  If anything we need in the footer
     */
    public function footer() {

    }

    /**
     * Get the instane
     *
     * @return self
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Cloning disabled
     */
    private function __clone() {
    }

    /**
     * Serialization disabled
     */
    private function __sleep() {
    }

    /**
     * De-serialization disabled
     */
    private function __wakeup() {
    }
}