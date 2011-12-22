<?Php
	include_once("../db.class.php");  
	$db = db::getInstance();
	header('Content-type: application/json');
	date_default_timezone_set( 'America/Chicago' );
	$status = "broke";
	$_GET = $db->Clean($_GET);
	if(isset($_GET["display"]) && $_GET["display"]=="init"){
		$count = $db->Query("SELECT COUNT(DISTINCT name) FROM serverStatus;",false,"row");
		$status = $db->Query("SELECT * FROM serverStatus ORDER BY dt DESC,name ASC LIMIT ".$count.";",false,"assoc_array");
	}else{ // a request is being made
		if(isset($_GET["name"])){
			if($_GET["name"] == "type"){
				$types = array("PvE","PVP","RP-PvE","RP-PvP");
				$status = array();
				$hours = array();
				foreach ($types as $t){
					$sql = "SELECT avg( population ) as pop ,hour( dt ) as hour,type FROM serverStatus WHERE type='".$t."' AND (DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') GROUP BY type, hour( dt ) ORDER BY name;";
					$status[$t] = $db->Query($sql,false,"assoc_array");
				}
				foreach ($status["PvE"] as $st){
					$hours[] = $st["hour"];
				}
				$status["hours"] = $hours;
			}else{
				$status = $db->Query("SELECT avg( population ) as pop ,name,hour( dt ) as hour FROM serverStatus WHERE name='".$_GET["name"]."' AND ( DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') GROUP BY name,hour( dt ) ;",false,"assoc_array");	
			}
			
			if(count($db->Error) == 2){
				$status = $db->Error;
			}	
		}		
	}
	echo json_encode($status);