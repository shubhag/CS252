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
</script>

<?php 
$conn = mysqli_connect("localhost", "root", "root", "test");
if (mysqli_connect_errno())
{
	echo "Failed connection" . mysqli_connect_error();
}
else {
		$username= mysqli_real_escape_string($conn, $_POST['username']);
		$password = $_POST['password'];
		$email = $_POST['email'];
		if( ($username == "" || $password == "" || $email == "" ))
		{
			echo "Please enter all fields";
			echo "Go to <a href='registration.html'>Sign up</a>" ; 
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		   	echo "Invalid Email Address<br> Go back to <a href='registration.html' >signup page</a>";
		}
		else{

			$sql = "SELECT * FROM register WHERE email='$email'";
			$result1 = mysqli_query($conn, $sql);

			if(!($row1 = mysqli_fetch_array($result1)))
			{
				$sql = "SELECT username FROM register WHERE username='$username'";
				$result = mysqli_query($conn, $sql);


				if(!($row = mysqli_fetch_array($result)))
				{
					$sql = "INSERT INTO register (username, password, email)
					VALUES('$username', MD5('$password'), '$email')";

					if (mysqli_query($conn, $sql)){
						echo "User Registered. <br> Go to <a href='index_login.php'>Login Page</a>";
					}
				}
				else
				{
					echo "User already exists. Please try a different username";
				}
			}
			else
			{
				echo "Sorry. Email Already used. Try with another email";
			}
		}
		mysqli_close($conn);
	}
?>

</body>
</html>
