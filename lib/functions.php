<?php

$urlNormalizer = new URLNormalizer();

/**
 * Get icon for a property and color code it for different rent levels
 *
 * @param int $rent 			Monthly rent
 * @param string $starred 		Whether the icon should be starred
 * @param float $rent_ratio 	Rent to income ratio
 * @return string $iconURL		URL to the icon image
 * @author Niklas Lindblad
 */
function get_rent_icon($rent, $starred = false, $rent_ratio)
{
	$colors = array('high' => 'FC2348', 'medium' => 'FFBB00', 'low' => '78CC5C');
	$color = $colors[get_rent_level($rent)];
	$icon = ( ! $starred ) ? 'home' : 'star';
	$rent = CURRENCY_SIGN . $rent . ' (' . $rent_ratio . '%)';
	return sprintf('https://chart.googleapis.com/chart?chst=d_bubble_icon_text_big&chld=%s|bb|%s|%s|000000', $icon, urlencode($rent), $color);
}

/**
 * Determine rent level compared to monthly income
 *
 * @param int $rent 		Monthly rent
 * @return string $level	The rent level ('low', 'medium' or 'high')
 * @author Niklas Lindblad
 */
function get_rent_level($rent)
{
	$level = 'low';
	if ( $rent > HIGH_RENT_LEVEL ) {
		$level = 'high';
	} else if ( $rent > MEDIUM_RENT_LEVEL ) {
		$level = 'medium';
	}
	return $level;
}

/**
 * Load parsing module for RSS feed based on URL
 *
 * @param string $url 	URL of RSS feed
 * @return void
 * @author Niklas Lindblad
 */
function load_parsing_module($url)
{
	global $urlNormalizer;
	global $loaded_parsing_modules;
	
	// Get name of service
	$urlNormalizer->setUrl($url);
	$urlNormalizer->normalize();
	$service = $urlNormalizer->getService();
	
	// Find associated class
	$class = str_replace('.', '_', ucfirst($service));

	/**
	 * Check if the parsing class is already loaded. Create new instance if it is not.
	 *
	 * @author Niklas Lindblad
	 */
	if ( ! isset($loaded_parsing_modules[$class]) ) {
		$classFileName = dirname(__FILE__) . '/modules/' . $class . '.php';
		if ( file_exists($classFileName) ) {
			require_once $classFileName;
			$loaded_parsing_modules[$class] = new $class;
		}
	}
	
	return $loaded_parsing_modules[$class];
}

?>