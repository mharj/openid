<?php
namespace openid;

abstract class OpenIDService implements OpenIDServiceInterface {
	const SERVICE_URI = null;
	private $code = null;
	private static $instance = array();
	private $accessToken = null;
	private $openIdConfig = null;
	protected $validCert = true;
	protected $ch = null;
	
	protected function __construct($code,$openIdConfig) {
		$this->code = $code;
		$this->openIdConfig = $openIdConfig;
	}
	
	public static function getInstance($code,$openIdConfig) {
		$class = get_called_class();
		if (! isset(self::$instance[$class]) ) {
			self::$instance[$class] = new $class($code,$openIdConfig); 
		}
		return self::$instance[$class];
	}
	
	public function haveValidSSL($validCert=true) {
		$this->validCert = $validCert;
	}
	
	public function haveTokens() {
		return ($this->accessToken !== null);	
	}
	
	public function setTokens($accessToken) {
		$this->accessToken = $accessToken;	
	}
	
	public function getAccessToken() {
		return $this->accessToken;	
	}
	
	protected function httpQuery($URL,array $headers,$post,$method=null) {
		if ( $this->accessToken == null ) {
				throw new OpenIDException("Missing access token!");
		}
		$headers[]='Authorization: '.$this->accessToken->token_type.' '.$this->accessToken->access_token;
		$data = $this->curlLoader($URL,$headers,$post,$method);
		return $data;
	}
	
	public function getBearer() {
		return substr($this->accessToken->access_token,0,30)."...";
	}
	
	// curl wrapper
	private function curlLoader($url,array $header=null,$post=null,$method=null) {
		if ( $this->ch == null ) {
			$this->ch = curl_init();
		}
		curl_setopt($this->ch, CURLOPT_URL, $url);		
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		if ( $method != null ) {
			curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);		
		}
		if ( $header != null ) {
			curl_setopt($this->ch, CURLOPT_HTTPHEADER,$header);
		}
		curl_setopt($this->ch, CURLOPT_PROXY, $this->openIdConfig->getHttpProxy() );
		if ( $post == null ) {
			curl_setopt($this->ch, CURLOPT_POST, 0);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS,null);
		} else  {
			curl_setopt($this->ch, CURLOPT_POST, 1);
			if ( is_array($post) ) {
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($post) );
			} else {
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post);
			}
		}
		if ( $this->validCert == false ) {
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($this->ch, CURLOPT_FAILONERROR,false);
		$return = curl_exec($this->ch);
		if( $return === false ) {
			throw new OpenIDException(curl_error($this->ch));
		}
		return $return;
	}	
	
	protected function httpLoader(OpenIDHTTPRequest $req) {
		$req->addHeader('Authorization: '.$this->accessToken->token_type.' '.$this->accessToken->access_token);
		return $this->curlLoader( $req->getURL() , $req->getHeaders() , $req->getPayload() , $req->getMethod() );
	}
} 
