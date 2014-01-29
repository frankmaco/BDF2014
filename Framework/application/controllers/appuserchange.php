<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class appuserchange extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('Profile','',TRUE);
 }

 function index()
 {
	//This method will have the credentials validation
   $this->load->library('form_validation');
   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
    $password = $this->input->post('newpassword');
	if(!empty($password)) {
		$this->form_validation->set_rules('newpassword', 'Password', 'trim|xss_clean');
   }
   if($this->session->userdata('logged_in')) {
		 $session_data = $this->session->userdata('logged_in');
		 $data['user_name'] = $session_data['username'];
		$userid = $this->input->post('userid');
		$username = $this->input->post('username');
	   $password = $this->input->post('newpassword');
	   
	   
	   if(!empty($password)) {
			$new_password = $this->create_new_appuser_password($password);
			$data = array('username' => $username, 'userpassword' => $new_password);
		}
		else {
			echo $username;
			$data = array('username' => $username);
		}
		$where = "id = " . $userid; 
		$str = $this->db->update('appusers', $data, $where);
		
		redirect('profile?id=' . $userid);
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
