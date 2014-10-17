<!DOCTYPE html>
<head>
<title>YAY</title>
</head>

<body>
Hello There.<br>

<?php 
$conn = mysqli_connect("localhost", "root", "root", "test");
if (mysqli_connect_errno())
{
	echo "Failed connection" . mysqli_connect_error();
}
else {
	echo "Connection Established with database<br>";

		$username= mysqli_real_escape_string($conn, $_POST['username']);
		$password = $_POST['password'];
		$email = $_POST['email'];


		$sql = "SELECT username FROM register WHERE username='$username'";
		$result = mysqli_query($conn, $sql);


		if(!($row = mysqli_fetch_array($result)))
		{
			$sql = "INSERT INTO register (username, password, email)
			VALUES('$username', MD5('$password'), '$email')";

			if (mysqli_query($conn, $sql)){
				echo "Registered";
			}
		}
		else
		{
			echo "User already exists. Please try a different username";
		}

		mysqli_close($conn);
	}
?>

</body>
</html>
