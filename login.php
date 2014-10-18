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
					session_start();
					$_SESSION['username'] = $username;
			

					//session_destroy();
				//	unset($SESSION['username']);
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
	$username = $_SESSION['username'];
	//also retrieving the balance and account number
	$sql = "SELECT * FROM register WHERE username = '$username'";
	$result= mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	$account = $row['account']; echo $account. "<br>";
	$balance = $row['balance']; echo $balance. "<br>";

	echo $_SESSION['username'];
	echo "Session set";
	echo "
<form action='upload_final.php' method='post'
enctype='multipart/form-data'>
<label for='file'>Filename:</label>
<input type=\"file\" name=\"file\" id=\"file\"><br>
<input type='text' name='username' value='".$_SESSION['username']."' readonly>
<input type='submit' name='submit' value='Submit'>
</form><br>
<br>

<form action='".$_SERVER['PHP_SELF']."' method='post' name='Transfer'>
		<div>
			<span>Enter the account to transfer the amount to: </span>
			<span><input type='number' name='accountno' required> </span>
			<br>
		</div>
		<div>
			<span>Enter the amount to transfer: </span>
			<span><input type='number' name='amount' required></span>
			<br>
		</div>
		<input type='submit' name='submit1' value='Transfer'>
	</form>
";
}



if(isset($_POST['submit1'])) //submitted request for transferring money
{
	if(is_numeric($_POST['amount']))
	{
		echo "yes it is";
	}

	echo $_POST['amount'] ."transferred to account no". $_POST['accountno'];
	unset($_POST['submit1']);
}





if(isset($_SESSION['username'])) //for logout
{
	echo "<br><br><a href='logout.php'>Logout</a>";
}
mysqli_close($conn);
?>


</body>
</html>
