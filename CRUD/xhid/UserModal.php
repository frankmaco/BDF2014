<?php

class UserModel{
	
	private function start_a_new_connection() {
		$database['host'] = "localhost";
		$database['name'] = "bdf1312";
		$database['user'] = "userfrank";
		$database['pass'] = "passfrankpass";
		
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
		}
	}
	
	private function process_query_results($row) {
		$data_row = array();
		foreach($row as $row_id => $row_value) {
			$data_row[] = $row_value;
		}
		return $data_row;
	}
	
	private function process_single_query_result($row) {
		$data_row = array();
		foreach($row as $row_id => $row_value) {
			if(!is_numeric($row_id)) {
				$data_row[$row_id] = $row_value;
			}
		}
		return $data_row;
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
				$data_row = $this->process_single_query_result($row);
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $data_row;
	}
	
	
	public function getUsers(){		
		$db_query =''; $db_params =''; $data_row = array();
		$db_conn = $this->start_a_new_connection();
		try {
			$db_query = $db_conn->prepare("SELECT id, username FROM appusers WHERE username !=''");
			$db_query->execute();
			$row = $db_query->fetchAll(PDO::FETCH_ASSOC);
			if($row) {
				$data_row = $this->process_query_results($row);
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $data_row;		
	}


	public function check_if_username_exist($newusername){
		$db_query =''; $db_params =''; $data_row = array();
		$db_conn = $this->start_a_new_connection();
		$db_query = "SELECT id, username FROM appusers WHERE username = :userName AND username !='' LIMIT 1";
		$db_params = array(':userName' => $newusername);
		try {
			$stmt = $db_conn->prepare($db_query); 
			$stmt->execute($db_params);
			$row = $stmt->fetch();
			if($row) {
				$data_row = $row['id'];
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $data_row;
	}
	
	public function getUser($user_id){
		$db_query =''; $db_params =''; $data_row = array();
		$db_conn = $this->start_a_new_connection();
		$db_query = "SELECT id, username, userpassword FROM appusers WHERE id = :userId AND id !='' LIMIT 1";
		$db_params = array(':userId' => $user_id);
		try {
			$stmt = $db_conn->prepare($db_query); 
			$stmt->execute($db_params);
			$row = $stmt->fetch();
			if($row) {
				$data_row = $this->process_single_query_result($row);
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $data_row;
	}
	
	public function update_user_profile_info($username, $user_id) {
		$db_conn = $this->start_a_new_connection();
		$db_query = "UPDATE appusers SET username = :userName WHERE id = :userId LIMIT 1";
		$db_params = array(':userName' => $username, ':userId' => $user_id);
		try
		{ 
			$stmt = $db_conn->prepare($db_query); 
			$stmt->execute($db_params);
		}
		catch(PDOException $ex) 
		{
			echo $ex->getMessage();
		}
	}
	
	public function add_new_user_profile($username, $password) {
		$db_conn = $this->start_a_new_connection();
		$db_query = "INSERT INTO appusers (username, userpassword) value (:newUsername, :newPassword)";
		$db_params = array(':newUsername'=>$username, ':newPassword'=>$password);
		try
		{ 
			$stmt = $db_conn->prepare($db_query); 
			$stmt->execute($db_params);
		}
		catch(PDOException $ex) 
		{
			echo $ex->getMessage();
		}
		return $db_conn->lastInsertId();
	}
	
	public function update_user_profile_info_pass($username, $password, $user_id) {
		$db_conn = $this->start_a_new_connection();
		$db_query = "UPDATE appusers SET username = :userName, userpassword = :passWord WHERE id = :userId LIMIT 1";
		$db_params = array(':userName' => $username, ':passWord' => $password, ':userId' => $user_id);
		try
		{ 
			$stmt = $db_conn->prepare($db_query); 
			$stmt->execute($db_params);
		}
		catch(PDOException $ex) 
		{
			echo $ex->getMessage();
		}
	}
	
	public function delete_user_profile($user_id) {
		$db_conn = $this->start_a_new_connection();
		$db_query = "DELETE FROM appusers WHERE id = :userId";
		$stmt = $db_conn->prepare($db_query);
		$stmt->bindParam(':userId', $user_id, PDO::PARAM_INT);   
		$stmt->execute();
	}
	
}

?>