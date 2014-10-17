<?php
$allowedExts = array("gif", "jpeg", "jpg", "png","pdf");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
echo $_POST['username'];

$date= new DateTime();
$datu=$date->format('Y-m-d H:i:s');


$flag = 0;
$checkstr = (string)$_POST['username'] . " " . $_FILES["file"]["name"];
echo $checkstr . "<br><br><br>";

if($handle = opendir('./upload'))
{
	while (false !== ($entry = readdir($handle)))
	if ($entry == $checkstr)
	{
		$flag = 1;
		echo "Same file exist. Renaming and saving";
	}

}






if ( in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    if (file_exists("upload/" . '$checkstr')) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
if($flag == 0){
      if(move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"])){echo "Jagiya<br>";}
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
    }}
  }
} else {
  echo "Invalid file";
}

$username = (string)$_POST['username'];
if($flag == 0){

$namee = $_FILES["file"]["name"];
rename("upload/$namee", "upload/$username $namee");
}
else
{

$namee = $_FILES["file"]["name"];
$tt = trim($namee, ".jpg");

      if(move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $username . " " . $tt . $datu . ".jpg")){echo "Wallah<br>";}
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
//rename("upload/$checkstr", "upload/$username _ $tt _ $datu .jpg");
}
?> 
