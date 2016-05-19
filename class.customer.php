<?php 
class Customer extends JobProgress {

	/**
	 * [$validation_error validation error
	 * @var null
	 */
	public $validation_error = null;

	/**
	 * [$input description]
	 * @var array
	 */
	public $input = array();
	
	/**
	 * 
	 * @return [type] [description]
	 */
	public function __construct() {
		parent::__construct();
		add_shortcode( 'jobprogress_customer_form_code', array($this, 'cf_short_code') );
		add_action( 'admin_menu',array($this, 'jobprogress_admin_page') );
		// $this->apiData();
	}

	/**
	 * customer form show and save customer data
	 * @return [type] [description]
	 */
	public  function cf_short_code() {
		ob_start();
		if(!$this->is_connected()) return false;
		$this->save_customer();
		$this->show_form();
		return ob_get_clean();
	}

	/**
	 * jobprogress admin section menus show on left side
	 * @return [type] [description]
	 */
	public function jobprogress_admin_page() {
		// show customer label on menu list
		add_submenu_page( 
			'jobprogress-admin-page', 
			'Customer Manager', 
			'Customers', 
			'manage_options', 
			'customers', 
			array($this, 'index')
		);
	}

	/**
	 * listing of customer page on index page
	 * @return [type] [description]
	 */
	public function index() {
		$input = $_GET;
		$page_num = isset( $input['page_num'] ) ? absint( $input['page_num'] ) : 1;
		$order   = ine($input, 'order') ? $input['order'] : 'desc';
		$order_by = ine($input, 'order_by') ? $input['order_by'] : 'created_at';
		$limit = 5; // number of rows in page_num
		$offset = ( $page_num - 1 ) * $limit;
		$total = $this->wpdb->get_var( "SELECT COUNT(id) FROM {$this->wpdb->prefix}customers" );
		$num_of_pages = ceil( $total / $limit );
		$sql = "SELECT * FROM {$this->wpdb->prefix}customers";

		if(ine($input, 'date')) {
			$sql .= " where DATE_FORMAT(created_at, '%Y-%m-%d') = '". sanitize_text_field($input['date']) . "'";
		}
		$sql .= " ORDER BY $order_by $order";
		$sql .= " LIMIT $offset, $limit";
		$customers = $this->wpdb->get_results( $sql );
		return require_once( JOBPROGRESS_PLUGIN_DIR . 'customer-index-page.php' );
	}

	/**
	 * Save jobprogress customer 
	 * @return [type] [description]
	 */
	public function save_customer() {
		$nonce = $_POST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'submit_jobprogress_customer_form' ) ) {
		  return false;
		}
		if(isset($_POST) && !empty($_POST)) {
			require_once( JOBPROGRESS_PLUGIN_DIR . 'class.customer-validator.php' );
			$validator = new Customer_Validator;
			if($validator->is_valid()) {
				$input = $_POST;
				$table_name = $this->wpdb->prefix . 'customers';
				require_once( JOBPROGRESS_PLUGIN_DIR . 'class.customer-data-map.php' );
				$customer =  new Customer_Data_Map($input);
				$plugin_input = $customer->get_plugin_input();
				$this->wpdb->insert($table_name, $plugin_input);
				return true;
			}
			$this->validation_error = $validator->get_validation_error();
		}

	}

	/**
	 * show add customer page
	 * @return [html] [show customer page]
	 */
	public function show_form() {
		
		if(($trades = get_transient("jobprogress_trades")) === false) {
			$trades = $this->get(JOBPRGRESS_TRADE_URL);
			set_transient("jobprogress_trades", $trades, 86400);
		}
		$states = $this->get(JOBPRGRESS_STATE_URL);
		if(($states = get_transient("jobprogress_states")) === false ) {
			$states = $this->get(JOBPRGRESS_STATE_URL);
			set_transient("jobprogress_states", $states, 86400);
		}

		if(($countries = get_transient("jobprogress_countries")) === false) {
			$countries = $this->get(JOBPRGRESS_COUNTRY_URL);
			set_transient("jobprogress_countries", $countries, 86400);
		}

		return require_once( JOBPROGRESS_PLUGIN_DIR . 'customer-form-page.php' );
	}

		
	/**
	 * get wrapper of error message
	 * @param  string $code [error code]
	 * @return [html]       [error message ]
	 */
	protected function get_error_wrapper($code = '') {
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
 ?>