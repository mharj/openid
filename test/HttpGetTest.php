<?php

use openid\HttpGet;

class HttpGetTest extends PHPUnit_Framework_TestCase {
	public function testConst() {
		$get = new HttpGet("http://www.google.com");
		$this->assertEquals($get->getMethod(),'GET');
	}
}
