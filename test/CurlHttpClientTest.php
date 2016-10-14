<?php
use openid\CurlHttpClient;
use openid\HttpRequest;
use openid\URL;

class CurlHttpClientTest extends PHPUnit_Framework_TestCase {
	private $curl;
	
	public function __construct() {
		$this->curl = new CurlHttpClient();
		$this->curl->setProxyUrl("");
	}
	
	public function testGet() {
		$req = new HttpRequest(URL::create("https://jsonplaceholder.typicode.com/posts/1"));
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),0);
		$this->assertEquals($resp->getMethod(),"GET");
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}
	
	public function testPost() {
		$data = json_encode(array('title'=>'foo','body'=>'bar','userId'=>1));
		$req = new HttpRequest(URL::create("https://jsonplaceholder.typicode.com/posts"),"POST",$data);
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),strlen($data));
		$this->assertEquals($resp->getMethod(),"POST");
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}
	
	public function testPut() {
		$data = json_encode(array('id'=>1,'title'=>'foo','body'=>'bar','userId'=>1));
		$req = new HttpRequest(URL::create("https://jsonplaceholder.typicode.com/posts/1"),"PUT",$data);
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),strlen($data));
		$this->assertEquals($resp->getMethod(),"PUT");
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}	

	public function testPatch() {
		$data = json_encode(array('title'=>'foo'));
		$req = new HttpRequest(URL::create("https://jsonplaceholder.typicode.com/posts/1"),"PATCH",$data);
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),strlen($data));
		$this->assertEquals($resp->getMethod(),"PATCH");
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}	
	
	public function testDelete() {
		$req = new HttpRequest(URL::create("https://jsonplaceholder.typicode.com/posts/1"),"DELETE");
		
		$resp = $this->curl->sendRequest($req);
		$this->assertEquals($resp->getUploadSize(),0);
		$this->assertEquals($resp->getMethod(),"DELETE");
		$obj = json_decode($resp->getData(),false);
		$this->assertNotNull($obj);
	}		
}
