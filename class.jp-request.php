<?php 

class JP_Request {

	/**
	 * Get Request
	 * @param  [string] $url [url of api]
	 * @param  array  $body  [body data]
	 * @return [array]       [response of api]
	 */
	public function get($url, $body = array()) {
		$args = array(
		    'headers'     => $this->get_header(),
		    'body'        => $body,
		);
		$response = wp_remote_get( $url, $args );	
		$response_body = wp_remote_retrieve_body( $response );
		$body_array = json_decode($response_body, true);
		return $body_array['data'];
	}

	/**
	 * Post Request
	 * @param  [string] $url [url of api]
	 * @param  array  $body  [body data]
	 * @return [array]       [response of api]
	 */
	public function post($url, $body) {
		$args = array(
		    'timeout'     => 5,
		    'headers'     => $this->get_header(),
		    'body'        => $body,
		); 
		$response =  wp_remote_post( $url, $args );
		$response_body = wp_remote_retrieve_body( $response );
		$body_array = json_decode($response_body, true);
		return $body_array;
	}

	/**
	 * any type of request like GET,POST,DELETE,PUT
	 * @param  [type] $url    [url of api]
	 * @param  [type] $body   [body data]
	 * @param  string $method [GET, DELETE, POST, PUT]
	 * @return [type]         [response of api]
	 */
	public function request($url, $body, $method = 'GET') {
		$arg = [
			'timeout' => 5,
			'headers' => $this->get_header(),
			'body'	  => $body,
			'method'  => $method
		];
		$response = wp_remote_request($url, $arg);
		$response_body = wp_remote_retrieve_body( $response );
		$body_array = json_decode($response_body, true);
		
		return $body_array;
	}

	/**
	 * Authorization Header
	 * @return [array] [header]
	 */
	public function get_header() {
		$jobprogressTokenOption = get_option( 'jobprogress_token_options' );
		$bearerToken =  'Bearer '.$jobprogressTokenOption['access_token'];
		return ['Authorization' => $bearerToken ];
	}
	
}

?>