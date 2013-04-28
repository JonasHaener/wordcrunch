<?php
require_once('./includes/check_session.inc.php');
if (isset($_SESSION['authenticated'])) {
		//empty session array
		$_SESSION = array();
		// invalidate session cookie
		if (isset($_COOKIE[session_name()])) {
				setcookie(session_name(),'', time()-86400, '/');
		}
		//end session and redirect
		session_destroy();
		header("Location: {$abs_path}login.php");
		exit;
}