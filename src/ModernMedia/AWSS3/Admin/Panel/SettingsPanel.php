<?php
namespace ModernMedia\AWSS3\Admin\Panel;
use ModernMedia\AWSS3\AWSS3Plugin;
use ModernMedia\WPLib\Admin\BaseAdminElement;
use ModernMedia\WPLib\Constants;

class SettingsPanel extends BaseAdminElement {
	public function __construct(){
		$init = array(
			'type' => self::TYPE_PANEL,
			'cap' => Constants::USER_ROLE_ADMINISTRATOR,
			'title' => __('AWS S3 Settings'),
		);
		parent::__construct($init);
	}

	protected function html($post_id = null){
		require MODERN_MEDIA_AWS_S3_PATH . '/inc/settings_panel.php';
	}

	protected function on_save($post_id = null){
		AWSS3Plugin::inst()->set_option_aws($_POST);
		$this->message = __('Settings saved!');
	}
} 