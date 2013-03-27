<?php
/*
 * DB VIEW
 *
 */

/**---------------------------
		View
 ---------------------------**/
/*
 * DB view
 * prepares input from model
 * and return JSON back to AJAX model
 *
 */

function WC_db_writer($arr_db_data)
{	
	$n;
	$res_all = array();
	// loop results array
	for ( $n = 0; $n < count($arr_db_data); $n += 1 ) {		
		$row = $arr_db_data[$n];
		$sub_res = $arr_db_data[$n];
		// counter for sup array position
		$c = 0;
		// if no result rows assign message
		$res = array();
		$res['counter']  	= $c;
		$res['id'] 		  	= $row['id'];
		$res['german']   	= $row['german'];
		$res['english']  	= $row['english'];
		$res['french']   	= $row['french'];
		$res['dutch']    	= $row['dutch'];
		$res['japanese'] 	= $row['japanese'];
		$res['italian']  	= $row['italian'];
		$res['spanish']  	= $row['spanish'];
		$res['comments'] 	= $row['comments'];
		$res['updated']  	= $row['updated'];
		// sends status back to AJAX
		$res['status']  	= $row['status'];			
		// assign subresults to all results array
		$res_all[] = $res;
		$c = $c + 1;	
	}
	// send data back to Ajax
	echo json_encode($res_all);
}