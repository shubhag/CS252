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
<input type=\"file\" name=\"file\" id=\"file\"><br>
<input type='text' name='username' value='".$_SESSION['username']."' readonly>
<input type='submit' name='submit' value='Submit'>
</form><br>
<a href='logout.php'>Logout</a>";


		$query = "SELECT * FROM upfiles WHERE User = '$_SESSION[username]'";
		$result = mysqli_query($conn,$query);
		while($row = mysqli_fetch_array($result))
		{
			// echo $row['ModifiedFilename'];
			// $nrows =  mysqli_num_rows($result);
			// echo $nrows;
			// for( $i = 0; $i < $nrows; $i++)
			// {
				if($row['IsSaved'] == True)
				{
					$doc = new DOMDocument();
					$doc->loadHTML("<a href=\"fetch_file.php?file=". $row['ModifiedFilename'] ."\">". $row['OriginalFilename'] ."</a><br><br>");
					echo $doc->saveHTML();
				}
			// }
		}

}
?>


</body>
</html>
