<?php
namespace openid;

class HttpGet extends HttpRequestBase {
	public static $METHOD_NAME = "GET";
	
	public function __construct($uri = null) {
		parent::__construct();
		if ( $uri != null ) {
			if ( $uri instanceof URI ) {
				$this->setURI($uri);
			}
			if ( is_string($uri) ) {
				$this->setURI(URI::create($uri));
			}
		}
	}


	public function getMethod(): string {
		return self::$METHOD_NAME;
	}

	public function isAborted(): bool {
		
	}

	public function abort() {
		
	}

}
