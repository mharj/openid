<?php
namespace openid;

class HttpRequest {
	private $data;
	private $headers = array();
	private $url;
	private $method;
	public function __construct(URL $url) {
		$this->url = $url;
	}
	public function getUrl() {
		return $this->url;
	}
	public function getMethod() {
		return $this->method;
	}
	public function getHeaders() {
		return $this->headers;
	}
	public function getData() {
		return $this->data;
	}
}
