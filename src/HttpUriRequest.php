<?php
namespace openid;

interface HttpUriRequest {
	function abort();
	function getMethod(): string;
	function getURI(): URI;
	function isAborted(): bool;
}
