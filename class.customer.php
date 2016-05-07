<?php 
class Customer extends JobProgress {

	public $validation_error = false;

	public $input = array();

	public function index() {
		$input = $_GET;
		$pagenum = isset( $input['pagenum'] ) ? absint( $input['pagenum'] ) : 1;
		$order   = ine($input, 'order') ? $input['order'] : 'desc';
		$order_by = ine($input, 'order_by') ? $input['order_by'] : 'created_at';
		$limit = 5; // number of rows in page
		$offset = ( $pagenum - 1 ) * $limit;
		$total = $this->wpdb->get_var( "SELECT COUNT(id) FROM {$this->wpdb->prefix}customers" );
		$num_of_pages = ceil( $total / $limit );
		$sql = "SELECT * FROM {$this->wpdb->prefix}customers";

		if(ine($input, 'date')) {
			$sql .= " where DATE_FORMAT(created_at, '%Y-%m-%d') = '". $input['date'] . "'";
		}
		$sql .= " ORDER BY $order_by $order";
		$sql .= " LIMIT $offset, $limit";
		$entries = $this->wpdb->get_results( $sql );
		return require_once( JOBPROGRESS_PLUGIN_DIR . 'customer-index-page.php' );
	}

	public function save_customer() {
		if(isset($_POST) && !empty($_POST)) {
			require_once( JOBPROGRESS_PLUGIN_DIR . 'class.customer-validator.php' );
			$validator = new Customer_Validator;
			if($validator->is_valid()) {
				$input = $_POST;
				$table_name = $this->wpdb->prefix . 'customers';
				if(ine($input, 'same_as_customer_address')) {
					$input['billing'] = $input['address'];
				}
				$this->input = $input;
				$api_input = $this->map_api_customer_data();
				$response = $this->post(API_BASE_URL.'/customers/save_customer_third_party', $api_input);
				$this->input['is_sync']  = 0;
				if(ine($response, 'customer'))  {
					$this->input['is_sync'] = 1;
				}
				$plugin_input = $this->map_plugin_customer_data($input);
				$this->wpdb->insert($table_name, $plugin_input);
				return true;
			}
			$this->validation_error = $validator->get_validation_error();
		}

	}

	public function show_form() {
		$trades = $this->get(API_BASE_URL.'/trades');
		$states = $this->get(API_BASE_URL.'/states');
		$countries = $this->get(API_BASE_URL.'/countries');
		return require_once( JOBPROGRESS_PLUGIN_DIR . 'customer-form-page.php' );
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



	private function map_inputs($map) {
		$ret = array();

    	// empty the set default.
    	if(empty($input)) {
    		$input = $this->input;
    	}

    	foreach ($map as $key => $value) {
			if(is_numeric($key)){
				$ret[$value] = isset($input[$value]) ? htmlentities($input[$value]) : "";
			}else{
				$ret[$key] = isset($input[$value]) ? htmlentities($input[$value]) : "";
			}
		}

        return $ret;
	}


	private function map_plugin_customer_data() {
		$map = ['email', 'first_name', 'last_name', 'company_name', 'is_sync'];
		$addressFields = ['address','address_line_1','city','state_id','country_id','zip'];
		$data = $this->map_inputs($map);
		$address['address'] = $this->mapFirstSubInputs($addressFields, 'address');
		if(ine($this->input, 'same_as_customer_address')){
			$address['same_as_customer_address'] = 1;
		} else {
			$address['billing']	= $this->mapFirstSubInputs($addressFields, 'billing');
			$address['same_as_customer_address'] = 0;
		}
		$data['address'] = json_encode($address, true);
		$data['is_commercial'] = 0 ;
		if(ine($this->input, 'jobprogress_customer_type2')) {
			$data['is_commercial']  = 1;
			$data['company_name']   = htmlentities($this->input['company_name_commercial']);
			$data['first_name']    = '';
			$data['last_name']     = '';
		}
		$data['phones'] = json_encode($this->map_phone_inputs(), true);
		$data['additional_emails'] = json_encode($this->map_additional_mail_input(), true);
		$data['created_at'] = current_time('mysql');
		return $data;
	}


	private function map_api_customer_data() {
		$map = ['email', 'first_name', 'last_name', 'company_name', 'same_as_customer_address'];
		$addressFields = ['address','address_line_1','city','state_id','country_id','zip'];
		$data = $this->map_inputs($map);
		$data['address'] = $this->mapFirstSubInputs($addressFields, 'address');
		if(!ine($this->input, 'same_as_customer_address')){
			$data['billing']	= $this->mapFirstSubInputs($addressFields, 'billing');
		}
		$data['referred_by_type'] = 'website';

		if(ine($this->input, 'jobprogress_customer_type2')) {
			$data['is_commercial'] = 1;
			$data['company_name']  = '';
			$data['first_name']    = htmlentities($this->input['company_name_commercial']);
			$data['last_name']     = '';
		}
		$data['phones'] = $this->map_phone_inputs();
		$data['additional_emails'] = $this->map_additional_mail_input();

		return $data;
	}

	/**
     *  Map  Model fields to inputs
     *  @return array of mapped array fields.
     */
    private function mapFirstSubInputs($map, $inputKey){
    	$ret = array();
    	foreach ($map as $key => $value) {
			if(is_numeric($key)){
				$ret[$value] = isset($this->input[$inputKey][$value]) ? htmlentities($this->input[$inputKey][$value]) : "";
			}else{
				$ret[$key] = isset($this->input[$inputKey][$value]) ? htmlentities($this->input[$inputKey][$value]) : "";
			}
		}
        return $ret;
    }

    private function map_phone_inputs() {
    	$phones = $this->input['phones'];
    	$ret = [];
    	foreach ($phones as $key => $phone) {
    		$ret[$key]['label'] = isset($phone['label']) ? htmlentities($phone['label']) : '';
    		$ret[$key]['number'] = isset($phone['number']) ? htmlentities($phone['number']) : '';
    		$ret[$key]['ext'] = isset($phone['ext']) ? htmlentities($phone['ext']) : '';
    	}

    	return $ret;
    }

    private function map_additional_mail_input() {
    	if(! ine($this->input, 'additional_emails')) return false;
    	$ret = [];
    	$additional_emails = $this->input['additional_emails'];
    	foreach ($additional_emails as $key => $value) {
    		$ret[] = htmlentities($value);
    	}

    	return $ret;
    }
}
 ?>