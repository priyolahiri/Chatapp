<?php
Class Redischat {
	public function __construct($chatid, $score) {
		$this->rediska = new Rediska();
		$this->chatset = new Rediska_Key_List($chatid."_chat");
		if ($score) {
			$this->chatscore = new Rediska_Key_List($chatid."_score");
		}
	}
	public function addmsg($msg, $userinfo) {
		$timestamp = time();
		$transport = json_encode(array($timestamp, $msg, $userinfo));
		$this->chatset[] = $transport;
	}
	public function addscore($score) {
		$timestamp = time();
		$transport = json_encode(array($timestamp, $score, $userinfo));
		$this->chatset[] = $transport;
	}
	public function getchat() {
		return $this->chatset->toArray(true);
	}
	public function getscore() {
		return $this->chatscore->toArray(true);
	}
}
