<?php
  include_once("db.php");  
  //now for the actual processing of the website
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
	function array_smart_implode($array){
		$returnArray = $array;a
		foreach($array as $key=>$value){
			if(is_array($value)){
				if(count($value)==1){
					$returnArray[$key]=$value[0];
				}
			}
		}
		return $returnArray;
	}
	function parseMarc($isbn){
	  $db = db::getInstance();
		preg_match("/([0-9]*)/",$isbn,$matches);
		$isbn = $matches[0];
		$url = "http://catalog.lapcat.org/search~S12?/i".$isbn."/i".$isbn."/1%2C1%2C1%2CE/marc&FF=i".$isbn;
		//$url = "http://catalog.lapcat.org/search/i".$isbn;
		//settings variables
		$cleaned = array("isbn"=>$isbn);
		$a_status = array();
    $cleaned["author"] = 0;
		$cleaned["year"] = 0;
		$cleaned["studio"] = "";
		$cleaned["location"] = "";
		$cleaned["rating"] = "";
		$cleaned["title"] = "";
		$cleaned["description"] = "";
		$cleaned["type"] = "";
		$cleaned["url"] = $url;
		$cleaned["tags"] = array();
		$cleaned["console"] = "";
    $cleaned["numbers"] = "";
    $fiveNineZero = false;
    $nfnz = 0;
		$doc = new DOMDocument();
		@$doc->loadHTMLFile($url);
		
		$marcRecord = $doc->getElementsByTagName('pre');
	//parse the marc record
		if (!is_null($marcRecord)) { //you are not parsing the marc record view
			foreach ($marcRecord as $mr) {
				$mcr = explode("\n",$mr->nodeValue);
				$fixedMCR = array();
				$preIndex = 0;
				foreach($mcr as $mr2){
					if(substr($mr2,0,3)=="   "){ // there is a new row with the same id.
						$fixedMCR[$preIndex][0] .= substr_replace($mr2, " ", 0,7);
					}else{ //this is a new row.
					  $fixedMCR[substr($mr2,0,3)][] = trim(substr_replace($mr2, "", 0,7));
					  $preIndex = substr($mr2,0,3);
					}
				}
				$a_status = $fixedMCR;
			}
		}
		$a_status = array_smart_implode($a_status);
	//	print_r($a_status);
	  //echo "===================\n";
    //echo print_r($a_status);
    echo "\n";
		foreach ($a_status as $key=>$value){
 			switch ($key){
        case "020": case "024"://This should be the ISBN and Standard Number(UPC) field
          $cleanedISBN = "";
          if(is_string($value)){ // if there is only one 020 field we need to account for it
            $cleaned["numbers"] = $value;  
          }else{
            foreach($value as $val){ // lets go though and make sure there is nothing extra being added to the ISBN tag
              $trash = explode(" ",$val);
              $cleanedISBN[]=$trash[0];
            }
            $cleaned["numbers"] = $cleanedISBN;      
          }
        break;
        
        case 100: //This should be the author field
          $split = explode("|", $value);
          preg_match("/([A-Za-z \, \s]*)/",$value,$authorMatches);
          $cleaned["author"] = $authorMatches[0];
        break;


				case 245: //Title of the item
					$split = explode("|", $value);
          //Cloudy with a chance of meatballs|h[Game] :|bfor  Playstation 3. 
          foreach($split as $val){
            switch(substr($val,0,1)){
              case "b":
                preg_match("/([0-9A-Za-z \s]*)/",$val,$subTitleMatches);
                $cleaned["subTitle"] = substr($subTitleMatches[0],1);
                break;
              case "h":
                preg_match("/([0-9A-Za-z \s]*)/",$val,$subTitleMatches);
                $cleaned["subTitleh"] = substr($subTitleMatches[0],1);
                break;                
              case "c":
                preg_match("/([0-9A-Za-z \s]*)/",$val,$subTitleMatches);
                $cleaned["subTitlec"] = substr($subTitleMatches[0],1);
                break;                
              case "p":
                preg_match("/([0-9A-Za-z \s]*)/",$val,$subTitleMatches);
                $cleaned["subTitlep"] = substr($subTitleMatches[0],1);
                break;   
              default:
                preg_match("/([0-9A-Za-z \, \- \s]*)/",$val,$titleMatches);
                $cleaned["title"] = rtrim($titleMatches[0]);

                break;
            }
          }
                    
          //echo "catalog Parsed Title:".$cleaned["title"]."\n";
					if(isset($split[1])){
						switch(substr($split[1], 0,1)){
							case "n":
								if(preg_match("/([Vv]ol\.\s[0-9][0-9])/",substr($split[1], 0),$titleMatches)){$cleaned["volume"] = $titleMatches[0];}
							break;
							default:break;
						}
					}
					
				break;
				case 260:
					$split = explode("|", $value);
					if(preg_match("/([1-9][0-9]{3})/",$value,$matches)){$cleaned["year"] = $matches[0];}
					if(isset($split[1]) && preg_match("/([A-Z|1-9\s][A-Za-z \s]*)/",$split[1],$studioMatches)){$cleaned["studio"] = $studioMatches[0];}
					if(preg_match("/([A-Za-z \s]*)/",$split[0],$locationMatches)){$cleaned["location"] = $locationMatches[0];}
				break;
				
				case 520:
					$cleaned["description"] = $value;
				break;
				
				case 521:
					$cleaned["rating"] = str_replace("ESRB rating:", "", $value);
					$cleaned["rating"] = str_replace("MPAA rating:", "", $cleaned["rating"]);
				break; 
				case 655: case 538: //type
					if(is_array($value)){
						foreach($value as $k=>$v){
							if(preg_match("/([A-Z0-9a-z \s]*)/",$v,$Matches)){$cleaned["type".$key] = $Matches[0];}		
						}
					}else{if(preg_match("/([A-Z0-9a-z \s]*)/",$value,$Matches)){$cleaned["type".$key] = $Matches[0];}}
				break;
				case 590: //this should be the tags field
				  $fiveNineZero = true; 
					//we have to make sure they are separated by , and not ;
					if(is_array($value)){
            $cleanedTags = trim(strtolower(join(",",$value)));
            $cleaned["tagsRaw"] = trim(strtolower($cleanedTags));
					}else{
            $cleanedTags = trim(strtolower($value));  
            $cleaned["tagsRaw"] = trim(strtolower($cleanedTags));
					}
					
					if(!strpos($cleanedTags,";")){
            $cleaned["tags"] = explode(",",$cleanedTags);
					}else{
            $cleaned["tags"] = explode(";",$cleanedTags); 
					}

          $tagIds = array();
          foreach($cleaned["tags"] as $t){
            $tagIds[] = $db->Query("SELECT id FROM lapcat.lapcat_tag WHERE name LIKE '".trim(strtolower($t))."%'",false,"row");
            $tagIds = array_implode($tagIds);
          }
          //echo "--------------catalogTags------------------:\n";
          //print_r($cleaned["tags"]);echo "-------------------End the tags------------\n";
          $tempTags = array();
          foreach ($tagIds as $t){
            if($t>0){
              $tempTags[]=$t;
            }
          }
          $tempTags = array_pad($tempTags,4,"0"); 
          $cleaned["tags"] = $tempTags;
          //$cleaned["tags"] = trim(strtolower($value));
				break;
				case 690: //This is where video games are normally entered
					if(isset($value) && preg_match("/([A-Z0-9a-z \s]*)/",$value,$Matches)){$cleaned["console"] = $Matches[0];}
				break;
				default:break;
			}
		}
   // echo "===================\n\n";
		return $cleaned;	
	}
?>