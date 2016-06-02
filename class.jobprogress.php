<?php
class JobProgress extends JP_Request {

	/**
	 * [$wpdb description]
	 * @var [object]
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
		add_action( 'admin_menu',array($this, 'jp_admin_page') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_script') );
	}

	/**
	 * jobprogress admin section menus show on left side
	 * @return [type] [description]
	 */
	public function jp_admin_page() {
		add_menu_page( 
			'JP Options', 
			'JobProgress', 
			'manage_options', 
			'jp_admin_page', 
			array($this, 'authorization'),
			JP_MENU_ICON,
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
			&& ine($_GET, 'user_id')
			&& wp_verify_nonce( $_GET['_wpnonce'], 'jp_connect_form' )
			&& ! $this->is_connected()
		) {
			$jp_token_data = [
				'access_token'  => $_GET['access_token'],
				'refresh_token' => $_GET['refresh_token'],
				'expires_in'    => $_GET['expires_in'],
				'token_type'    => $_GET['token_type']
			];

			update_option('jp_token_options', $jp_token_data);

			$body = [
				'includes[]' => 'company_details'
			];

			// get user detail from jobprogress
			$user = $this->get(JP_USER_URL.$_GET['user_id'] .'?'. http_build_query($body));
			if(ine($user, 'id')) {
				update_option('jp_connected_user', $user);			
			}
		}

		if(ine($_POST, 'disconnect')) {
			$this->disconnect();
		}
		$jp_user = get_option( 'jp_connected_user' );
		if($this->is_connected()) {
			return require_once( JP_PLUGIN_DIR . 'disconnect-form.php' );	
		}

		return require_once( JP_PLUGIN_DIR . 'connect-form.php' );

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

		wp_enqueue_script(
			'select2',
			plugin_dir_url( __FILE__ ) . 'js/select2.min.js',
			array('jquery-validate')
		);

		wp_enqueue_script(
			'mask',
			plugin_dir_url( __FILE__ ) . 'js/jquery.mask.min.js',
			array('jquery-validate')
		);

		wp_enqueue_script(
			'underscore',
			plugin_dir_url( __FILE__ ) . 'js/underscore-min.js',
			array('underscore')
		);

		wp_enqueue_style(
			'select2',
			plugin_dir_url( __FILE__ ) . 'css/select2.min.css',
			array(),
			'1.0'
		);

		wp_enqueue_style(
			'style',
			plugin_dir_url( __FILE__ ) . 'css/style.css',
			array(),
			'1.0'
		);
	}

	/**
	 * add admin script on connect and disconnect page and customer page
	 * @param  [type] $hook [description]
	 * @return [type]       [description]
	 */
	public function admin_script($hook){

		if((string)$hook === 'toplevel_page_jp_admin_page') {
			// wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js' );
			wp_enqueue_script( 'jquery-ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.js' );
			wp_enqueue_script( 'custom-admin-side', plugin_dir_url( __FILE__ ) . 'js/custom-admin-side.js' );
			wp_enqueue_style( 'jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css');
		}
		if((string)$hook === 'toplevel_page_jp_admin_page'
			|| (string)$hook === 'jobprogress_page_jp_customer_page' ) {

			wp_enqueue_style( 'custom', plugin_dir_url( __FILE__ ) . 'css/admin-style.css');
		}

	}

	/**
	 * customer table create on plugin activation
	 * @return [type] [description]
	 */
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
		
	}

	/**
	 * jobprogress detail like accesss token and jobprgress user and cache data clear
	 * @return [type] [description]
	 */
	public  function plugin_deactivation() {
		
		if($this->is_connected()) {
			return $this->disconnect();
		}
	}


	/**
	 * get access token
	 * @return [array] [access token]
	 */
	public function get_access_token() {
		return get_option( 'jp_token_options' );
	}

	/**
	 * check user is connected
	 * @return boolean [true or false]
	 */
	protected function is_connected() {
		return (get_option('jp_token_options')) ? true : false;
	}

	
	/**
	 * update access token
	 * @param  [array] $token [description]
	 * @return [type]        [description]
	 */
	protected function update_access_token($token) {
		update_option( 'jp_token_options', $token);
	}

	/**
	 * plugin task removed
	 * @return [type] [description]
	 */
	private function disconnect() {
		$data = [
			'domain' =>	$this->get_domain()
		];
		$response = $this->request(JP_DISCONNECT_URL, $data, JP_DELETE_REQUEST);
		if(ine($response, 'status') && (int)$response['status'] != 200) {
			return false;
		}
		delete_transient('jp_trades');
		delete_transient('jp_states');
		delete_transient('jp_countries');
		delete_option('jp_token_options');
		delete_option('jp_connected_user');
		wp_clear_scheduled_hook('jp_token_refresh_hook');
		wp_clear_scheduled_hook('jp_customer_sync_hook');
	}

	/**
	 * get domain
	 * @return [url] [site domain]
	 */
	private function get_domain() {
		$domain = ((!empty($_SERVER['HTTPS']) 
				&& $_SERVER['HTTPS'] !== 'off')
				|| $_SERVER['SERVER_PORT'] === 443)
				? 'https://'
				:'http://'
				. $_SERVER['HTTP_HOST'];

		return $domain;
	}

	/**
	 * get redirect url
	 * @return [url] [description]
	 */
	private function get_redirect_url() {
		$url = $this->get_domain().$_SERVER['REQUEST_URI'];
		$url_parts = parse_url($url);
    	$url = $url_parts['scheme'] 
    		. '://' . $url_parts['host'] 
    		. (isset($url_parts['path'])
    		?$url_parts['path']
    		:'');
    		
    	return $url . '?page=jp_admin_page';
	}
}