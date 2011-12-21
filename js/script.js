/* Author: Joseph Harry

*/
var Priority_string = {
	1:{"id":1,"name":"Light"},
	2:{"id":2,"name":"Standard"},
	3:{"id":3,"name":"Heavy"},
	4:{"id":4,"name":"Very Heavy"},
	5:{"id":5,"name":"Full"}
 }
var newUserTpl = 
	$("<div/>",{"class":"ticketBox insideBorder roundAll4 border-all-Main-1 newTicketTpl"})
		.html(
			$("<div/>",{id:"userDisplay","class":"ticketItem"})
				.append( // Ticket Priority
					$("<div/>",{"class":"ticketPriorityBox colorMain-2 border-all-B-1 roundAll2","html":"",id:"ticketPriority"})
				)
				.append( //Ticket Title
					$("<div/>",{"class":"ticketTitleBox ticketTitle",id:"title"}).html("Title of the ticket")
				)

		);
		
var newPermissionTpl = $("<div/>",{"class":" colorMain-2 border-all-B-1 roundBottomRight4 ticketCategoryBox",id:"permInfo"}).html("On: Aug. 8, 1982")


swtor = {
	"loadAllServers":function(){
			Tlb = $("#statusTable");
			$.getJSON("ajax/getData.php",{"display":"init"},function(json){
				var display = $("<div/>");
				$.each(json,function(i,data){
					//alert(data.name)
					var userDisplay = newUserTpl.clone();
					//Params.allPermissions = json.data.allPermissions;
						userDisplay.find("#title").attr("id","title"+data.name).html(
							$("<div/>")
								.html(
									$("<a/>",{"html":data.name,"href":"/swtorStuff/"+data.name})
								)
						)
						
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","20px").attr("id",data.name+"_Perm"+data.status).removeClass("roundBottomRight4").addClass("roundBottomRight8").html(
							data.status
						);
						userDisplay.find("#userDisplay").append(tempHolder)
						tempHolder = newPermissionTpl.clone();
						//alert(data.population)
						tempHolder.css("width","auto").removeClass("roundBottomRight4").html(data.population);
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","auto").removeClass("roundBottomRight4").html(data.type);
						userDisplay.find("#userDisplay").append(tempHolder)
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","auto").removeClass("roundBottomRight4").html(data.timezone);
						userDisplay.find("#userDisplay").append(tempHolder)
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","auto").removeClass("roundBottomRight4").html(data.dt);
						userDisplay.find("#userDisplay").append(tempHolder)
						
						userDisplay.find("#ticketPriority").attr("id","ticketPriority-"+data.name).html(
				    		function(i,html){
				     			if(data.population>0){
				       				if(data.population>5){data.population = data.population-5;}
				       				result = $("<div/>",{"title":Priority_string[data.population].name}).addClass("pSquare p"+Priority_string[data.population].name.replace(" ",""));
								}else{result = Priority_string[0].name;}
								return result;
				    		})							
						
						display.append(userDisplay);
				});

					Tlb.append(display);
			});	
	},"test":"cool"
};

swtor.loadAllServers();
//admin.loadAllUsers()

window.onpopstate = function(event) { 
  //alert("location: " + document.location + ", state: " + JSON.stringify(event.state)); 
  alert("pop")
  if($(".fakeDropDown")){$(".fakeDropDown").replaceWith();} 
};

















