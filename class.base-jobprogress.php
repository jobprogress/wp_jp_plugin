<?php 

class Base_JobProgress {

	public function get($url) {
			$args = array(
			    'timeout'     => 5,
			    'redirection' => 5,
			    'httpversion' => '1.0',
			    'user-agent'  => 'WordPress/4.5.1; ' . get_bloginfo( 'url' ),
			    'blocking'    => true,
			    'headers'     => $this->getHeader(),
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
		$body_array = json_decode($response_body, true);
		return $body_array['data'];
	}

	public function post($url, $body) {
		$args = array(
		    'timeout'     => 5,
		    'redirection' => 5,
		    'httpversion' => '1.0',
		    'blocking'    => true,
		    'headers'     => $this->getHeader(),
		    'body'        => $body,
		); 
		$response =  wp_remote_post( $url, $args );
		$response_body = wp_remote_retrieve_body( $response );
		$body_array = json_decode($response_body, true);
		return $body_array;
	}

	public function getHeader() {
		return array('Authorization' => "Bearer XKC7bXxCv2qa5dhG5lzlsEd5NfhHwpciiCulcRMi");
	}

}

?>