<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class addnewuser extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

function cleantextstring($clean_input) {
	$clean_input = strip_tags($clean_input);
	$clean_input = htmlspecialchars($clean_input, ENT_QUOTES, 'UTF-8');
	$clean_input = preg_replace('!\s+!', ' ', $clean_input);
	$clean_input = trim($clean_input);
	return $clean_input;
}


 function index()
 {
	//This method will have the credentials validation
   
   if($this->session->userdata('logged_in')) {
			
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$new_password = $this->create_new_appuser_password($password);
		$data = array('username' => $username, 'userpassword' => $new_password);
		$str = $this->db->insert('appusers', $data);
		$last_id =  $this->db->insert_id();
		
		 $session_data = $this->session->userdata('logged_in');
		 $data['user_name'] = $session_data['username'];
		redirect('profile?id=' . $last_id);
	}
	else {
		//If no session, redirect to login page
		redirect('login', 'refresh');
	 }

 }
 
 function create_new_appuser_password($password) {
	$password_options = array(); $values = array();
		$password_options = [
			'cost' => 12,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		return password_hash($password, PASSWORD_DEFAULT, $password_options);
 }

}
?>
