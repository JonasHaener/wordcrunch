<?php
require_once('../application/modules/helpers/db-class-connect.inc.php');
require_once('../application/modules/login/controllers/login-class-controller.inc.php');
require_once("../application/modules/login/login-logic.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>login | wordcrunch</title>
</head>
<body>
<span><?php echo $LOGIN_ERROR; ?></span>
<form name="login" action="" method="post">
	<input type="text" name="username"><br>
	<input type="password" placeholder="Enter PW here" name="password"><br>
	<button type="submit">Login</button>
</form>
</body>
</html>