<?php

Class Profile extends CI_Model
{
	 function change_userdata($username, $password) {
	   $this -> db -> select('user_id, user_name, user_password');
	   $this -> db -> from('users');
	   $this -> db -> where('user_name', $username);
	   $this -> db -> limit(1);
	   $query = $this -> db -> get();

	   if($query -> num_rows() == 1)
	   {
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
	 }
	 
	 
}

?>