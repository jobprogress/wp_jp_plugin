<?php
class JobProgress extends Base_JobProgress{

	private  $initiated = false;

	public  $validation_error = false;

	protected $wpdb;

	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->init();
	}

	public  function init() {
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
		$this->update_token();
	}

	private function update_token(){
		if(! $this->is_connected()) {
			return false;
		}

		$body = [
			'grant_type' => JOBPRGRESS_REFRESH_TOKEN_GRANT_TYPE,
			'client_id'  => JOBPROGRESS_CLIENT_ID,
			'client_secret' => JOBPROGRESS_CLIENT_SECRET,
			'refresh_token' => 	$this->get_jobprogres_token()['refresh_token']
		];
		$token = $this->post(JOBPRGRESS_REFRESH_TOKEN_URL, $body);
		if(empty($token)) {
			return false;
		}
		$this->update_access_token($token);
	}
	public  function cf_shortcode() {
		ob_start();
		if(!$this->is_connected()) return false;
		$this->save_customer();
		$this->show_form();
		return ob_get_clean();
	}

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
		add_submenu_page( 
			'jobprogress-admin-page', 
			'Customer Manager', 
			'Customers', 
			'manage_options', 
			'customers', 
			array($this, 'index')
		);

	}
		
	function authorization() {
		//get domain
		$domain = $this->get_domain();

		// $jobprogressTokenOption = get_option( 'jobprogress_token_options' );
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

	function my_enqueue($hook) {
	    // if ( 'edit.php' != $hook ) {
	    //     return;
	    // }
	    
	    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/myscript.js' );
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
			  PRIMARY KEY (id)
			)";
		$this->wpdb->query($customer_query);
	}

	public  function plugin_deactivation() {
		$customer_sql = "DROP TABLE ". $this->wpdb->prefix."customers";
		$this->wpdb->query($customer_sql);	

		if($this->is_connected()) {
			return $this->disconnect();
		}
	}

	private function disconnect() {
		$data = [
			'client_id'		=> JOBPROGRESS_CLIENT_ID,
			'client_secret' => JOBPROGRESS_CLIENT_SECRET,
			'domain'        =>	$this->get_domain()
		];
		$data = $this->request(JOBPRGRESS_DISCONNECT_URL, $data, 'Delete');
		delete_option( 'jobprogress_token_options');
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
	
	private function is_connected() {
		return (get_option( 'jobprogress_token_options' )) ? true : false;
	}

	public function get_jobprogres_token() {
		return get_option( 'jobprogress_token_options' );
	}

	private function update_access_token($token) {
		update_option( 'jobprogress_token_options', $token);
	}
}