<!DOCTYPE html>

<head>
<title>Welcome</title>
</head>


<body>
<?php
$conn = mysqli_connect("localhost", "root", "root", "test");

if(mysqli_connect_errno())
{
	echo "Failed to connect to mysql" . "mysql_connect_error()";
}
else{
	session_start();
	if(!isset($_SESSION['username'])){
		if( ($_POST['username'] == "" || $_POST['password'] == ""))
		{
		//	header('Location: index_login.php');
			echo "Please enter all field";
			echo "Go to <a href='index_login.php'>Login Page</a>" ; 
		}
		else{
			$username = mysqli_real_escape_string($conn, $_POST['username']);

			$sql = "SELECT * FROM register WHERE username = '$username'";

			$result= mysqli_query($conn, $sql);

			if($row = mysqli_fetch_array($result))
			{
			//	echo $row['username'];
				$password = $row['password'];
				if (MD5($_POST['password']) == $password)
				{
					echo "LOGGED IN";
					$_SESSION['username'] = $username;

				}
				else {echo "Incorrect password";}
				echo "<br>";
			}
			else{echo "username does not exists";}
		}
	}
}


?>



<?php
if(isset($_SESSION['username']))
{
	echo "Session set";
	echo "
		<form action='upload_final.php' method='post'
		enctype='multipart/form-data'>
		<label for='file'>Filename:</label>
		<input type=\"file\" name=\"file\" id=\"file\">
		<input type='submit' name='submit' value='Submit'>
		</form><br>
		";


		$query = "SELECT * FROM upfiles WHERE User = '$_SESSION[username]'";
		$result = mysqli_query($conn,$query);
		while($row = mysqli_fetch_array($result))
		{
				if($row['IsSaved'] == True)
				{
					$doc = new DOMDocument();
					$doc->loadHTML("<a href=\"fetch_file.php?file=". $row['ModifiedFilename'] ."\">". $row['OriginalFilename'] ."</a><br><br>");
					echo $doc->saveHTML();
				}
		}
		echo "
<br>
	<div style='font-size:18px;''>Reset Password</div>
	<form action = 'reset_pass.php' method='post'>
	Old Password: <input type='password' name='oldpass' required>
	New Password: <input type='password' name='newpass' required>
	<input type='submit'></form>

		<br><a href='logout.php'>Logout</a";
}
?>
>
</body>
</html>
