<?php
if (!class_exists("wpnetbaseTextSmall")) {
    /**
     * Class wpnetbaseTextSmall
     *
     * A 5 characters wide text input field.
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseTextSmall extends wpnetbaseType {
        public function getType() {
            parent::getType();
            echo "<div class='wpnetbaseTextSmall'>";
            if ($this->label != "")
                echo "<label for='wpnetbasetextsmall_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            echo "<input isparam=1 class='small' type='text' id='wpnetbasetextsmall_" . self::$_instancenumber . "' name='" . $this->name . "' value=\"" . stripslashes(esc_html($this->data)) . "\" />";
            echo "
        <div class='triggerer'></div>
      </div>";
        }
    }
}