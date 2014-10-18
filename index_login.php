<!DOCTYPE html>
<head>
<title>LOGIN</title>
</head>

<body>

<?php
	session_start();
	if(isset($_SESSION['username'])){
		header("location:login.php");
	}
?>
	<h1 style="margin-left:20%">Welcome to Hawa Hawai Bank</h1>
	<center>
	<form action = "login.php" method="post">
	Username: <input type="text" name="username" required>
	Password: <input type="password" name="password" required>
	<input type="submit"></form></center>

	<p>
		Not Signed up yet. Click Here to <a href="registration.html">Signup</a>
		<br> Forget Password <a href="reset.html">Click Here</a>
	</p>
</body>
</html>
