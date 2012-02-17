<!DOCTYPE html>
<html>
	<!-- BEGIN HEAD -->
	<head>
		<title>Chatapp</title>
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
					<a href="/"><img src="/img/jscore_logo.png" alt="JScore Logo"></a>
				</div>
				<div class="col_4">
					This is for development use only for internal testing. If you're seeing this and you don't know us, you're not suppossed to be here.
				</div>
			</div>
			<!-- END HEADER AREA -->
			<div class=clear></div>
			<!-- BEGIN MENU -->
			<ul class="menu">
				<li class="current"><a href="">Item 1</a></li>
				<li><a href="">Item 2</a></li>
				<li><a href=""><span class="icon" data-icon="R"></span>Item 3</a>
					<ul>
						<li><a href=""><span class="icon" data-icon="G"></span>Sub Item</a></li>
						<li><a href=""><span class="icon" data-icon="A"></span>Sub Item</a>
							<ul>
								<li><a href=""><span class="icon" data-icon="Z"></span>Sub Item</a></li>
								<li><a href=""><span class="icon" data-icon="k"></span>Sub Item</a></li>
								<li><a href=""><span class="icon" data-icon="J"></span>Sub Item</a></li>
								<li><a href=""><span class="icon" data-icon="="></span>Sub Item</a></li>
							</ul>
						</li>
						<li class="divider"><a href=""><span class="icon" data-icon="T"></span>li.divider</a></li>
					</ul>
				</li>
				<li><a href="">Item 4</a></li>
			</ul>	
	 		<!-- END MENU -->
	 		<div class="clear"></div>
	 		<!-- BEGIN BODY AREA -->
			<div class="col_12" id="body_area">
				<!-- BEGIN CONTENT AREA -->
				<div class="col_8" id="content_area">
					<h3>Body</h3>
					<?php var_dump($socialauth); ?>
				</div>
				<!-- END CONTENT AREA -->
				<!-- BEGIN SIDEBAR AREA -->
				<div class="col_4" id="sidebar_area">
					<div class="sidebar_wrap">
						<div class="sidebar_head">
							<h5>Login</h6>
						</div>
						<div class="sidebar_body">
							<p align="center" class="zerom">
								Login using <br/><br/>
								<a href="/login/social/facebook"><span class="icon social x-large blue" data-icon="F"></span></a>	
								<a href="/login/social/twitter"><span class="icon social x-large blue" data-icon="t"></span></a><hr/>
							</p>
						</div>
					</div>
				</div>
				<!-- END SIDEBAR AREA -->
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