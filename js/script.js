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
	$("<div/>",{"class":"ticketBox insideBorder roundAll4 border-all-Main-1 newTicketTpl WhitetoLightOff"})
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
				
				var pie = new RGraph.Pie('upServers', [json.serverUp,json.serverCount-json.serverUp]);
				
		
		        // Configure the chart to look as you want.
		        pie.Set('chart.labels', ['Up', 'Down']);
		        pie.Set('chart.title', "2");
		        pie.Set('chart.stroke','black')
		        pie.Set('chart.colors',['#25A2C3','#111111'])
		        pie.Set('chart.text.color',"#FBB50D")
		        // Call the .Draw() chart to draw the Pie chart.
		        pie.Draw();
				
				
				$("#generatedTime").html(json["servers"][0]["dt"]);
				var display = $("<div/>");
				$.each(json.servers,function(i,data){
					
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
						userDisplay.find("#ticketPriority").attr("id","ticketPriority-"+data.name).html(
				    		function(i,html){
				     			//if(data.population>0){
				       				result = $("<div/>",{"title":Priority_string[data.population].name}).addClass("pSquare p"+Priority_string[data.population].name.replace(" ",""));
								//}
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

function drawType(){
	
}


function checkHash(){
	hash = hash = jQuery.makeArray(getHash().split("\/"));
	hash[0] = hash[0].replace("#","")
	var ymax = 5;
	if(hash[0] == "")hash[0]="type";
	$.getJSON("ajax/getData.php",{"name":hash[0]},function(data){
			var values = new Array();
			var values2 = new Array();
			var lable = new Array();
			var lable2 = new Array();
			var key = "";
			if(hash[0] == "type"){
				drawType();
				var cnt = 0;
				var cnt2 = 0;
				key = [];
				values = [[0,1],[0,2],[0,3],[0,4],[0,5]];
				values2 = [[0,1],[0,2],[0,3],[0,4],[0,5]];
				lable = data["day"]["title"];
				$.each(data.day,function(k,item){
					if(k!="title"){
						cnt2 = 0;
						key[cnt] = k;
						$.each(item,function(k2,item2){
							values[cnt][cnt2] = item2.pop;
							cnt2++;
						});
						cnt++;
					}
				});
				if(data.month){
					cnt = 0;
					lable2 = data["month"]["title"];
					$.each(data.month,function(k,item){
						if(k!="title"){
							cnt2 = 0;
							key[cnt] = k;
							$.each(item,function(k2,item2){
								values2[cnt][cnt2] = item2.pop;
								cnt2++;
							});
							cnt++;
						}
					});
				}
			}else{
				key = [hash[0]];
				$.each(data,function(k,item){
					values[k] = item.pop;
					lable[k] = item.hour;
				});
				if(data.month){
					$.each(data.month,function(k,item){
						values2[k] = item.pop;
						lable2[k] = item.hour;
					});
				}
			}

			
		    var line1 = new RGraph.Line('graph', values);
		    line1.Set('chart.key',key);
            line1.Set('chart.background.grid', false);
            line1.Set('chart.linewidth', 2);
            line1.Set('chart.gutter.left', 35);
            line1.Set('chart.ymin', 0);
            line1.Set('chart.ymax', ymax);
            line1.Set('chart.scale.decimals',0);
            line1.Set('chart.hmargin', 1);
            if (!document.all || RGraph.isIE9up()) {
                line1.Set('chart.shadow', true);
            }
            line1.Set('chart.tickmarks', null);
            line1.Set('chart.units.post', '');
            line1.Set('chart.text.color',"white");
            line1.Set('chart.colors', ['#FBB50D', 'green','blue', '#111111']);
            line1.Set('chart.background.grid.autofit', true);
            line1.Set('chart.background.grid.autofit.numhlines', 10);
            line1.Set('chart.curvy', true);
            line1.Set('chart.curvy.factor', 0.5); // This is the default
            line1.Set('chart.animation.unfold.initial',0);
            line1.Set('chart.labels',lable);
            
            if (RGraph.isOld()) {
                line1.Draw();
            } else {
                RGraph.Effects.Line.jQuery.Trace(line1);
            }
            
            var line2 = new RGraph.Line('graphMonth', values2);
		    line2.Set('chart.key',key);
            line2.Set('chart.background.grid', false);
            line2.Set('chart.linewidth', 2);
            line2.Set('chart.gutter.left', 35);
            line2.Set('chart.ymin', 0);
            line2.Set('chart.ymax', ymax);
            line2.Set('chart.scale.decimals',0);
            line2.Set('chart.hmargin', 1);
            if (!document.all || RGraph.isIE9up()) {
                line2.Set('chart.shadow', true);
            }
            line2.Set('chart.tickmarks', null);
            line2.Set('chart.units.post', '');
            line2.Set('chart.text.color',"white");
            line2.Set('chart.colors', ['#FBB50D', 'green','blue', '#111111']);
            line2.Set('chart.background.grid.autofit', true);
            line2.Set('chart.background.grid.autofit.numhlines', 10);
            line2.Set('chart.curvy', true);
            line2.Set('chart.curvy.factor', 0.5); // This is the default
            line2.Set('chart.animation.unfold.initial',0);
            line2.Set('chart.labels',lable2);
            
            if (RGraph.isOld()) {
                line2.Draw();
            } else {
                RGraph.Effects.Line.jQuery.Trace(line2);
            }
            
            
            
            
	});

	if(hash[1]){
		alert(hash[1]);
	}
		
	//alert(hash);
}

window.onpopstate = function(event) {
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