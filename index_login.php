<!DOCTYPE html>
<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php
	session_start();
	if(isset($_SESSION['username'])){
		header("location:login.php");
	}
?>
	<h1 ><center>Welcome to Hawa Hawai Bank</center></h1>
	<div class="container">

      <form action = "login.php" method="post" class="form-signin" role="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" name="username" placeholder="User Name" required="" autofocus="">
        <input type="password" class="form-control" name="password" placeholder="Password" required="">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
      </form>

    </div>
    <p>
    	<center>
			Not Signed up yet. Click Here to <a href="registration.html">Signup</a>
			<br> Forget Password <a href="reset.html">Click Here</a>
		</center>
	</p>
</body>
</html>
