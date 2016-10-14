<?php
namespace openid;

class HttpRequest {
	private $data;
	private $headers = array();
	private $url;
	private $method = "GET";
	public function __construct(URL $url,string $method = "GET",string $data = "") {
		$this->url = $url;
		$this->method = $method;
		$this->data = $data;
	}
	public function getUrl() {
		return $this->url;
	}
	public function getMethod() {
		return $this->method;
	}
	public function setMethod(string $method) {
		$this->method = $method;
	}
	public function getHeaders() {
		return $this->headers;
	}
	public function setData($data) {
		$this->data = $data;
	}
	public function getData() {
		return $this->data;
	}
}
