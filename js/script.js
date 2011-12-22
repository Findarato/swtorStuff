/* Author: Joseph Harry

*/
var Priority_string = {
	0:{"id":0,"name":"Down"},
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
				Tlb.append(json[0]["dt"])
				var display = $("<div/>");
				$.each(json,function(i,data){
					
					//alert(data.name)
					var userDisplay = newUserTpl.clone();
					//Params.allPermissions = json.data.allPermissions;
						userDisplay.find("#title").attr("id","title"+data.name).html(
							$("<div/>")
								.html(
									$("<a/>",{"class":"fakelink","html":data.name,"href":"#"+data.name})
								)
						)
						
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","50px").attr("id",data.name+"_Perm"+data.status).removeClass("roundBottomRight4").addClass("roundBottomRight8").html(
							data.status
						);
						userDisplay.find("#userDisplay").append(tempHolder)
						tempHolder = newPermissionTpl.clone();
						//alert(data.population)
						tempHolder.css("width","50px").removeClass("roundBottomRight4").html(data.population);
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","50px").removeClass("roundBottomRight4").html(data.type);
						userDisplay.find("#userDisplay").append(tempHolder)
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","50px").removeClass("roundBottomRight4").html(data.timezone);
						userDisplay.find("#userDisplay").append(tempHolder)
						/*
						tempHolder = newPermissionTpl.clone();
						tempHolder.css("width","auto").removeClass("roundBottomRight4").html(data.dt);
						userDisplay.find("#userDisplay").append(tempHolder)
						*/
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
	}
};

swtor.loadAllServers();

function setHash(htbs) {
    if (getHash() != htbs) {
        window.location.hash = htbs;
    }
}

function checkHash(){
	hash = hash = jQuery.makeArray(getHash().split("\/"));
	hash[0] = hash[0].replace("#","")
	$.getJSON("ajax/getData.php",{"name":hash[0]},function(data){
			var values = new Array();
			var lable = new Array();
			$.each(data,function(k,item){
				values[k] = item.pop;
				lable[k] = item.hour;
			})
		
		    var line1 = new RGraph.Line('graph', values);
            line1.Set('chart.background.grid', true);
            line1.Set('chart.linewidth', 5);
            line1.Set('chart.gutter.left', 35);
            line1.Set('chart.ymin', 0);
            line1.Set('chart.ymax', 5);
            line1.Set('chart.scale.decimals',0);
            line1.Set('chart.hmargin', 1);
            if (!document.all || RGraph.isIE9up()) {
                line1.Set('chart.shadow', true);
            }
            line1.Set('chart.tickmarks', null);
            line1.Set('chart.units.post', '');
            line1.Set('chart.colors', ['red', 'green']);
            line1.Set('chart.background.grid.autofit', true);
            line1.Set('chart.background.grid.autofit.numhlines', 10);
            line1.Set('chart.curvy', true);
            line1.Set('chart.curvy.factor', 0.5); // This is the default
            line1.Set('chart.animation.unfold.initial',0);
            line1.Set('chart.labels',lable);
            line1.Set('chart.title',hash[0]);
            
            if (RGraph.isOld()) {
                line1.Draw();
            } else {
                RGraph.Effects.Line.jQuery.Trace(line1);
            }
		
		
		
		
	});

	if(hash[1]){
		alert(hash[1]);
	}
		
	//alert(hash);
}


window.onpopstate = function(event) {
	//alert("location: " + document.location + ", state: " + JSON.stringify(event.state));
	checkHash(); 
}

jQuery(document).ready(function () {
	checkHash();
	$(".fakelink").live("click", function () {
		me = $(this);
		var pageTracker = _gat._getTracker('UA-27871949-1');
		switch(me.attr("id")){
			case "topperUserInfo":
				if(me.attr("href")=="#"){
					//me.toggleClass("colorMain-2")
					$("#idBox").toggleClass("colorMain-2");
					$("#userPopup").toggle();
				}
			break;
			default:
				$("#userPopup").hide();
				$("#idBox").removeClass("colorMain-2");
				pageTracker._trackPageview(me.attr("href"));
				setHash(me.attr("href"));
			break;
		}

    	/*checkHash*/
		return false; //to make sure the a isnt clicked
	});

});