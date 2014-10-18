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
	$username = $_SESSION['username'];
	//also retrieving the balance and account number
	$sql = "SELECT * FROM register WHERE username = '$username'";
	$result= mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	$usraccount = $row['account']; echo $usraccount. "<br>";
	$usrbalance = $row['balance']; echo $usrbalance. "<br>";

	echo $_SESSION['username'];
	echo "Session set";
	echo "
<form action='upload_final.php' method='post'
		enctype='multipart/form-data'>
		<label for='file'>Filename:</label>
		<input type=\"file\" name=\"file\" id=\"file\">
		<input type='submit' name='submit' value='Submit'>
		</form><br>

<form action='".$_SERVER['PHP_SELF']."' method='post' name='Transfer'>
		<div>
			<span>Enter the account to transfer the amount to: </span>
			<span><input type='number' name='account' required> </span>
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
	<input type='submit'></form>";
}


if(isset($_POST['submit1'])) //submitted request for transferring money
{
	if(is_numeric($_POST['amount']) && is_numeric($_POST['account'])) // && intval($_POST['account'])>0 && intval($_POST['amount'])>0)
	{
		$account = $_POST['account'];
		$amount = $_POST['amount'];
		$sql = "SELECT * FROM register WHERE account = '$account'";
		$result= mysqli_query($conn, $sql);
		if($row = mysqli_fetch_array($result))
		{
			//account exists
			$newbal = $usrbalance - $amount;
			if($newbal >0)
			{
				$sql = "UPDATE register SET balance=$newbal WHERE account = '$usraccount'";
				$result= mysqli_query($conn, $sql);
				$transbal = $amount + $row['balance'];
				$sql = "UPDATE register SET balance=$transbal WHERE account = '$account'";
				$result= mysqli_query($conn, $sql);
				echo "ho gaya";

			}

		}
		else
		{
			echo"Oops No user with that account found";
		}
		

	}
	else
	{
		echo "Please Enter valid Amount and Account Number";
	}

	
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
