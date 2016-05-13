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
// run the install scripts upon plugin activation
// add_action( 'init', array( 'JobProgress', 'init' ) );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.base-jobprogress.php' );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.jobprogress.php' );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.customer.php' );

$jobprogress = New JobProgress;
register_activation_hook( __FILE__, array( $jobprogress, 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( $jobprogress, 'plugin_deactivation' ) );
$customer = New Customer;


function ine($haystack,$needle){
		
	return (isset($haystack[$needle]) && !empty($haystack[$needle]));
}

function dd($data = array()) {
	echo "<pre>";
	print_r($data);
	exit;
}

