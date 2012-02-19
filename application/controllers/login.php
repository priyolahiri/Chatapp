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
		$query_column = $service.'_id';
		$profile_query = $service.'_profile';
		$profile = $socialauth->$profile_query;
		$userquery = User::where($query_column, '=', $profile->identifier)->first();
		if (!$userquery) {
			return View::make('login.socialregister')->with('profile', $profile);
		}
		return View::make('dash.index')->with('socialauth', $socialauth);
	}
}