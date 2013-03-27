<?php
//include_once('../application/modules/login/controllers/login-control.php');

?> 
<!DOCTYPE HTML>
<html class="cssgradients"><!-- InstanceBegin template="/Templates/wordcruch.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Search | WordCrunch</title>
	<!-- InstanceEndEditable -->
	<!-- InstanceBeginEditable name="head" -->
	<link type="text/css" rel="stylesheet" href="css/main.css">
	<script></script>
	<!-- InstanceEndEditable -->
</head>
<body>
<!-- InstanceBeginEditable name="body2" -->
<!--index page container-->
	<div id="index_module" class="">
<!--header bar-->
		<header class="header margin-bott-3_5em"></header>
<!--main container-->
		<div id="main_container" class="">
		<div id="spinner" class="ajax-load"></div>
		<!--left side navigation fields-->
			<nav id="menu_navi" class="float-left">
				<ul>
					<li><a href="" id="keyword_button" class="backgr-win-blue backgr-win-purple-h"></a></li>
					<li><a href="" id="stats_button" class="backgr-win-blue backgr-win-purple-h"></a></li>
					<li><a href="" id="checklist_button" class="backgr-win-blue backgr-win-purple-h"></a></li>
					<li><a href="" id="help_button" class="backgr-win-blue backgr-win-purple-h"></a></li>
				</ul>
			</nav>
		<!--working container-->		
			<div id="work_container" class="backgr-win-white border-thin-grey float-left">
				<h2 id="menu_entry_displ" class="col-light-grey float-left margin-right-1-5em">Keyword search</h2>
				<nav id="function_navi" class="float-left">
					<ul class="float-left margin-bottom-1em">
						<li id="entry_edit" class="backgr-win-purple backgr-win-blue-h float-left div margin-right-025em"></li>
						<!--<li id="entry_delete" class="backgr-win-purple backgr-win-blue-h float-left  margin-right-025em"></li>-->
						<li id="entry_refresh" class="backgr-win-purple backgr-win-blue-h float-left  margin-right-2em"></li>
					</ul>
				<!-- form and search navigation-->
					<form id="form_search" name="form_search" class="float-left inl-block" action="">
							<input type="text" id="inp_search" list="search_list" class="inp-field margin-right-1em inl-block" name="search" placeholder="">
								<datalist id="search_list">
									<option value="Stromaufnahme">
									<option value="Spannungsversogung">
									<option value="----------------------">
									<option value="Current consumption">
									<option value="Stromversorgung">
									<option></option>
									<option></option>
									<option></option>
								</datalist>
							<!--<select id="lang_sele" class="inp-select margin-right-1em">
								<option selected>By Language</option>
								<option>By All</option>
								<option>By German</option>
								<option>By English</option>
								<option>By French</option>
								<option>By Dutch</option>
							</select>-->
					</form>
				</nav>
				
				
				<form action="" id="form_edit_entry" name="form_edit_entry" class="float-left inl-block margin-bottom-2em padd-top-2em padd-bott-1em border-top-thin-grey border-bott-thin-grey">
							<!--Radio button selection -->
							
							<input type="radio" checked name="change_db" value="edit_entry">&nbsp;&nbsp;<span class="margin-right-025em">Edit</span>&nbsp;&nbsp;
							<input type="radio" name="change_db"  value="new_entry" a>&nbsp;&nbsp;<span class="margin-right-025em">New</span>
							<input type="radio" name="change_db"  value="delete_entry">&nbsp;&nbsp;<span class="margin-right-025em">Delete</span>&nbsp;&nbsp;
							<!--END Radio button-->
							
							<input type="button" id="go_edit" name="go_edit" class="inl-block margin-right-1em margin-bottom-1em" value="Update"><br><br>
							
							<!--input fields for editing-->
							<input type="text" id="id_to_edit" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="id_to_edit" placeholder="Enter ID here">
							<input type="text" id="edit_german" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_german" placeholder="New German here">
							<input type="text" id="edit_english" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_english" placeholder="New English here">
							<input type="text" id="edit_french" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_french" placeholder="New French here">
							<input type="text" id="edit_dutch" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_dutch" placeholder="New Dutch here">
							<input type="text" id="edit_japanese" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_japanese" placeholder="New Japanese here">
							<input type="text" id="edit_italian" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_italian" placeholder="New Italian here">
							<input type="text" id="edit_spanish" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_spanish" placeholder="New Spanish here">
							<input type="text" id="edit_comments" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_comments" placeholder="Comments here">
							
					</form>
				<table class="" id="result">
						
						<thead >
							<tr class="">
								<th class="backgr-win-orange">ID</th>
								<th class="backgr-win-green">German</th>
								<th class="backgr-win-blue-shade-m">English</th>
								<th class="backgr-win-blue-shade-m">French</th>
								<th class="backgr-win-blue-shade-m">Dutch</th>
								<th class="backgr-win-blue-shade-m">Japanese</th>
								<th class="backgr-win-blue-shade-m">Italian</th>
								<th class="backgr-win-blue-shade-m">Spanish</th>
								<th class="backgr-win-blue-shade-m">Comments</th>
								<th class="backgr-win-blue-shade-m">Updated</th>
							</tr>
						</thead>
						<tbody>
						<tr>
								<td>Result will be displayed here</td>
						</tr>
							<!--<tr>
								<td>1</td>
								<td>German here1</td>
								<td>English here1</td>
								<td>French here1</td>
								<td>Dutch here1</td>
								<td>Japanese here1</td>
								<td>Italian here1</td>
								<td>Spanish here1</td>
								<td>Comments here1</td>
								<td>2013-01-26</td>
							</tr>
							<tr>
								<td>1</td>
								<td>German here1</td>
								<td>English here1</td>
								<td>French here1</td>
								<td>Dutch here1</td>
								<td>Japanese here1</td>
								<td>Italian here1</td>
								<td>Spanish here1</td>
								<td>Comments here1</td>
								<td>2013-01-26</td>
							</tr>
							<tr>
								<td>1</td>
								<td>German here1</td>
								<td>English here1</td>
								<td>French here1</td>
								<td>Dutch here1</td>
								<td>Japanese here1</td>
								<td>Italian here1</td>
								<td>Spanish here1</td>
								<td>Comments here1</td>
								<td>2013-01-26</td>
							</tr>
							<tr>
								<td>1</td>
								<td>German here1</td>
								<td>English here1</td>
								<td>French here1</td>
								<td>Dutch here1</td>
								<td>Japanese here1</td>
								<td>Italian here1</td>
								<td>Spanish here1</td>
								<td>Comments here1</td>
								<td>2013-01-26</td>
							</tr>-->
						</tbody>
					</table>
					<footer class="">
						<br>
						<div>
							<label>IDs used:</label>
							<input type="text" id="ids_used">
						</div>	
						<br>
						<p>Today: <span id="date"></span></p>	
					</footer>
				<!--<div id="user_feedback" class="gradient-yellow-rgb">Hell user feedack</div>-->	
				</div>
	<!--end work_container-->
		</div>
	</div>
<!-- InstanceEndEditable -->
<!--<script src="../js/libs/jQuery-v1.8.2.js"></script>-->
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src="js/control/controller.js"></script>
<script src="js/control/navi.js"></script>
<script src="js/model/db.js"></script>
<script src="js/view/update.js"></script>
</body>

<!-- InstanceEnd --></html>
