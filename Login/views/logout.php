<?php
	session_start(); session_destroy(); $_SESSION = array(); session_regenerate_id(true); exit(header('Location:../index.php'));
?>