<?php
	session_start();
	$_SESSION['token_id'] = md5(uniqid(rand(), TRUE));
	include("/views/form.inc");
?>