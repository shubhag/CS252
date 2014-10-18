<!DOCTYPE html>
<head>
<title>Sign Up</title>
</head>

<body>

<script type="text/javascript">
var LoggedIn=getCookie("IsLoggedIn");
if (LoggedIn == "true") 
{
	window.location = "login.php";
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
}

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
