<?php
Class ChatsController extends Controller {
	public function action_index() {
		$error = Session::get('error');
		$socialauth= new Socialauth();
		$error = Session::get('error');
		if ($socialauth->user_id) {
			return View::make('chats.index')->with('error', $error)->with('socialauth', $socialauth);
		} else {
			return Redirect::to('/');
		}
	}
	public function action_add() {
		$error = Session::get('error');
		$socialauth= new Socialauth();
		$error = Session::get('error');
		if ($socialauth->user_id) {
			return View::make('chats.add')->with('error', $error)->with('socialauth', $socialauth);
		} else {
			return Redirect::to('/');
		}
	}
	public function action_active() {
		$error = Session::get('error');
		$socialauth= new Socialauth();
		$error = Session::get('error');
		if ($socialauth->user_id) {
			return View::make('chats.active')->with('error', $error)->with('socialauth', $socialauth);
		} else {
			return Redirect::to('/');
		}
	}
	public function action_finished() {
		$error = Session::get('error');
		$socialauth= new Socialauth();
		$error = Session::get('error');
		if ($socialauth->user_id) {
			return View::make('chats.finsihed')->with('error', $error)->with('socialauth', $socialauth);
		} else {
			return Redirect::to('/');
		}
	}
}
