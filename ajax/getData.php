<?Php
	include_once("../db.class.php");  
	$db = db::getInstance();
	header('Content-type: application/json');
	date_default_timezone_set( 'America/Chicago' );
	
	function array_implode($arrays, &$target = array()) {
		if(is_array($arrays)){
		    foreach ($arrays as $item) {
		        if (is_array($item)) {
		            array_implode($item, $target);
		        } else {
		            $target[] = $item;
		        }
		    }
    	return $target;
		}else {return false;}
	}
	
	
	
	$status = "broke";
	$_GET = $db->Clean($_GET);
	$servers = $db->Query("SELECT id,name,type,timezone FROM server;",true,"assoc_array");
	if(isset($_GET["display"]) && $_GET["display"]=="init"){
		$status = array();
		$status["serverUp"] = 0;
		$count = $db->Query("SELECT COUNT(name) FROM server;",false,"row");
		$status["serverCount"] = intval($count);
		$status["servers"] = $db->Query("SELECT s.dt,s.status,s.server_id,s.population,ser.name,ser.type,ser.timezone FROM status AS s JOIN server AS ser ON(s.server_id=ser.id) ORDER BY s.dt DESC, s.server_id ASC LIMIT ".$count.";",false,"assoc_array");
		foreach($status["servers"] as $s){
			if($s["status"] == "UP"){
				$status["serverUp"]++;				
			}
		}	
		//print_r($db->Error);
	}else{ // a request is being made
		if(isset($_GET["name"])){
			if($_GET["name"] == "type"){
				$types = array("PvE","PVP","RP-PvE","RP-PvP");
				$status = array();
				$status["day"] = array();
				$hours = array();
				$days = array();
				foreach ($types as $t){
					$ids = array_implode($db->Query("SELECT id FROM server WHERE type='".$t."'",true,"row"));
					if(isset($_GET["raw"]) && $_GET["raw"]==true){
						$sql = "SELECT AVG( population ) as pop ,hour( dt ) as hour,server_id FROM status WHERE (DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') AND server_id IN(".join(",",$ids).") GROUP BY hour( dt ),server_id ORDER BY dt;";
						$status["day"][$t] = $db->Query($sql,false,"assoc_array");
						$serverTemp = array();
						foreach ($status["day"][$t] as $k=> $i){
							$serverTemp[$k]["hour"] = $i["hour"];
							$serverTemp[$k]["pop"] += $i["pop"];
						}
						//echo $sql;						
					}else{
						$sql = "SELECT avg( population ) as pop ,hour( dt ) as hour FROM status WHERE (DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') AND server_id IN(SELECT id FROM server WHERE type='".$t."') GROUP BY  hour( dt ) ORDER BY dt;";
						$status["day"][$t] = $db->Query($sql,false,"assoc_array");
					}
	
				}
				
				foreach ($status["day"]["PvE"] as $st){
					$days[] = $st["hour"];
				}
				$status["day"]["title"] = $days;
				
				$status["month"] = array();
				foreach ($types as $t){
					$ids = array_implode($db->Query("SELECT id FROM server WHERE type='".$t."'",true,"row"));
					$sql = "SELECT avg( population ) as pop ,DAY( dt ) as hour FROM status WHERE (MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') AND server_id IN(".join(",",$ids).") GROUP BY  DAY( dt ) ORDER BY dt;";
					$status["month"][$t] = $db->Query($sql,false,"assoc_array");
				}
				foreach ($status["month"]["PvE"] as $st){
					$hours[] = $st["hour"];
					
				}
				$status["month"]["title"] = $hours;
								
			}else{
				if(is_int($_GET["name"])){
					$serverId = $_GET["name"];	
				}else{
					$serverId = $db->Query("SELECT id FROM server WHERE name='".$_GET["name"]."';",false,"row");					
				}
			
				$status = $db->Query("SELECT avg( population ) as pop,hour( dt ) as hour FROM status WHERE server_id='".$serverId."' AND ( DAY(dt) = '".date("j")."' AND MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') GROUP BY server_id,hour( dt ) ;",false,"assoc_array");
				//echo $db->Lastsql;
				$status["month"] = $db->Query("SELECT avg( population ) as pop,DAY( dt ) as hour FROM status WHERE server_id='".$serverId."' AND ( MONTH(dt) = '".date("m")."' AND YEAR(dt) = '".date("Y")."') GROUP BY server_id,DAY( dt ) ;",false,"assoc_array");					
				
			}
			
			if(count($db->Error) == 2){
				$status = $db->Error;
			}	
		}		
	}
	echo json_encode($status);