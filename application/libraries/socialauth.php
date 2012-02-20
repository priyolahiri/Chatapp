<?php
Class Socialauth {
	public function __construct() {
		require_once(APPROOT. "/public/hybridauth/Hybrid/Auth.php" );
		$this->hybridauth = new Hybrid_Auth(HYBRID_CONFIG);
		$this->providers = array('facebook','twitter');
		$this->userprofile=array();
		foreach ($this->providers as $provider) {
			$status_var = $provider.'_status';
			$profile_var = $provider.'_profile';
			$identifier_var = $provider.'_id';
			$displayname_var = $provider.'_displayName';
			$photourl_var = $provider.'_photoURL';
			$this->$status_var = $this->hybridauth->isConnectedWith($provider);
			if ($this->$status_var) {
				try {
					$adapter = $this->hybridauth->authenticate($provider);
					$this->$status_var = true;
					$this->$profile_var = $adapter->getUserProfile();
					$this->$identifier_var = $this->$profile_var->identifier;
					$this->$displayname_var = $this->$profile_var->displayName;
					$this->$photourl_var = $this->$profile_var->photoURL;
				} catch (Exception $e) {
					$this->errorhandle($e);
				}
			} else {
				$this->$status_var = false;
				$this->$profile_var = 'NA';
				$this->$identifier_var = 'NA';
				$this->$displayname_var = 'NA';
				$this->$photourl_var = 'NA';
			}
		}
		if ($this->facebook_status or $this->twitter_status) {
				$user = User::where('facebook_id', '=', $this->facebook_id)->or_where('twitter_id', '=', $this->twitter_id)->first();
				if ($user) {
					$this->user_id = $user->id;
					$this->user_role = $user->role;
				} else {
					$usercreate = new User();
					if  ($this->facebook_status) {
						$usercreate->facebook_id = $this->facebook_id;
					}
					if  ($this->twitter_status) {
						$usercreate->twitter_id = $this->twitter_id;
					}
					$usercreate->save();
					$userquery = User::where('facebook_id', '=', $this->facebook_id)->or_where('twitter_id', '=', $this->twitter_id)->first();
					if ($userquery) {
						$this->user_id = $userquery->id;
						$this->user_role = $userquery->role;
					}
				}
		}
	}
	public function authenticate($provider) {
		$profile_var = $provider.'_profile';
		try {
			$adapter = $this->hybridauth->authenticate($provider);
			$this->__construct();
		} catch (Exception $e) {
			$this->errorhandle($e);
		}
	}
	public function errorhandle($e) {
		switch($e->getCode()) {
			case 0 : $msg = "Unspecified error."; break;
			case 1 : $msg =  "Hybriauth configuration error."; break;
			case 2 : $msg =  "Provider not properly configured."; break;
			case 3 : $msg = "Unknown or disabled provider."; break;
			case 4 : $msg = "Missing provider application credentials."; break;
			case 5 : $msg = "Authentification failed. ". "The user has canceled the authentication or the provider refused the connection.";
			break;
			case 6 : $msg = "User profile request failed. Most likely the user is not connected ". "to the provider and he should authenticate again.";
			$this->hybridauth->logoutAllProviders();
			break;
			case 7 : $msg = "User not connected to the provider.";
			$this->hybridauth->logoutAllProviders();
			break;
			case 8 : $msg = "Provider does not support this feature."; break;
		}
		$this->error = $msg;
	}
}

