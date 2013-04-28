<?php
require_once('./includes/handling_functions.inc.v1.0.php');
require_once('./includes/set_path.inc.v1.0.php');
$error = "";
if (isset($_POST['username']) && isset($_POST['pwd'])) {
	 session_start();
	 ob_start();
	 $username = htmlchars($_POST['username']); //use handling function
	 $password = htmlchars($_POST['pwd']); //use handling function
	 //location of usernames and passwords
	 $login_ok = false;
	 $userlist = './private/user_login_data_v1.0.txt';
	 $redirect = "{$abs_path}index.php";
	 // user authentication
	 require_once('./includes/authenticate.inc.v1.0.php');
}
?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description"
      content="Calculate your price for technical writing, packaging artwork and technical translations" />
<title>Login | Eggbasegroup</title>
<link type="text/css" rel="stylesheet" href="<?php echo $abs_path;?>libs/css/login_v01.css">
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" href="<?php echo $abs_path;?>libs/css/login_IE_lte7_fix_v01.css">
<![endif]-->
<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $abs_path;?>libs/css/login_mquer_ie_lt9_v01.css"/>
<![endif]-->
<script src="<?php echo $abs_path;?>libs/js/calculator/modernizr.custom.59742_all_features.js"></script>
</head>
<body>
<article>
	<div id="content">
<!-----------------------------Section Login form------------------->		
	<section id="login_page" class="c_section">
			<header>
				<hgroup>
					<h1>Eggbasegroup</h1>
				</hgroup>
			</header>
			<section id="login_form">
			<?php 
			if ($error) { echo "<p class='error'>$error</p>";
			} elseif (isset($_GET['expired'])) {
			?>
			<p class="error">Your session has expired, please login again.</p>
			<?php } ?>
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
					<label for="name">Name:</label>
					<input type="text" id="username" name="username" required placeholder="Your username">
					<label for="pwd">Password:</label>
					<input type="password" id="pwd" name="pwd" required placeholder="•••••••••">
					<input type="submit" id="login" name="login"<?php
							//if error is blank form was not submitted or there are no error after validation
							if (!$login_ok) { 
								echo 'value="Log In"';
							} elseif ($login_ok) {
							 	echo 'disabled="disabled" value="Logged In!"';
							} ?>>	
				</form>				
			</section>
	</section>	
	</div>
</article>
<script src="<?php echo $abs_path;?>libs/js/jQuery_v172.js"></script>
<script src="<?php echo $abs_path;?>libs/js/egb_login_v1.0.js"></script>
</body>
</html>
