<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2017 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class RsAddonBeforeAfterSlideSettingsAdmin {
	
	protected function init() {
		
		add_filter('revslider_slide_settings_addons', array($this, 'add_addon_settings'), 10, 3);
		
	}
	
	public function add_addon_settings($_settings, $_slide, $_slider) {
		
		// only add to slide editor if enabled from slider settings first
		if($_slider->getParam(static::$_Title . '_enabled', false) == 'true') {

			static::_init($_slider, $_slide);
			
			$_settings[static::$_Title] = array(
			
				'title'		 => 'Before/After',
				'markup'	 => static::$_Markup,
				'javascript' => static::$_JavaScript
			   
			);
			
		}
		
		return $_settings;
		
	}
	
}
?>