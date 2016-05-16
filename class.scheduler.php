<?php 
class Scheduler extends JobProgress {

	public function __construct() {
		$this->crone();
	}

	private function crone(){
		if(! $this->is_connected()) {
			return false;
		}
		add_filter('cron_schedules',array($this, 'my_cron_schedules'));
		if (!wp_next_scheduled('jobprogress_token_refresh_hook')) {
			wp_schedule_event( time(), '10sec', 'jobprogress_token_refresh_hook' );
		}
		add_action( 'jobprogress_token_refresh_hook', array( $this, 'update_token'));
	}

	public function my_cron_schedules($schedules){
	    if(!isset($schedules["10sec"])) {
	    	$schedules["10sec"] = array(
	            'interval' => 10,
	            'display' => __('Once every 10 sec')
	        );
	    }

	    return $schedules;
	}

	protected function update_token() {
		$body = [
			'grant_type'    => JOBPRGRESS_REFRESH_TOKEN_GRANT_TYPE,
			'client_id'     => JOBPROGRESS_CLIENT_ID,
			'client_secret' => JOBPROGRESS_CLIENT_SECRET,
			'refresh_token' => 	$this->get_jobprogres_token()['refresh_token']
		];
		$token = $this->post(JOBPRGRESS_REFRESH_TOKEN_URL, $body);
		if(empty($token)) {
			return false;
		}
		$this->update_access_token($token);
	}
}
?>