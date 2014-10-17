<!DOCTYPE html>

<head>
<title>Reset Password</title>
</head>


<body>
<?php

//generates a random string of length 32
function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


$conn = mysqli_connect("localhost", "root", "root", "test");

if(mysqli_connect_errno())
{
	echo "Failed to connect to mysql" . "mysql_connect_error()";
}
else{

$username = mysqli_real_escape_string($conn, $_POST['username']);
//echo gettype($username);

$sql = "SELECT * FROM register WHERE username = '$username'";

$result= mysqli_query($conn, $sql);

if($row = mysqli_fetch_array($result))
{
	$email = $row['email'];

	$appendstr = 'http://localhost';
	$appendstr .= '?';
	$appendstr .= $username;
	$appendstr .= '&';   //separator
	$randstr = generateRandomString();
	$appendstr .= $randstr;

	//echo $appendstr;
	//echo "   ";


	$sql = "UPDATE register SET resetstr='$randstr' WHERE username='$username'";
	$result = mysqli_query($conn, $sql);


	$to = $email;
	//echo $to;
   $subject = "Link to Reset password Hawa Hawai Bank";
   $message = "This is a system generated mail.\n Here is your link to reset password: \n".$appendstr."\nIf you didn't send this request, then please ignore.\n\n\nHawa Hawai Bank\nDept of CSE\nIIT Kanpur";
   $header = "From:noreply@hawahawai.bank.com \r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Password reset link sent to your email. Check your email. Stay Healthy";
   }
   else
   {
      echo "Aapki asuvidha k liye hame khed hai. Baad me try kar lena phir se. Bye";
   }

}
else{echo "Sorry, username does not exists in Hawa Hawai Database. Please enter a valid username";}

mysqli_close($conn);
}
?>

</body>
</html>
