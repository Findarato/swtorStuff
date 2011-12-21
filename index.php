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
		<link rel="stylesheet" id="themeCss" media="screen" href="css/style.css"/>
        <link rel="stylesheet" media="screen" href="css/foundation.css?v=1"  />
        <link rel="stylesheet" media="screen and (max-width: 1024px) " href="css/handheld.css?v=1"  />
		<link rel="stylesheet" href="css/reset.css">
		<!-- end CSS-->
		<script src="js/libs/modernizr-2.0.6.min.js"></script>
	</head>
	<body>
		<div id="container">
			<header></header>
			<div id="main" role="main" style="padding:5px;">
				Stuff will go here <div id=statusTable></div>
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
