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

	/************************************************************************
	* 					Database setup 
	************************************************************************/

	/* include sensitive information */
	include "info.php";

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
	if($mysqli->connect_errno){
		echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}

	/***********************************************************************
	*				Add to the table
	***********************************************************************/

	/* create my variables */
	$user = $_SESSION['username'];
	$msg = $_POST['msg'];


	/* prepare the statement*/
	if (!($stmt = $mysqli->prepare("INSERT INTO MsgBoard (user, msg) VALUES (?, ?)"))){
		echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}

	/* bind the variables */
	if(!$stmt->bind_param('ss', $user, $msg)){
 		echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
 	}

	/* execute */
	if(!$stmt->execute()){
		echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}

	/* updated */
	echo 1;
	$stmt->close();
	$mysqli->close();

?>