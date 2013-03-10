<?php

class London_Flats
{
	private $m;
	private $db;

	private $ignore;
	private $starred;
	
	function __construct($name)
	{
		$this->m = new MongoClient();
		$this->db = $this->m->selectDB($name);
		$this->ignore = new MongoCollection($this->db, 'ignore');
		$this->starred = new MongoCollection($this->db, 'starred');
	}

	public function addToIgnore($guid, $reason, $url)
	{
		$this->ignore->insert(array('guid' => $guid, 'reason' => $reason, 'url' => $url));
	}
	
	public function addToStarred($guid, $reason, $url)
	{
		$this->starred->insert(array('guid' => $guid, 'reason' => $reason, 'url' => $url));
	}

	public function getIgnoreList()
	{
		$results = array();
		$cursor = $this->ignore->find();
		foreach ($cursor as $doc) {
			$results[$doc['guid']] = true;
		}
		return $results;
	}

	public function getStarredList()
	{
		$results = array();
		$cursor = $this->starred->find();
		foreach ( $cursor as $doc ) {
			$results[$doc['guid']] = true;
		}
		return $results;
	}

}

$flats = new London_Flats(MONGODB_DB_NAME);

if ( isset($_POST['hide']) ) {
	$flats->addToIgnore($_POST['id'], $_POST['reason'], $_POST['url']);
} else if ( isset($_POST['favorite']) ) {
	$flats->addToStarred($_POST['id'], $_POST['reason'], $_POST['url']);
}


?>