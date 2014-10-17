


<?php
$con=mysqli_connect("localhost","root","root");
// Check connection

//  echo "Failed to connect to MySQL: " . mysqli_connect_error();
if(mysqli_select_db($con,'test'))
{
echo "database located";
}

$query='create table trial
(firstname varchar(20),
lastname varchar(20),
age varchar(2)
);';

if(mysqli_query($con,$query))
{
echo "table successful";
}

$firstname = $_POST['firstname'];
echo $firstname;
echo "LOL";
//$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
//$age = mysqli_real_escape_string($con, $_POST['age']);
//mysqli_query($con,"INSERT INTO trial (firstName, lastName, age)
//VALUES ($firstname, $lastname,$age);");
echo "completed";
$age="12";
$query = "INSERT INTO trial (firstname, lastname, age) VALUES($firstname, $firstname, $age);";

if(mysqli_query($con, $query))
{
	echo "Hell Ya";
}


mysqli_close($con);
?> 
