<!DOCTYPE html>
<html>
	<!-- BEGIN HEAD -->
	<head>
		<title>Chatapp | Chats</title>
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
			<!-- BEGIN MENU -->
			<ul class="menu">
				<li><a href="/dash"><span class="icon" data-icon="4"></span>Dash</a></li>
				<li><a href="/connect"><span class="icon" data-icon="H"></span>Connect Account</a></li>
				<li class="current"><a href="/chats"><span class="icon" data-icon="F"></span>Chats</a>
					<ul>
						<li class="current"><a href="/chats/add"><span class="icon" data-icon="+"></span>Create</a></li>
						<li class="divider"></li>
						<li><a href="/chats/active"><span class="icon" data-icon="A"></span>Active Chats</a></li>
						<li><a href="/chats/finished"><span class="icon" data-icon="C"></span>Finished Chats</a></li>
					</ul>
				</li>
				<li><a href="/logout"><span class="icon" data-icon="o"></span>Logout</a></li>
			</ul>	
	 		<!-- END MENU -->
	 		<div class="clear"></div>
	 		<!-- BEGIN BODY AREA -->
			<div class="col_12" id="body_area">
				<!-- BEGIN CONTENT AREA -->
				<div class="col_12" id="content_area">
					<h3>Chats</h3>
					<?php
					if ($error) {
					?>
						<div class="notice error"><?php echo($error) ?></div><div class="clear"></div>
					<?php
					}
					?>
					<p><a class="button medium red" href="/chats/add">Add Chat</a><br/></p>
					<p>
						<a class="button medium green" href="/chats/active">Active Chats</a>
						<a class="button medium orange" href="/chats/finished">Finished Chats</a>
					</p>
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