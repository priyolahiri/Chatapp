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
		$redichat =new Redischat($chatsearch->chatslug, $chatsearch->score);
		return View::make('chatnow.index')->with('socialauth', $socialauth)->with('chat', $chatsearch)->with('admin', $admin)->with('redischat', $redichat);
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
);