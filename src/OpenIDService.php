<?php
namespace openid;

abstract class OpenIDService implements OpenIDServiceInterface {
	const SERVICE_URI = null;
	private $code = null;
	private static $instance = array();
	private $accessToken = null;
	private $openIdConfig = null;
	protected $validCert = true;
	
	protected function __construct($code,$openIdConfig) {
		$this->code = $code;
		$this->openIdConfig = $openIdConfig;
	}
	
	public static function getInstance($code,$openIdConfig) {
		$class = get_called_class();
        if (! isset(self::$instance[$class]) ) {
        	self::$instance[$class] = new $class($code,$openIdConfig); 
        }
#        echo "<pre>";
#        print_r(self::$instance);
#		echo "</pre>";
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
		$process = curl_init($url); 
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		if ( $method != null ) {
			curl_setopt($process, CURLOPT_CUSTOMREQUEST, $method);		
		}
		if ( $header != null ) {
			curl_setopt($process, CURLOPT_HTTPHEADER,$header);
		}
		curl_setopt($process, CURLOPT_PROXY, $this->openIdConfig->getHttpProxy() );
		if ( $post != null ) {
			curl_setopt($process, CURLOPT_POST, 1);
			if ( is_array($post) ) {
				curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($post) );
			} else {
				curl_setopt($process, CURLOPT_POSTFIELDS, $post);
			}
		}
		if ( $this->validCert == false ) {
			curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
		}
		curl_setopt($process, CURLOPT_TIMEOUT, 10);
		curl_setopt($process, CURLOPT_FAILONERROR,false);
		$return = curl_exec($process);
		if( $return === false ) {
			throw new OpenIDException(curl_error($process));
		}
		curl_close($process);
		return $return;
	}
	
	protected function httpLoader(OpenIDHTTPRequest $req) {
		$req->addHeader('Authorization: '.$this->accessToken->token_type.' '.$this->accessToken->access_token);
		return $this->curlLoader( $req->getURL() , $req->getHeaders() , $req->getPayload() , $req->getMethod() );
	}
} 
