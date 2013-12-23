<?php
namespace ModernMedia\AWSS3;
use Aws\S3\S3Client;
use ModernMedia\AWSS3\Admin\Panel\SettingsPanel;
use ModernMedia\AWSS3\Data\AWSOptions;
use ModernMedia\WPLib\Debugger;

class AWSS3Plugin {

	const OK_AWS_KEYS = 'modern_media_aws_keys';
	/**
	 * @var AWSS3Plugin
	 */
	private static $instance;

	private $settings_panel;

	/**
	 * @var S3Client
	 */
	private $client = null;

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
		add_filter('wp_update_attachment_metadata', array($this, '_filter_wp_update_attachment_metadata'), 10, 2);

	}

	public function  _filter_wp_update_attachment_metadata($data, $post_id){
		Debugger::inst()->add('attachment_metadata', $data);
		return $data;
	}

	/**
	 * @return AWSOptions
	 */
	public function get_option_aws(){
		$o = get_option(self::OK_AWS_KEYS);
		if (! $o instanceof AWSOptions){
			$o = new AWSOptions;
		}
		return $o;
	}

	/**
	 * @param $arr
	 */
	public function set_option_aws($arr){
		$o = new AWSOptions($arr);
		update_option(self::OK_AWS_KEYS, $o);
	}

	/**
	 * @return bool
	 */
	public function is_option_aws_keys_valid(){
		$keys = $this->get_option_aws();
		return ! empty($keys->id) && ! empty($keys->secret);
	}

	/**
	 * @return S3Client
	 */
	public function get_client(){
		if (! $this->client instanceof S3Client){
			$keys = $this->get_option_aws();
			$this->client = S3Client::factory(array(
				'key'    => $keys->id,
				'secret' => $keys->secret
			));
		}
		return $this->client;
	}

} 