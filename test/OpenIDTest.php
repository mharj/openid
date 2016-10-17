<?php
use openid\OpenIDConfig;
use openid\OpenID;
use mharj\net\URL;

class OpenIDTest extends PHPUnit_Framework_TestCase {
	public function testOpenIDUrlBuild() {
		$_SERVER['HTTP_HOST']='localhost';
		$_SERVER['REQUEST_URI']='';
		session_id('666');
		$config = new OpenIDConfig('https://accounts.google.com/');
		$oid = new OpenID($config);
		$url = URL::create($oid->getAuthUrl(array('openid','email','profile')));
		$this->assertEquals($url->getScheme(),'https');
		$this->assertEquals($url->getAuthority(),'accounts.google.com');
		$this->assertEquals($url->getPath(),'/o/oauth2/v2/auth');
		parse_str($url->getQuery(),$query);
		$this->assertEquals($query['response_type'],'none');
		$this->assertEquals($query['redirect_uri'],'http://localhost');
	}
}
