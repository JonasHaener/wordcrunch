<?php
include_once('../models/db-model.php');


/*
	 * return string to Ajax
	 */ 
function return_data($db_data) {
$table = "";

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
	echo $table;
}
	

function controller($inp) {

//======== control input ============//
	

	if (isset($inp['search']))
	{	
	
		$search = $inp['search'];
	}
	else
	{
		return;
	}

//======== connect to DB ============//

	//$query = "SELECT*FROM person WHERE email={$user}";
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
	$conn = dbConnect("localhost", "jonasCanAll", "fridolin88", "wordcrunch");
	$query_res = $conn -> query($query);
//======== send data to returner ============//
	
	return_data($query_res);
	// release connection
	$query_res -> free_result();

}
controller($_REQUEST);