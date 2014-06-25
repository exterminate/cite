<?php
class LoginHandler {
	
	public $sessionName, $sessionSecretCode, $sessionEmail;
	
	public function login($email, $password, $dbHandler) {
		// Validate before login                  		
		$user = $dbHandler->getUser('email', $email);
		if($dbHandler->count('users', 'email', '=', $email) == 1) { // check user exists
			// Success user exists, is password ok?
			if($user->password == md5($password)) {
				// has the user verified their account?
				if($user->accessLevel != "unverified"){
					// let's add the time they last logged in i.e., now
					$dbHandler->updateNew('users', 'lastLogin', date('Y-m-d H:i:s'), 'email', $email); //check lastLoning camel case
					
					// ok, let's start a session
					$_SESSION['name'] = $user->firstName." ".$user->surname;
					$sessionName = $_SESSION['name'];
					$_SESSION['secretCode'] = md5(date('Y-m-d H:i:s')).md5($email);
					$sessionSecretCode = $_SESSION['secretCode'];
					$_SESSION['email'] = $email;
					$sessionEmail = $_SESSION['email'];
				} else {
					die("You need to verify your account, please check you email for a verification link.");
				}
			} else {
				//password fail
				die("This user exists but you got the wrong password!");
			}
		} else { // user doesn't exist
			die("This user doesn't exist!");
		}
		
	}
	
	public static function isLoggedIn() {
		if(isset($sessionName) && isset($sessionSecretCode) && isset($sessionEmail))
			return true;
		else
			return false;
	}
	
	
}

?>
