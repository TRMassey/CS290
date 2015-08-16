<!-- establish session -->
<?php
session_start();

# clear session for logout
# Citation : Wolfram/Ghorashi, Spring 2015 OSU CS290 Demo, Demo Video: PHP Sessions, sessions.php
if($_GET['action'] == 'end'){
	$_SESSION = array();
	session_unset();
	session_destroy();
	header("Location: login.php");
	die();
}

# create the session if there was a username entered
# Citation: Code adapted from Wolfram/Ghorashi, Spring 2015 OSU CS290 Demo, Demo Video: PHP Sessions, sessions.php
if(isset($_POST['username'])){
	$_SESSION['username'] = $_REQUEST['username'];
	$_SESSION['login'] = true;
	$_SESSION['number'] = 0;
}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Assignment Four Content 1</title>
		<link rel="stylesheet" href="assign4style.css" />
	</head>
	<body>
		<h1> Assignment Four: Content1.php </h1>
		<h3> Author: Tara Massey </h3>
		<h3> CS 290 Spring Term </h3>
		<br/>
		<?php

		# error catch for someone typing in the URL without the login page
		if($_SESSION['login'] != true){
			echo "You haven't logged in! You must log in with a valid username.";
			echo '</br>';
			echo "Click <a href= 'http://web.engr.oregonstate.edu/~masseyta/assign4/login.php'> here</a> to return to the login screen.";
		}
			
		# login is true, there is a session, there is a username - increment the page count
		else{		
			echo "Hello ".$_SESSION['username']."!";
			echo '<br/>';
			echo "You have visited this page ".$_SESSION['number']." times before.";
			$_SESSION['number'] = $_SESSION['number'] +1;
			echo '<br/>';
			echo "Click <a href= 'http://web.engr.oregonstate.edu/~masseyta/assign4/login.php?action=end'> here</a> to return to the login screen.";
			echo '<br/>';
			echo "Or continue to <a href='http://web.engr.oregonstate.edu/~masseyta/assign4/content2.php'> page two. </a>";
		}
		?>
</body>
</html>