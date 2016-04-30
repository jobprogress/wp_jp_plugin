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
 

// run the install scripts upon plugin activation
register_activation_hook( __FILE__, array( 'JobProgress', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'JobProgress', 'plugin_deactivation' ) );
add_action( 'init', array( 'JobProgress', 'init' ) );
require_once( JOBPROGRESS_PLUGIN_DIR . 'class.jobprogress.php' );

function get_error_wrapper($code = '') {
	$error = null;
	if(! $error = JobProgress::$validation_error) {
		return false;
	}
	if(! $error->get_error_message($code)) {
		return false;
	}
	
	$id  = str_replace(array('.','_'), '-', $code). '-error';
	$for = str_replace('.', '_', $code).'_error';
 	$html = '<label id='.$id.' class="error" for='.$for.'>';
 	$html .= $error->get_error_message($code);
 	$html .= '</label>';
	return $html;
}

function ine($haystack,$needle){
		
	return (isset($haystack[$needle]) && !empty($haystack[$needle]));
}

function dd($data = array()) {
	echo "<pre>";
	print_r($data);
	exit;
}

