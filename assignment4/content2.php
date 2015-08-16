<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Assignment Four Content Two</title>
		<link rel="stylesheet" href="assign4style.css" />
	</head>
	<body>
		<h1> Assignment Four: Content2.php </h1>
		<h3> Author: Tara Massey </h3>
		<h3> CS 290 Spring Term </h3>
		<br/>
		<?php
		# error check for someone typing the URL in. Username should only populate in a session if it was first received from login page
		if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
			echo "You must login with a valid username.";
			echo "Click <a href='http://web.engr.oregonstate.edu/~masseyta/assign4/login.php'> here </a> to return to the login.";
		}
		# user has been through the login page and has a current session
		else{
			echo "Welcome, ".$_SESSION['username']."!";
			echo "Click to <a href='http://web.engr.oregonstate.edu/~masseyta/assign4/content1.php'> return </a> to the previous page.";
		}
		?>
	</body>
<html>
