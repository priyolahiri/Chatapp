<!DOCTYPE html>
<html>
	<!-- BEGIN HEAD -->
	<head>
		<title>Chatapp | Server Error (500)</title>
		<meta charset="UTF-8">
		<meta name="description" content="" />
		<!-- BEGIN SCRIPTS -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="/js/prettify.js"></script>                                   <!-- PRETTIFY -->
		<script type="text/javascript" src="/js/kickstart.js"></script>                                  <!-- KICKSTART -->
		<!-- END SCRIPTS -->
		<!-- BEGIN STYLES -->
		<link rel="stylesheet" type="text/css" href="/css/kickstart.css" media="all" />                  <!-- KICKSTART -->
		<link rel="stylesheet" type="text/css" href="/css/style.css" media="all" />                          <!-- CUSTOM STYLES -->
		<!-- END STYLES -->
	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body>
		<a id="top-of-page"></a>
		<!-- BEGIN PAGEWRAP -->
		<div id="wrap" class="clearfix">
			<!-- BEGIN HEADER AREA-->
			<div class="col_12" id="header_area">
				<div class="col_8">
					<h1>Chatapp</h1>
				</div>
				<div class="col_4">
					This is for development use only for internal testing. If you're seeing this and you don't know us, you're not suppossed to be here.
				</div>
			</div>
			<!-- END HEADER AREA -->
			<div class=clear></div>
	 		<!-- BEGIN BODY AREA -->
			<div class="col_12" id="body_area">
				<!-- BEGIN CONTENT AREA -->
				<div class="col_12" id="content_area">
					<h3>Server Error</h3>
					<p>Oops! We have encountered an error. Our admins have been notified of the problem.</p>
					<p>Error details:<br/><?php echo($error) ?></p>
				</div>
				<!-- END CONTENT AREA -->
			</div>
			<!-- END BODY AREA -->
			<div class="clear"></div>
			<!-- BEGIN FOOTER -->
			<div id="footer">
				&copy; Copyright Priyadarshi Lahiri 2011–2012 All Rights Reserved.
				<a id="link-top" href="#top-of-page">Top</a>
			</div>
			<!-- END FOOTER -->
		</div>
		<!-- END PAGEWRAP -->
	</body>
	<!-- END BODY -->
</html>