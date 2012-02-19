<?php

class Home_Controller extends Controller {
	public function action_index()
	{
		$socialauth= new Socialauth();
		
		return View::make('home.index');
	}

}