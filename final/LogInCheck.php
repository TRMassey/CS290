<?php
	/**********************************************************************
	*					 Session set up
	**********************************************************************/

	/* error check */
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);

	/* start session */
	ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
    session_start();

	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == false) {
   			echo "Need a redirect. Already in use by another user.";
   			header("Location: {$redirect}/index.php", true);
   	}

	/************************************************************************
	* 					Database setup 
	************************************************************************/

		/* include sensitive information */
		include "info.php";

		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}
	}

?>