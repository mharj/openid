<?php
namespace openid;

abstract class HttpClient {
	protected $proxy = null;
	protected $validCertificate = true;
	abstract function sendRequest(HttpRequest $req): HttpResponse;
	abstract function close();
	abstract function isOpen(): bool;
	public function setProxyUrl(string $proxy) {
		$this->proxy = $proxy;
	}
	public function checkValidCertificate(bool $validCertificate) {
		$this->validCertificate = $validCertificate;
	}
}
