<?php
	setcookie("IsLoggedIn", "false");
	session_start();
	session_destroy();
	header("Location: index_login.php");
	exit;
?>