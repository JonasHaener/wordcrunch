<?php
/*
 * Login logic
 * Controls login procedure
 *
 *
 */

$LOGIN_ERROR = "";

function WC_login_logic( $user_input, &$error ) {
	
	$REDIRECT = "http://localhost/wordcrunch_3/public";
	$db = new WC_DB_connect("localhost", "jonasCanAll", "fridolin88", "wordcrunch", "mysqli");
	$model = new WC_LOGIN_model($db->conn);
	$controller = new WC_LOGIN_controller($model, $user_input);
	$view = new WC_LOGIN_view($model, $controller);
	$db->conn->close();

	if($view->get_login() === true) {
		header("Location:{$REDIRECT}");
	} else {
		$error = $view->get_error();
	}

}
// if $_POST is set run login logic
if( isset($_POST['username']) && isset($_POST['password']) ) {
	WC_login_logic( $_POST, $LOGIN_ERROR);
}

