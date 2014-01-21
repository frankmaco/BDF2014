<?php
class AuthModel{
	
	private function start_a_new_connection($database_db) {
		$database['host'] = "localhost";
		$database['name'] = "bdf1312";
		$database['user'] = "user_frank";
		$database['pass'] = "frankspass";
		
		// ********** TRY DB CONNECTION
		try {
			$dbxb = new PDO("mysql:host=$database[host];dbname=$database[name]",$database['user'],$database['pass']);
			$dbxb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			return $dbxb;
		}
		catch(PDOException $e) { $e->getMessage();
			echo $e;
		}
		// ********** NO CONNECTION
		if(!$dbxb) {
			clean_destroy_all_sessions();
			redirect_user_fatal_error();
		}
	}
	
	public function check_and_verify_user_login($username) {
		$db_query =''; $db_params =''; $data_row = array();
		$db_conn = $this->start_a_new_connection();
		$db_query = "SELECT user_id, user_name, user_password FROM users WHERE user_name = :userName AND user_name !='' LIMIT 1";
		$db_params = array(':userName' => $username);
		try {
			$stmt = $db_conn->prepare($db_query); 
			$stmt->execute($db_params);
			$row = $stmt->fetch();
			if($row) {
				foreach($row as $row_id => $row_value) {
					if(!is_numeric($row_id)) {
						$data_row[$row_id] = $row_value;
					}
				}
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $data_row;
	}
	
}
?>