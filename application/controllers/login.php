<?php
class Login_Controller extends Controller {
	public function action_index() {
		return Redirect::to('/');
	}
	public function action_social($service) {
		$socialauth = new SocialAuth;
		$socialauth->authenticate($service);
		if ($socialauth->error) {
			return Response::make(View::make('error.500')->with('error', $socialauth->error), 500);
		}
		if ($socialauth->twiiter_status or $socialauth->facebook_status) {
			return Redirect::to('/dash')->with('socialauth', $socialauth);
		} else {
			return Redirect::to('/')->with('error', 'authentication failed');
		}
	}
}