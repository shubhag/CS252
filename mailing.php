<!DOCTYPE html>
<head>
<title>Hello</title>
</head>

<body>

Hello LOL <br>



<!-- lol -->
<?php
   $to = "deepakr@iitk.ac.in";
   $subject = "Test 2";
   $message = "Hey brother. This is lol me troll me";
   $header = "From:noreply@ghotala.bank.com \r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Message sent successfully...";
   }
   else
   {
      echo "Message could not be sent...";
   }
?>

</body>
</html>