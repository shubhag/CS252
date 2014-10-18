<?php
	define("HOST", "localhost");     // The host you want to connect to.
	define("USER", "root");    // The database username. 
	define("PASSWORD", "root");    // The database password. 
	define("DATABASE", "test");    // The database name.
	 
	//define("CAN_REGISTER", "any");
	//define("DEFAULT_ROLE", "member");
	 
	//define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if (mysqli_connect_errno())
	{
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>