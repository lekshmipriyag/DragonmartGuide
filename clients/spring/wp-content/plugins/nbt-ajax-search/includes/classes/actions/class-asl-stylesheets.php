<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASL_StyleSheets_Action")) {
    /**
     * Class WD_ASL_StyleSheets_Action
     *
     * Handles the non-ajax searches if activated.
     *
     * @class         WD_ASL_StyleSheets_Action
     * @version       1.0
     * @package       AjaxSearchLite/Classes/Actions
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASL_StyleSheets_Action extends WD_ASL_Action_Abstract {

        /**
         * Holds the inline CSS
         *
         * @var string
         */
        private static $inline_css = "";

        /**
         * This function is bound as the handler
         */
        public function handle() {
            if (function_exists('get_current_screen')) {
                $screen = get_current_screen();
                if (isset($screen) && isset($screen->id) && $screen->id == 'widgets')
                    return;
            }

            add_action('wp_head', array($this, 'inlineCSS'), 10, 0);


            // Don't print if on the back-end
            if ( !is_admin() ) {
                $inst = wd_asl()->instances->get(0);
                $asl_options = $inst['data'];
                wp_register_style('wpnetbase-asl-basic', ASL_URL.'css/style.basic.css', array(), ASL_CURR_VER_STRING);
                wp_enqueue_style('wpnetbase-asl-basic');
                wp_enqueue_style('wpnetbase-ajaxsearchlite', ASL_URL.'css/style-'.$asl_options['theme'].'.css', array(), ASL_CURR_VER_STRING);
                wp_register_style('wpnetbase-gf-opensans', '//fonts.googleapis.com/css?family=Open+Sans:300|Open+Sans:400|Open+Sans:700', array(), ASL_CURR_VER_STRING);
                wp_enqueue_style('wpnetbase-gf-opensans');
            }

            self::$inline_css = "
            @font-face {
                font-family: 'aslsicons2';
                src: url('".str_replace('http:',"",plugins_url())."/nbt-ajax-search/css/fonts/icons2.eot');
                src: url('".str_replace('http:',"",plugins_url())."/nbt-ajax-search/css/fonts/icons2.eot?#iefix') format('embedded-opentype'),
                     url('".str_replace('http:',"",plugins_url())."/nbt-ajax-search/css/fonts/icons2.woff2') format('woff2'),
                     url('".str_replace('http:',"",plugins_url())."/nbt-ajax-search/css/fonts/icons2.woff') format('woff'),
                     url('".str_replace('http:',"",plugins_url())."/nbt-ajax-search/css/fonts/icons2.ttf') format('truetype'),
                     url('".str_replace('http:',"",plugins_url())."/nbt-ajax-search/css/fonts/icons2.svg#icons') format('svg');
                font-weight: normal;
                font-style: normal;
            }
            div[id*='ajaxsearchlite'].wpnetbase_asl_container {
                width: ".$asl_options['box_width'].";
                margin: ".wpnetbase_four_to_string($asl_options['box_margin']).";
            }
            div[id*='ajaxsearchliteres'].wpnetbase_asl_results div.resdrg span.highlighted {
                font-weight: bold;
                color: ".$asl_options['highlight_color'].";
                background-color: ".$asl_options['highlight_bg_color'].";
            }
            div[id*='ajaxsearchliteres'].wpnetbase_asl_results .results div.asl_image {
                width: ". $asl_options['image_width'] . "px;
                height: " . $asl_options['image_height'] . "px;
            }
            ";
        }

        /**
         * Echos the inline CSS if available
         */
        public function inlineCSS() {
            if (self::$inline_css != "") {
                ?>
                <style type="text/css">
                    <!--
                    <?php echo self::$inline_css; ?>
                    -->
                </style>
                <?php
            }

            /**
             * Compatibility resolution to ajax page loaders:
             *
             * If the _ASL variable is defined at this point, it means that the page was already loaded before,
             * and this header script is executed once again. However that also means that the ASL variable is
             * resetted (due to the localization script) and that the page content is changed, so ajax search pro
             * is not initialized.
             */
            ?>
            <script type="text/javascript">
                if ( typeof _ASL !== "undefined" && _ASL !== null && typeof _ASL.initialize !== "undefined" )
                    _ASL.initialize();
            </script>
            <?php
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