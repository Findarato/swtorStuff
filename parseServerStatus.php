<?php
	include_once("db.class.php");  
	date_default_timezone_set( 'America/Chicago' );

	function defaultAction(){
		$db = db::getInstance();
		$servers = $db->Query("SELECT id FROM server ;",false,"assoc");
		foreach ($servers as $k=>$s){
			$db->Query("INSERT INTO status (dt,status,server_id,population) VALUES(NOW(),'DOWN','".$s["id"]."','0');");
			echo $db->Lastsql."Default ACTION!<br/>";
		}
	}
	$db = db::getInstance();
	$url = "http://www.swtor.com/server-status";
	$file = file($url);
	//print_r($file);
	$site = join("",$file);
	$doc = new DOMDocument();
	@$doc->loadHTML($site);
	$records = $doc->getElementsByTagName('div');
	echo $records->length;
	if (!is_null($records)) { // You have a page that works
		foreach ($records as $r) {
			if($r->attributes->getNamedItem("data-status")){ // I can not find the status lets do something
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
				$serverId = $db->Query("SELECT id FROM server WHERE name='".$name."';",false,"row");
				if($serverId == 0){ // this is a new server
					$serverId = $db->Query("INSERT INTO server (name,type,timezone) VALUES ('".$name."','".$type."','".$location."');"  ,false,"row");
				}
				$db->Query("INSERT INTO status (dt,status,server_id,population) VALUES(NOW(),'".$status."','".$serverId."','".$pop."');");
				echo $db->Lastsql."<br/>";
			}
		}
	}else{ // something went wrong and lets account for it
		defaultAction();
	}