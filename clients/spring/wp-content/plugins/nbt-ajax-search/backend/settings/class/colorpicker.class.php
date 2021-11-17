<?php
if (!class_exists("wpnetbaseColorPicker")) {
    /**
     * Class wpnetbaseColorPicker
     *
     * A simple color picker UI.
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseColorPicker extends wpnetbaseType {
        function getType() {
            $this->name = $this->name;
            parent::getType();
            $this->data = wpnetbase_admin_hex2rgb($this->data);
            echo "<div class='wpnetbaseColorPicker'>";
            if ($this->label != "")
                echo "<label for='wpnetbasecolorpicker_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            echo "<input isparam=1 type='text' class='color' id='" . $this->name . "' id='wpnetbasecolorpicker_" . self::$_instancenumber . "'  name='" . $this->name . "' id='wpnetbasecolorpicker_" . self::$_instancenumber . "' value='" . $this->data . "' />";
            //echo "<input type='button' class='wpnetbasecolorpicker button-secondary' value='Select Color'>";
            //echo "<div class='' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>";
            echo "<div class='triggerer'></div>
      </div>";
        }
    }
}
?>