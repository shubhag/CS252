<!DOCTYPE html>
<head>
<title>Reset Password</title>
</head>


<body>



<?php
   
$conn = mysqli_connect("localhost", "root", "root", "test");

if(mysqli_connect_errno())
{
	echo "Failed to connect to mysql" . "mysql_connect_error()";
}
else
{

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$randomstr = $_POST['str'];
	$password = $_POST['password'];
	$password1 = $_POST['password1'];

	if($password == $password1)
	{
	//echo $username;

		$sql = "SELECT * FROM register WHERE username = '$username'";

		$result= mysqli_query($conn, $sql);

		if($row = mysqli_fetch_array($result))
		{
			$randstr = $row['resetstr'];
			$hello = "helloworld";
			if ($randstr == $randomstr && $randstr != $hello)
			{
				$sql = "UPDATE register SET resetstr='$hello' WHERE username='$username'";
				$result = mysqli_query($conn, $sql);
				$newpass = MD5($password);
				$sql = "UPDATE register SET password='$newpass' WHERE username='$username'";
				$result = mysqli_query($conn, $sql);
				echo "Passwrd updated succussfully. Go to <a href='/login.html'> Login page </a> to reuse our services";
			}
			else
			{
				echo "The link is invalid or the link has expired. Please try again.";
			}
		}
		else
		{
			echo "Sorry, username does not exists in Hawa Hawai Database. You're trying good. But we're one step ahead. Keep trying.";
		}
	}
	else
	{
		echo "Passwords don't match. Please go back and type passwords again";
	}

	mysqli_close($conn);
}




?>


</body>
</html>