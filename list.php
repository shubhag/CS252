<?php

$link = mysqli_connect('localhost', 'root', 'root'); 
if ($link) { }
if (mysqli_select_db($link, 'test')) {}
$user_name = mysqli_real_escape_string($link, $_POST["user_name"]);
$len=strlen($user_name);

$thelist = "";
 if ($handle = opendir('upload')) {
   while (false !== ($file = readdir($handle)))
      { $rest = substr($file, 0, $len);
          if ($file != "." && $file != ".." && ($rest==$user_name))
	  {
          	#$thelist .= '<a href="'.$file.'">'.$file.'</a>';
		$thelist .= $file.'<br>';
          }
       }
  closedir($handle);
  }       
?>
<P>List of files:</p>
<P><?=$thelist?></p>
