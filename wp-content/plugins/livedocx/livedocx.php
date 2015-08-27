<?php
/**
 * @package Livedocx
 * @version 1.6
 */
/*
Plugin Name: Livedocx
Plugin URI: https://github.com/zendframework/ZendService_LiveDocx
Description: This plugin make Livedocx service availbale in WP instance
Author: ZendMania
Version: 1.0
Author URI: http://zendmania.elance.com
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'LIVEDOCX_VERSION', '3.0.0' );
define( 'LIVEDOCX__MINIMUM_WP_VERSION', '3.0' );
define( 'LIVEDOCX__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LIVEDOCX__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LIVEDOCX__PLUGIN_VENDOR_DIR', LIVEDOCX__PLUGIN_DIR.'vendor'.DIRECTORY_SEPARATOR );
define( 'LIVEDOCX__PLUGIN_DEMOS_DIR',
	LIVEDOCX__PLUGIN_VENDOR_DIR.
	'zendframework'.DIRECTORY_SEPARATOR.
	'zendservice-livedocx'.DIRECTORY_SEPARATOR.
	'demos'.DIRECTORY_SEPARATOR
);
define( 'LIVEDOCX_DELETE_LIMIT', 100000 );

define( 'LIVEDOCX_FREE_USERNAME', 'evgheni' );
define( 'LIVEDOCX_FREE_PASSWORD', '1234567' );

register_activation_hook( __FILE__, array( 'Livedocx', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Livedocx', 'plugin_deactivation' ) );

require_once( LIVEDOCX__PLUGIN_VENDOR_DIR . 'autoload.php' );
require_once( LIVEDOCX__PLUGIN_DIR . 'class.livedocx-widget.php' );
require_once( LIVEDOCX__PLUGIN_DIR . 'class.livedocx.php' );

add_action( 'init', array( 'Livedocx', 'init' ) );

if ( is_admin() ) {
	require_once( LIVEDOCX__PLUGIN_DIR . 'class.livedocx-admin.php' );
	add_action( 'init', array( 'Livedocx_Admin', 'init' ) );
}

