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
	public function getData(): string {
		return $this->data;
	}
	public function setData($data) {
		$this->data = $data;
	}
	public function setUrl(string $url) {
		$this->url = $url;
	}
}
