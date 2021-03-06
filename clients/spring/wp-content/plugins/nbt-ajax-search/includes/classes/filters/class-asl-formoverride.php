<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASL_FormOverride_Filter")) {
    /**
     * Class WD_ASL_FormOverride_Filter
     *
     * Handles the default search form layout override
     *
     * @class         WD_ASL_FormOverride_Filter
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Filters
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASL_FormOverride_Filter extends WD_ASL_Filter_Abstract {

        public function handle( $form = "" ) {
            $inst = wd_asl()->instances->get(0);

            if (  $inst['data']['override_search_form'] )
                return do_shortcode("[wpnetbase_ajaxsearch]");

            return $form;
        }

        // ------------------------------------------------------------
        //   ---------------- SINGLETON SPECIFIC --------------------
        // ------------------------------------------------------------
        public static function getInstance() {
            if ( ! ( self::$_instance instanceof self ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
    }
}