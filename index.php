<?php
/*
Plugin Name: Modern Media AWS S3
Plugin URI: http://modernmedia.co
Description: Automatically copies media uploads to Amazon S3 for storage and delivery.
Author: Chris Carson
Version: 0.1
Author URI: http://modernmedia.co
*/
use ModernMedia\AWSS3\AWSS3Plugin;
define('MODERN_MEDIA_AWS_S3_PATH', __DIR__);
AWSS3Plugin::inst();