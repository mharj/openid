<?php
use openid\URI;

class URITest extends PHPUnit_Framework_TestCase {
	public function testConst() {
		$uri = new URI();
	}
	public function testParse() {
		$uri = URI::create("https://github.com/mharj/openid/tree/master/src?asd=param#fragments");
		$this->assertEquals($uri->getScheme(),"https");
		$this->assertEquals($uri->getAuthority(),"github.com");
		$this->assertEquals($uri->getPath(),"/mharj/openid/tree/master/src");
		$this->assertEquals($uri->getQuery(),"asd=param");
		$this->assertEquals($uri->getFragment(),"fragments");
		$this->assertEquals($uri->toString(),"https://github.com/mharj/openid/tree/master/src?asd=param#fragments");
		
		$uri = URI::create("https://qwe:asd@github.com/mharj/openid/tree/master/src?asd=param#fragments");
		$this->assertEquals($uri->getScheme(),"https");
		$this->assertEquals($uri->getAuthority(),"github.com");
		$this->assertEquals($uri->getUserInfo(),"qwe:asd");
		$this->assertEquals($uri->getPath(),"/mharj/openid/tree/master/src");
		$this->assertEquals($uri->getQuery(),"asd=param");
		$this->assertEquals($uri->getFragment(),"fragments");	
		$this->assertEquals($uri->toString(),"https://qwe:asd@github.com/mharj/openid/tree/master/src?asd=param#fragments");
		
		// TODO: handle opaque URI:s
#		$uri = URI::create("mailto:java-net@java.sun.com");
#		$this->assertEquals($uri->getScheme(),"mailto");
#		$this->assertEquals($uri->getAuthority(),"java-net@java.sun.com");
		
#		mailto:java-net@java.sun.com	
#		news:comp.lang.java	
#		urn:isbn:096139210x
#		http://java.sun.com/j2se/1.3/
#		docs/guide/collections/designfaq.html#28
#		../../../demo/jfc/SwingSet2/src/SwingSet2.java
#		file:///~/calendar		
	}	
}
