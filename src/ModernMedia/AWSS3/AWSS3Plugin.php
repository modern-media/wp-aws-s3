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
		$unique = substr(md5($data['file']), 0, 5);
		$client = $this->get_client();
		$path = dirname($data['file']);
		$filename = basename($data['file']);
		$source_path = WP_CONTENT_DIR . '/uploads/' . $path;
		$opts = $this->get_option_aws();
		$result = $client->putObject(array(
			'Bucket'     => $opts->bucket,
			'Key'        => $unique . '/' . $filename,
			'SourceFile' => $source_path . '/' . $filename,
			'ACL'        => 'public-read',
			'Metadata'   => array(
				'height' => $data['height'],
				'width' => $data['width']
			)
		));
		/** @var \Guzzle\Service\Resource\Model $result */
		$data['s3_url'] = $result->get('ObjectURL');
		Debugger::inst()->add('result', $result);
		foreach($data['sizes'] as $size => $info){
			$result = $client->putObject(array(
				'Bucket'     => $opts->bucket,
				'Key'        => $unique . '/' . $info['file'],
				'SourceFile' => $source_path . '/' . $info['file'],
				'ACL'        => 'public-read',
				'Metadata'   => array(
					'height' => $info['height'],
					'width' => $info['width']
				)
			));
			$data[$size]['s3_url'] = $result->get('ObjectURL');
		}

		wp_get_attachment_image_src()
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