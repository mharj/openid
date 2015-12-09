<?php
namespace openid;

class OpenIDNonce {
	const Auth_OpenID_Nonce_CHRS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	const Auth_OpenID_Nonce_REGEX = '/(\d{4})-(\d\d)-(\d\d)T(\d\d):(\d\d):(\d\d)Z(.*)/';
	const Auth_OpenID_Nonce_TIME_FMT = '%Y-%m-%dT%H:%M:%SZ';
	const Auth_OpenID_SKEW = 3600; // hour?
	private static function splitNonce($nonce) {
		$result = preg_match(self::Auth_OpenID_Nonce_REGEX, $nonce, $matches);
		if ($result != 1 || count($matches) != 8) {
			throw new OpenIDException("Broken Nonce match");
		}
		list($unused,$tm_year,$tm_mon,$tm_mday,$tm_hour,$tm_min,$tm_sec,$uniquifier) = $matches;
		$timestamp = @gmmktime($tm_hour, $tm_min, $tm_sec, $tm_mon, $tm_mday, $tm_year);
		if ($timestamp === false || $timestamp < 0) {
			throw new OpenIDException("Broken Nonce timestamp");
		}
		$ret = new \stdClass();
		$ret->timestamp = $timestamp;
		$ret->unique = $uniquifier;
		return $ret;
	}
	
	public function checkTimestamp($nonce_string,$allowed_skew = self::Auth_OpenID_SKEW,$now = null) {
		$parts = self::splitNonce($nonce_string);
		if ($now === null) {
	        $now = time();
	    }
		$stamp = $parts->timestamp;
		// Time after which we should not use the nonce
		$past = $now - $allowed_skew;
		// Time that is too far in the future for us to allow
		$future = $now + $allowed_skew;
		// the stamp is not too far in the future and is not too far
		// in the past
		return (($past <= $stamp) && ($stamp <= $future));
	}
	
	
	public static function makeNonce($when = null) {
		$salt = self::randomString(6, self::Auth_OpenID_Nonce_CHRS);
		if ($when === null) {
			$when = time();
		}
		$time_str = gmstrftime(self::Auth_OpenID_Nonce_TIME_FMT, $when);
		return $time_str . $salt;
	}
	
	public static function randomString($length, $population = null) {
        if ($population === null) {
            return self::getBytes($length);
        }
        $popsize = strlen($population);
        if ($popsize > 256) {
			throw new \Exception('More than 256 characters supplied to ' . __FUNCTION__);
		}
		$duplicate = 256 % $popsize;
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			do {
				$n = ord(self::getBytes(1));
			} while ($n < $duplicate);
			$n %= $popsize;
			$str .= $population[$n];
		}
		return $str;
    }
	
    public static function getBytes($num_bytes) {
		$bytes = '';
		for ($i = 0; $i < $num_bytes; $i += 4) {
			$bytes .= pack('L', mt_rand());
		}
        return substr($bytes, 0, $num_bytes);
    }	
}