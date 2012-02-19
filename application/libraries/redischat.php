<?php
Class Redischat {
	public function __construct($chatid, $score) {
		$this->rediska = new Rediska();
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
