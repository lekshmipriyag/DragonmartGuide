<?php
if (!class_exists("wpnetbaseHidden")) {
    /**
     * Class wpnetbaseHidden
     *
     * Just a hidden input field.
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseHidden extends wpnetbaseType {
        function getType() {
            echo "<input type='hidden' id='wpnetbasehidden_" . self::$_instancenumber . "' name='" . $this->name . "' value='" . $this->data . "' />";
        }
    }
}