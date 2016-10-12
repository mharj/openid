<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace openid;

/**
 * Description of HttpRequestBase
 *
 * @author marko
 */
abstract class HttpRequestBase implements HttpUriRequest {
	private $uri;
	
	public function __construct() {
		
	}
	
	public function getURI(): URI {
        return $this->uri;
    }
	
	public function setURI(URI $uri) {
        $this->uri = $uri;
    }
	
	public function toString():string  {
        return getMethod() + " " + getURI() + " " + getProtocolVersion();
    }
}
