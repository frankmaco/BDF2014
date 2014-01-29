<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class AddUser extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

	function getUsers(){
		$this -> db -> select('id, username');
		$this -> db -> from('appusers');
		$query = $this -> db -> get();
		$all_users = '';
	   if($query -> num_rows() > 0) {
			$all_user_results = $query->result();
			 foreach($all_user_results as $row) {
				$new_result = get_object_vars($row);
				$all_users .='
					<article>
					<h1>' . $new_result['id'] . '</h1>
					<h2>' . $new_result['username'] . '</h2>
					'  . anchor('profile?id=' . $new_result['id'] . '', 'View Profile', 'class="link-class"') . '
					</article>
				';
			}
		}
		else {
			$all_users ='
				<article>
					<h1>No Current Users!</h1>
				</article>
			';
		}
		return $all_users;		
	}
	
 function index()
 { 
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['user_name'] = $session_data['username'];
	$this->load->helper(array('form'));
     $this->load->view('addnew_view', $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

}

?>