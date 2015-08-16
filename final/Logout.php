<?php
  /**********************************************************************
  *          Session set up
  **********************************************************************/

  /* error check */
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);

  /* start session */
  ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">    
    <title>Logout</title>
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
/*******************************************************************
*           Adding video practice to Log
* Error handling structure with true/false reponses came from -
* Citation: Dottoro Web Reference, "responseText property", 
* Example HTML Code 3, http://help.dottoro.com/ljvlqrpi.php
********************************************************************/
function logOut(){

    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
   		  if(req.readyState == 4 && req.status == 200){

	    	 if(req.responseText == 1){
    	    	/* everything has passed! Yay! Go into your session */
        		window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/LoginOrRegister.php";
     		}

        /* no specific instance for causing false, but if it's not true... tell me */
     		else{
          		document.getElementById("errorZone").innerHTML = req.responseText;
     		}
   		}
  	}

        /* send data to create table */
        req.open("POST","killSession.php", true);
        req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
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
  <div>

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
  
    <?php

    /* welcome the person by session name */
    echo "<p>";
      echo "<h2>Do you want to Logout, ".$_SESSION['username']."?</h2>";
      echo "<h2>_______________________</h2>";
      echo "</br>";
    echo "</p>";
    ?>
  </div>
  <div class="main">
  </br>
    <h3>Yes, I'm ready to log out. I understand that all information will be saved. </h3>

    <!-- main instruction set -->
    <form Id="EndingSession">
      <p align="center">

        <!-- Send information to loginCheck function for error handling and ajax call if wrong -->
          <button Id ="out" type ="button" onclick="logOut()">Log Me Out!</button>
      </p>
    </form>

    <!-- display area for user initiated errors -->
  </div>
    <div id="errorZone">
    </br>
</body>
</html>
