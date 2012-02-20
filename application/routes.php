<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| Simply tell Laravel the HTTP verbs and URIs it should respond to. It's a
	| piece of cake to create beautiful applications using the elegant RESTful
	| routing available in Laravel.
	|
	| Let's respond to a simple GET request to http://example.com/hello:
	|
	|		'GET /hello' => function()
	|		{
	|			return 'Hello World!';
	|		}
	|
	| You can even respond to more than one URI:
	|
	|		'GET /hello, GET /world' => function()
	|		{
	|			return 'Hello World!';
	|		}
	|
	| It's easy to allow URI wildcards using (:num) or (:any):
	|
	|		'GET /hello/(:any)' => function($name)
	|		{
	|			return "Welcome, $name.";
	|		}
	|
	*/
	//9886023241
	//'GET /' => function()
	//{
	//	return View::make('home.index');
	//},
	'GET /chatnow/(:any)' => function($slug)
	{
		$socialauth = new Socialauth();
		if (!$socialauth->user_id) {
			return Redirect::to('/');
		}
		$chatsearch = Chat::where('chatslug', '=', $slug)->first();
		if (!$chatsearch) {
			return Redirect::to('/');
		}
		$chatadmin = Chatadmin::where('chat_id', '=', $chatsearch->id)->where('user_id', '=', $socialauth->user_id)->first();
		if ($chatadmin) {
			$admin = true;
		} else {
			$admin = false;
		}
		$redischat =new Redischat($chatsearch->chatslug, $chatsearch->score);
		return View::make('chatnow.index')->with('socialauth', $socialauth)->with('chat', $chatsearch)->with('admin', $admin)->with('redischat', $redischat);
	},
	'POST /chatauth' => function() {
		$socialauth = new Socialauth();
		if (!$socialauth->user_id) {
			header('', true, 403);
  			echo( "Not authorized" );
		}
		$pusher = new Pusher('bcc01e8ba13fef13ba43', '7d96c3c187a49ed7f0ee', '15575');
		$user_id = $socialauth->user_id;
		$role = $socialauth->user_role;
		$imgurl = $socialauth->facebook_photoURL == "NA" ? $socialauth->twitter_profile->photoURL : $socialauth->facebook_profile->photoURL;
		$name =  $socialauth->facebook_status ? $socialauth->facebook_profile->firstName.' '.$socialauth->facebook_profile->lastName : $socialauth->twitter_profile->firstName;
		$presence_data = array('name' => $name, 'imgURL' => $imgurl);
		echo $pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $user_id, $presence_data);
	},
	'POST /sendchat/(:any)' => function($chatslug) {
		$socialauth = new Socialauth();
		if (!$socialauth->user_id) {
			header('', true, 403);
  			echo( "Not authorized" );
		}
		$chatsearch = Chat::where('chatslug', '=', $chatslug)->first();
		if (!$chatsearch) {
			header('', true, 403);
  			echo( "Chat not found" );
		}
		$chatadmin = Chatadmin::where('chat_id', '=', $chatsearch->id)->where('user_id', '=', $socialauth->user_id)->first();
		if ($chatadmin) {
			$admin = true;
		} else {
			$admin = false;
		}
		$posttext = Input::get('chat_text');
		$postimgsrc = Input::get('img_source');
		$postimgcode = Input::get('img_code');
		$postvidsrc = Input::get('vid_source');
		$postvidcode = Input::get('vid_code');
		if (!$posttext and !$postimgcode and !$postvidcode) {
			return json_encode(array('error' => 'Please enter something. You cannot send a blank chat'));
		}
		if (!$postimgsrc=="NA" and !$postimgcode) {
			return json_encode(array('error' => 'Please enter valid image code.'));
		}
		if (!$postvidsrc=="NA" and !$postvidcode) {
			return json_encode(array('error' => 'Please enter valid video code.'));
		}
		$redischat = new Redischat($chatsearch->chatslug, $chatsearch->score);
		$imgurl = $socialauth->facebook_photoURL == "NA" ? $socialauth->twitter_profile->photoURL : $socialauth->facebook_profile->photoURL;
		$name =  $socialauth->facebook_status ? $socialauth->facebook_profile->firstName.' '.$socialauth->facebook_profile->lastName : $socialauth->twitter_profile->firstName;
		$msg = "<img src='$img' width='20' height='20' /> ".$name . " says :<br/>";
		$msg .= $posttext ? $posttext.'<br/>' : '';
		if ($postimgsrc=='twitpic') {
			$msg.="<a href='http://twitpic.com/$postimgcode' target='_blank'><img src='http://twitpic.com/show/thumb/$postimgcode' /></a><br/>";
		}
		if ($postimgsrc=='yfrog') {
			$msg.="<a href='http://yfrog.com/$postimgcode' target='_blank'><img src='http://yfrog.com/$postimgcode:small' /></a><br/>";
		}
		if ($vidimgsrc=='youtube') {
			$msg.="<iframe width='560' height='315' src='http://www.youtube.com/embed/$postvidcode' frameborder='0' allowfullscreen></iframe>";
		}
		$redischat->addMsg($msg);
		return json_encode(array('success' => true));
	} 
);