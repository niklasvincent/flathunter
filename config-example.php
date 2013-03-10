<?php

/**
 * Lat/long for map center
 */
define('GOOGLE_MAP_CENTER', '51.500549, 0.072744');

/**
 * Destination address to consider for Google Transit
 * e.g. the address of your office
 */
define('GOOGLE_MAP_TRANSIT_DEST', 'Some street 12 London');

/**
 * Database name in MongoDB
 */
define('MONGODB_DB_NAME', 'london_flats');

/**
 * Where to cache Yahoo currency look-up
 */
define('CURRENCY_CACHE_FILE', '/tmp/currency_cache');
define('CURRENCY_SIGN', '£');

/**
 * MagpieRSS cache settings
 */
define('MAGPIE_CACHE_DIR', '/tmp/magpie_cache_foxton');
define('MAGPIE_CACHE_ON', 1);

/**
 * Monthly income
 */
define('MONTHLY_INCOME', 1337);

/**
 * Determines how results are color coded after rent.
 * E.g. 75% of income is 'high' and 50% of income is 'medium'
 */
define('HIGH_RENT_LEVEL', MONTHLY_INCOME * 0.75);
define('MEDIUM_RENT_LEVEL', MONTHLY_INCOME * 0.5);

/**
 * RSS URLs to scrape
 */
$searches = array(
	'http://www.foxtons.co.uk/feeds/foxtons_feed.rss?bedrooms_to=1&polyline=k~wyHrpMihDawd%40p%7CMe%7CFiHnug%40&price_from=175&price_to=750&prop_type=flats&result_view=rss&search_type=LL&submit_type=search',
	'http://www.foxtons.co.uk/feeds/foxtons_feed.rss?bedrooms_to=3&polyline=a%7BfyHz%7DO%7BlJahMjh%40kxT%7CoNk%7DA%7C%7DAto_%40&price_to=350&prop_type=flats&result_view=rss&search_type=LL&submit_type=search',
	'http://www.foxtons.co.uk/feeds/foxtons_feed.rss?polyline=yzcyH%60leAcs%40%7Bys%40dgNivIn~Dfiv%40&price_to=500&prop_type=flats&result_view=rss&search_type=LL&submit_type=search',
	'http://www.foxtons.co.uk/feeds/foxtons_feed.rss?bedrooms_to=2&polyline=kk%7BxHxmcAgzDgbxB%60ePscAfk%40v%7C%7CB&price_to=250&prop_type=flats&result_view=rss&search_type=LL&submit_type=search',
	'http://www.foxtons.co.uk/feeds/foxtons_feed.rss?bedrooms_to=1&polyline=mv_yHdcx%40ehRsjDtMox%60%40raSkjN&price_to=350&prop_type=flats&result_view=rss&search_type=LL&submit_type=search'
);

?>