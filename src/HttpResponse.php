<?php
namespace openid;

class HttpResponse {
	private $statusCode;
	private $data;
	private $headers = array();
	private $url;
	
	public function setStatusCode(int $statusCode) {
		$this->statusCode = $statusCode;
	}
	
	public function setHeaders(array $headers) {
		$this->headers = $headers;
	}
	public function setData($data) {
		$this->data = $data;
	}
}
