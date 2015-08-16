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
	$title = $_POST['title'];
	$purpose = $_POST['purpose'];
	$length = $_POST['length'];
	$before = $_POST['before'];
	$after = $_POST['after'];
	$user = $_SESSION['username'];


	/* prepare the statement*/
	if (!($stmt = $mysqli->prepare("INSERT INTO YogaLog (title, purpose, length, befMood, aftMood, user) VALUES (?, ?, ?, ?, ?, ?)"))){
		echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}

	/* bind the variables */
	 if(!$stmt->bind_param('ssisss', $title, $purpose, $length, $before, $after, $user)){
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