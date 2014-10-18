<!DOCTYPE html>
<html>
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
		session_start();
		if(!isset($_SESSION['username'])){
			header('Location: index_login.php');
		}
		else{
			$username = $_SESSION['username'] ;
			$sql = "SELECT * FROM register WHERE username = '$username'";
			$result= mysqli_query($conn, $sql);

			if($row = mysqli_fetch_array($result))
			{	
				$password = $row['password'];
				if (MD5($_POST['oldpass']) == $password)
				{
					$newpass = MD5($_POST['newpass']);
					$sql = "UPDATE register SET password='$newpass' WHERE username='$username'";
					$result = mysqli_query($conn, $sql);
					echo "Passwrd updated succussfully. Go back to <a href='login.php'> Main page </a>";
				}
				else{
					echo "Incorrect Password";
				}
			}
			else{
				echo "Are you a registerd user. Please go to <a href='index_login.php'>Login Page</a>";
			}
		}

	?>
</body>

</html>