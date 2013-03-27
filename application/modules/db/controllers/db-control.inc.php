<?php
/*
 * DB CONTROLLER
 *
 */


/**---------------------------
		Dependencies
 ---------------------------**/
require_once('../../helpers/db-class-connect.inc.php');
require_once('../models/db-class-create.inc.php');
require_once('../models/db-class-fetch.inc.php');
require_once('../models/db-class-update.inc.php'); //blocking
require_once('../models/db-class-delete.inc.php');
require_once('../view/db-view.inc.php');




/**---------------------------
		Controller
 ---------------------------**/
//JSON
function WC_db_controller($inp) 
{	
		// database connection
		$db;
	
		// search data
		if (isset($inp['search'])) {	
			$db = new WC_DB_fetch("localhost", "jonasCanAll", "fridolin88", "wordcrunch", 'mysqli', $inp['search']);
		}
		// create data
		if (isset($inp['change_db']) && $inp['change_db'] === "new_entry") {
			$db = new WC_DB_create("localhost", "jonasCanAll", "fridolin88", "wordcrunch", 'mysqli', $inp);
			//echo 'NEW';
		}
		// update data
		if (isset($inp['change_db']) && $inp['change_db'] === "edit_entry" && isset($inp['id_to_edit']) && $inp['id_to_edit'] !== "") {
				
				$db = new WC_DB_updater("localhost", "jonasCanAll", "fridolin88", "wordcrunch", 'mysqli', $inp);
				//echo 'UPDATE';
		
		}
		// delete data
		if (isset($inp['change_db']) && $inp['change_db'] === "delete_entry" && isset($inp['id_to_edit']) && $inp['id_to_edit'] !== "" ) {
			$db = new WC_DB_delete("localhost", "jonasCanAll", "fridolin88", "wordcrunch", 'mysqli', $inp);	
		}
		
		// fetch data for editor form >> Must be last to avoid conflict
		// !! checks if input is_numeric (if blank then it no numeric)
		if (is_numeric($inp['id_to_edit']) && !isset($inp['change_db']) && $inp['change_db'] !== "") {
			$db = new WC_DB_fetch("localhost", "jonasCanAll", "fridolin88", "wordcrunch", 'mysqli', $inp['id_to_edit']);
			//echo 'FETCH';
		}

		// send data to returner
		WC_db_writer($db->db_res);
}


// call DB controller
WC_db_controller($_POST);