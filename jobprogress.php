<?php
/*
Plugin Name: jobprogress
Plugin URI: http://example.com
Description: plugin description here.
Version: 1.0
Author: Logiciel solutions
Author URI: http://w3guy.com
*/

define( 'JOBPROGRESS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('API_BASE_URL', 'http://localhost:8000/api/v1');
define('JOBPROGRESS_CLIENT_ID', '123457');
define('JOBPROGRESS_CLIENT_SECRET', 'schs1EKRpLaS1auhTIc25JrlWSjkry1P');
define('JOBPRGRESS_AUTHORIZATION_URL', 'http://jobprogress.dev/api/v1/oauth2/authorization');
define('JOBPRGRESS_DISCONNECT_URL', 'http://jobprogress.dev/api/v1/oauth2/disconnect');
define('JOBPRGRESS_REFRESH_TOKEN_URL', 'http://localhost:8000/api/v1/oauth2/renew_access_token');
define('JOBPRGRESS_REFRESH_TOKEN_GRANT_TYPE', 'refresh_token');
// run the install scripts upon plugin activation
// add_action( 'init', array( 'JobProgress', 'init' ) );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.base-jobprogress.php' );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.jobprogress.php' );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.customer.php' );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.scheduler.php' );
$scheduler = New Scheduler;
$customer = New Customer;
register_activation_hook( __FILE__, array( $customer, 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( $customer, 'plugin_deactivation' ) );

function ine($haystack,$needle){

	return (isset($haystack[$needle]) && !empty($haystack[$needle]));
}

function dd($data = array()) {
	echo "<pre>";
	print_r($data);
	exit;
}


