<?php
Class Redischat {
	public function __construct($chatid, $score) {
		include 'Rediska.php';
		$this->rediska = new Rediska();
		$this->pusher = new Pusher(PUSHERKEY, PUSHERSECRET, PUSHERAPPID);
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
	public function addAdmin($id) {
		$adminsend = json_encode(array("user_id" => $id));
		$this->pusher->trigger($this->pusherChannel, 'makeadmin', $adminsend, null, false, true);
	}
	public function newAuth($id) {
		$adminsend = json_encode(array("user_id" => $id));
		$this->pusher->trigger($this->pusherChannel, 'newauth', $adminsend, null, false, true);
	}
	public function addMsgMod($msg) {
		$timenow = date('H:i', time());
		$transport = json_encode(array('timenow' => $timenow, 'msg' => $msg));
		$this->modchatset[] = $transport;
		//$this->pusher->trigger($this->pusherModChannel, 'chat', $transport, null, false, true);
	}
	public function addScore($score) {
		$transport = json_encode(array('score' => $score));
		$this->chatset[0] = $transport;
		$this->pusher->trigger($this->pusherModChannel, 'score', $transport, null, false, true);
	}
	public function approve($id) {
		$modchats = $this->modchatset->toArray(true);
		$c = 0;
		foreach ($modchats as $modchat) {
			$c++;
			if ($c==$id) {
				$transport = json_decode($modchat);
				error_log(json_encode($transport));
				$timenow = date('H:i', time());
				$newtransport = json_encode(array('timenow' => $timenow, 'msg' => $transport->msg));
				$this->chatset[] = $newtransport;
				$this->pusher->trigger($this->pusherChannel, 'chat', $newtransport, null, false, true);
				$this->modchatset->remove(json_encode($transport));
			}
		}
		return json_encode(array("msgsuccess" => "approved!"));
	}
	public function setScore($score) {
		$newtransport = json_encode(array('score' => $score));
		if (!$this->chatscore[0]) {
			$this->chatscore[] = $newtransport;
		} else {
			$this->chatscore[0] = $newtransport;
		}
		$this->pusher->trigger($this->pusherChannel, 'score', $newtransport, null, false, true);
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
