<?php
namespace openid;
include "Math/BigInteger.php";
include "Crypt/Hash.php";
include "Crypt/RSA.php";

use \Crypt_RSA;
use \Math_BigInteger;

class OpenIDCert {
	private $publicKey=null;
	function __construct($data) {
		$this->publicKey = openssl_x509_read($data);
	}
	function __destruct() {
		if ( $this->publicKey === null ) {
			openssl_x509_free($this->publicKey);
		}
	}
	function verify($data, $signature) {
		$status = openssl_verify($data, $signature, $this->publicKey, "sha256");
		if ($status === -1) {
			throw new OpenIDException('Signature verification error: ' . openssl_error_string());
		}
		return $status === 1;
	}
	
	/**
	 * Build PEM from modulus and exponent
	 * TODO: broken!
	 * @param type $certJson have modulus and exponent to create new pub cert
	 * @return string PEM
	 */
	public static function certPemList($certJson) {
		$ret = array();
		foreach ( $certJson->keys AS $k => $v ) {
			$rsa = new Crypt_RSA();
			$modulus = new Math_BigInteger(OpenIDCert::urlSafeB64Decode($v->n), 256);
			$exponent = new Math_BigInteger(OpenIDCert::urlSafeB64Decode($v->e), 256);
			$rsa->loadKey(array('n' => $modulus, 'e' => $exponent));
			$rsa->setPublicKey();
			$ret[$v->kid]=$rsa->getPublicKey()."\n";
		}
		return $ret;
	}
	
	private static function urlSafeB64Decode($b64) {
		$b64 = str_replace(array('-', '_'),array('+', '/'),$b64);
		return base64_decode($b64);
	}
}
