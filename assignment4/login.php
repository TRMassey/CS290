<?php
# keeps the user from returning to login via redirect, then
# typing in the URL for content1/content2 and getting access
# Citation for php: Ianni, Eric. 4/30 Tutoring Session. Demo: login.php
	session_start();
	session_unset();
	session_destroy();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Assignment Four Login</title>
		<link rel="stylesheet" href="assign4style.css" />
	</head>
	<body>
		<!-- Show assignment -->
		<h1> Assignment Four: Login. php </h1>
		<h3> Author: Tara Massey </h3>
		<h3> CS 290 Spring Term </h3>
		<br/>

		<!-- Get the user's login information -->
		<form action ="content1.php" method="POST">
			<fieldset>
				<legend> LOGIN </legend>
					<label>Enter your user name: </label>
					<input type ="text" name="username">
					<input type ="submit" value="Login">
			</fieldset>
		</form>
	</body>
</html>