<?php
Class Dash_Controller extends Controller {
	public function action_index() {
		$socialauth = new Socialauth();
		if ($socialauth->user_id) {
			return View::make('dash.index')->with('socialauth', $socialauth);
		} else {
			return Redirect::to('/')->with('error', 'Please login');
		}
	}
}
