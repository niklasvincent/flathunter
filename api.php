<?php

/**
 * Read configuration
 * Edit config-example.php and rename it
 *
 * @author Niklas Lindblad
 */
require_once 'config.php';

/**
 * Load libraries
 *
 * @author Niklas Lindblad
 */
require_once 'lib/URLNormalizer.php';
require_once 'lib/db.php';
require_once 'lib/functions.php';
require_once 'lib/currency.func.php';

define('MAGPIE_DIR', 'lib/vendor/magpierss/');
require_once MAGPIE_DIR . '/rss_fetch.inc';

/**
 * Exclude and favorite list from DB
 *
 * @author Niklas Lindblad
 */
$exclude = $flats->getIgnoreList();
$starred = $flats->getStarredList();

// Results
$loaded_parsing_modules = array();
$flats = array();
$flats_check_duplicate = array();

foreach ( $searches as $search ) {
	
	$parser = load_parsing_module($search);
	
	if ( $parser != null ) {
		$parser->parse($search);
	}
	
}

echo json_encode($flats);
?>