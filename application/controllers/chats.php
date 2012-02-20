<?php
Class Chats_Controller extends Controller {
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
		$success = Session::get('success');
		$socialauth= new Socialauth();
		if ($socialauth->user_id) {
			if ($socialauth->user_role!="admin") {
				return Redirect::to('/chats')->with('error', 'You have to be an admin user to create a chat.');
			} else {
				if (Input::get('chatid')) {
						$chat_name = Input::get('chatid');
						$chat_slug = URL::slug($chat_name)	;
						if (strlen($chat_name)<4 and strlen($chatname) > 50) {
							return Redirect::to('/chats/add')->with('error', 'Chat name needs to be more than 3 chars and less than 51 chars.');
						}
						$newchat = new Chat();
						$newchat->chatname = $chat_name;
						$newchat->chatslug = $chat_slug;
						$newchat->user_id = $socialauth->user_id;
						$newchat->createdon = time();
						$newchat->status = "active";
						$newchat->score = Input::get('chatscore');
						$newchat->save();
						$newadmin = new Chatadmin();
						$newadmin->chat_id = $newchat->id;
						$newadmin->user_id = $socialauth->user_id;
						$success = "Created chat '$chat_name' with slug '$chat_slug' and id: ".$newchat->id.". You have been added as chat admin for the chat.";
						$success .= '<a href="/chatnow/'.$newchat->id.'" class="button small green">Chat Now!</a>';
 				}
				return View::make('chats.add')->with('error', $error)->with('socialauth', $socialauth)->with('success', $success);
			}
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
