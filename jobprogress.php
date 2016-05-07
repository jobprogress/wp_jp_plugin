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

// run the install scripts upon plugin activation
// add_action( 'init', array( 'JobProgress', 'init' ) );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.base-jobprogress.php' );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.jobprogress.php' );

register_activation_hook( __FILE__, array( 'JobProgress', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'JobProgress', 'plugin_deactivation' ) );
$jobProgress = New JobProgress;


function ine($haystack,$needle){
		
	return (isset($haystack[$needle]) && !empty($haystack[$needle]));
}

function dd($data = array()) {
	echo "<pre>";
	print_r($data);
	exit;
}

