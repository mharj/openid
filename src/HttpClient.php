<?php
namespace openid;

abstract class HttpClient {
	abstract function sendRequest(HttpRequest $req): HttpResponse;
	abstract function close();
	abstract function isOpen(): bool;
}
