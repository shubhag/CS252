<html>
<head><title>LOL</title></head>


<body>
<?php
echo "Hello everyone <hr> I'm DK";
$link = mysqli_connect('localhost', 'root', 'root'); 

if ($link) 

{ 

  $output = 'Connected to the database server.'; 

  echo $output; 

}

if (mysqli_select_db($link, 'test')) 

{ 

  $output = '  Located the test database.'; 

  echo $output; 


}
/*
$query = 'create table sunil(name varchar(9));';

if (mysqli_query($link, $query))  

{  

  $output = 'Table created successfully';
  echo $output;
 
} 

$query= 'insert into sunil values("sunil");';

if (mysqli_query($link, $query))  

{  

  $output = 'record entered';
  echo $output;
 
}
echo "<br>";

$result = mysqli_query($link, 'SELECT name FROM sunil');  

while ($row = mysqli_fetch_array($result))  

{  

  $jokes = $row['name'];  

} 
echo $jokes;
*/

?>

</body>
</html>
