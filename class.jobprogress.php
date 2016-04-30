<?php
class JobProgress {

	private static $initiated = false;

	public static $validation_error = false;

	private 
	public static function init() {
		// if ( ! self::$initiated ) {
			self::init_hooks();
		// }
	}

	/**
	 * Initializes WordPress hooks
	 */
	public static function init_hooks() {
		self::$initiated = true;
		add_action('wp_footer', array('JobProgress', 'scripts'));
		add_shortcode( 'jobprogress_customer_form_code', array('JobProgress', 'cf_shortcode') );
	}

	public static function cf_shortcode() {
		ob_start();
		JobProgress::save_jobprogress_customer();
		JobProgress::show_customer_form();
		return ob_get_clean();
	}

	public static function save_jobprogress_customer() {
		if(isset($_POST) && !empty($_POST)) {
			if(self::isFormValid()) {
				
			}
			return self::show_customer_form();

		}
		
	} 

	static function save_customer_data(){
		// $first_name = sanitize_text_field( $_POST["first_name"] );
		// 	$last_name  = sanitize_text_field( $_POST["last_name"] );
		// 	$email = sanitize_email($_POST["email"]);
		// 	$company_name = sanitize_text_field( $_POST["company_name"] );
		// 	$is_commercial = isset($_POST['jobprogress_customer_type2']) ? $_POST['jobprogress_customer_type2'] : 0;
		// 	$job = isset($_POST['customer_job']) ? $_POST['customer_job'] : [];
		// 	$address = $_POST['address'];
		// 	if(isset($_POST['same_as_billing_address']) && !empty($_POST['same_as_billing_address'])) {
		// 		$billing_address = $address;
		// 	}else {
		// 		$billing_address = $_POST['billing_address'];
		// 	}
	}
	static function isFormValid() {
		$is_commercial = 0;
		$hasError = false;
		$error = new WP_Error;
		if(ine($_POST, 'jobprogress_customer_type2')) {
			$is_commercial = 1;
		}

		if(!isset($_POST['jobprogress_customer_type1']) && !isset($_POST['jobprogress_customer_type2'])) {
			$error->add('customer_type', 'This field is required.');
			$hasError = true;
		}

		if( ($is_commercial) && ( sanitize_text_field($_POST['company_name']) === '') ) {
			$error->add('company_name', 'Please enter the company name.');
			$hasError = true;
		} 
		if (! $is_commercial && (sanitize_text_field($_POST['first_name']) === '')) {
			$error->add('first_name', 'Please enter the first name.');
			$hasError = true;
		}
		if (! $is_commercial && (sanitize_text_field($_POST['last_name']) === '')) {
			$error->add('last_name', 'Please enter the last name.');
			$hasError = true;
		} 
		 if(sanitize_text_field($_POST['email']) === '' ) {
			$error->add('email', 'Please enter the email.');
			$hasError = true;
		} else {
			if(! filter_var(sanitize_text_field($_POST['email']), FILTER_VALIDATE_EMAIL))	{
				$error->add('email', 'The email must be a valid email address.');
				$hasError = true;
			}
		}
		

		if(sanitize_text_field($_POST['address']['address']) === '')	{
			$error->add('address.address', 'Please enter the address.');
			$hasError = true;
		} 
		if(sanitize_text_field($_POST['address']['city']) === '')	{
			$error->add('address.city', 'Please enter the city.');
			$hasError = true;
		} 
		if(sanitize_text_field($_POST['address']['state']) === '')	{
			$error->add('address.state', 'Please enter the state.');
			$hasError = true;
		} 
		if(sanitize_text_field($_POST['address']['zip']) === '') {
			$error->add('address.zip', 'Please enter the zip.');
			$hasError = true;
		} 
		if(sanitize_text_field($_POST['address']['country']) === '')	{
			$error->add('address.country', 'Please enter the country.');
			$hasError = true;
		}
		if(isset($_POST['additional_emails']) 
			&& !empty($additional_emails = $_POST['additional_emails']) ) {
			foreach ($additional_emails as $key => $additional_email) {
				if(! $additional_email) {
					$error->add("additional_emails.$key", 'Please enter the additional email.');
					$hasError = true;
					continue;
				}
				if(! filter_var($additional_email, FILTER_VALIDATE_EMAIL))	{
					$error->add("additional_emails.$key", 'The additional email must be a valid email 
					address.');
					$hasError = true;
				}
			}
		}

		if(!ine($_POST, 'same_as_customer_address')) {
			if(sanitize_text_field($_POST['billing_address']['country']) === '') {
				$error->add("billing_address.country", 'please enter the country.');
				$hasError = true;
			}
			if(sanitize_text_field($_POST['address']['state']) === '')	{
				$error->add("billing_address.state", 'Please enter the state.');
				$hasError = true;
			} 
			if(sanitize_text_field($_POST['billing_address']['address']) === '')	{
				$error->add("billing_address.address", 'Please enter the address.');
				$hasError = true;
			} 
			if(sanitize_text_field($_POST['billing_address']['city']) === '') {
				$error->add("billing_address.city", 'Please enter the city.');
				$hasError = true;
			} 
			if(sanitize_text_field($_POST['billing_address']['zip']) === '') {
				$error->add("billing_address.zip", 'Please enter the zip.');
				$hasError = true;
			} 
		}

		if(count($_POST['phones'])) {
			$phones = array_filter($_POST['phones']);

			foreach ($phones as $key => $value) {

				if(! ine($value, 'label')) {
					$error->add("phones.$key.label", 'Please choose the phone label.');
					$hasError = true;
				}
				if(! ine($value, 'number')) {
					$error->add("phones.$key.number", 'This field is required.');
					$hasError = true;
					continue;
				}
				if(!is_numeric($value['number'])) {
					$error->add("phones.$key.number", 'The phone must be a number.');
					$hasError = true;
					continue;
				}
				if(strlen($value['number']) > 10) {
					$error->add("phones.$key.number", 'The phone number may not be greater than 10 digit.');
					$hasError = true;
				} 
				if(strlen($value['number']) < 10) {
					$error->add("phones.$key.number", 'The phone number may not be less than than 10 
					digit.');
					$hasError = true;
				}
			}
		}
		Self::$validation_error = $error;
		// echo "<pre>";
		// print_r($error);
		// exit;
		if($hasError) {

			return false;
		}

		return true;

	}
	public static function show_customer_form() {
		return require_once( JOBPROGRESS_PLUGIN_DIR . 'customer-form.php' );
	}

	/**
	 * Add  jQuery Validation script on customers
	 */
	public static function scripts() {
		wp_register_script(
			'jquery-validate',
			plugin_dir_url( __FILE__ ) . 'js/jquery.validate.js',
			array('jquery'),
			'1.15.0',
			true
		);

		// wp_enqueue_script(
		// 	'custom',
		// 	plugin_dir_url( __FILE__ ) . 'js/custom.js',
		// 	array('jquery-validate')
		// );

		wp_enqueue_style(
			'jquery-validate',
			plugin_dir_url( __FILE__ ) . 'css/style.css',
			array(),
			'1.0'
		);
	}

	public static function plugin_activation() {
		global $wpdb;
		$customer_query = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."customers(
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  first_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  last_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  company_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  email varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  additional_emails varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  address text NOT NULL,
			  job text,
			  is_commercial tinyint(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12;";

		$wpdb->query($customer_query);
	}

	public static function plugin_deactivation() {
		global $wpdb;
		$customer_sql = "DROP TABLE ". $wpdb->prefix."customers";
		$wpdb->query($customer_sql);	
	}

	

}