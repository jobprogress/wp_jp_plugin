<?php
class JobProgress extends JP_Request {

	/**
	 * [$wpdb description]
	 * @var [type]
	 */
	protected $wpdb;

	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->init_hooks();
	}

	/**
	 * Initializes WordPress hooks
	 */
	private function init_hooks() {
		add_action('wp_footer', array($this, 'scripts'));
		add_action( 'admin_menu',array($this, 'jobprogress_admin_page') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_script') );
	}

	/**
	 * jobprogress admin section menus show on left side
	 * @return [type] [description]
	 */
	public function jobprogress_admin_page() {
		add_menu_page( 
			'My Plugin Options', 
			'JobProgress', 
			'manage_options', 
			'jobprogress-admin-page', 
			array($this, 'authorization'),
			'https://staging.jobprogress.com/app/favicon.ico',
			6
		);
	}
	
	/**
	 * 
	 * @return [type] [description]
	 */
	public function authorization() {
		//get domain
		$domain = $this->get_domain();
		$redirect_url = $this->get_redirect_url();
		if(	ine($_GET, 'access_token')
			&& ine($_GET, 'refresh_token')
			&& ine($_GET, 'expires_in')
			&& ine($_GET, 'token_type')
			&& ! $this->is_connected()
		) {
			$jobprogressTokenData = [
				'access_token'  => $_GET['access_token'],
				'refresh_token' => $_GET['refresh_token'],
				'expires_in'    => $_GET['expires_in'],
				'token_type'    => $_GET['token_type']
			];
			update_option( 'jobprogress_token_options', $jobprogressTokenData);
			return require_once( JOBPROGRESS_PLUGIN_DIR . 'disconnect-form.php' );
		}

		if(ine($_POST, 'disconnect')) {
			$this->disconnect();
		}

		if($this->is_connected()) {
			return require_once( JOBPROGRESS_PLUGIN_DIR . 'disconnect-form.php' );	
		}

		return require_once( JOBPROGRESS_PLUGIN_DIR . 'connect-form.php' );

	}

	private function get_redirect_url() {
		$url = $this->get_domain().$_SERVER['REQUEST_URI'];
		$url_parts = parse_url($url);
    	$url = $url_parts['scheme'] 
    		. '://' . $url_parts['host'] 
    		. (isset($url_parts['path'])
    		?$url_parts['path']
    		:'');
    		
    	return $url . '?page=jobprogress-admin-page';
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

		if((string)$hook === 'toplevel_page_jobprogress-admin-page'
			|| (string)$hook === 'jobprogress_page_customers' ) {
			wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/myscript.js' );
			wp_enqueue_style( 'custom', plugin_dir_url( __FILE__ ) . 'css/admin-style.css'  );
		} 
	}

	public  function plugin_activation() {
			$customer_query = "CREATE TABLE IF NOT EXISTS ".$this->wpdb->prefix."customers(
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
			  customer_id int(10) DEFAULT NULL,
			  PRIMARY KEY (id)
			)";
		$this->wpdb->query($customer_query);
		wp_clear_scheduled_hook('jobprogress_token_refresh_hook');
	}

	public  function plugin_deactivation() {
		// $customer_sql = "DROP TABLE ". $this->wpdb->prefix."customers";
		// $this->wpdb->query($customer_sql);	

		if($this->is_connected()) {
			return $this->disconnect();
		}
	}

	private function disconnect() {
		$data = [
			'domain' =>	$this->get_domain()
		];
		$response = $this->request(JOBPRGRESS_DISCONNECT_URL, $data, 'Delete');
		if(ine($response, 'status') && (int)$response['status'] != 200) {
			return false;
		}
		delete_option( 'jobprogress_token_options');
		wp_clear_scheduled_hook('jobprogress_token_refresh_hook');
		wp_clear_scheduled_hook('jobprogress_customer_sync_hook');
	}

	private function get_domain() {
		$domain = ((!empty($_SERVER['HTTPS']) 
				&& $_SERVER['HTTPS'] !== 'off')
				|| $_SERVER['SERVER_PORT'] === 443)
				? 'https://'
				:'http://'
				. $_SERVER['HTTP_HOST'];

		return $domain;
	}
	
	protected function is_connected() {
		return (get_option( 'jobprogress_token_options' )) ? true : false;
	}

	public function get_jobprogres_token() {
		return get_option( 'jobprogress_token_options' );
	}

	protected function update_access_token($token) {
		update_option( 'jobprogress_token_options', $token);
	}

}