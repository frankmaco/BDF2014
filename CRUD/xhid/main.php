<?php
##										START SESSION
session_start();
define("LOGINURL", "http://192.241.155.197/");
##										LOGOUT
if(isset($_GET['logout'])) {
	session_destroy(); $_SESSION = array(); session_regenerate_id(true); exit(header('Location:' . LOGINURL));
}
$show_page ='';
##										PROCESS
require_once("process.php");

$query = $_SERVER['PHP_SELF'];
$path = pathinfo($query);
$base = $path['basename'];

##										USER IS LOGGED IN
if(isset($_SESSION['userInfo'])) {
	$show_page ='
		<header>
			<p>Welcome back <strong>' . clean_text_string($_SESSION['userInfo']['user_name']) . '!</strong> | <a href="' . LOGINURL . 'index.php?logout=true">LOGOUT</a></p>
		</header>
		<hr />
		<p><a href="' . LOGINURL . 'index.php">View All Users</a> | <a href="' . LOGINURL . 'index.php?adduser=true">Add New User</a></p>
	';
	require_once("UserModal.php");
	if(isset($_GET['adduser'])) {
		if(isset($_POST) && !empty($_POST)) {
			if(isset($_POST['newusername'])) {
				process_new_user($_POST);
			}
		}
		if($_GET['adduser'] =="true") {
			$_SESSION['token_id'] = md5(uniqid(rand(), TRUE));
			$show_error ='';
			if(isset($_SESSION['newUserError'])) {
				$show_error ='
					<h3>Error: ** ' . $_SESSION['newUserError'] . '</h3>
				';
				unset($_SESSION['newUserError']);
			}
			$show_page .= '
				<h2>Add New User</h2>
				' . $show_error . '
<form action="' . LOGINURL . 'index.php?adduser=true" method="POST">
<label for="username">Username:</label>
<input type="text" name="newusername" id="username" maxlength="20" size="20"/><br/>
<label for="password">Password:</label>
<input type="password" name="password" id="password" maxlength="20" size="20"/><br/>
<input type="hidden" name="token" value="' . $_SESSION['token_id'] . '" />
<input type="submit"/>
</form>
			';
		}
	}
	elseif(isset($_GET['id'])) {
		if(!is_numeric($_GET['id'])) {
			destroy_and_redirect();
		}
		$id = preg_replace("/[^0-9]/","",$_GET['id']);
		$model = new UserModel;
		$user = $model->getUser($id);
		$model = null;
		
		if(isset($_POST) && !empty($_POST)) {
			if(empty($user)) {
				destroy_and_redirect();
			}
			process_update_user($_POST, $id);
		}
		elseif(isset($_GET['delete'])) {
			if($_GET['delete'] =="true") {
				if(empty($user)) {
					exit(header('Location:' . LOGINURL . 'index.php?id=' . $id));
				}
				$model = new UserModel;
				$model->delete_user_profile($id);
				$model = NULL;
				
				$show_page .='
				<article>
					<h1>User has been deleted!</h1>
					<h2><a href="' . LOGINURL . $base . '">view all users</a></h2>
				</article>
				';
			}
			else {
				exit(header('Location:' . LOGINURL . 'index.php?id=' . $id));
			}
		}
		else {
			if(!empty($user)) {
				$view = new UserView();
				$show_page .= $view->showUser($base, $user);
				$view = null;
			}
			$show_page .='
			<article>
				<h1>User not found!</h1>
				<h2><a href="' . LOGINURL . $base . '">view all users</a></h2>
			</article>
			';
		}
	}
	else {
		$model = new UserModel;
		$users = $model->getUsers();
		$model = null;
		
		if(!empty($users)) {
			$view = new UsersView();
			$show_page .= $view->showUsers($base, $users);
			$view = null;
		}
		else {
			$show_page .='
			<article>
				<h1>NO USERS</h1>
			</article>
			';
		}
	}
}
##										USER IS LOGGING IN
elseif(isset($_POST) && !empty($_POST)) {
	process_user_login($_POST);
}
##										SHOW LOGIN FORM
else {
	$_SESSION['token_id'] = md5(uniqid(rand(), TRUE));

	$pageTitle ='Authentication';
	$show_page ='
<p>Please login</p>
<form action="' . LOGINURL . 'index.php" method="POST">
<label for="username">Username:</label>
<input type="text" name="username" id="username" maxlength="20" size="20"/><br/>
<label for="password">Password:</label>
<input type="password" name="password" id="password" maxlength="20" size="20"/><br/>
<input type="hidden" name="token" value="' . $_SESSION['token_id'] . '" />
<input type="submit"/>
</form>
	';
}
?>