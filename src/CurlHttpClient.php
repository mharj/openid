<?php
namespace openid;

class CurlHttpClient extends HttpClient {
	private $ch = null;
	public function __construct() {
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($this->ch, CURLOPT_FAILONERROR, false);
		curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);
	}
	
	public function close() {
		if ( $this->ch != null ) {
			curl_close($this->ch);
			$this->ch = null;
		}
	}

	public function isOpen(): bool {
		return ($this->ch!=null);
	}

	public function sendRequest(HttpRequest $req): HttpResponse {
		$ret = new HttpResponse();
		curl_setopt($this->ch, CURLOPT_URL, $req->getUrl()->toString() );
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST,$req->getMethod());
		curl_setopt($this->ch, CURLOPT_HTTPHEADER,$req->getHeaders());
		if ( $this->proxy !== null ) {
			curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy);
		}
		if ( $req->getMethod() != "POST" ) {
			curl_setopt($this->ch, CURLOPT_POST, 0);
		} else  {
			curl_setopt($this->ch, CURLOPT_POST, 1);
		}
		if ( empty($req->getData()) ) {
			curl_setopt($this->ch, CURLOPT_POSTFIELDS,array());
		} else {
			if ( is_array($req->getData()) ) {
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($req->getData()) );
			} else {
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $req->getData());
			}
		}
		if ( $this->validCertificate == false ) {
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		$data = curl_exec($this->ch);
		$info = curl_getinfo($this->ch);
		if ( curl_errno($this->ch) ) {
			throw new \Exception("Curl exception: ".curl_error($this->ch));
		}
		$ret->setUrl($info['url']);
		$ret->setStatusCode($info['http_code']);
		$ret->setUploadSize($info['size_upload']);
		if ( isset($info['request_header'])) {
			list($method)=explode(" ",$info['request_header']);
			$ret->setMethod($method);
			$headers = explode("\n",$info['request_header']);
			foreach ( $headers AS $k => $v ) {
				$v = trim($v);
				if ( empty($v) ) {
					unset($headers[$k]);
				}
			}
			$ret->setHeaders($headers);
		}
		$ret->setData($data);
		return $ret;
	}
}
