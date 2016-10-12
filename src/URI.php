<?php
namespace openid;

class URI {
	private $scheme;
	private $authority;
	private $path;
	private $query;
	private $fragment;
	private $userInfo;
	
	function __construct($scheme = null,$authority = null,$path = null,$query = null,$fragment = null) {
		$this->scheme = $scheme;
		$this->authority = $authority;
		$this->path = $path;
		$this->query = $query;
		$this->fragment = $fragment;
	}
	
	function getScheme() {
		return $this->scheme;
	}
	
	function getAuthority() {
		return $this->authority;
	}
	
	function getPath() {
		return $this->path;
	}
	
	function getQuery() {
		return $this->query;
	}
	
	function getFragment() {
		return $this->fragment;
	}
	
	function getUserInfo() {
		return $this->userInfo;
	}
	
	function toString() {
		return ($this->scheme!=null?$this->scheme.'://':'').($this->userInfo!=null?$this->userInfo.'@':'').($this->authority!=null?$this->authority:'').($this->path!=null?$this->path:'').($this->query!=null?'?'.$this->query:'').($this->fragment!=null?'#'.$this->fragment:'');
	}
	
	public static function create(string $uri) {
		$ins = new URI();
		$ins->parse($uri);
		return $ins;
	}
	
	private function parse(string $uri) {
		if ( preg_match("/^(.*?):/",$uri,$match) ) {
			$this->scheme = $match[1];
			$uri = substr($uri, (strlen($this->scheme)+1) , strlen($uri));
		}
		if ( preg_match("/^\/\/(.*?)[\/,$]/",$uri,$match) ) {
			$this->authority=$match[1];
			$uri = substr($uri, (strlen($this->authority)+2) , strlen($uri));
			if ( preg_match("/^(.*?)@(.*?)$/",$this->authority,$sub) ) {
				$this->authority = $sub[2];
				$this->userInfo = $sub[1];
			}
		}
		if ( preg_match("/^(.*?)($|#|\?)/",$uri,$match) ) {
			$this->path=$match[1];
			$uri = substr($uri, strlen($this->path) , strlen($uri));
		}
		if ( preg_match("/^\?(.*?)($|#)/",$uri,$match) ) {
			$this->query=$match[1];
			$uri = substr($uri, (strlen($this->query)+1) , strlen($uri));
		}
		if ( preg_match("/^#(.*?)$/",$uri,$match) ) {
			$this->fragment=$match[1];
		}
	}
	
}
