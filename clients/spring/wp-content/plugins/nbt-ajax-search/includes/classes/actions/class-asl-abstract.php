<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASL_Action_Abstract")) {
    /**
     * Class WD_ASL_Action_Abstract
     *
     * An abstract for mainly ajax handler classes in Ajax Search plugin.
     *
     * @class         WD_ASL_Action_Abstract
     * @version       1.0
     * @package       AjaxSearchLite/Classes/Actions
     * @category      Class
     * @author        Ernest Marcinko
     */
    abstract class WD_ASL_Action_Abstract {

        /**
         * Static instance storage
         *
         * @var self
         */
        protected static $_instance;


        /**
         * Get the instance
         *
         * All shortcode classes must be singletons!
         */

        public static function getInstance() {}

        /**
         * The handler
         *
         * This function is called by the appropriate handler
         */
        abstract public function handle();

        /**
         * Cloning disabled
         */
        protected function __clone() {}

        /**
         * Serialization disabled
         */
        protected function __sleep() {}

        /**
         * De-serialization disabled
         */
        protected function __wakeup() {}

    }
}