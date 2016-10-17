<?php
use openid\OpenIDConfig;

class OpenIDConfigTest extends PHPUnit_Framework_TestCase {
	public function testCons() {
		$config = new OpenIDConfig('https://accounts.google.com/');
		$this->assertEquals($config->getDomainUri(),'https://accounts.google.com/');
		$this->assertEquals($config->getResponseType(),OpenIDConfig::RESP_NONE);
	}
}
