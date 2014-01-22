<?php
require_once"db.php";
require_once "UserModel.php";
require_once"UserView.php";

$db = new PDO(MY_DSN, MY_USER, MY_PASS);
$model = new UserModel(MY_DSN, MY_USER, MY_PASS);
$id = $_GET['id'];
echo($id);
$user = $model->getUser($id);

$view = new UserView();
$view->showDetail($user);