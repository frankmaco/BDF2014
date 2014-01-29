<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	 }
	 
	 
	 function getUserBasedOnId($appuser_id){
		$this -> db -> select('id, username');
		$this -> db -> from('appusers');
		$this -> db -> where('id', $appuser_id);
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		
	   if($query -> num_rows() ==1) {
			$appuser_result = $query->result();
			 foreach($appuser_result as $row) {
				$new_result = get_object_vars($row);
			}
			return $new_result;
		}
		else {
			redirect('home');
		}
		return $all_users;		
	}
 
	function check_user_get_id() {
		if(!isset($_GET['id'])) {
			redirect('home');
		}
		if(!is_numeric($_GET['id'])) {
			redirect('home');
		}
		return $_GET['id'];
	}
	
	function index() {
	  if($this->session->userdata('logged_in')) {
		 $session_data = $this->session->userdata('logged_in');
		 $data['user_name'] = $session_data['username'];
		 $appuser_id = $this->check_user_get_id();
		 if(isset($_GET['delete'])) {
			$this->db->delete('appusers', array('id' => $_GET['id'])); 
		}
		 $app_user_data = $this->getUserBasedOnId($appuser_id);
		 $data['appuser_id'] = $app_user_data['id'];
		 $data['appuser_name'] = $app_user_data['username'];
		 $this->load->helper(array('form'));
		 $this->load->view('profile_view', $data);
	   }
	   else {
			//If no session, redirect to login page
			redirect('login', 'refresh');
	   }
	}
 }

?>