<!DOCTYPE html>
<head>
<title>Reset Password</title>
</head>


<body>



<?php
    $part = "abc?" . $_SERVER['QUERY_STRING'] ;
    $parts = parse_url($part);
    parse_str($parts['query'], $query);
    
	$username = $query['uname'];
	$randomstr = $query['str'];

$conn = mysqli_connect("localhost", "root", "root", "test");

if(mysqli_connect_errno())
{
	echo "Failed to connect to mysql" . "mysql_connect_error()";
}
else
{

	//$username = mysqli_real_escape_string($conn, $_POST['username']);
	echo $username;

	$sql = "SELECT * FROM register WHERE username = '$username'";

	$result= mysqli_query($conn, $sql);

	if($row = mysqli_fetch_array($result))
	{
		$randstr = $row['resetstr'];

		if ($randstr == $randomstr)
		{
		echo " <form action='success.php' method='post' 
			enctype='multipart/form-data'>
				<span><input type='hidden' name='username' value='".$username."' required></span>
				<span><input type='hidden' name='str' value='".$randstr."' required></span>
			<span >Enter New Password: </span>
				<span><input type='password' name='password' required></span>
				<br>

			<span >Re-Enter New Password: </span>
				<span><input type='password' name='password1' required></span>
				<br>
			<input type='submit' name='submit' value='Submit'>
			</form>";
			//Echo reset form // Also send the randomstring with this
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

	mysqli_close($conn);
}




?>


</body>
</html>
