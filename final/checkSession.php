<?php

	ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
  session_start();
     
	if(!(isset($_SESSION['username'])) || $_SESSION['username'] == "") {
   		echo 1;
   	}
   	else{
   		echo 0;
   	}

?>
