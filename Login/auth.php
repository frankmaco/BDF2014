<?php
session_start();
include 'AuthModel.php';
include 'AuthView.php';

$contentPage = 'form';
$user_data =array();

if(isset($_SESSION['userInfo'])) {
	$contentPage = 'success';
}
elseif(isset($_POST)) {
	if(isset($_SESSION['token_id'])) {
		if($_SESSION['token_id'] == $_POST['token']) {
			if(!empty($_POST['username']) && !empty($_POST['password'])) {
				$model = new AuthModel;
				$user_data = $model->check_and_verify_user_login($_POST['username']);
				$model =null;
				
				if(!empty($user_data)) {
					if(password_verify($_POST['password'], $user_data['user_password'])) {
						$_SESSION['userInfo'] = $user_data;
						$contentPage ='success';
					}
				}
				else {
					// NO MATCH
				}
			}
		}
	}
}
else {
	session_destroy(); $_SESSION = array(); session_regenerate_id(true); exit(header('Location:../index.php'));
}
$_SESSION['token_id'] = md5(uniqid(rand(), TRUE));

function clean_text_string($clean_input) {
	$clean_input = strip_tags($clean_input);
	$clean_input = htmlspecialchars($clean_input, ENT_QUOTES, 'UTF-8');
	$clean_input = preg_replace('!\s+!', ' ', $clean_input);
	$clean_input = trim($clean_input);
	return $clean_input;
}

$view  = new AuthView();
$view->show('header');
$view->show($contentPage);
$view->show('footer');
$view =null;
?>