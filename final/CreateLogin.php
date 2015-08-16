<?php
	/**********************************************************************
	*					error reporting
	**********************************************************************/

	/* error check */
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);


	/* include sensitive information */
	include "info.php";
	$newUser = true;

	$usernameDB = $_POST['username'];
	$usernameDB = strtoupper($usernameDB);
	$passwordDB = $_POST['password'];
	$userArray = [];


	/************************************************************************************
	*						Create the Session
	************************************************************************************/
	ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
    session_start();


	$_SESSION['username'] = $usernameDB;
	$_SESSION['password'] = $passwordDB;
	$_SESSION['loggedIn'] = true;



	/************************************************************************************
	*					Search for duplicate usernames
	*
	* Referenced stack overflow for organization and methods. Based off of -
	* Citation: Carnogursky, Juraj. Stack Overflow. "How to fetch details with while 
	* loop and display with foreach[MySQL and PHP], 09/06/2014
	* http://stackoverflow.com/questions/25698711/how-to-fetch-details-with-while-loop-
	* and-display-with-foreachmysql-and-php
	************************************************************************************/

	/* connect to db */
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
	if($mysqli->connect_errno){
		echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}

	/* prepare statement */
	if(!($stmt = $mysqli->prepare('SELECT user FROM Users'))){
		echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}

	/* execute */
	if(!$stmt->execute()){
		echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
	}

	/* bind results to a temp array of user names */
	if(!$stmt->bind_result($tempArray)){
		echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
	}

	/* while there's ueser names, fill the array */
	while($stmt->fetch()){
		array_push($userArray, $tempArray);
	}

	/* check each username to see if a new one will create a duplicate */
	foreach($userArray as $i){
		if($usernameDB === $i){
			$newUser = false;
			echo 0;
			break;
		}
	}

	/* close this request */
	$mysqli->close();

		
	/*******************************************************************************
	*					create new database user
	*******************************************************************************/
		
	/* name not taken  */
	if($newUser === true){

		/* connect */
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}


		/* prepare the statement*/
		if (!($stmt = $mysqli->prepare("INSERT INTO Users (user, password) VALUES (?, ?)"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* bind to the variables for testing */
		if(!$stmt->bind_param('ss', $usernameDB, $passwordDB)){
 			echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
 		}

		/* execute */
		if(!$stmt->execute()){
			echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		echo 1;			// return false to javascript for notification

		/* close this request */
		$stmt->close();
		$mysqli->close();

		}		
?>