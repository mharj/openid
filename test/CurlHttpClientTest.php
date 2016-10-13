<?php
use openid\CurlHttpClient;
use openid\HttpRequest;
use openid\URL;

class CurlHttpClientTest extends PHPUnit_Framework_TestCase {
	public function testConst() {
		$req = new HttpRequest(URL::create("http://ip.jsontest.com/"));
		$curl = new CurlHttpClient();
		$curl->setProxyUrl("");
		$resp = $curl->sendRequest($req);
		$obj = json_decode($resp->getData(),false);
		print_r($obj);
	}
}
