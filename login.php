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
$username = mysqli_real_escape_string($conn, $_POST['username']);
//echo gettype($username);

$sql = "SELECT * FROM register WHERE username = '$username'";

$result= mysqli_query($conn, $sql);

if($row = mysqli_fetch_array($result))
{
//	echo $row['username'];
	$password = $row['password'];
	if (MD5($_POST['password']) == $password)
	{
		echo "LOGGED IN";
		session_start();
		$_SESSION['username'] = $username;
		//session_destroy();
	//	unset($SESSION['username']);
	}
	else {echo "Incorrect password";}
	echo "<br>";
}
else{echo "username does not exists";}


/*
$flag = 0;
if ($row = mysqli_fetch_array($result))
{
	$flag = 1;
}

if ($flag == 0)
{
	echo "User already exists. Choose different username";
}
*/

mysqli_close($conn);
?>



<?php
if(isset($_SESSION['username']))
{
	echo "Session set";
	echo "
<form action='upload.php' method='post'
enctype='multipart/form-data'>
<label for='file'>Filename:</label>
<input type='file' name='file' id='file'><br>
<input type='text' name='username' value='$username' readonly>
<input type='submit' name='submit' value='Submit'>
</form>";

}
?>


</body>
</html>