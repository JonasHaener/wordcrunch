<?php
//redirection variable to login page
if (!file_exists($userlist) || !is_readable($userlist)) {
		$error = 'Login facility unavailable. Please try again later';
		
} else {
	  // read file into array
		$users = file ($userlist);
		// loop through array process each line
		for ($i = 0; $i < count($users); $i++) {
				//store each in seperate temp array
				$tmp = explode(', ', $users[$i]);
				//check for match
				if ($tmp[0] == $username && rtrim($tmp[1]) == $password) {
						$_SESSION['authenticated'] = "Hello";
						//register time when login was successful
						$_SESSION['start'] = time();
						session_regenerate_id();
						$login_ok = true; //used for login button confirmation
						break;
				}
		}
	// if session variable is set, redirect
	if (isset($_SESSION['authenticated'])) {
			header("Location:{$redirect}");
			exit;
	} else {
			$error = 'Sorry. The username or password is invalid !';
	}
}