<?php
/*
Plugin Name: jobprogress
Plugin URI: http://example.com
Description: plugin description here.
Version: 1.0
Author: Logiciel solutions
Author URI: http://w3guy.com
*/
define( 'JP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('API_BASE_URL', 'http://jobprogress.dev/api/v1/');
define('JP_CLIENT_ID', '123457');
define('JP_CLIENT_SECRET', 'schs1EKRpLaS1auhTIc25JrlWSjkry1P');
define('JP_AUTHORIZATION_URL', API_BASE_URL.'login_form');
define('JP_DISCONNECT_URL', API_BASE_URL.'logout');
define('JP_REFRESH_TOKEN_URL', API_BASE_URL.'oauth2/renew_access_token');
define('JP_TRADE_URL', API_BASE_URL.'trades');
define('JP_STATE_URL', API_BASE_URL.'states');
define('JP_COUNTRY_URL', API_BASE_URL.'countries');
define('JP_ADD_CUSTOMER_URL', API_BASE_URL.'customers/save_customer_third_party');
define('JP_USER_URL', API_BASE_URL.'company/users/');
define('JP_REFRESH_TOKEN_GRANT_TYPE', 'refresh_token');
define('JP_CUSTOMER_LIMIT_PAGINATION', 10);
define('JP_DELETE_REQUEST', 'Delete');
define('JP_MENU_ICON', 'https://staging.jobprogress.com/app/favicon.ico');

require_once( JP_PLUGIN_DIR . 'class.jp-request.php' );
require_once( JP_PLUGIN_DIR . 'class.jobprogress.php' );
require_once( JP_PLUGIN_DIR . 'class.customer.php' );
require_once( JP_PLUGIN_DIR . 'class.scheduler.php' );

$scheduler = New Scheduler;
$customer  = New Customer;
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

function format_number($number = false) {
	return "(".substr($number, 0, 3).") ".substr($number, 3, 3)."-".substr($number,6);
}