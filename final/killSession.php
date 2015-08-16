<?php
	ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
	session_start();
	session_unset();
	session_destroy();
	echo 1;
?>