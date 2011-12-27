<!doctype html> <!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
	<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title></title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<!-- CSS concatenated and minified via ant build script-->
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" id="themeCss" media="screen" href="css/style.css"/>
		<link rel="stylesheet" media="screen" href="css/foundation.css?v=1"  />
		<link rel="stylesheet" media="screen and (max-width: 1024px) " href="css/handheld.css?v=1"  />
		<!-- end CSS-->
		<script src="js/libs/modernizr-2.0.6.min.js"></script>
	</head>
	<body>
		<div id="container">
			<header></header>
			<div id="main" role="main" style="padding:5px;">
				<div style="float:left;margin:5px;position:relative;;margin-top:33px">
					<div style="height:24px;position:absolute;top:-28px;z-index:5">
						<div class="" style="display:table-cell;width:21px;height:21px;margin-left:1px;"></div>
						<div class="colorText border-top-Main-1 border-sides-Main-1 roundTop4" style="background-color:black;height:21px;width:40px;padding:5px;display:table-cell">
							Hourly
						</div>
					</div>
					<div class="border-all-Main-1 roundAll4" style="position:relative;height:300px;width:500px;">
						<div class="pFull graphBox" style="top:25px;left:36px">
							Full
						</div>
						<div class="pVeryHeavy graphBox" style="top:75px;left:36px;">
							Very High
						</div>
						<div class="pHeavy graphBox" style="top:125px;left:36px;">
							High
						</div>
						<div class="pStandard graphBox" style="top:175px;left:36px;">
							Normal
						</div>
						<div class="pLight graphBox" style="top:225px;left:36px;">
							Low
						</div>
						<div class="graphBox" id="generatedTime" style="top:224px;right:25px;width:170px;opacity:6.5;font-size:15px;">
							TIME STAMP
						</div>
						<canvas style="position:absolute;top:0px;left:0px;" id=graph width=500px height=300px></canvas>
					</div>
				</div>
				<div style="float:left;margin:5px;position:relative;margin-top:33px">
					<div style="height:24px;position:absolute;top:-28px;z-index:5">
						<div class="" style="display:table-cell;width:21px;height:21px;margin-left:1px;"></div>
						<div class="colorText border-top-Main-1 border-sides-Main-1 roundTop4" style="background-color:black;height:21px;width:40px;padding:5px;display:table-cell">
							Daily
						</div>
					</div>
					<div class="border-all-Main-1 roundAll4" style="position:relative;height:300px;width:500px;">
						<div class="pFull graphBox" style="top:25px;left:36px">
							Full
						</div>
						<div class="pVeryHeavy graphBox" style="top:75px;left:36px;">
							Very High
						</div>
						<div class="pHeavy graphBox" style="top:125px;left:36px;">
							High
						</div>
						<div class="pStandard graphBox" style="top:175px;left:36px;">
							Normal
						</div>
						<div class="pLight graphBox" style="top:225px;left:36px;">
							Low
						</div>
						<canvas style="position:absolute;top:0px;left:0px;" id=graphMonth width=500px height=300px></canvas>
					</div>
				</div>
				<div style="overflow:auto;width:100%"></div>
				<div>
					<div style="display:table-cell;vertical-align:top;">
						<div id="statusTable" style="height:400px;overflow:auto;width:440px;"></div>
					</div>
					<div class="colorText" id="infoTable" style="display:table-cell;">
						<div style="margin-left:5px;">
							<div style="float:left;margin:5px;position:relative;;margin-top:33px">
								<div style="height:24px;position:absolute;top:-28px;z-index:5">
									<div class="" style="display:table-cell;width:21px;height:21px;margin-left:1px;"></div>
									<div class="colorText border-top-Main-1 border-sides-Main-1 roundTop4" style="background-color:black;height:21px;width:auto;padding:5px;display:table-cell">
										Server Status
									</div>
								</div>
								<div class="border-all-Main-1 roundAll4" style="position:relative;height:200px;width:200px;padding:5px">
									<canvas style="" id=upServers width=200px height=200px></canvas>
								</div>
							</div>
							<div style="float:left;margin:5px;position:relative;;margin-top:33px">
								<div style="height:24px;position:absolute;top:-28px;z-index:5">
									<div class="" style="display:table-cell;width:21px;height:21px;margin-left:1px;"></div>
									<div class="colorText border-top-Main-1 border-sides-Main-1 roundTop4" style="background-color:black;height:21px;width:auto;padding:5px;display:table-cell">
										Options
									</div>
								</div>
								<div class="border-all-Main-1 roundAll4" style="position:relative;height:200px;width:200px;padding:5px">
									 <ul>
									 	<li><a class="fakelink" href="#type">Compare by Server Type </a></li>
									 	<li><a class="fakelink actionButtons">Show Raw Numbers</a></li>
									 	<li><a class="fakelink actionButtons">Show Average Numbers</a></li>
									 </ul> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer></footer>
		</div>
		<!--! end of #container -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
		<!-- scripts concatenated and minified via ant build script-->
		<script src="js/libs/RGraph/libraries/RGraph.common.core.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.common.context.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.common.annotate.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.common.tooltips.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.common.zoom.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.common.effects.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.common.key.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.line.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.pie.js" ></script>
		<script src="js/libs/RGraph/libraries/RGraph.common.key.js" ></script>
		<script defer src="js/plugins.js"></script>
		<script defer src="js/globalFunctions.js"></script>
		<script defer src="js/script.js"></script>
		<!-- end scripts-->
		<script>
			// Change UA-XXXXX-X to be your site's ID
			window._gaq = [['_setAccount', 'UA278719491'], ['_trackPageview'], ['_trackPageLoadTime']];
			window._gaq.push(['_setDomainName', 'findarato.org']);
			Modernizr.load({
				load : ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
			});

		</script>
		<!--[if lt IE 7 ]>
		<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
	</body>
</html>
