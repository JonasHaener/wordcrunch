<?php
require_once('../application/modules/helpers/wc-db-class-connect.inc.php');
require_once('../application/modules/login/controllers/wc-login-class-control.inc.php');
require_once("../application/modules/login/wc-login-logic.php");
?>
<!DOCTYPE HTML>
<html class="cssgradients"><!-- InstanceBegin template="/Templates/wordcruch.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>login|wordcrunch</title>
	<!-- InstanceEndEditable -->
	<!-- InstanceBeginEditable name="head" -->
	<link type="text/css" rel="stylesheet" href="css/wc-main.css">
	<script src="libs/js/calculator/modernizr.custom.59742_all_features.js"></script>
	<!-- InstanceEndEditable -->
</head>
<body>
<!-- InstanceBeginEditable name="body2" -->
	<div id="login_module" class="@@backgr-grey-l">
		<div id="container">
			<section id="login_page" class="c_section border-bott-thin-grey">
				<header class="backgr-win-blue bottom-border-thin-light"><h1 class="txt-light-blue center-text emboss-black-bot">@wordcrunch</h1></header>
				<div id="login_form" class="backgr-grey-vl">
				<?php 
				if ($LOGIN_ERROR) { echo "<p class='error margin-bottom-1em'>$LOGIN_ERROR</p>";
				} elseif (isset($_GET['expired'])) {
				?>
				<p class="error">Your session has expired, please login again.</p>
				<?php } ?>
				<form action="" method="post">
						<input type="text" id="username" name="username" class="margin-right-3em focus field-border" required placeholder="Your username">
						<input type="password" id="password" name="password" class="margin-right-3em focus field-border" required placeholder="Your password">
						<input type="submit" class="gradient-black-rgb-vlight box-shadow-lit" id="submit" name="login"<?php
								//if error is blank form was not submitted or there are no error after validation
								if (!$login_ok) { 
									echo 'value="Log In"';
								} elseif ($login_ok) {
									echo 'disabled="disabled" value="Logged In!"';
								} ?>>	
					</form>				
				</div>
			</section>
		</div>
	</div>
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src=""></script>
<!-- InstanceEndEditable -->
<!--<script src="../js/libs/jQuery-v1.8.2.js"></script>-->
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src="js/modules/db/control/wc-db-control.js"></script>
<script src="js/modules/db/model/wc-db-model.js"></script>
<script src="js/modules/db/view/wc-db-view-update.js"></script>
<script src="js/modules/interface/wc-db-navi.js"></script>
</body>

<!-- InstanceEnd --></html>
