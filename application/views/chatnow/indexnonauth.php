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
		<script type="text/javascript" src="/js/underscore.min.js"></script>
		<script type="text/javascript" src="/js/jquery.easing-1.3.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.prettyLoader.js"></script>
		<script type="text/javascript" src="/js/slimscroll.js"></script>
		<script src="http://js.pusher.com/1.11/pusher.min.js" type="text/javascript"></script>
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="/js/prettify.js"></script>                                   <!-- PRETTIFY -->
		<script type="text/javascript" src="/js/kickstart.js"></script>                                  <!-- KICKSTART -->
		<!-- END SCRIPTS -->
		<!-- BEGIN STYLES -->
		<link rel="stylesheet" type="text/css" href="/css/kickstart.css" media="all" />                  <!-- KICKSTART -->
		<link rel="stylesheet" type="text/css" href="/css/style2.css" media="all" />    
		<link rel="stylesheet" type="text/css" href="/css/jquery.fancybox-1.3.4.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/prettyLoader.css" media="all" />
		                      <!-- CUSTOM STYLES -->
		<!-- END STYLES -->
		<script type="text/javascript">
			$(function() {
				$.prettyLoader();
				getoldchat();
				initchat();
				$('#submit_chat').submit(function(e) {
					e.preventDefault();
					var postdata = $('#submit_chat').serialize();
					$.ajax({
						url: '/sendchat/<?php echo($chat->chatslug) ?>',
						dataType: 'json',
						type: 'POST',
						data: postdata,
						success: function(data) {
							var msg = data;
							if (msg.msgsuccess) {
								$('#chatsuccess').html('');
								$('#chaterror').html('');
								$('#chatsuccess').html('Send Success!');
								$('#submit_chat').each (function(){
  									this.reset();
								});
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
			function getoldchat() {
				$.ajax({
						url: '/getchat/<?php echo($chat->chatslug) ?>',
						type: 'GET',
						dataType: 'json',
						success: function(data) {
							_.each(data, function(oldmsg) {
								var oldobj = jQuery.parseJSON(oldmsg);
								var chattime = oldobj.timenow;
								var chatmsg = oldobj.msg;
								var output = '<tr><td class="col-gray" width="8%">'+chattime+'</td>';
								var output2 = '<td>'+chatmsg+'</td></tr>';
								$('#chat_main_inner table tbody').append(output+output2);
							});
							var elem = document.getElementById('chat_main_inner');
  							elem.scrollTop = elem.scrollHeight;
						}
				})
			}
			function initchat() {
				$.ajax({
						url: '/chatinfo/<?php echo($chat->chatslug) ?>',
						type: 'GET',
						dataType: 'json',
						success: function(data) {
							if (!data.error) {
								console.log('event chat sub');
								channel.bind('chat', function(data){
									console.log(data);
									var chattime = data.timenow;
									var chatmsg = data.msg;
									var output = '<tr><td class="col-gray" width="8%">'+chattime+'</td>';
									var output2 = '<td>'+chatmsg+'</td></tr>';
									$('#chat_main_inner table tbody').append(output+output2);
									var elem = document.getElementById('chat_main_inner');
  									elem.scrollTop = elem.scrollHeight;
								});
								role = data.role;
								chatadmin = data.chatadmin;
								if (data.name != "anonymous") {
									$('div.auth_main').addClass("block");
									$('div.sendchat_main').addClass('block');
									$('div.sendchat_main').addClass('block-fullwidth');
								}
								if (chatadmin) {
									$('div.sendchat_main').removeClass('block-fullwidth');
									$('div.moderate_main').addClass("block");
									$('div.')
									initadmin();
								}
							}
						}
				});
			}
			function initsend() {
				
			}
			function initadmin() {
				channel.bind('pusher:subscription_succeeded', function(members) {
					var onlinetext = members.count + ' user(s) online';
					$('#member_count').html(onlinetext);
					members.each(function(member) {
    						var name = member.info.name;
    						var img = member.info.imgURL;
    						var memberinsert = '<li class="sub_li" data-userid="'+member.info.user_id+'" id="member_'+member.id+'">'+'<img src="'+img+'" align="middle"> '+name;
    						console.log(chatadmin);
    						console.log(member.info.chatadmin);
    						console.log(member.info.name);
    						if (chatadmin==true && member.info.chatadmin==false && member.info.name != "anonymous") {
    							memberinsert = memberinsert + '<br/><button class="small makeadmin" data-userid="'+member.info.user_id+'">Make Admin</button>';
    						}
    						memberinsert = memberinsert + '</li>';
    						$("#contact_main_inner ul").append(memberinsert);
    						var elem = document.getElementById('contact_main_inner');
  						elem.scrollTop = elem.scrollHeight;
 					});
				});
				channel.bind('pusher:member_added', function(member) {
  				// for example:
  					var name = member.info.name;
    					var img = member.info.imgURL;
    					var memberinsert = '<li class="sub_li" data-userid="'+member.info.user_id+'" id="member_'+member.id+'">'+'<img src="'+img+'" align="middle"> '+name;
    					if (chatadmin==true && member.info.chatadmin==false && member.info.name != "anonymous") {
    						memberinsert = memberinsert + '<br/><button class="small makeadmin" data-userid="'+member.info.user_id+'">Make Admin</button>';
    					}
    					memberinsert = memberinsert + '</li>';
    					$("#contact_main_inner ul").append(memberinsert);
    					var elem = document.getElementById('contact_main_inner');
  					elem.scrollTop = elem.scrollHeight;
				});
				channel.bind('pusher:member_removed', function(member) {
  					var id = '#member_' + member.id;
  					$(id).remove();
				});
				setInterval('refreshmod()',20000);
				$('#moderate_window').show();
				refreshmod();
			}
			function refreshmod() {
				var co = 0;
				$.ajax({
						url: '/getchatmod/<?php echo($chat->chatslug) ?>',
						type: 'GET',
						dataType: 'json',
						success: function(data) {
							$('#moderate_main_inner table tbody tr').empty().end();
							_.each(data, function(oldmsg) {
								var oldobj = jQuery.parseJSON(oldmsg);
								co = co + 1;
								var chattime = oldobj.timenow;
								var chatmsg = oldobj.msg;
								var memid = oldobj.key;
								var output = '<tr>';
								var output2 = '<td>'+chatmsg+'<br/><button class="small green app_comment" onclick="approve('+co+')">approve</button></td></tr>';
								$('#moderate_main_inner table tbody').append(output+output2);
								var elem = document.getElementById('moderate_main_inner');
								
  								elem.scrollTop = elem.scrollHeight;
							});
						}
				})
			}
			function approve(id) {
					$.ajax({
						url: '/chatapprove/<?php echo($chat->chatslug) ?>/'+id,
						type: 'GET',
						dataType: 'json',
						success: function(data) {
							refreshmod();
						}
					});
			}
			role = '';
			chatadmin = '';
			pusher = new Pusher('<?php echo($redischat->pusherKey); ?>');
			Pusher.channel_auth_endpoint = '/chatauth/<?php echo($chat->chatslug) ?>';
			channel = pusher.subscribe('<?php echo ($redischat->pusherChannel) ?>');
		</script>
	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body>
		<div class="chat_main">
			<div id="chat_main_inner">
				<table class="striped">
					<thead><tr><th colspan="2"><?php echo $chat->chatname ?></th></tr></thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
		<div class="clear"></div>
		<div class="auth_main">
			<div class="sendchat_main">
				<div id="sendchat_main_inner">
					<ul class="chat">
						<li class="head_li">Comment</li>
					</ul>
					<form id="submit_chat">
						<label for="chat_text">Text</label><br/>
						<textarea id="chat_text" name="chat_text"></textarea>
						<button type="submit" class="small green">Send</button><br/>
						<label for="img_source">Image Source</label><br/>
						<select id="img_source" name="img_source">
							<option value="NA">None</option>
							<option value="twitpic">Twitpic</option>
							<option value="yfrog">YFrog</option>
						</select><br/>
						<label for="img_code">Image Code</label><br/>
						<input type="text" id="img_code" name="img_code"><br/>
						<label for="vid_source">Video Source</label><br/>
						<select id="vid_source" name="vid_source">
							<option value="NA">None</option>
							<option value="youtube">Youtube</option>
						</select><br/>
						<label for="vid_code">Video Code</label><br/>
						<input type="text" id="vid_code" name="vid_code">
						</form>
						<div class="clear"></div>
						<div class="notice success" id="chatsuccess"></div>
						<div class="notice error" id="chaterror"></div>
				</div>
			</div>
			<div class="moderate_main">
				<div id="moderate_main_inner">
					<ul class="chat">
						<li class="head_li">Moderation</li>
					</ul>
					<table class="striped">
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="clear"></div>
			<div class="contact_main">
				<div id="contact_main_inner">
					<ul class="chat">
						<li class="head_li">Contacts Online</li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</body>
	<!-- END BODY -->
</html>