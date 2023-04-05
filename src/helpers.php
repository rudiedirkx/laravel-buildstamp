<?php

function fresh_asset(string $path) : string {
	$url = asset($path);
	if (strpos($url, '?_') === false) {
		$url .= '?_' . config('app.buildstamp');
	}
	return $url;
}
