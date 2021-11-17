<?php
if (!class_exists("wpnetbaseColorPickerDummy")) {
    /**
     * Class wpnetbaseColorPickerDummy
     *
     * A dummy colorpicker for using inside other elements. This does not have a frontend trigger method,
     * so it can't be changed by the themeChooser class.
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseColorPickerDummy extends wpnetbaseType {
        function getType() {
            $this->data = wpnetbase_admin_hex2rgb($this->data);
            $this->name = $this->name . "_colorpicker";
            echo "<span class='wpnetbaseColorPicker'>";
            if ($this->label != "")
                echo "<label for='wpnetbasecolorpicker_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            echo "<input type='text' class='color' id='" . $this->name . "' id='wpnetbasecolorpicker_" . self::$_instancenumber . "'  name='" . $this->name . "' id='wpnetbasecolorpicker_" . self::$_instancenumber . "' value='" . $this->data . "' />";
            echo "<div class='triggerer'></div>
      </span>";
        }
    }
}