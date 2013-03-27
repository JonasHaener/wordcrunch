<?php
/*
 * DB VIEW
 *
 */

/**---------------------------
		View
 ---------------------------**/
/*
function WC_db_writer($db_data)
{
	
	
		// table to insert
		$table = "";
		// if no result rows assign message
		if ($db_data->num_rows === 0) {
			$table .= "<tr><td>Sorry, no match found</td></tr>";
		} else {
			// loop through results
			while ($row = $db_data ->fetch_assoc()) {
				$table .= "<tr>
					<td>{$row['id']}</td>
					<td>{$row['german']}</td>
					<td>{$row['english']}</td>
					<td>{$row['french']}</td>
					<td>{$row['dutch']}</td>
					<td>{$row['japanese']}</td>
					<td>{$row['italian']}</td>
					<td>{$row['spanish']}</td>
					<td>{$row['comments']}</td>
					<td>{$row['updated']}</td>
					</tr>";
			}
		}
		// send data back to Ajax		
		echo $table;
}*/

function WC_db_writer($arr_db_data)
{	
	
		$n;
		$res_all = array();
		
		for ($n = 0; $n < count($arr_db_data); $n += 1)
		{		
		
				$row = $arr_db_data[$n];
	
				$sub_res = $arr_db_data[$n];
				// counter for sup array position
				$c = 0;
				
				// if no result rows assign message
				if ($sub_res->num_rows === 0) {
					echo '{ "error":"Sorry, no match found" }';
					break;
					
				} else {
					
						$res = array();
							$res['counter'] = $c;
							$res['id'] = $row['id'];
							$res['german'] = $row['german'];
							$res['english'] = $row['english'];
							$res['french'] = $row['french'];
							$res['dutch'] = $row['dutch'];
							$res['japanese'] = $row['japanese'];
							$res['italian'] = $row['italian'];
							$res['spanish'] = $row['spanish'];
							$res['comments'] = $row['comments'];
							$res['updated'] = $row['updated'];
						// assign subresults to all results array
						
						$res_all[] = $res;
						$c = $c + 1;	
					}
				
		}
		// send data back to Ajax
	
		echo json_encode($res_all);
		// JSON_FORCE_OBJECT
}