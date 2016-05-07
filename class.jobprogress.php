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
	}

	public  function cf_shortcode() {
		ob_start();
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
			array($this, 'index')
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

	static  function plugin_activation() {
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
		$this->wpdb->query($customer_query);
	}

	static  function plugin_deactivation() {
		$customer_sql = "DROP TABLE ". $wpdb->prefix."customers";
		$this->wpdb->query($customer_sql);	
	}

	
	

}