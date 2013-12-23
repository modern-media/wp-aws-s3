<?php
namespace ModernMedia\AWSS3\Admin\Panel;
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
		echo 'Hello';
	}
} 