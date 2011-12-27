<?php
	include_once("db.class.php");  
	date_default_timezone_set( 'America/Chicago' );
	$db = db::getInstance();
	$oldStatus = $db->Query("SELECT * FROM serverStatus",false,"assoc_array");
	foreach ($oldStatus as $os){
		$serverId = $db->Query("SELECT id FROM server WHERE name='".$os["name"]."';",false,"row");
		if($serverId != 0){
			$db->Query("INSERT INTO status (dt,status,server_id,population) VALUES('".$os["dt"]."','".$os["status"]."','".$serverId."','".$os["population"]."');");
			echo $db->Lastsql;	
		}
	}
