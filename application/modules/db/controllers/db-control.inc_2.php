<?php
/*
 * DB CONTROLLER
 *
 */
echo "received JSON";
/**---------------------------
		Dependencies
 ---------------------------**/
require_once('../models/db-model.inc.php');
require_once('../view/db-view.inc.php');



/**---------------------------
		Controller
 ---------------------------**/
function WC_db_controller($inp) 
{
		//control input
		if (isset($inp['search'])) {	
			$search = $inp['search'];
		} else {
			return;
		}
		
		// DB query
		$query = "SELECT*FROM keywords WHERE 
						(german='{$search}') OR 
						(english='{$search}') OR
						(french='{$search}') OR
						(dutch='{$search}') OR
						(japanese='{$search}') OR
						(italian='{$search}') OR
						(spanish='{$search}') OR
						(comments='{$search}')
						";
					
		// DB results object
		$db = new WC_DB_fetch("localhost", "jonasCanAll", "fridolin88", "wordcrunch", 'mysqli', $query);
		
		// send data to returner
		WC_db_writer($db->db_res);
		$db->freeRes();
}

// call DB controller
WC_db_controller($_REQUEST);