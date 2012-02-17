<?php
Class Socialauth {
	public function __construct() {
		require_once(APPROOT. "/public/hybridauth/Hybrid/Auth.php" );
		$this->hybridauth = new Hybrid_Auth(HYBRID_CONFIG);
		$this->providers = array('facebook','google','twitter','linkedin');
		$this->userprofile=array();
		foreach ($this->providers as $provider) {
			$status_var = $provider.'_status';
			$profile_var = $provider.'_profile';
			$this->$status_var = $this->hybridauth->isConnectedWith($provider);
			if ($this->$status_var) {
				try {
					$adapter = $this->hybridauth->authenticate($provider);
					$this->$profile_var = $adapter->getUserProfile();
				} catch (Exception $e) {
					$this->errorhandle($e);
				}
			}
		}
	}
	public function authenticate($provider) {
		$profile_var = $provider.'_profile';
		try {
			$adapter = $this->hybridauth->authenticate($provider);
			$this->$profile_var = $adapter->getUserProfile();
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
			$socialauth->logout();
			break;
			case 7 : $msg = "User not connected to the provider.";
			$socialauth->logout();
			break;
			case 8 : $msg = "Provider does not support this feature."; break;
		}
		$this->error = $msg;
	}
}

