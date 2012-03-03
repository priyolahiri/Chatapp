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
		<script type="text/javascript" src="/js/underscore.min.js"></script>
		<script type="text/javascript" src="/js/jquery.easing-1.3.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.prettyLoader.js"></script>
		<script type="text/javascript" src="/js/jquery.noty.js"></script>
		<script src="http://js.pusher.com/1.11/pusher.min.js" type="text/javascript"></script>
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="/js/prettify.js"></script>                                   <!-- PRETTIFY -->
		<script type="text/javascript" src="/js/kickstart.js"></script>                                  <!-- KICKSTART -->
		<!-- END SCRIPTS -->
		<!-- BEGIN STYLES -->
		<link rel="stylesheet" type="text/css" href="/css/kickstart.css" media="all" />                  <!-- KICKSTART -->
		<link rel="stylesheet" type="text/css" href="/css/style2.css" media="all" />    
		<link rel="stylesheet" type="text/css" href="/css/prettyLoader.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/jquery.noty.css" media="all" />
		                      <!-- CUSTOM STYLES -->
		<!-- END STYLES -->
		<script type="text/javascript">
		(function($) {
    			$.extend({
        			getGo: function(url, params) {
            		document.location = url + '?' + $.param(params);
        		},
        		postGo: function(url, params) {
            		var $form = $("<form>")
               		.attr("method", "post")
               		.attr("action", url);
            		$.each(params, function(name, value) {
                $("<input type='hidden'>")
                    .attr("name", name)
                    .attr("value", value)
                    .appendTo($form);
            		});
            		$form.appendTo("body");
            		$form.submit();
        		}
    			});
		})(jQuery);
		</script>
		<script type="text/javascript">
			$(function() {
				$.prettyLoader();
				getoldchat();
				initchat();
				$('#contact_main_inner').on('click', 'button.makeadmin', function(e) {
					e.preventDefault();
					var makeadmin_id = $(this).attr('data-userid');
					$.ajax({
						url: '/makeadmin/<?php echo($chat->chatslug) ?>/'+makeadmin_id,
						type: 'GET',
						dataType: 'json',
						success: function(data) {
							if (data.success) {
								noty({"text":"User granted admin.","layout":"topRight","type":"error","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
							} else {
								noty({"text":"Admin grant failed.","layout":"topRight","type":"error","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
							}
						},
						error: function() {
							noty({"text":"Admin grant failed.","layout":"topRight","type":"error","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
						}
					})
				});
				$('span.social').click(function(e) {
					e.preventDefault;
					var isInIFrame = (window.location != window.parent.location) ? true : false;
					var social = $(this).attr('data-icon');
					console.log(social);
					if (social == 'F') {
						var provider = 'facebook';
					}
					if (social == 't') {
						var provider = 'twitter';
					}
					<?php
					$origurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					$origurlenc = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					?>
					if (isInIFrame) {
						var origurl = '<?php echo ($origurlenc) ?>';
						var finalurl = '<?php echo('http://'.$_SERVER['HTTP_HOST']) ?>/authforchati/<?php echo($chat->chatslug); ?>/'+provider+'/'+user_id;
						window.open(finalurl,'_newtab');
						channel.bind('newauth', function(data){
									if (data.user_id == user_id ) {
										console.log('match');
										self.location.reload();
									}
									
						});
					} else {
						var origurl = '<?php echo ($origurl) ?>';
						var finalurl = '<?php echo('http://'.$_SERVER['HTTP_HOST']) ?>/authforchat/'+provider;
						$.postGo(finalurl, {'directurl' : origurl });
					}
					});
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
								if (chatadmin) {
									noty({"text":"Coment posted!","layout":"topRight","type":"success","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
								} else {
									noty({"text":"Coment posted for moderation!","layout":"topRight","type":"alert","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
								}
								$('#submit_chat').each (function(){
  									this.reset();
								});
							}
							if (msg.msgerror) {
								noty({"text":"Error Occured!","layout":"topRight","type":"error","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
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
									user_id = data.user_id;
									siteadmin = data.siteadmin;
									$('div.auth_main').addClass("block");
									$('div.sendchat_main').addClass('block');
									$('div.sendchat_main').addClass('block-fullwidth');
									$('#chat_text').addClass('large');
									if (chatadmin) {
										$('div.sendchat_main').removeClass('block-fullwidth');
										$('#chat_text').removeClass('large');
										$('div.moderate_main').addClass("block");
										$('div.contact_main').addClass('block');
										initadmin();
									} else {
										channel.bind('makeadmin', function(data){
											if (data.user_id == user_id) {
												window.location.reload();
											}
										});
									}
								} else {
									$('div.login_main').addClass('block');
									user_id = data.user_id;
								}
							}
						}
				});
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
							noty({"text":"Coment approved!","layout":"topRight","type":"success","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
							refreshmod();
						}
					});
			}
			user_id = '';
			siteadmin = '';
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
		<div class="head_main">
			<div id="head_main_inner">
				<table class="striped">
					<thead><tr><th><?php echo $chat->chatname ?></th></tr></thead>
					<?php
					if ($chat->score!='no') {
					 echo('<tbody id="score_update"><tr><td>&nbsp;</td></tr></tbody>');
					}
					?>
				</table>
			</div>
		</div>
		<div class="clear"></div>
		<div class="chat_main">
			<div id="chat_main_inner">
				<table class="striped">
					<tbody></tbody>
				</table>
			</div>
		</div>
		<div class="clear"></div>
		<div class="login_main">
			<div id="login_main_inner">
				<p align='center'>Login with:</p>
				<p align="center" class="zerom">
					<span class="icon social large blue" data-icon="F"></span></button>	
					<span class="icon social large blue" data-icon="t"></span></button>
				</p>
			</div>
		</div>
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
							<option value="upload">Upload</option>
							<option value="twitpic">Twitpic</option>
							<option value="yfrog">YFrog</option>
						</select><br/>
						<label for="img_code">Image Code</label><br/>
						<input type="text" id="img_code" name="img_code"><br/>
						<label for="img_upload">Image Upload</label><br/>
						<input type="text" id="img_upload" name="img_upload"><br/>
						<label for="vid_source">Video Source</label><br/>
						<select id="vid_source" name="vid_source">
							<option value="NA">None</option>
							<option value="youtube">Youtube</option>
						</select><br/>
						<label for="vid_code">Video Code</label><br/>
						<input type="text" id="vid_code" name="vid_code">
						</form>
						<div class="clear"></div>
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