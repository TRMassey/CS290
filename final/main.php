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

?>

<!-- I like my printed output inside it's HTML shell -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">		
		<title>Yoga Log Homepage</title>
		<link rel="stylesheet" href="stylesheet.css" />
		<script>

  /************************************************************************
  * 				Check Session on body load
  ************************************************************************/

function checkSession(){

    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

        if(req.responseText == 1){
          /* everything has passed! Yay! Go into your session */
          window.alert("You are not logged in! You will be redirected.");
          window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/LoginOrRegister.php";
        }
      }
    }

    /* send data to create table */
    req.open("POST","checkSession.php", true);
    req.send();
}

</script>
	</head>
	<body onload="checkSession()">
 	 <div class="header">
      <!-- IMAGE SOURCE: http://www.clker.com/clipart-purple-lotus-5.html, CLKER -->
    	<img alt="mainPic" src="http://i60.tinypic.com/6gh3f7.png">
 	 </div>

    <!-- Line seperating title -->
    <div class="bars">
      <img alt="lines" src="http://i59.tinypic.com/2572lns.png" width="100%">
    </div>

    <div class="sidebar">
    <ul id="menu">
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/main.php">Home Page</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/YogaLog.php">Yoga Log</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Balance.php">Balance</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Strength.php">Strength</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Relief.php">Stress Relief</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Flexibility.php">Flexibility</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Relaxation.php">Relaxation</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Energy.php">Energy</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/MsgBoard.php">Community Message Board</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Logout.php">Logout</a></li>
    </ul>
  </div>


  	<!-- Line seperating title -->
  	<div class="bars">
    	<img alt="lines" src="http://i59.tinypic.com/2572lns.png" width="100%">
 	</div>
 	<div>
 		<?php

		/* welcome the person by session name */
		echo "<p>";
			echo "<h2>Welcome to your Yoga Tracker, ".$_SESSION['username']."!</h2>";
			echo "<h2>_______________________</h2>";
			echo "</br>";
		echo "</p>";
		?>
 	</div>
	<div class = "main">  
  <p align="center">
    <h2>Yoga Practice Options</h2>
    <h2>______________________</h2>
  </p>

  <!-- Links to various choices -->
  <!-- IMAGE SOURCE: http://www.clker.com/clipart-23716.html, CLKER -->
  <div class="formDec">
    <a href= "Balance.php">
      <img alt="balance" src="http://i58.tinypic.com/nvtnhe.png" width="70%" onmouseover= "this.src='http://i61.tinypic.com/wl4zk1.png';"
      onmouseout="this.src='http://i58.tinypic.com/nvtnhe.png';" align="center">
    </a>


    <a href= "Strength.php">
      <img alt="strength" src="http://i62.tinypic.com/bhmupv.png" width="70%" onmouseover="this.src='http://i61.tinypic.com/25yw0ut.png';"
      onmouseout="this.src='http://i62.tinypic.com/bhmupv.png';" align="center">
    </a>

    <a href= "Flexibility.php">
      <img alt="flexibility" src="http://i62.tinypic.com/14cwmex.png" width="70%" onmouseover="this.src='http://i61.tinypic.com/jsljy0.png';"
      onmouseout="this.src='http://i62.tinypic.com/14cwmex.png';" align="center">
    </a>

    <a href= "Energy.php">
      <img alt="energy" src="http://i62.tinypic.com/30mwrbr.png" width="70%" onmouseover="this.src='http://i62.tinypic.com/2e0tk75.png';"
      onmouseout="this.src='http://i62.tinypic.com/30mwrbr.png';" align="center">
    </a>

    <a href= "Relaxation.php">
      <img alt="relaxation" src="http://i61.tinypic.com/2ltk6ty.png" width="70%" onmouseover="this.src='http://i60.tinypic.com/29dwaxd.png';"
      onmouseout="this.src='http://i61.tinypic.com/2ltk6ty.png';" align="center">
    </a>

    <a href= "Relief.php">
      <img alt="relief" src="http://i57.tinypic.com/25hz4ab.png" width="70%" onmouseover="this.src='http://i60.tinypic.com/akhi4k.png';"
      onmouseout="this.src='http://i57.tinypic.com/25hz4ab.png';" align="center">
    </a>
  </div>
	<p>
		<h3>Please select from the above goals for today's practice, and you'll be guided to the appropriate yoga practice tutorial</h3>
  </p>
	
  </div>
  </br>

  <!-- display area for user initiated errors -->
	<div id="output2">
	</br>
</div>
</body>
</html>