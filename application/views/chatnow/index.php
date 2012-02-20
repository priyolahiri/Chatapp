<!DOCTYPE html>
<html>
	<!-- BEGIN HEAD -->
	<head>
		<title>Chatapp | Chatting on <?php echo ($chat->chatname) ?></title>
		<meta charset="UTF-8">
		<meta name="description" content="" />
		<!-- BEGIN SCRIPTS -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/js/jquery.easing-1.3.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.wijmo-open.all.2.0.0.min.js"></script>
		<script src="http://js.pusher.com/1.11/pusher.min.js" type="text/javascript"></script>
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="/js/prettify.js"></script>                                   <!-- PRETTIFY -->
		<script type="text/javascript" src="/js/kickstart.js"></script>                                  <!-- KICKSTART -->
		<!-- END SCRIPTS -->
		<!-- BEGIN STYLES -->
		<link rel="stylesheet" type="text/css" href="/css/kickstart.css" media="all" />                  <!-- KICKSTART -->
		<link rel="stylesheet" type="text/css" href="/css/jquery.fancybox-1.3.4.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/jquery.wijmo-open.2.0.0.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/aristo/jquery-wijmo.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" media="all" />                          <!-- CUSTOM STYLES -->
		<!-- END STYLES -->
		<script type="text/javascript">
			$(function() {
				$('#main_window').wijsuperpanel();
				$('#contact_window').wijsuperpanel();
				$('#moderate_window').wijsuperpanel();
				$.ajax({
						url: '/getchat/<?php echo($chat->chatslug) ?>',
						type: 'GET',
						success: function(data) {
							console.log(data);
						}
				})
				$('#submit_chat').submit(function(e) {
					e.preventDefault();
					var postdata = $('#submit_chat').serialize();
					$.ajax({
						url: '/sendchat/<?php echo($chat->chatslug) ?>',
						dataType: 'json,
						type: 'POST',
						data: postdata,
						success: function(data) {
							console.log(data);
							var msg = data;
							console.log(msg);
							console.log(msg.msgsuccess);
							console.log(msg.msgerror);
							if (msg.msgsuccess) {
								$('#chatsuccess').html('');
								$('#chaterror').html('');
								$('#chatsuccess').html('Send Success!');
							}
							if (msg.msgerror) {
								$('#chatsuccess').html('');
								$('#chaterror').html('');
								$('#chaterror').html(msg.msgerror);
							}
						}
					})
				})
			})
			pusher = new Pusher('<?php echo($redischat->pusherKey); ?>');
			Pusher.channel_auth_endpoint = '/chatauth';
			channel = pusher.subscribe('<?php echo ($redischat->pusherChannel) ?>');
			channel.bind('pusher:subscription_succeeded', function(members) {
				//console.log(members.count);
				var onlinetext = members.count + ' user(s) online';
				//console.log(onlinetext);
				$('#member_count').html(onlinetext);
				members.each(function(member) {
    					//console.log(member);
    					var name = member.info.name;
    					var img = member.info.imgURL;
    					var memberinsert = '<li class="contact_element" id="member_'+member.id+'">'+'<img src="'+img+'" align="middle"> '+name+'</li>';
    					$("#contact_list").append(memberinsert);
 				});
			});
			channel.bind('pusher:member_added', function(member) {
  			// for example:
  				var name = member.info.name;
    				var img = member.info.imgURL;
    				var memberinsert = '<li class="contact_element" id="member_'+member.id+'">'+'<img src="'+img+'" align="middle"> '+name+'</li>';
    				$("#contact_list").append(memberinsert);
			});
			channel.bind('pusher:member_removed', function(member) {
				console.log('member removed');
  				var id = '#member_' + member.id;
  				$(id).remove();
			});
			channel.bind('chat', function(data){
				var chattime = data.timenow;
				var chatmsg = data.msg;
				var output = '<li class="chat_element">At '+chattime+':</li>';
				var output2 = '<li class="chat_element">'+chatmsg+'</li>';
				$('#chat_list').append(output+output2);
			});
		</script>
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
					<h3><?php echo ($chat->chatname) ?></h3>
					<div class="col_8 chat_main" id="main_window">
						<div class="elements">
             				<ul id="chat_list">
               					<li class="window_block">Chat</li>
               					<li><hr/></li>
             				</ul>
       					</div>
					</div>
					<div class="col_3 chat_main" id="contact_window">
						<div class="elements">
             				<ul id="contact_list">
               					<li class="window_block" id="member_count"></li>
               					<li><hr/></li>
             				</ul>
       					</div>
					</div>
					<div class="clear"></div>
					<div class="col_5">
						<form id="submit_chat" class="vertical">
							<label for="chat_text">Text</label>
							<input type="text" id="chat_text" name="chat_text">
							<label for="img_source">Image Source</label>
							<select id="img_source" name="img_source">
								<option value="NA">None</option>
								<option value="twitpic">Twitpic</option>
								<option value="yfrog">YFrog</option>
							</select>
							<label for="img_code">Image Code</label>
							<input type="text" id="img_code" name="img_code">
							<label for="vid_source">Video Source</label>
							<select id="vid_source" name="vid_source">
								<option value="NA">None</option>
								<option value="youtube">Youtube</option>
							</select>
							<label for="vid_code">Video Code</label>
							<input type="text" id="vid_code" name="vid_code">
							<button class="small green">Send</button>
						</form>
						<div class="clear"></div>
						<div class="notice success" id="chatsuccess"></div>
						<div class="notice error" id="chaterror"></div>
					</div>
					<div class="col_6 chat_main" id="moderate_window">
						<div class="elements">
             				<ul id="moderate_list">
               					<li class="window_block">Moderation</li>
               					<li><hr/></li>
             				</ul>
       					</div>
					</div>
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