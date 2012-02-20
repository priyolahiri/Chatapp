<?php
Class Redischat {
	public function __construct($chatid, $score) {
		include 'Rediska.php';
		$this->rediska = new Rediska();
		$this->pusher = new Pusher('bcc01e8ba13fef13ba43', '7d96c3c187a49ed7f0ee', '15575');
		$this->pusherKey = 'bcc01e8ba13fef13ba43';
		$this->pusherChannel = "presence-".$chatid;
		$this->chatset = new Rediska_Key_List($chatid."_chat");
		if ($score) {
			$this->chatscore = new Rediska_Key_List($chatid."_score");
		}
	}
	public function addMsg($msg, $userinfo) {
		$timestamp = time();
		$transport = json_encode(array($timestamp, $msg, $userinfo));
		$this->chatset[] = $transport;
	}
	public function addScore($score) {
		$timestamp = time();
		$transport = json_encode(array($timestamp, $score, $userinfo));
		$this->chatset[] = $transport;
	}
	public function getChat() {
		return $this->chatset->toArray(true);
	}
	public function getScore() {
		return $this->chatscore->toArray(true);
	}
	public function getChatTotal($user = NULL) {
		
	}
	public function getChatActive($user = NULL) {
		
	}
	public function getChatFinished($user= NULL) {
		
	}
}
