<?php

function destroy_and_redirect() {
	session_destroy(); $_SESSION = array(); session_regenerate_id(true); exit(header('Location:' . LOGINURL));
}

function clean_text_string($clean_input) {
	$clean_input = strip_tags($clean_input);
	$clean_input = htmlspecialchars($clean_input, ENT_QUOTES, 'UTF-8');
	$clean_input = preg_replace('!\s+!', ' ', $clean_input);
	$clean_input = trim($clean_input);
	return $clean_input;
}

function process_user_login($postValues) {
	if(isset($_SESSION['token_id'])) {
		if($_SESSION['token_id'] == $postValues['token']) {
			if(!empty($postValues['username']) && !empty($postValues['password'])) {
				require('UserModal.php');
				$model = new UserModel;
				$user_data = $model->check_and_verify_user_login($postValues['username']);
				$model =null;

				if(!empty($user_data)) { 
					if(password_verify($postValues['password'], $user_data['user_password'])) {
						$_SESSION['userInfo'] = $user_data;
						exit(header('Location:' . LOGINURL));
					}
				} else { destroy_and_redirect(); }
			} else { destroy_and_redirect(); }
		} else { destroy_and_redirect(); }
	} else { destroy_and_redirect(); }
}


function process_update_user($postValues, $user_id) {
	if(isset($_SESSION['token_id'])) {
		if($_SESSION['token_id'] == $postValues['token']) {
			if(!empty($postValues['username'])) {
				$check_user_id ='';
				$model = new UserModel;
				$check_user_id = $model->check_if_username_exist($postValues['username'], $user_id);
				$model = NULL;
				if(!empty($check_user_id) && empty($postValues['password'])) {
					if($user_id == $check_user_id) {
						$_SESSION['newUserError'] = 'Same Username, No Change';
					}
					else {
						$_SESSION['newUserError'] = 'Username Already Exist';
					}
					exit(header('Location:' . LOGINURL . 'index.php?id=' . $user_id));
				}
				##										UPDATE PASSWORD
				if(!empty($postValues['password'])) {
					$eudu = new editUpdateDeleteUser;
					$password = $eudu->create_new_password($postValues['password']);
					$eudu = null;
					
					$model = new UserModel;
					$model->update_user_profile_info_pass($postValues['username'], $password, $user_id);
					$model = NULL;
				}
				else {
					$model = new UserModel;
					$model->update_user_profile_info($postValues['username'], $user_id);
					$model = NULL;
				}
				exit(header('Location:' . LOGINURL . 'index.php?id=' . $user_id));			
			} else { destroy_and_redirect(); }
		} else { destroy_and_redirect(); }
	} else { destroy_and_redirect(); }
}


function process_new_user($postValues) {
	unset($_SESSION['newUserError']);
	if(isset($_SESSION['token_id'])) {
		if($_SESSION['token_id'] == $postValues['token']) {
			if(!empty($postValues['newusername']) && !empty($postValues['password'])) {
				$user_id ='';
				$model = new UserModel;
				$user_id = $model->check_if_username_exist($postValues['newusername']);
				$model = NULL;
				if(!empty($user_id)) {
					$_SESSION['newUserError'] = 'Username Already Exist';
					exit(header('Location:' . LOGINURL . 'index.php?adduser=true'));
				}
				
				$eudu = new editUpdateDeleteUser;
				$password = $eudu->create_new_password($postValues['password']);
				$eudu = null;
				
				$model = new UserModel;
				$user_id = $model->add_new_user_profile($postValues['newusername'], $password);
				$model = NULL;
				
				exit(header('Location:' . LOGINURL . 'index.php?id=' . $user_id));
			}
			else {
				$_SESSION['newUserError'] = 'Username and Password Required';
				exit(header('Location:' . LOGINURL . 'index.php?adduser=true'));
			}
		} else { destroy_and_redirect(); }
	} else { destroy_and_redirect(); }
}


class UsersView{
	public function showUsers($base, $users) {
		$all_users ='';
		foreach ($users as $num=> $row){	
			$all_users .='
			<article>
			<h1>' . $row['id'] . '</h1>
			<h2>' . $row['username'] . '</h2>
			<a href="' . $base. '?id=' . $row['id'] . '">profile</a>
			</article>';
		}
		return $all_users;
	}
}

class UserView{
	public function showUser($base, $user){
		$_SESSION['token_id'] = md5(uniqid(rand(), TRUE));
		$show_error ='';
		if(isset($_SESSION['newUserError'])) {
			$show_error ='
				<h3>Error: ** ' . $_SESSION['newUserError'] . '</h3>
			';
			unset($_SESSION['newUserError']);
		}
		return '
		<article>
		' . $show_error . '
		<h1>USER ID: ' . $user['id'] . '</h1>
		<h2>USER NAME: ' . $user['username'] . '</h2>
		<h1><a href="' . LOGINURL . $base . '?id=' . $user['id'] . '&delete=true">delete user</a></h1>
		<h3>Edit User Info</h3>
		<form action="' . LOGINURL . 'index.php?id=' . $user['id'] . '" method="POST">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" maxlength="20" size="20" value="' . $user['username'] . '"/><br/>
		<label for="password">New Password:</label>
		<input type="password" name="password" id="password" maxlength="20" size="20"/><br/>
		<input type="hidden" name="token" value="' . $_SESSION['token_id'] . '" />
		<input type="submit"/>
		</form>
		<a href="' . LOGINURL . $base . '">back</a>
		</article>
		';
	}
}

class editUpdateDeleteUser {

	public  function create_new_password($password) {	
		$password_options = array(); $values = array();
		$password_options = [
			'cost' => 12,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		return password_hash($password, PASSWORD_DEFAULT, $password_options);
	}

}

?>