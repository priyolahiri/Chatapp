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
		<link rel="stylesheet" type="text/css" href="/css/jquery.fancybox-1.3.4.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/prettyLoader.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/style2.css" media="all" />                          <!-- CUSTOM STYLES -->
		<!-- END STYLES -->
		<script type="text/javascript">
			$(function() {
				$.prettyLoader();
				$('#chat_main_inner').slimScroll({
       				 height: '250px',
       				 width: '600px'
    				});
				//$('#main_window').wijsuperpanel();
				//$('#contact_window').wijsuperpanel();
				//$('#moderate_window').wijsuperpanel();
				c=0;
				getoldchat();
				<?php
				if ($admin) {
				?>
				setrefresh();
				<?php
				}
				?>
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
			pusher = new Pusher('<?php echo($redischat->pusherKey); ?>');
			Pusher.channel_auth_endpoint = '/chatauth';
			channel = pusher.subscribe('<?php echo ($redischat->pusherChannel) ?>');
			channel.bind('chat', function(data){
				var chattime = data.timenow;
				var chatmsg = data.msg;
				var output = '<li class="chat_element">At '+chattime+':</li>';
				var output2 = '<li class="chat_element">'+chatmsg+'<hr/></li>';
				$('#chat_list').append(output+output2);
				var elem = document.getElementById('chat_main_inner');
  				elem.scrollTop = elem.scrollHeight;
			});
			function userauth() {
				channel.bind('pusher:subscription_succeeded', function(members) {
				var onlinetext = members.count + ' user(s) online';
				$('#member_count').html(onlinetext);
				members.each(function(member) {
    					var name = member.info.name;
    					var img = member.info.imgURL;
    					var memberinsert = '<li class="contact_element" id="member_'+member.id+'">'+'<img src="'+img+'" align="middle"> '+name+'</li>';
    					$("#contact_list").append(memberinsert);
    					var elem = document.getElementById('contact_window');
  					elem.scrollTop = elem.scrollHeight;
 				});
			});
			channel.bind('pusher:member_added', function(member) {
  			// for example:
  				var name = member.info.name;
    				var img = member.info.imgURL;
    				var memberinsert = '<li class="contact_element" id="member_'+member.id+'">'+'<img src="'+img+'" align="middle"> '+name+'</li>';
    				$("#contact_list").append(memberinsert);
    				var elem = document.getElementById('contact_window');
  				elem.scrollTop = elem.scrollHeight;
			});
			channel.bind('pusher:member_removed', function(member) {
  				var id = '#member_' + member.id;
  				$(id).remove();
			});
			}
			function setrefresh() {
				setInterval('refreshmod()',20000);
				$('#moderate_window').show();
				refreshmod();
			}
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
								var output = '<li class="chat_element">'+chatmsg+'<hr/></li>';
								$('#chat_main_inner').append(output);
								var elem = document.getElementById('chat_main_inner');
  								elem.scrollTop = elem.scrollHeight;
							});
						}
				})
			}
			function refreshmod() {
				var co = 0;
				$.ajax({
						url: '/getchatmod/<?php echo($chat->chatslug) ?>',
						type: 'GET',
						dataType: 'json',
						success: function(data) {
							$('#moderate_list li.modchat_element').empty().end();
							_.each(data, function(oldmsg) {
								var oldobj = jQuery.parseJSON(oldmsg);
								co = co + 1;
								var chattime = oldobj.timenow;
								var chatmsg = oldobj.msg;
								var memid = oldobj.key;
								var output = '<li class="modchat_element" data-key="'+co+'">At '+chattime+':</li>';
								var output2 = '<li class="modchat_element" data-key="'+co+'">'+chatmsg+'</li>';
								var output3 = '<li class="modchat_element"><button class="small green app_comment" onclick="approve('+co+')">approve</span></button><hr/></li>';
								$('#moderate_list').append(output+output2+output3);
								var elem = document.getElementById('moderate_window');
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
			c = 0;
		</script>
	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body>
		<div class="chat_main">
			<div id="chat_main_inner">
			
			</div>
		</div>
	</body>
	<!-- END BODY -->
</html>