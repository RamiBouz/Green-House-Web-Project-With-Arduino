<?php

    $host = "localhost";		         // host = localhost because database hosted on the same server where PHP files are hosted
    $dbname = "greenhouse";              // Database name
    $username = "root";		// Database username
    $password = "";	        // Database password

// Establish connection to MySQL database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if connection established successfully
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else { echo "Connected to mysql database. "; }

// Get date and time variables
    date_default_timezone_set('Israel');
   $d = date("Y-m-d");
   $t = date("H:i:s");
    
		$temperature = $_POST['tempDB'];
        $humidity = $_POST['humidityDB'];
       
//Update your tablename here
$sql = "INSERT INTO sensortable (temperature, humidity,date, time) VALUES ('".$temperature."','".$humidity."','".$d."','".$t."')"; 

		if ($conn->query($sql) === TRUE) {
		    echo "Values inserted in MySQL database table.";
		} else {
		   echo "Error: " . $sql . "<br>" . $conn->error;
		}
	
// Close MySQL connection
$conn->close();

?>