<?php
namespace openid;

class OpenIDHTTPRequest {
	private $method;
	private $headers = array();
	private $postData;
	private $url;
	
	public function __construct($url,$method=OpenIDHTTPMethod::GET,$postData=null) {
		$this->url = $url;
		$this->method = $method;
		$this->setPayload($postData);
	}
	
	public function getMethod() {
		return $this->method;	
	}
	
	public function getURL() {
		return $this->url;	
	}
	
	public function setPayload($postData) {
		if ( is_array($postData) ) {
			$this->postData = http_build_query($postData);	
		} else {
			$this->postData = $postData;
		}
	}
	
	public function getPayload() {
		return $this->postData;
	}	
	
	public function addHeader($header) {
		$this->headers[]=$header;	
	}
	
	public function getHeaders() {
		return $this->headers;	
	}
}
