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

  /************************************************************************
  *           Database setup 
  ************************************************************************/

  /* include sensitive information */
  include "info.php";

  $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
  if($mysqli->connect_errno){
    echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">    
    <title>Yoga Practice: Energy</title>
    <link rel="stylesheet" href="stylesheet.css" />
    <script>

  /************************************************************************
  *         Check Session on body load
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

    /*****************************************************************
    *             Connect to YouTube
    * Note: The YouTube Flash Player API and JavaScript Player API were
    * deprecated on January 27, 2015. This uses <iframe>, which is
    * compatible with modern browsers, but not IE 7.
    *
    * Citation: Google Developers, "Getting Started"
    * https://developers.google.com/youtube/iframe_api_reference
    ******************************************************************/
      
      /* loads the IFrame Player API */
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      /* create the payer at the specified location */
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: 'K-Ina_WW4Yc',
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }
      
      /* function to play  video */
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      /* checks state, and stops video when done */
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }

  /*******************************************************************
   *           Adding video practice to Log
   * Error handling structure with true/false reponses came from -
   * Citation: Dottoro Web Reference, "responseText property", 
   * Example HTML Code 3, http://help.dottoro.com/ljvlqrpi.php
  ********************************************************************/
  function addTable(){

  /* get values from form */
  var title = document.getElementById("title").value;
  var purpose = "Energy";
  var length = document.getElementById("length").value;
  var before = document.getElementById("Before").value;
  var after = document.getElementById("After").value;

  /* check for blanks in the form */
  if(title > 20){
    document.getElementById("Output7").innerHTML = "Please enter a title that is 20 characters or less";
    document.getElementById("AddFormEnergy").reset();
   return;
  }

  if(isNaN(length)){
    document.getElementById("Output7").innerHTML ="Length input should be numeric.";
    document.getElementById("AddFormEnergy").reset();
    return;
  }

  else{
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

    /* error adding to DB */
    if(req.responseText == 0){
      document.getElementById("Output7").innerHTML = "Error.";
      document.getElementById("AddFormEnergy").reset(); 
    }

    /* add to DB successful */
     if(req.responseText == 1){
        window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/main.php";
     }

     /* weird, bad things happen that kill my grade */
     else if(req.responseText != 1 && req.responseText != 0){
          document.getElementById("Output7").innerHTML = req.responseText;
       }
    }
  }

          /* send data to create table */
        req.open("POST","AddToTable.php", true);
        req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var tableData = "title="+title+"&purpose="+purpose+"&length="+length+"&before="+before+"&after="+after;
        req.send(tableData);
    }
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

      <!-- Line seperating title -->
    <div class="bars">
      <img alt="lines" src="http://i59.tinypic.com/2572lns.png" width="100%">
  </div>

    <?php

    /* welcome the person by session name */
    echo "<p>";
      echo "<h2>Welcome to your Energy Practice, ".$_SESSION['username']."!</h2>";
      echo "<h2>_______________________</h2>";
      echo "</br>";
    echo "</p>";
    ?>
  </div>

    <!-- main instruction set -->

          <!-- Play the Video-->
    <div class="video">
      <div id="player" align="center"></div>
    </div>
    <p>
     </br>
    </p>
    <div class = "main">
      <h2 align="center">Please record your session to keep track of your progress</h2>
      <h2 align="center">_______________________</h2>
    <p>
      </br>
    </p>
   <div class="formDec">
    <!-- add the practice -->
    <form Id="AddFormEnergy">
      <fieldset>
        <legend>Yoga Practice : </legend>

        <!-- Title of exercise -->
         <p>
            <label>Title: </label>
            <input type ="text" Id="title">
          </p>

          <!-- Length of exercise -->
            <p>
            <label>Length of time practicing: </label>
            <input type ="text" Id ="length">
          </p>

          <!-- moods -->
          <p>
            <label>Mood before the practice:</label>
            <select name="purpose" id="Before">
              <option value="Bad" name="Bad">Bad</option>
              <option value="Poor" name="Poor">Poor</option>
              <option value="Average" name="Average">Average</option>
              <option value="Improved" name="Improved">Improved</option>
              <option value="Good1" name="Good">Good</option>
            </select>
          </p>
            <p>
            <label>Mood after the practice: </label>
            <select name="purpose" id="After">
              <option value="Bad" name="Bad">Bad</option>
              <option value="Poor" name="Poor">Poor</option>
              <option value="Average" name="Average">Average</option>
              <option value="Improved" name="Improved">Improved</option>
              <option value="Good1" name="Good">Good</option>
            </select>
          </p>
      <p align="center">

        <!-- Send information to loginCheck function for error handling and ajax call if wrong -->
        <button Id ="submit" type ="button" onclick="addTable()" align="center">Add my Practice</button>
      </p>
    </fieldset>
    </form>
    
  <!-- area for text to print from JS if user did bad things -->  
  </div>
    <div id="Output7">
    </br>
   </div>
  </div>
</body>
</html>