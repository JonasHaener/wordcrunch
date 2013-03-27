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
				$query;
				$search_term = "";
				$search_id = 0;
				// prepare statement
				
				// check if first array item is numeric
				if ( is_numeric($sear[0]) ) {
					
					for ($c = 0; $c < count($sear); $c += 1) {	
						 $search_id = $sear[$c];
						 $sql_id = "SELECT 
						 id, german, english, french, 
						 dutch, japanese, italian, spanish,comments, updated 
						 FROM keywords WHERE id = '{$search_id}'";
						
						 $res = $this->db_conn->query( $sql_id );
						
						 while ( $row = $res -> fetch_assoc() ) {
						 		 $arr_res[] = $row; 	
						}
					}
					// assign result to results array
					$this->db_res = $arr_res;	
				
				// if nor numeric assign as string
				} else {
				
					$search_term_1 = '%' . $sear[0] . '%';
					$search_term_2 = '%' . $sear[0] . '%';
					$search_term_3 = '%' . $sear[0] . '%';
					$search_term_4 = '%' . $sear[0] . '%';
					$search_term_5 = '%' . $sear[0] . '%';
					$search_term_6 = '%' . $sear[0] . '%';
					$search_term_7 = '%' . $sear[0] . '%';
					$search_term_8 = '%' . $sear[0] . '%';
						
					// DB query
					$sql_term = "
						SELECT
							id, german, english, french, 
							dutch, japanese, italian, spanish,comments, updated 
						FROM
							keywords 
						WHERE 
							(german LIKE ?) OR
							(english LIKE ?) OR
							(french LIKE ?) OR
							(dutch LIKE ?) OR
							(japanese LIKE ?) OR
							(italian LIKE ?) OR
							(spanish LIKE ?) OR
							(comments LIKE ?)";
				
						
						// args[0] '$data_type', '$connection', '$sql'
						// args[1][0...] $term, $term, $term...
					function WC_db_helper_prepStatement ($args, $para) {
							
							echo $args[1][1];
							$conn = $args[0]['connection'];
							$stmt = $conn->stmt_init();
							$stmt->prepare($args[0]['sql']);
							
							// convert array to string
							//$stmt_args = implode( ",", $args[1] );
							$stmt_args = "";
												
							
							
							// prep arguments
							//$stmt->bind_param($args[0]['data_type'], $stmt_args);
							//$stmt->bind_param($para);
							$stmt->bind_param($para); 
							$stmt->bind_result($id, $german, $english, $french, $dutch, $japanese,$italian,$spanish,$comments, $updated);
							
							$stmt->execute();
							
							$stmt->store_result();
							
							$arr_res = array();
							while ($stmt -> fetch() ) {
									$temp_arr = array();
									
									$temp_arr['id']			= $id;
									$temp_arr['german']		= $german;
									$temp_arr['english']		= $english;
									$temp_arr['french'] 		= $french; 
									$temp_arr['dutch'] 		= $dutch;
									$temp_arr['japanese']	= $japanese;
									$temp_arr['italian'] 	= $italian;
									$temp_arr['spanish'] 	= $spanish;
									$temp_arr['comments'] 	= $comments;
									$temp_arr['updated'] 	= $updated;
									
									$arr_res[] = $temp_arr;
							}
							//return res;
							$stmt->close();
							return $arr_res;
						}
						
						// pass arguments to 
						$bind_param = array(
								array('data_type' => 'ssssssss', 'connection' => $this->db_conn, 'sql' => $sql_term),
								array($sear[0], 
										$sear[0], 
										$sear[0], 
										$sear[0], 
										$sear[0], 
										$sear[0], 
										$sear[0], 
										$sear[0]
										),
								array($id, 
										$german, 
										$english, 
										$french, 
										$dutch, 
										$japanese, 
										$italian, 
										$spanish, 
										$comments, 
										$updated	
								)
						);
										
						$this->db_res = WC_db_helper_prepStatement($bind_param, $para);
						$this->db_conn->close();
	
	/*					
	
										
						if ($stmt->prepare( $sql_term )) {
							$stmt->bind_param('ssssssss', $search_term_1, $search_term_2, $search_term_3, $search_term_4, $search_term_5, $search_term_6, $search_term_7, $search_term_8);
							$stmt->bind_result($id, $german, $english, $french, $dutch, $japanese, $italian, $spanish, $comments, $updated);
							$stmt->execute();
							$stmt->store_result();
							
				
							// push results rows!! into array
							while ($stmt -> fetch() ) {
									$temp_arr = array();
								
									$temp_arr['id']			= $id;
									$temp_arr['german']		= $german;
									$temp_arr['english']		= $english;
									$temp_arr['french'] 		= $french; 
									$temp_arr['dutch'] 		= $dutch;
									$temp_arr['japanese']	= $japanese;
									$temp_arr['italian'] 	= $italian;
									$temp_arr['spanish'] 	= $spanish;
									$temp_arr['comments'] 	= $comments;
									$temp_arr['updated'] 	= $updated;
									
									$arr_res[] = $temp_arr;
							
							}
							// free results for next loop
							//$res -> free_result();
							$stmt -> free_result();
						
						} else {
							echo $stmt->error;	
						}
					}
				}
				// close prepared statement
				$stmt->close();
				// pass results array
			*/	
				//$this->db_res = $arr_res;
				
				
		}
		
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
