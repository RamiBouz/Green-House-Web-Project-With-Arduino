<?php 
	session_start();
	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'greenhouse');


	//WATER SYSTEM
	
	if (isset($_POST['open_water'])) {
 
          $query = "UPDATE watercontrol SET Stat = 1
      	  WHERE id = 0";
          mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
		if (isset($_POST['close_water'])) {
    
           $query = "UPDATE watercontrol SET Stat = 0
      	    WHERE id = 0";
            mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
		if (isset($_POST['open_water'])) {
 
          $query ="INSERT INTO controlpaneltable (system,status) VALUES ('Water','Open')";
          mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
		if (isset($_POST['close_water'])) {
  
		    $query ="INSERT INTO controlpaneltable (system,status) VALUES ('Water','Close')";
            mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
	//NET SYSTEM
	
		if (isset($_POST['open_net'])) {
  
           $query = "UPDATE netcontrol SET Stat = 1
      	     WHERE id = 0";
            mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
		if (isset($_POST['close_net'])) {
     
           $query = "UPDATE netcontrol SET Stat = 0
      	     WHERE id = 0";
            mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
			if (isset($_POST['open_net'])) {
  
		   $query ="INSERT INTO controlpaneltable (system,status) VALUES ('Net','Open')";
            mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
		if (isset($_POST['close_net'])) {
     
		   $query ="INSERT INTO controlpaneltable (system,status) VALUES ('Net','Close')";
            mysqli_query($db, $query);

			header('location: controlpanel.php');
  	}
	
?>