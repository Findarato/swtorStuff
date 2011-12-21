<?php
	include_once("db.php");  

	preg_match("/([0-9]*)/",$isbn,$matches);
	$isbn = $matches[0];
	$url = "http://www.swtor.com/server-status";

	$doc = new DOMDocument();
	@$doc->loadHTMLFile($url);
	
	$record = $doc->getElementsByTagName('div');

	if (!is_null($record)) { //you are not parsing the marc record view
		foreach ($record as $r) {
			echo $r->attributes->getNamedItem("data-status")->nodeValue;
			echo $r->attributes->getNamedItem("data-name")->nodeValue;
			echo $r->attributes->getNamedItem("data-population")->nodeValue;
			echo $r->attributes->getNamedItem("data-type")->nodeValue;
			echo $r->attributes->getNamedItem("data-timezone")->nodeValue;
		}
	}

?>