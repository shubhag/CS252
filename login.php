<!DOCTYPE html>

<head>
<title>Welcome</title>
<link rel="stylesheet" type="text/css" href="main.css">
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

	echo "<div class='tabs'>
          <a href='#' id='tab1' class='tab active'>Transfer Money</a>
          <a href='#' id='tab2' class='tab'>DropBox</a>
          <a href='#' id='tab4' class='tab'>Mini Statement</a>
          <a href='#' id='tab3' class='tab'>Reset Password</a></div>
          <a href='#' id='tab5' class='tab'>Other User Details</a></div>" ;
		$result= mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result);
		$usraccount = $row['account']; 
		$usrbalance = $row['balance']; 

	echo $_SESSION['username'];

	echo "<div style='margin-top:40px;'>Welcome ". $username ."</div>";
	echo "<div class='content' id='dropdown'>
         	<form action='upload_final.php' method='post' enctype='multipart/form-data'>
				<label for='file'>Filename:</label>
				<input type=\"file\" name=\"file\" id=\"file\">
				<input type='submit' name='submit' value='Submit'>
			</form>
			<br>";

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
		echo "</div>";

		echo "<div class='content active' id='transaction'>
			<form action='".$_SERVER['PHP_SELF']."' method='post' name='Transfer'>
				<div>
					<span>Enter the account number(as given on Other User Details tab) of user to transfer the amount to: </span>
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
			<br><br>

			<form action='".$_SERVER['PHP_SELF']."' method='post' name='Withdraw'>
					<div>
						<span>Enter the amount to Withdraw: </span>
						<span><input type='number' name='amountwithdraw' required></span>
						<br>
					</div>
					<input type='submit' name='submit2' value='Withdraw'>
			</form>

			<form action='".$_SERVER['PHP_SELF']."' method='post' name='Deposit'>
				<div>
					<span>Enter the amount to Deposit: </span>
					<span><input type='number' name='amountdeposit' required></span>
					<br>
				</div>
				<input type='submit' name='submit3' value='Deposit'>
			</form>
	</div>";
		echo "
	<br><div class='content' id='resetp'>
			<div style='font-size:18px;''>Reset Password</div>
				<form action = 'reset_pass.php' method='post'>
					Old Password: <input type='password' name='oldpass' required>
					New Password: <input type='password' name='newpass' required>
					<input type='submit'>
				</form>
			</div>";

		$query = "SELECT * FROM minis WHERE user1 = '$username'";
		$result = mysqli_query($conn,$query);
		
		echo "<div class='content' id='minis'>
		<table class='gridtable'>
			<tr>
				<th>Transaction Type</th><th>Diposited/Withdrawl Money</th><th>Balance</th><th>Transaction Time</th> 
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			$a = 0;	
			if($row['deposited']==NULL){
				$a = $row['withdrawl'] ;
			}
			else if($row['withdrawl']==NULL){
				$a = $row['deposited'] ;
			}
			if($row['transaction'] == 'Transfer'){
				$a = $row['transfer'] ;
			}
			$doc = new DOMDocument();
			$doc->loadHTML("<tr><td>".$row['transaction']."</td><td>".$a."</td><td>".$row['balance']."</td><td>".$row['Time']."</td></tr>");
			echo $doc->saveHTML();
		}
		echo "</table></div>";

		$query = "SELECT * FROM register WHERE username != '$username'";
		$result = mysqli_query($conn,$query);
		echo "<div class='content' id='other_udetail'>
		<table class='gridtable'>
			<tr>
				<th>User Name</th><th>Email Id</th><th>Account Number</th> 
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			$doc = new DOMDocument();
			$doc->loadHTML("<tr><td>".$row['username']."</td><td>".$row['email']."</td><td>".$row['account']."</td></tr>");
			echo $doc->saveHTML();
		}
		echo "</table></div>";
}


if(isset($_POST['submit1'])) //submitted request for transferring money
{
	if(is_numeric($_POST['amount']) && is_numeric($_POST['account']) && intval($_POST['account'])>0 && intval($_POST['amount'])>0)
	{
		$account = $_POST['account'];
		$amount = $_POST['amount'];
		$sql = "SELECT * FROM register WHERE account = '$account'";
		$result= mysqli_query($conn, $sql);
		if($row = mysqli_fetch_array($result))
		{
			$user2 = $row['username'];
			$newbal = $usrbalance - $amount;
			if($newbal >0)
			{
				$sql = "UPDATE register SET balance=$newbal WHERE account = '$usraccount'";
				$result= mysqli_query($conn, $sql);

				$transbal = $amount + $row['balance'];
				$sql = "UPDATE register SET balance=$transbal WHERE account = '$account'";
				$result= mysqli_query($conn, $sql);

				//Updating Ministatement table
				$user1 = $_SESSION['username'];
				$sql = "INSERT into minis (user1, user2, transaction, transfer, balance, Time) VALUES ('$user1', '$user2', 'Transfer', '$amount', '$newbal', NOW())";
				$result= mysqli_query($conn, $sql);
				$sql = "INSERT into minis (user1, user2, transaction, transfer, balance, Time) VALUES ('$user2', '$user1', 'Transfer', '$amount', '$transbal', NOW())";
				$result= mysqli_query($conn, $sql);

				echo "Money transferred";
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
	$query = "SELECT * FROM minis WHERE user1 = '$username'";
		$result = mysqli_query($conn,$query);
	echo "<div class='content' id='minis'>
		<table class='gridtable'>
			<tr>
				<th>Transaction Type</th><th>Diposited/Withdrawl Money</th><th>Balance</th><th>Transaction Time</th> 
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			$a = 0;	
			if($row['deposited']==NULL){
				$a = $row['withdrawl'] ;
			}
			else if($row['withdrawl']==NULL){
				$a = $row['deposited'] ;
			}
			if($row['transaction'] == 'Transfer'){
				$a = $row['transfer'] ;
			}
			$doc = new DOMDocument();
			$doc->loadHTML("<tr><td>".$row['transaction']."</td><td>".$a."</td><td>".$row['balance']."</td><td>".$row['Time']."</td></tr>");
			echo $doc->saveHTML();
		}
		echo "</table></div>";
}

if(isset($_POST['submit2']))
{
	if(is_numeric($_POST['amountwithdraw']) && intval($_POST['amountwithdraw']) >0)
	{
		if(($usrbalance -intval($_POST['amountwithdraw'])) >=0)
		{
			$newbal = $usrbalance - $_POST['amountwithdraw'];
			$sql = "UPDATE register SET balance=$newbal WHERE account = '$usraccount'";
			$result= mysqli_query($conn, $sql);
			echo "Please collect your money from the cashier";

			$user1 = $_SESSION['username'];
			$amount = $_POST['amountwithdraw'];
			$sql = "INSERT into minis (user1, transaction, withdrawl, balance, Time) VALUES ('$user1', 'Withdrawl', '$amount', '$newbal', NOW())";
			$result= mysqli_query($conn, $sql);
		}
		else
		{
			echo "Sorry Unsufficient Balance<br>";
		}
	}
	else
	{
		echo "Please enter valid amount";
	}
	unset($_POST['submit2']);
	$query = "SELECT * FROM minis WHERE user1 = '$username'";
		$result = mysqli_query($conn,$query);
	echo "<div class='content' id='minis'>
		<table class='gridtable'>
			<tr>
				<th>Transaction Type</th><th>Diposited/Withdrawl Money</th><th>Balance</th><th>Transaction Time</th> 
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			$a = 0;	
			if($row['deposited']==NULL){
				$a = $row['withdrawl'] ;
			}
			else if($row['withdrawl']==NULL){
				$a = $row['deposited'] ;
			}
			if($row['transaction'] == 'Transfer'){
				$a = $row['transfer'] ;
			}
			$doc = new DOMDocument();
			$doc->loadHTML("<tr><td>".$row['transaction']."</td><td>".$a."</td><td>".$row['balance']."</td><td>".$row['Time']."</td></tr>");
			echo $doc->saveHTML();
		}
		echo "</table></div>";
}

if(isset($_POST['submit3']))
{
	if(is_numeric($_POST['amountdeposit']) && intval($_POST['amountdeposit']) >0)
	{
		if(($usrbalance + intval($_POST['amountdeposit'])) <10000000)
		{
			$newbal = $usrbalance + $_POST['amountdeposit'];
			$sql = "UPDATE register SET balance=$newbal WHERE account = '$usraccount'";
			$result= mysqli_query($conn, $sql);
			echo "Your Cash has been successfully deposited<br>";

			$user1 = $_SESSION['username'];
			$amount = $_POST['amountdeposit'];
			$sql = "INSERT into minis (user1, transaction, withdrawl, balance, Time) VALUES ('$user1', 'Deposit', '$amount', '$newbal', NOW())";
			$result= mysqli_query($conn, $sql);
		}
		else
		{
			echo "Amount deposit greater than Rs 10000000 only done at valid bank counter<br>";
		}
	}
	else
	{
		echo "Please enter valid amount<br>";
	}
	unset($_POST['submit3']);
	$query = "SELECT * FROM minis WHERE user1 = '$username'";
		$result = mysqli_query($conn,$query);
	echo "<div class='content' id='minis'>
		<table class='gridtable'>
			<tr>
				<th>Transaction Type</th><th>Diposited/Withdrawl Money</th><th>Balance</th><th>Transaction Time</th> 
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			$a = 0;	
			if($row['deposited']==NULL){
				$a = $row['withdrawl'] ;
			}
			else if($row['withdrawl']==NULL){
				$a = $row['deposited'] ;
			}
			else {
				$a = $row['transfer'] ;
			}
			$doc = new DOMDocument();
			$doc->loadHTML("<tr><td>".$row['transaction']."</td><td>".$a."</td><td>".$row['balance']."</td><td>".$row['Time']."</td></tr>");
			echo $doc->saveHTML();
		}
		echo "</table></div>";
}



if(isset($_SESSION['username'])) //for logout
{
	echo "<br><br><a href='logout.php'>Logout</a>";
}
mysqli_close($conn);
?>
<script type="text/javascript">
	document.getElementById("tab2").onclick = function(){
		document.getElementById("tab1").className = "tab";
		document.getElementById("tab2").className = "tab active";
		document.getElementById("tab3").className = "tab";
		document.getElementById("tab4").className = "tab";
		document.getElementById("tab5").className = "tab";

		document.getElementById("dropdown").className = "content active";
		document.getElementById("resetp").className = "content";
		document.getElementById("transaction").className = "content";
		document.getElementById("minis").className = "content";
		document.getElementById("other_udetail").className = "content";
	}
	document.getElementById("tab1").onclick = function(){
		document.getElementById("tab2").className = "tab";
		document.getElementById("tab1").className = "tab active";
		document.getElementById("tab3").className = "tab";
		document.getElementById("tab4").className = "tab";
		document.getElementById("tab5").className = "tab";

		document.getElementById("dropdown").className = "content";
		document.getElementById("resetp").className = "content";
		document.getElementById("transaction").className = "content active";
		document.getElementById("minis").className = "content";
		document.getElementById("other_udetail").className = "content";
	}
	document.getElementById("tab3").onclick = function(){
		document.getElementById("tab1").className = "tab";
		document.getElementById("tab3").className = "tab active";
		document.getElementById("tab2").className = "tab";
		document.getElementById("tab4").className = "tab";
				document.getElementById("tab5").className = "tab";

		document.getElementById("dropdown").className = "content";
		document.getElementById("resetp").className = "content active";
		document.getElementById("transaction").className = "content";
		document.getElementById("minis").className = "content";
		document.getElementById("other_udetail").className = "content";
	}
	document.getElementById("tab4").onclick = function(){
		document.getElementById("tab1").className = "tab";
		document.getElementById("tab4").className = "tab active";
		document.getElementById("tab2").className = "tab";
		document.getElementById("tab3").className = "tab";
		document.getElementById("tab5").className = "tab";

		document.getElementById("dropdown").className = "content";
		document.getElementById("resetp").className = "content";
		document.getElementById("transaction").className = "content";
		document.getElementById("minis").className = "content active";
		document.getElementById("other_udetail").className = "content";
	}
	document.getElementById("tab5").onclick = function(){
		document.getElementById("tab1").className = "tab";
		document.getElementById("tab5").className = "tab active";
		document.getElementById("tab2").className = "tab";
		document.getElementById("tab3").className = "tab";
		document.getElementById("tab4").className = "tab";

		document.getElementById("dropdown").className = "content";
		document.getElementById("resetp").className = "content";
		document.getElementById("transaction").className = "content";
		document.getElementById("minis").className = "content";
		document.getElementById("other_udetail").className = "content active";
	}

</script>
</body>
</html>
