<?php

class Foxtons_co_uk {
	
	public function parse($search)
	{
		global $flats;
		global $flats_check_duplicate;
	
		$rss = fetch_rss($search);

		foreach ( $rss->items as $item ) {
			$title = explode(' ', $item['title']);
			$rent  = round((int)substr($title[0], 1) * 4.33);
			$rent_to_salary  = round($rent/MONTHLY_INCOME, 2) * 100;
			array_splice($title, 0, 3);
			$title = implode(' ', $title);
			$coordinates = explode(' ', $item['georss']['point']);
			for ( $i = 0; $i <= 1; $i++ ) { $coordinates[$i] = (float)$coordinates[$i]; }
	
			if ( ! isset($flats_check_duplicate[$item['guid']]) && ! $this->exclude_ad($item['description']) && ! isset($exclude[sha1($item['guid'])]) ) {
				// Add to results
				$hash = sha1($item['guid']);
				$flats[] = array(
					'title' 		=> $title,
					'rent'			=> $rent,
					'hash'			=> $hash,
					'url'			=> $item['guid'],
					'description'		=> $item['description'],
					'coordinates'		=> $coordinates,
					'icon'			=> get_rent_icon($rent, isset($starred[$hash]), $rent_to_salary),
					'rent_level'	=> get_rent_level($rent),
					'rent_ratio'	=> $rent_to_salary,
					'starred'		=> isset($starred[$hash])
				);
				$flats_check_duplicate[$item['guid']] = true;			
			}	
		}
	}
	
	private function exclude_ad($description)
	{
		if ( preg_match('/(first floor)|(ground floor)/', $description) ) {
			return true;
		}
		return false;	
	}
	
}

?>