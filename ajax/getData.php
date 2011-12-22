<?Php

	include_once("../db.class.php");  
	$db = db::getInstance();
	header('Content-type: application/json');
	date_default_timezone_set( 'America/Chicago' );
	$status = "broke";
	$_GET = $db->Clean($_GET);
	if(isset($_GET["display"]) && $_GET["display"]=="init"){
		$count = $db->Query("SELECT COUNT(DISTINCT name) FROM serverStatus;;",false,"row");
		$status = $db->Query("SELECT DISTINCT * FROM serverStatus ORDER BY dt DESC LIMIT ".$count.";",false,"assoc_array");
	}else{ // a request is being made
		if(isset($_GET["name"])){
			if($_GET["name"] == "type"){
				$status = $db->Query("
				SELECT 
					avg( population ) as pop , 
					hour( dt ) as hour,
					type 
				FROM 
					serverStatus 
				WHERE(
					DAY(dt) = '".date("j")."' 
					AND MONTH(dt) = '".date("m")."' 
					AND YEAR(dt) = '".date("Y")."'
				) 
				GROUP BY 
					type, 
					hour( dt );",false,"assoc_array");
			}else{
				$status = $db->Query("SELECT avg( population ) as pop ,name,hour( dt ) as hour FROM serverStatus WHERE name='".$_GET["name"]."' AND ( DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') GROUP BY name,hour( dt );",false,"assoc_array");	
			}
			
			if(count($db->Error) == 2){
				$status = $db->Error;
			}	
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