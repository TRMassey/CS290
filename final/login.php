<?php
	/**********************************************************************
	*					Basic Set Up
	**********************************************************************/

	/* error check */
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);


	/* include sensitive information */
	include "info.php";

	/* variables */
	$username = $_POST['username'];
	$username = strtoupper($username);
	$password = $_POST['password'];


	/************************************************************************
	* 			Check to see if another user is logged in
	************************************************************************

	/* start session */
	ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
     session_start();

    /* check for someone elses session prior to starting page */
    if(isset($_SESSION['username']) && $_SESSION['username'] != $username){
    	if($_SESSION['loggedIn'] != false){
   			echo "Another user is already logged in. If this is not you, click ";
   			echo "<a href='logoutUser.php'>here</a> to log out.";
   		}
   	}

   	else{
	/************************************************************************
	* 					Search for users name and password
	*
	* Researched methods. Referenced StackOverflow and found numRows method.
	* Citation: Kumar, Mohan. "username and password validation in php mysql"
	* StackOverflow. http://stackoverflow.com/questions/7267685/username-and-
	* password-validation-in-php-mysql
	************************************************************************/

	/* connect */
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
	if($mysqli->connect_errno){
		echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}

	/* Select user input for search */
	$result = "SELECT user FROM Users WHERE user='$username' && password='$password'";
	$product = $mysqli->query($result);
	$numReturned = $product->num_rows;

	/* if no results, there's no record of that username/password match */
	if($numReturned == 0){
		echo 0;				// false back to javascript
	}

	/* there is a match, so log them in an create a session */
	else{
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['loggedIn'] = true;
		echo 1;				// true back to javascript
	}

	/* close it up */
	$mysqli->close();
}
?>