<?php
if (!class_exists("wpnetbaseYesNo")) {
    /**
     * Class wpnetbaseYesNo
     *
     * Displays an ON-OFF switch UI element. Same as wpnetbaseOnOff
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseYesNo extends wpnetbaseType {
        function getType() {
            parent::getType();
            echo "<div class='wpnetbaseYesNo" . (($this->data == 1) ? " active" : "") . "'>";
            echo "<label for='wpnetbasetext_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            //echo "<a class='wpnetbaseyesno" . (($this->data == 1) ? " yes" : " no") . "' id='wpnetbaseyesno_" . self::$_instancenumber . "' name='" . $this->name . "_yesno'>" . (($this->data == 1) ? "YES" : "NO") . "</a>";
            echo "<input isparam=1 type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
            echo "<div class='wpnetbaseYesNoInner'></div>";
            echo "<div class='triggerer'></div>";
            echo "</div>";
        }
    }
}