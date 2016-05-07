<?php
class JobProgress extends Base_JobProgress{

	private  $initiated = false;

	public  $validation_error = false;


	public function __construct() {
		$this->init();
	}

	public  function init() {
		header('Access-Control-Allow-Origin: *'); 
		$this->init_hooks();
	}

	/**
	 * Initializes WordPress hooks
	 */
	private function init_hooks() {
		add_action('wp_footer', array($this, 'scripts'));
		add_shortcode( 'jobprogress_customer_form_code', array($this, 'cf_shortcode') );
		add_action( 'admin_menu',array($this, 'jobprogress_admin_page') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_script') );
	}

	public  function cf_shortcode() {
		ob_start();
		$this->save_jobprogress_customer();
		$this->show_customer_form();
		return ob_get_clean();
	}

	public function jobprogress_admin_page() {
		add_menu_page( 
			'My Plugin Options', 
			'JobProgress', 
			'manage_options', 
			'jobprogress-admin-page', 
			array($this, 'my_plugin_options'),
			'https://staging.jobprogress.com/app/favicon.ico',
			6
		);
		add_submenu_page( 
			'jobprogress-admin-page', 
			'Customer Manager', 
			'Customers', 
			'manage_options', 
			'customers', 
			array($this, 'add_customer_options')
		);

	}
		/** Step 3. */
	function my_plugin_options() {
			$url = API_BASE_URL.'/trades';
			$args = array(
			    'timeout'     => 5,
			    'redirection' => 5,
			    'httpversion' => '1.0',
			    'user-agent'  => 'WordPress/4.5.1; ' . get_bloginfo( 'url' ),
			    'blocking'    => true,
			    'headers'     => array('Authorization' => "Bearer XKC7bXxCv2qa5dhG5lzlsEd5NfhHwpciiCulcRMi"),
			    'cookies'     => array(),
			    'body'        => null,
			    'compress'    => false,
			    'decompress'  => true,
			    'sslverify'   => true,
			    'stream'      => false,
			    'filename'    => null
			);
			$response = wp_remote_get( $url, $args );

			$response_body = wp_remote_retrieve_body( $response );

		?>
		<!-- <a onclick="window.open('http://localhost:8000/connect_job_progress', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');">Connect</a> -->
		<a class="jobprogress-connect">Connect</a>
		<?php
		// echo '<a onclick="window.open('http://localhost:8000/connect_job_progress', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');">Share Page</a>";

	}

	function my_enqueue($hook) {
	    // if ( 'edit.php' != $hook ) {
	    //     return;
	    // }
	    echo 'test';exit;
	    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/myscript.js' );
	}
	public function add_customer_options() {
		global $wpdb;
		$input = $_GET;
		$pagenum = isset( $input['pagenum'] ) ? absint( $input['pagenum'] ) : 1;
		$order   = ine($input, 'order') ? $input['order'] : 'desc';
		$order_by = ine($input, 'order_by') ? $input['order_by'] : 'created_at';
		$limit = 5; // number of rows in page
		$offset = ( $pagenum - 1 ) * $limit;
		$total = $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}customers" );
		$num_of_pages = ceil( $total / $limit );
		$sql = "SELECT * FROM {$wpdb->prefix}customers";

		if(ine($input, 'date')) {
			$sql .= " where DATE_FORMAT(created_at, '%Y-%m-%d') = '". $input['date'] . "'";
		}
		$sql .= " ORDER BY $order_by $order";
		$sql .= " LIMIT $offset, $limit";
		$entries = $wpdb->get_results( $sql );
		return require_once( JOBPROGRESS_PLUGIN_DIR . 'customer-index.php' );
	}


	public  function save_jobprogress_customer() {
		if(isset($_POST) && !empty($_POST)) {
			if($this->isFormValid()) {
				global $wpdb;
				$input = $_POST;
				$table_name = $wpdb->prefix . 'customers';
				if(ine($input, 'same_as_customer_address')) {
					$input['billing'] = $input['address'];
				}

				$map_input = $this->map_input_for_api_request($input);
				$response = $this->post(API_BASE_URL.'/customers/save_customer_third_party', $map_input);
				$input['is_sync']  = 0;
				if(ine($response, 'customer'))  {
					$input['is_sync'] = 1;
				}
				$map_input_wordpress = $this->wordpress_map_input($input);
				$wpdb->insert($table_name, $map_input_wordpress);
			}
			return $this->show_customer_form();

		}
		
	} 
	private function wordpress_map_input($input) {
		
		if(ine($input, 'jobprogress_customer_type2')) {
			$input['is_commercial']  = 1;
			$input['company_name']   = $input['company_name_commercial'];
			$input['first_name']    = '';
			$input['last_name']     = '';
		}
		if(ine($input, 'same_as_customer_address')) {
			$input['address']['billing'] = $input['address'];
		} else {
			$input['address']['billing'] = $input['billing'];
		}
		$map_input = [
			'email'             => htmlentities($input['email']),
			'phones'            => json_encode($input['phones'], true),
			'first_name'        => htmlentities($input['first_name']),
			'last_name'         => htmlentities($input['last_name']),
			'company_name'      => htmlentities($input['company_name']),
			'additional_emails' => ! ine($input, 'additional_emails') ? null : json_encode($input['additional_emails']),
			'job'               => !ine($input, 'job') ? null : json_encode($input['job']),
			'address'           => json_encode($input['address']),
			'created_at'        => current_time('mysql'),
			'is_sync'           => $input['is_sync'],
			'is_commercial'     => ine($input,'is_commercial') ? $input['is_commercial']  : 0,
		];
		return $map_input;
	}
	private function map_input_for_api_request($input) {
		if(ine($input, 'jobprogress_customer_type2')) {
			$input['is_commercial'] = 1;
			$input['first_name']   = $input['company_name_commercial'];
			$input['last_name']    = '';
			$input['company_name'] = '';
		}
		$map_input = [
			'email'             => htmlentities($input['email']),
			'phones'            => $input['phones'],
			'first_name'        => htmlentities($input['first_name']),
			'last_name'         => htmlentities($input['last_name']),
			'company_name'      => htmlentities($input['company_name']),
			'additional_emails' => ! ine($input, 'additional_emails') ? null : $input['additional_emails'],
			'job'               => !ine($input, 'job') ? null : $input['job'],
			'address'           => $input['address'],
			'is_commercial'     => $input['is_commercial'],
			'same_as_customer_address' => ine($input, 'same_as_customer_address') ? $input['same_as_customer_address'] : 0,
			'referred_by_type'  => 'website',
			'billing'   =>  $input['billing'],
		];

		if(!ine($input, 'same_as_customer_address')) {
			$map_input['billing'] = $input['address'];
		}

		return $map_input;
	}

	public function get_customers($filter = array()) {
		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'customers';
		$results = $wpdb->get_results($sql , OBJECT );
		return $results;
	}

	 function save_customer_data(){
		// $first_name = sanitize_text_field( $_POST["first_name"] );
		// 	$last_name  = sanitize_text_field( $_POST["last_name"] );
		// 	$email = sanitize_email($_POST["email"]);
		// 	$company_name = sanitize_text_field( $_POST["company_name"] );
		// 	$is_commercial = isset($_POST['jobprogress_customer_type2']) ? $_POST['jobprogress_customer_type2'] : 0;
		// 	$job = isset($_POST['customer_job']) ? $_POST['customer_job'] : [];
		// 	$address = $_POST['address'];
		// 	if(isset($_POST['same_as_billing']) && !empty($_POST['same_as_billing'])) {
		// 		$billing = $address;
		// 	}else {
		// 		$billing = $_POST['billing'];
		// 	}
	}
	 function isFormValid() {
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

		if( ($is_commercial) && ( sanitize_text_field($_POST['company_name_commercial']) === '') ) {
			$error->add('company_name_commercial', 'Please enter the company name.');
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
		

		// if(sanitize_text_field($_POST['address']['address']) === '')	{
		// 	$error->add('address.address', 'Please enter the address.');
		// 	$hasError = true;
		// } 
		// if(sanitize_text_field($_POST['address']['city']) === '')	{
		// 	$error->add('address.city', 'Please enter the city.');
		// 	$hasError = true;
		// } 
		// if(sanitize_text_field($_POST['address']['state_id']) === '')	{
		// 	$error->add('address.state', 'Please enter the state.');
		// 	$hasError = true;
		// } 
		// if(sanitize_text_field($_POST['address']['zip']) === '') {
		// 	$error->add('address.zip', 'Please enter the zip.');
		// 	$hasError = true;
		// } 
		// if(sanitize_text_field($_POST['address']['country_id']) === '')	{
		// 	$error->add('address.country', 'Please enter the country.');
		// 	$hasError = true;
		// }
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

		// if(!ine($_POST, 'same_as_customer_address')) {
		// 	if(sanitize_text_field($_POST['billing']['country_id']) === '') {
		// 		$error->add("billing.country", 'please enter the country.');
		// 		$hasError = true;
		// 	}
		// 	if(sanitize_text_field($_POST['address']['state_id']) === '')	{
		// 		$error->add("billing.state", 'Please enter the state.');
		// 		$hasError = true;
		// 	} 
		// 	if(sanitize_text_field($_POST['billing']['address']) === '')	{
		// 		$error->add("billing.address", 'Please enter the address.');
		// 		$hasError = true;
		// 	} 
		// 	if(sanitize_text_field($_POST['billing']['city']) === '') {
		// 		$error->add("billing.city", 'Please enter the city.');
		// 		$hasError = true;
		// 	} 
		// 	if(sanitize_text_field($_POST['billing']['zip']) === '') {
		// 		$error->add("billing.zip", 'Please enter the zip.');
		// 		$hasError = true;
		// 	} 
		// }

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
		$this->validation_error = $error;
		if($hasError) {

			return false;
		}

		return true;

	}

	public  function show_customer_form() {
		$trades = $this->get(API_BASE_URL.'/trades');
		$states = $this->get(API_BASE_URL.'/states');
		$countries = $this->get(API_BASE_URL.'/countries');
		return require_once( JOBPROGRESS_PLUGIN_DIR . 'customer-form.php' );
	}

	/**
	 * Add  jQuery Validation script on customers
	 */
	public  function scripts() {
		wp_register_script(
			'jquery-validate',
			plugin_dir_url( __FILE__ ) . 'js/jquery.validate.js',
			array('jquery'),
			'1.15.0',
			true
		);

		wp_enqueue_script(
			'custom',
			plugin_dir_url( __FILE__ ) . 'js/custom.js',
			array('jquery-validate')
		);

		wp_enqueue_script(
			'custom',
			plugin_dir_url( __FILE__ ) . 'js/customer-validation.js',
			array('jquery-validate')
		);

		wp_enqueue_style(
			'jquery-validate',
			plugin_dir_url( __FILE__ ) . 'css/style.css',
			array(),
			'1.0'
		);
	}

	public function admin_script($hook){
		if((string)$hook != 'toplevel_page_jobprogress-admin-page') {
			return false;
		}
		wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/myscript.js' );
	}

	static  function plugin_activation() {
		global $wpdb;
		$customer_query = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."customers(
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  first_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  last_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  company_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  email varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  additional_emails varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  address text NOT NULL,
			  phones text,
			  is_sync tinyint(1) NOT NULL DEFAULT '0',
			  is_commercial tinyint(1) NOT NULL DEFAULT '0',
			  created_at timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
			  job text NULL,
			  PRIMARY KEY (id)
			)";
		$wpdb->query($customer_query);
	}

	static  function plugin_deactivation() {
		global $wpdb;
		$customer_sql = "DROP TABLE ". $wpdb->prefix."customers";
		$wpdb->query($customer_sql);	
	}

	function get_error_wrapper($code = '') {
		$error = null;
		if(! $this->validation_error) {
			return false;
		}
		if(! $this->validation_error->get_error_message($code)) {
			return false;
		}
		
		$id  = str_replace(array('.','_'), '-', $code). '-error';
		$for = str_replace('.', '_', $code).'_error';
	 	$html = '<label id='.$id.' class="error" for='.$for.'>';
	 	$html .= $this->validation_error->get_error_message($code);
	 	$html .= '</label>';
		return $html;
	}
	

}