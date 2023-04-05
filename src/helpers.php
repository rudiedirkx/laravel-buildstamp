<?php

function fresh_asset(string $path) : string {
	$url = asset($path);
	if (strpos($url, '?_v=') === false) {
		$url .= '?_v=' . config('app.buildstamp');
	}
	return $url;
}
