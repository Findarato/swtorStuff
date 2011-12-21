<?Php

	include_once("../db.class.php");  
	$db = db::getInstance();
	header('Content-type: application/json');


	if(isset($_GET["display"]) && $_GET["display"]=="init"){
		$status = $db->Query("SELECT name,status,population,type,timezone,dt FROM serverStatus GROUP BY name",false,"assoc_array");
	}else{ // a request is being made
		if(isset($_GET["name"])){
			$status = $db->Query("SELECT avg( population ) , name, hour( dt )FROM `serverStatus` WHERE name='".$_GET["name"]."' GROUP BY name, hour( dt )",false,"assoc_array");	
		}
	}

	
	echo json_encode($status);		



	/*
	 * SELECT avg( population ) , name, hour( dt )
FROM `serverStatus`
GROUP BY name, hour( dt )
	 * 
	 * 
	 */