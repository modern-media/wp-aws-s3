<?php
namespace ModernMedia\AWSS3;
use Aws\S3\S3Client;
use ModernMedia\AWSS3\Admin\Panel\SettingsPanel;
use ModernMedia\AWSS3\Data\AWSKeys;

class AWSS3Plugin {

	const OK_AWS_KEYS = 'modern_media_aws_keys';
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

	/**
	 * @return AWSKeys
	 */
	public function get_option_aws_keys(){
		$o = get_option(self::OK_AWS_KEYS);
		if (! $o instanceof AWSKeys){
			$o = new AWSKeys;
		}
		return $o;
	}

	/**
	 * @param $arr
	 */
	public function set_option_aws_keys($arr){
		$o = new AWSKeys($arr);
		update_option(self::OK_AWS_KEYS, $o);
	}

} 