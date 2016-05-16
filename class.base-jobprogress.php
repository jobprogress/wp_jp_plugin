<?php 

class Base_JobProgress {

	public function get($url, $body) {
			$args = array(
			    // 'timeout'     => 5,
			    // 'redirection' => 5,
			    // 'httpversion' => '1.0',
			    // 'user-agent'  => 'WordPress/4.5.1; ' . get_bloginfo( 'url' ),
			    // 'blocking'    => true,
			    'headers'     => $this->getHeader(),
			    'cookies'     => array(),
			    'body'        => null,
			    // 'compress'    => false,
			    // 'decompress'  => true,
			    // 'sslverify'   => true,
			    // 'stream'      => false,
			    // 'filename'    => null
			);
		$response = wp_remote_get( $url, $args );	
		$response_body = wp_remote_retrieve_body( $response );
		$body_array = json_decode($response_body, true);
		return $body_array['data'];
	}

	public function post($url, $body) {
		$args = array(
		    'timeout'     => 5,
		    // 'redirection' => 5,
		    // 'httpversion' => '1.0',
		    // 'blocking'    => true,
		    'headers'     => $this->getHeader(),
		    'body'        => $body,
		); 
		$response =  wp_remote_post( $url, $args );
		$response_body = wp_remote_retrieve_body( $response );
		$body_array = json_decode($response_body, true);
		return $body_array;
	}

	public function request($url, $body, $method = 'GET') {
		$arg = [
			'timeout' => 5,
			'headers' => $this->getHeader(),
			'body'	  => $body,
			'method'  => $method
		];
		$response = wp_remote_request($url, $arg);
		$response_body = wp_remote_retrieve_body( $response );
		$body_array = json_decode($response_body, true);
		
		return $body_array;
	}
	public function getHeader() {
		$jobprogressTokenOption = get_option( 'jobprogress_token_options' );
		$bearerToken =  'Bearer '.$jobprogressTokenOption['access_token'];
		return ['Authorization' => $bearerToken ];
	}
	
}

?>