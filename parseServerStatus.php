<?php
	include_once("db.class.php");  
	date_default_timezone_set( 'America/Chicago' );
	$db = db::getInstance();
	$url = "http://www.swtor.com/server-status";
	$doc = new DOMDocument();
	@$doc->loadHTMLFile($url);
	$record = $doc->getElementsByTagName('div');

	function defaultAction(){
		$db = db::getInstance();
		$servers = $db->Query("SELECT name,type,timezone from serverStatus group by name;",false,"assoc_array");
		foreach ($servers as $k=>$s){
			$sql = "INSERT INTO serverStatus VALUES(NOW(),'DOWN','".$s["name"]."','0','".$s["type"]."','".$s["timezone"]."');";
			echo $sql."<br/>";
			$db->Query($sql);
		}
	}
	if (!is_null($record)) { // You have a page that works
		foreach ($record as $r) {
			if($r->attributes->getNamedItem("data-status")){
				$status = $r->attributes->getNamedItem("data-status")->nodeValue;
				$name = $db->Clean($r->attributes->getNamedItem("data-name")->nodeValue);
				$pop = $r->attributes->getNamedItem("data-population")->nodeValue;
				if($pop > 5)$pop = 0;
				if($pop < 0)$pop = 0;
				$type = $r->attributes->getNamedItem("data-type")->nodeValue;
				if($r->attributes->getNamedItem("data-timezone")){
					$location = $r->attributes->getNamedItem("data-timezone")->nodeValue;	
				}else{
					$location = $r->attributes->getNamedItem("data-language")->nodeValue;
				}
				$db->Query("INSERT INTO serverStatus VALUES(NOW(),'".$status."','".$name."','".$pop."','".$type."','".$location."');");
				echo $db->Lastsql."<br/>";
			}else{
				defaultAction();
			}
		}
	}else{ // something went wrong and lets account for it
		defaultAction();
	}