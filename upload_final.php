<?php
	include_once 'db-connect.php';
	session_start();
	if(!isset($_SESSION['username']))
	{
 		header("Location: index_login.php");
	}
	else
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png","pdf", "pptx", "mp3", "3gp","zip","docx");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		$name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $_FILES["file"]["name"]);

		echo "<br>";

		if (in_array($extension, $allowedExts)) 
		{
			if(($_FILES["file"]["size"] / 1024) <= 102400)
			{
		  		if ($_FILES["file"]["error"] > 0) 
				{
			    		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
				}	 
				else 
				{
					echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			    		echo "Type: " . $_FILES["file"]["type"] . "<br>";
			   		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			    		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
					$date = date_create();

					 $stmt = $mysqli->prepare("INSERT INTO upfiles (User, IsSaved, OriginalFilename, ModifiedFilename, Time) VALUE('$_SESSION[username]' , 'Yes','".  $_FILES["file"]["name"]."','". $_SESSION['username']."_" .$name . "_" . date_format($date, 'U') . "." . $extension . "', NOW())");
					
					 $stmt->execute();
					

			      		move_uploaded_file($_FILES["file"]["tmp_name"],
		      			"/var/www/html/lab/upload/" . $_SESSION['username']."_" .$name . "_" . date_format($date, 'U') . "." . $extension);
					echo "File Uploaded<br>";	      			
					chmod("/var/www/html/lab/upload/". $_FILES["file"]["name"], 0644);
				}
			}
			else
			{
				echo "File Size Exceeded<br>";
			}
		} 
		else 
		{
			echo "Invalid file<br>";
		}

		$doc = new DOMDocument();
		$doc->loadHTML("<button onclick=\"window.location='login.php'\">Back</button>");
		echo $doc->saveHTML();
	}
?>
