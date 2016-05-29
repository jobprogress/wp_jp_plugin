<?php 
class Scheduler extends JobProgress {

	public function __construct() {
		parent::__construct();
		$this->cron_schedules();
	}

	/**
	 * schduler
	 * @return [boolean] [description]
	 */
	private function cron_schedules(){
		if(! $this->is_connected()) {
			return false;
		}
		add_filter('cron_schedules',array($this, 'custom_schedules'));
		if (!wp_next_scheduled('jp_token_refresh_hook')) {
			wp_schedule_event( time(), '10min', 'jp_token_refresh_hook' );
		}
		if(!wp_next_scheduled('jb_customer_sync_hook')) {
			wp_schedule_event( time(), '5min', 'jb_customer_sync_hook' );	
		}
		add_action( 'jp_token_refresh_hook', array( $this, 'update_token'));
		add_action( 'jb_customer_sync_hook', array( $this, 'sync_jp_customer'));

		return true;
	}

	/**
	 * custom schedules
	 * @param  [type] $schedules [description]
	 * @return [array]            [custom_schdules]
	 */
	public function custom_schedules($schedules){
	    if(!isset($schedules["10min"])) {
	    	$schedules = [
	    		'1min' => [
		            'interval' => 600,
		            'display' => __('Once every 10 min')
	    		],
	    		'5min' => [
	    			'interval' => 300,
	    			'display'  => __('once every 5 min')
	    		]
	    	];
	    }

	    return $schedules;
	}

	/**
	 * refresh the access token
	 * @return [type] [description]
	 */
	public function update_token() {
		//file create code is temporary only for scheduler testing
		fopen( JP_PLUGIN_DIR . current_time('timestamp').'token.txt' , "w");
		$body = [
			'grant_type'    => JP_REFRESH_TOKEN_GRANT_TYPE,
			'client_id'     => JP_CLIENT_ID,
			'client_secret' => JP_CLIENT_SECRET,
			'refresh_token' => 	$this->get_access_token()['refresh_token']
		];
		$response = $this->post(JP_REFRESH_TOKEN_URL, $body);
		if(ine($response, 'status') && (int)$response['status'] != 200) {
			return false;
		}
		$token = $response['token'];

		$this->update_access_token($token);
	}

	/**
	 * sync jp customer
	 * @return [type] [description]
	 */
	public function sync_jp_customer() {
		//file create code is temporary only for scheduler testing
		// fopen( JP_PLUGIN_DIR . current_time('timestamp').'customer.txt' , "w");

		$table_name = $this->wpdb->prefix.'customers';
		$sql = "SELECT * FROM $table_name";
		$sql .= " where is_sync = 0";
		$sql .= " LIMIT 0, 5";
		$customers = $this->wpdb->get_results( $sql );
		if(empty($customers)) {
			return false;
		}
		foreach ($customers as $key => $customer) {
			$customer_data =  $this->map_api_data($customer);
			$response = $this->post(JP_ADD_CUSTOMER_URL, $customer_data);
			if(ine($response, 'status') && (int)$response['status'] === 200) {
				$this->wpdb->update( $table_name, 
					[
						 'is_sync'     => 1,
						 'customer_id' => $response['customer']['id']
					], 
					[
						'id' => $customer->id
					]
				);
			}
		}
	}

	/**
	 * Map data for api request
	 * @param  [object] $customer [description]
	 * @return [array]           [description]
	 */
	private function map_api_data($customer) {
		$input['first_name'] = $customer->first_name;
		$input['last_name']  = $customer->last_name;
		$input['company_name'] = $customer->company_name;
		$input['email'] = $customer->email;
		$input['additional_emails'] = json_decode($customer->additional_emails, true);
		$address = json_decode($customer->address, true);
		$input['address'] = $address['address'];
		$input['phones']  = json_decode($customer->phones, true);
		$input['is_commercial'] = $customer->is_commercial;
		if(ine($input, 'billing')) {
			$input['billing'] = $address['billing'];
		}
		$input['billing']['same_as_customer_address'] = (int)$address['same_as_customer_address'];
		$input['job'] = json_decode($customer->job, true);
		return $input;
	}
}
?>