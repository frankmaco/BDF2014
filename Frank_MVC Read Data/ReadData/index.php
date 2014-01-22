<?php
require_once"db.php";
require_once "UserModel.php";
require_once"UserView.php";
require_once"UsersView.php";

$query = $_SERVER['PHP_SELF'];
$path = pathinfo($query);
$base = $path['basename'];

$db = new PDO(MY_DSN, MY_USER, MY_PASS);
$model = new UserModel(MY_DSN, MY_USER, MY_PASS);

if (isset($_GET['id'])) {	
	$id = mysql_real_escape_string($_GET['id']);
    $user = $model->getUser($id);
    $view = new UserView();
    $view->showUser($user, $base);
} else {
    $users = $model->getUsers();
    $view = new UsersView();
    $view->showUsers($users, $base);
}


