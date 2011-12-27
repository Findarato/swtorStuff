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
	
	
	$oldStatus = $db->Query("SELECT * FROM serverStatus",false,"assoc_array");
	foreach ($oldStatus as $os){
		$serverId = $db->Query("SELECT id FROM server WHERE name='".$os["name"]."';",false,"row");
		if($serverId != 0){
			$db->Query("INSERT INTO status (dt,status,server_id,population) VALUES('".$os["dt"]."','".$os["status"]."','".$serverId."','".$s["population"]."');");
			echo $db->Lastsql;	
		}
	}
