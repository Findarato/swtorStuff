<?php
	include_once("db.class.php");  
	$db = db::getInstance();
	$url = "http://www.swtor.com/server-status";
	$doc = new DOMDocument();
	@$doc->loadHTMLFile($url);
	$record = $doc->getElementsByTagName('div');
	if (!is_null($record)) { //you are not parsing the marc record view
		foreach ($record as $r) {
			if($r->attributes->getNamedItem("data-status")){
				$status = $r->attributes->getNamedItem("data-status")->nodeValue;
				$name = $db->Clean($r->attributes->getNamedItem("data-name")->nodeValue);
				$pop = $r->attributes->getNamedItem("data-population")->nodeValue;
				$type = $r->attributes->getNamedItem("data-type")->nodeValue;
				if($r->attributes->getNamedItem("data-timezone")){
					$location = $r->attributes->getNamedItem("data-timezone")->nodeValue;	
				}else{
					$location = $r->attributes->getNamedItem("data-language")->nodeValue;
				}
				$db->Query("INSERT INTO serverStatus VALUES(NOW(),'".$status."','".$name."','".$pop."','".$type."','".$location."');");
				print_r($db->Error);
			}
		}
	}

?>