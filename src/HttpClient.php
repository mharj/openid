<?php
namespace openid;

abstract class HttpClient {
	protected $proxy = null;
	protected $validCertificate = true;
	protected $timeOut = 10;
	
	abstract function sendRequest(HttpRequest $req): HttpResponse;
	abstract function close();
	abstract function isOpen(): bool;
	
	public function setTimeout(int $timeOut) {
		$this->timeOut = $timeOut;
	}
	
	public function setProxyUrl(string $proxy) {
		$this->proxy = $proxy;
	}
	
	public function checkValidCertificate(bool $validCertificate) {
		$this->validCertificate = $validCertificate;
	}
}
