<?php

function dbConnect($host, $user, $passw, $db, $connectionType = 'mysqli') {
	// establish connection
	if ($connectionType === 'mysqli') {
			$conn = new mysqli($host, $user, $passw, $db) or die ('Cannot open database');
			if ($conn->connect_errno) {
					echo "failed to connect:{$conn->connect_error}";
			} else if ($conn) {
				//	echo "db connection established";
				
			}
			return $conn;
			
	} else {
			try {
				$conn = new PDO("mysql:host = $host; dbname = $db", $user, $pwd); 
				return $conn;
	
			} catch(PDOException $e) {
				return 'Cannot connect to database';
				exit;
				
			}
	
	}
}

