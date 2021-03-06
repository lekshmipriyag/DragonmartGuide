<?php
if (!class_exists("wpnetbaseCustomPostTypesEditable")) {
    /**
     * Class wpnetbaseCustomPostTypesEditable
     *
     * A custom post types selector UI element with editable titles.
     *
     * @package  wpnetbase/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2014, Ernest Marcinko
     */
    class wpnetbaseCustomPostTypesEditable extends wpnetbaseType {
        function getType() {
            parent::getType();
            $this->processData();
            $this->types = get_post_types(array(
                '_builtin' => false
            ));
            echo "
      <div class='wpnetbaseCustomPostTypesEditable' id='wpnetbaseCustomPostTypesEditable-" . self::$_instancenumber . "'>
        <fieldset>
          <legend>" . $this->label . "</legend>";
            echo '<div class="sortablecontainer" id="sortablecontainer' . self::$_instancenumber . '">
            <p>Available post types</p><ul id="sortable' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->types != null && is_array($this->types)) {
                foreach ($this->types as $k => $v) {
                    if ($this->selected == null || !wd_in_array_r($v, $this->selected)) {
                        echo '<li class="ui-state-default ui-left" style="background: #ddd;">
              <label>' . $k . '</label>
              <input type="text" value="' . $k . '"/>
              </li>';
                    }
                }
            }
            echo "</ul></div>";
            echo '<div class="sortablecontainer"><p>Drag here the post types you want to use!</p><ul id="sortable_conn' . self::$_instancenumber . '" class="connectedSortable">';
            if ($this->selected != null && is_array($this->selected)) {
                foreach ($this->selected as $k => $v) {
                    echo '<li class="ui-state-default ui-left" style="background: #ddd;">
            <label>' . $v[0] . '</label>
            <input type="text" value="' . $v[1] . '"/>
            </li>';
                }
            }
            echo "</ul></div>";
            echo "
         <input isparam=1 type='hidden' value='" . $this->data . "' name='" . $this->name . "'>";
            echo "
         <input type='hidden' value='wpnetbaseCustomPostTypesEditable' name='classname-" . $this->name . "'>";
            echo "
        </fieldset>
      </div>";
        }

        function processData() {
            $this->data = stripslashes(str_replace("\n", "", $this->data));
            if ($this->data != "") {
                $this->_t = explode("|", $this->data);
                foreach ($this->_t as $k => $v) {
                    $this->selected[] = explode(';', $v);
                }
            } else {
                $this->selected = null;
            }
        }

        final function getData() {
            return $this->data;
        }

        final function getSelected() {
            return $this->selected;
        }
    }
}