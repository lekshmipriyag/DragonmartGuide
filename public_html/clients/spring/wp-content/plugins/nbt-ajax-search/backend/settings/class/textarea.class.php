<?php
if (!class_exists("wpnetbaseTextarea")) {
    /**
     * Class wpnetbaseTextarea
     *
     * A simple textarea field.
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseTextarea extends wpnetbaseType {
        function getType() {
            parent::getType();
            echo "<label style='vertical-align: top;' for='wpnetbasetextarea_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            echo "<textarea id='wpnetbasetextarea_" . self::$_instancenumber . "' name='" . $this->name . "'>" . stripcslashes($this->data) . "</textarea>";
        }
    }
}