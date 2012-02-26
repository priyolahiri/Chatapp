<?php
Class Redischat {
	public function __construct($chatid, $score) {
		include 'Rediska.php';
		$this->rediska = new Rediska();
		$this->pusher = new Pusher('bcc01e8ba13fef13ba43', '7d96c3c187a49ed7f0ee', '15575');
		$this->pusherKey = 'bcc01e8ba13fef13ba43';
		$this->pusherChannel = "presence-".$chatid;
		$this->pusherModChannel = "presence-".$chatid."-moderate";
		$this->chatset = new Rediska_Key_List($chatid."_chat");
		$this->modchatset = new Rediska_Key_List($chatid."_chat_moderate");
		if ($score) {
			$this->chatscore = new Rediska_Key_List($chatid."_score");
		}
	}
	public function addMsg($msg) {
		$timenow = date('H:i', time());
		$transport = json_encode(array('timenow' => $timenow, 'msg' => $msg));
		$this->chatset[] = $transport;
		$this->pusher->trigger($this->pusherChannel, 'chat', $transport, null, false, true);
	}
	public function addMsgMod($msg) {
		$timenow = date('H:i', time());
		$transport = json_encode(array('timenow' => $timenow, 'msg' => $msg));
		$this->modchatset[] = $transport;
		//$this->pusher->trigger($this->pusherModChannel, 'chat', $transport, null, false, true);
	}
	public function addScore($score) {
		$timestamp = time();
		$transport = json_encode(array($timestamp, $score, $userinfo));
		$this->chatset[] = $transport;
	}
	public function approve($id) {
		$modchats = $this->modchatset->toArray(true);
		$c = 0;
		foreach ($modchats as $modchat) {
			$c++;
			if ($c==$id) {
				$transport = json_decode($modchat);
				error_log(json_encode($transport));
				$timenow = date('d/m/Y H:i', time());
				$newtransport = json_encode(array('timenow' => $timenow, 'msg' => $transport->msg));
				$this->chatset[] = $newtransport;
				$this->pusher->trigger($this->pusherChannel, 'chat', $newtransport, null, false, true);
				$this->modchatset->remove(json_encode($transport));
			}
		}
		return json_encode(array("msgsuccess" => "approved!"));
	}
	public function getChat() {
		return $this->chatset->toArray(true);
	}
	public function getModChat() {
		return $this->modchatset->toArray(true);
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
