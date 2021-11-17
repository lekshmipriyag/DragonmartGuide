<?php
if (!class_exists("wpnetbaseCustomSelect")) {
    /**
     * Class wpnetbaseCustomSelect
     *
     * A customisable drop down UI element.
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseCustomSelect extends wpnetbaseType {
        function getType() {
            parent::getType();
            $this->processData();
            echo "<div class='wpnetbaseCustomSelect'>";
            echo "<label for='wpnetbasecustomselect_" . self::$_instancenumber . "'>" . $this->label . "</label>";
            echo "<select isparam=1 class='wpnetbasecustomselect' id='wpnetbasecustomselect_" . self::$_instancenumber . "' name='" . $this->name . "'>";
            foreach ($this->selects as $sel) {
                if (($sel['value'] . "") == ($this->selected . ""))
                    echo "<option value='" . $sel['value'] . "' selected='selected'>" . $sel['option'] . "</option>";
                else
                    echo "<option value='" . $sel['value'] . "'>" . $sel['option'] . "</option>";
            }
            echo "</select>";
            echo "<div class='triggerer'></div>
      </div>";
        }

        function processData() {
            //$this->data = str_replace("\n","",$this->data);
            $this->selects = array();
            $this->selects = $this->data['selects'];
            $this->selected = $this->data['value'];
        }

        final function getData() {
            return $this->data;
        }

        final function getSelected() {
            return $this->selected;
        }

    }
}