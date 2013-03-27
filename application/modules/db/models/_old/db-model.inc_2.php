<?php
/*
 * DB MODEL
 *
 */


/**---------------------------------------
		CLASS – WC_DB_connect
		connect to database mysqli or PDO
 ---------------------------------------**/
class WC_DB_connect
{
		// holds public DB connection
		public $conn;
		// holds errors
		public $err="";
		// construct
		public function __construct($host, $user, $passw, $db, $connectionType) 
		{		
				if ($connectionType === 'mysqli') {
					$this->conn = new mysqli("localhost", "jonasCanAll", "fridolin88", "wordcrunch") or die ('Cannot open database');
					// assign error in case
					if ($this->conn->connect_errno) {
						$this->err = "failed to connect:{$conn->connect_error}";
					}
					 
				} elseif ($connectionType === 'pdo') {
					try {
						$this->conn = new PDO("mysql:host = $host; dbname = $db", $user, $pwd); 
					
					// catch connection error
					} catch(PDOException $e) {
						return 'Cannot connect to database';
						// exit connection if error
						exit;
					}
				}
		}
		// destruct
		public function __destruct()
		{
			
		}	
}

/**---------------------------
		CLASS – WC_DB_fetch
		fetch data from database
 ---------------------------**/
class WC_DB_fetch
{		
		private $db_conn;
		public $db_res;
		
		// fetcher query function
		private function fetcher($search) {	
			$c;
			$sear = explode(",", $search);
			$arr_res = array();
		
			for ($c = 0; $c < count($sear); $c += 1) 
			{		
					$search_var = $sear[$c];
		
					// DB query
					$query_keyw = "SELECT*FROM keywords WHERE 
						(german LIKE '%{$search_var}') OR 
						(english LIKE '%{$search_var}') OR
						(french LIKE '%{$search_var}') OR
						(dutch LIKE '%{$search_var}') OR
						(japanese LIKE '%{$search_var}') OR
						(italian LIKE '%{$search_var}') OR
						(spanish LIKE '%{$search_var}') OR
						(comments LIKE '%{$search_var}')";
						
					$query_id = "SELECT*FROM keywords WHERE id = '{$search_var}'";
					// if first array item is numeric then search by id
					$query = ( is_numeric($sear[0]) ) ? $query_id : $query_keyw;
					
									
					$res = $this->db_conn->query($query);
					
					// push results rows!! into array
					while ($row = $res -> fetch_assoc()) {
						$arr_res[] = $row; 	
					}
					
					// free results for next loop
					$res -> free_result();
					
				}
				// pass results array
				$this -> db_res = $arr_res;
				
		}
		// release DB
		public function freeRes() {
				//$this->db_res->free_result();
		}
		
		// constructor
		public function __construct($host, $user, $passw, $db, $connectionType, $search, $query)
		{
			// call DB connection class establish connection
			$connected = new WC_DB_connect($host, $user, $passw, $db, $connectionType);
			
			$this->db_conn = $connected->conn; 													
			// in case of error assign error to result
			if ($connected->err) {
				$this->db_res = $connected->err;
			} else {		
		
				// call fetcher and send db query
				$this->fetcher($search, $query);
			}
		}
		// destructor
		private function __destruct()
		{
				// release search result
		}
}

/**---------------------------
		CLASS – WC_DB_update
		update and enter to database
 ---------------------------**/

class WC_DB_update
{	
		private $db_conn;
		// constructor
		// constructor
		public function __construct($host, $user, $passw, $db, $connectionType, $search, $query)
		{
			// call DB connection class establish connection
			$connected = new WC_DB_connect($host, $user, $passw, $db, $connectionType);
			
			$this->db_conn = $connected->conn; 													
			// in case of error assign error to result
			if ($connected->err) {
				$this->db_res = $connected->err;
			} else {		
		
				// call fetcher and send db query
				$this->fetcher($search, $query);
			}
		}
		
		// fetcher query function
		private function fetcher($search) {	

				// if the id to update is not numeric then return immediately	
				if ( !is_numeric($search['id_to_edit']) ) {
						return;
				}	
				
				// DB query
				$query = "UPDATE keywords SET 
									german='{$search['edit_german']}',".
									"english='{$search['edit_english']}',".
									"french='{$search['edit_french']}',".
									"dutch='{$search['edit_dutch']}',".
									"japanese='{$search['edit_japanese']}',".
									"italian='{$search['edit_italian']}',".
									"spanish='{$search['edit_spanish']}',".
									"comments='{$search['edit_comments']}'".
									"WHERE id='{$search['id_to_edit']}'";
				
				
				// send query to DB				
				$res = $this->db_conn->query($query);
				
				$row;
				$arr_res = array();
				while ($row = $res -> fetch_assoc()) {
						$arr_res[] = $row;
						// free results for next loop
						$res -> free_result();
				}
	
				// pass results array
				$this -> db_res = $arr_res;
				
		}		
	
		// destructor
		private function __destruct()
		{
			
		}
	

}

/**---------------------------
		CLASS – WC_DB_update
		delete from database
 ---------------------------**/
class WC_DB_delete
{		
}
