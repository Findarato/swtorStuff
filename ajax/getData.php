<?Php
	include_once("../db.class.php");  
	$db = db::getInstance();
	header('Content-type: application/json');
	date_default_timezone_set( 'America/Chicago' );
	$status = "broke";
	$_GET = $db->Clean($_GET);
	$servers = $db->Query("SELECT id,name,type,timezone FROM server;",false,"assoc_array");
	if(isset($_GET["display"]) && $_GET["display"]=="init"){
		$count = $db->Query("SELECT COUNT(name) FROM server;",false,"row");
		$status = $db->Query("SELECT s.dt,s.status,s.server_id,s.population,ser.name,ser.type,ser.timezone FROM status AS s JOIN server AS ser ON(s.server_id=ser.id) ORDER BY s.dt DESC, s.server_id ASC LIMIT ".$count.";",false,"assoc_array");
		//print_r($db->Error);
	}else{ // a request is being made
		if(isset($_GET["name"])){
			if($_GET["name"] == "type"){
				$types = array("PvE","PVP","RP-PvE","RP-PvP");
				$status = array();
				$hours = array();
				foreach ($types as $t){
					$sql = "SELECT avg( population ) as pop ,hour( dt ) as hour FROM status WHERE type='".$t."' AND (DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') GROUP BY  hour( dt ) ORDER BY server_id;";
					$status[$t] = $db->Query($sql,false,"assoc_array");
				}
				foreach ($status["PvE"] as $st){
					$hours[] = $st["hour"];
				}
				$status["hours"] = $hours;
			}else{
				if(is_int($_GET["name"])){
					$serverId = $_GET["name"];	
				}else{
					$serverId = $db->Query("SELECT id FROM server WHERE name='".$_GET["name"]."';",false,"row");					
				}
				$status = $db->Query("SELECT avg( population ) as pop,hour( dt ) as hour FROM status WHERE server_id='".$serverId."' AND ( DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') GROUP BY server_id,hour( dt ) ;",false,"assoc_array");	
			}
			
			if(count($db->Error) == 2){
				$status = $db->Error;
			}	
		}		
	}
	echo json_encode($status);