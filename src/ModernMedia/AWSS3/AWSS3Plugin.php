<?php
namespace ModernMedia\AWSS3;
use ModernMedia\AWSS3\Admin\Panel\SettingsPanel;

class AWSS3Plugin {

	/**
	 * @var AWSS3Plugin
	 */
	private static $instance;

	private $settings_panel;

	/**
	 * @return AWSS3Plugin
	 */
	public static function inst(){
		if (! self::$instance instanceof AWSS3Plugin){
			self::$instance = new AWSS3Plugin;
		}
		return self::$instance;
	}

	private function __construct(){
		$this->settings_panel = new SettingsPanel;
	}

} 