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
);