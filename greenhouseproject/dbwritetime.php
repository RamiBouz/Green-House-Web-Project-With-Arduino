<?php

    $host = "localhost";		         // host = localhost because database hosted on the same server where PHP files are hosted
    $dbname = "greenhouse";              // Database name
    $username = "root";		// Database username
    $password = "";	        // Database password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else { echo "Connected to mysql database. "; }

    date_default_timezone_set('Israel');  // for other timezones, refer:- https://www.php.net/manual/en/timezones.asia.php
   $d = date("Y-m-d");
   $t = date("H:i:s");
    
  if(($_POST['amountDB'])!=0)
    {
		$amount = $_POST['amountDB'];
		$sum = $_POST['sumDB'];
     
$sql = "INSERT INTO watertable (amount ,sum, date, time) VALUES ('".$amount."','".$sum."','".$d."','".$t."')"; 

		if ($conn->query($sql) === TRUE) {
		    echo "Values inserted in MySQL database table.";
		} else {
		   echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

$conn->close();

?>