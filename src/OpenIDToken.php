<?php
namespace openid;

class OpenIDToken {
	public $header = null;
	public $payload = null;
	public $signature = null;
	public $signedData = null;
	public function __construct($tokenString=null) {
		if ( $tokenString != null ) {
			$token_data  = explode(".",$tokenString);
			$this->header = json_decode(base64_decode($token_data[0]));
			$this->payload = json_decode(base64_decode($token_data[1]));
			$this->signedData = $token_data[0] . "." . $token_data[1];
			$this->signature = OpenIDToken::urlsafeB64Decode($token_data[2]);
		}
	}
	public function getSignature() {
		return $this->signature;
	}
	
	public function getSignedData() {
		return $this->signedData;
	}
	
    private static function urlsafeB64Decode($input) {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
