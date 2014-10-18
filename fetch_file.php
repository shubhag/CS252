<?php
	$conn = mysqli_connect("localhost", "root", "root", "test");
	if(mysqli_connect_errno())
	{
		echo "Failed to connect to mysql" . "mysql_connect_error()";
	}
	$file = basename(urldecode($_GET['file']));
	$fileDir = '/var/www/html/upload/';
	$filepath = $fileDir . $file;
	session_start();
	if(!isset($_SESSION['username']))
	{
 		header("Location: index_login.php");
	}
	else
	{
		$query = "SELECT * FROM upfiles WHERE User = '$_SESSION[username]'";
		$result = mysqli_query($conn,$query);
		if($row = mysqli_fetch_array($result))
		{
				if (file_exists($fileDir . $file))
				{
					$contents = file_get_contents($filepath);
					header('Content-Type: ' . mime_content_type($filepath));
					echo $contents;
				}
				else
				{
					echo "The file you are looking for does not exist<br>";
				}
			}
			else
			{
				echo "You are on a wrong place<br>";
			}
		}

?>
