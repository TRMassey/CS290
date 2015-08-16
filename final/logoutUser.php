<?php
	ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
	session_start();
	session_unset();
	session_destroy();
	header("Location: http://web.engr.oregonstate.edu/~masseyta/final/LoginOrRegister");
?>