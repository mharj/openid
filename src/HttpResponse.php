<?php
namespace openid;

class HttpResponse {
	private $statusCode;
	private $data;
	private $headers = array();
	private $url;
	private $method = null;
	private $uploadSize = 0;
	
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
	public function setMethod(string $method) {
		$this->method = $method;
	}
	public function getMethod() {
		return $this->method;
	}
	public function setUploadSize(int $size) {
		$this->uploadSize = $size;
	}
	public function getUploadSize(): int {
		return $this->uploadSize;
	}	
}
