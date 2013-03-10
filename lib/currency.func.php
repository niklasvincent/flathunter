<?php

define('CURRENCY_CACHE_FILE', '/tmp/currency_cache');

if ( file_exists(CURRENCY_CACHE_FILE) && time() - filemtime(CURRENCY_CACHE_FILE) < 24 * 3600 ) {
	$content = @file_get_contents(CURRENCY_CACHE_FILE);
} else {
	$url = sprintf('http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=%s%s=X', 'GBP', 'SEK');
	$content = @file_get_contents($url);
	file_put_contents(CURRENCY_CACHE_FILE, $content);
}

$data = explode(',', $content);

define('GBP_TO_SEK', (float)$data[1]);

?>
