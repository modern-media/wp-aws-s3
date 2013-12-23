<?php
namespace ModernMedia\AWSS3;
class AWSS3Plugin {

	/**
	 * @var AWSS3Plugin
	 */
	private static $instance;

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
	}

} 