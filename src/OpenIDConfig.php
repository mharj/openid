<?php
namespace openid;
class OpenIDConfig {
	const RESP_CODE='code';
	const RESP_TOKEN='token';
	const RESP_ID_TOKEN='id_token';
	const RESP_CODE_AND_TOKEN='code token';
	const RESP_CODE_AND_ID_TOKEN='code id_token';
	const RESP_TOKEN_AND_ID_TOKEN='token id_token';
	const RESP_CODE_AND_TOKEN_AND_ID_TOKEN='code token id_token';
	const RESP_NONE='none';
	private static $resp_types=array(
		OpenIDConfig::RESP_CODE,
		OpenIDConfig::RESP_TOKEN,
		OpenIDConfig::RESP_ID_TOKEN,
		OpenIDConfig::RESP_CODE_AND_TOKEN,
		OpenIDConfig::RESP_CODE_AND_ID_TOKEN,
		OpenIDConfig::RESP_TOKEN_AND_ID_TOKEN,
		OpenIDConfig::RESP_CODE_AND_TOKEN_AND_ID_TOKEN,
		OpenIDConfig::RESP_NONE
	);
	private $domain_uri;
	private $redirect_uri;
	private $clientID;
	private $clientSecret;
	private $response_type;
	private $http_proxy = null;
	public function __construct($domain_uri,$redirect_uri=null,$clientID=null,$clientSecret=null,$response_type=OpenIDConfig::RESP_NONE) {
		if ( $domain_uri == null ) {
			throw New OpenIDException("empty meta uri");
		}
		if ( ! in_array($response_type,OpenIDConfig::$resp_types)) {
			throw New OpenIDException("unknown response type '".$response_type."'");
		}
		$this->setDomainUri($domain_uri);
		$this->setRedirectUri($redirect_uri);
		$this->setClientId($clientID);
		$this->setClientSecret($clientSecret);
		$this->setResponseType($response_type);
	}
	
	public function setResponseType($response_type) {
		if ( ! in_array($response_type,OpenIDConfig::$resp_types)) {
			throw New OpenIDException("unknown response type '".$response_type."'");
		}
		$this->response_type = $response_type;
	}
	public function getResponseType() {
		return $this->response_type;
	}
	
	public function getDomainUri() {
		return $this->domain_uri;
	}
	public function setDomainUri($uri) {
		$this->domain_uri = $uri;
	}
	
	
	public function getDomainConfigurationUri() {
		return $this->domain_uri.'/.well-known/openid-configuration';
	}
	
	public function setRedirectUri($redirect_uri) {
		$this->redirect_uri = $redirect_uri;
	}
	
	public function getRedirectUri() {
		return $this->redirect_uri;
	}
	
	public function setClientId($clientID) {
		$this->clientID = $clientID;
	}
	public function getClientId() {
		return $this->clientID;
	}
	
	public function setClientSecret($clientSecret) {
		$this->clientSecret = $clientSecret;
	}
	public function getClientSecret() {
		return $this->clientSecret;
	}
	
	public function setHttpProxy($http_proxy) {
		$this->http_proxy = $http_proxy;
	}
	
	public function getHttpProxy() {
		return $this->http_proxy;
	}
}
