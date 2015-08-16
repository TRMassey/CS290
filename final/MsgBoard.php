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
		<title>Yoga Message Board</title>
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
          
          /* response true for finding errors, dont allow them to continue */
          window.alert("You are not logged in! You will be redirected.");
          window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/LoginOrRegister.php";
        }
      }
    }

    /* send data to create table */
    req.open("POST","checkSession.php", true);
    req.send();
}



  /************************************************************************
  *         Add Message to Table
   * Error handling structure with true/false reponses came from -
   * Citation: Dottoro Web Reference, "responseText property", 
   * Example HTML Code 3, http://help.dottoro.com/ljvlqrpi.php
  ************************************************************************/

function addMsg(){

  /* get values from form */
  var msg = document.getElementById("msg").value;
  var msgLength = msg.Length;

  /* validate length parameters */
  if(msgLength > 100){
    document.getElementById("output9").innerHTML = "ERROR: Message is too long. Please keep the comment at 100 characters or less.";
    document.getElementById("AddMsg").reset();
   return;
  }

  /* request */
  else{
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

    /* response was true, message added to DB */
     if(req.responseText == 1){
        /* redirect with updates */
        window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/MsgBoard.php";
     }

    /* response false, notify with error */
    if(req.responseText == 0){
      document.getElementById("output9").innerHTML = "Error creating message.";
      document.getElementById("AddMsg").reset(); 
    }

     /* error I didn't think of, for testing */
     else if(req.responseText != 1 && req.responseText != 0){
          document.getElementById("output9").innerHTML = req.responseText;
       }
    }
  }

      /* send data to create table */
   	  req.open("POST","AddToMessage.php", true);
   	  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
   		var tableData = "msg="+msg;
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

 	  <div class="sidebar">
    <ul id="menu">
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/main.php">Home Page</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/YogaLog.php">Yoga Log</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Balance.php">Balance</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Strength.php">Strength</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Flexibility.php">Flexibility</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Relaxation.php">Relaxation</a></li>
      <li><a href="http://web.engr.oregonstate.edu/~masseyta/final/Relief.php">Stress Relief</a></li>
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
			echo "<h2>Welcome to your The Community Message Boards, ".$_SESSION['username']."!</h2>";
			echo "<h2>_______________________</h2>";
			echo "</br>";
		echo "</p>";
		?>
 	</div>
	<div class = "main">
	<?php

		/* table for each of the db contents */
    echo "</br>";
		echo "<h1 align='center'>Practice Log</h1>";
    echo "<p>";
    echo "</p>";
		echo "<table border ='1' align='center' style='width:80%'>";
			echo "<tr>";
				echo "<th>User</th>";
				echo "<th>Message</th>";
			echo "</tr>";

			/* fill in the table from the db */
			$result = mysqli_query($mysqli, 'SELECT * FROM MsgBoard');
			while($row = mysqli_fetch_array($result)){
				echo '<tr>';
				echo '<td>'.$row['user'].'</td>';
				echo '<td>'.$row['msg'].'</td>';
        echo '</tr>';   
			}
		echo "</table>";
    echo "<p>";
    echo "</br>";
    echo "</p>";

		/* close it all */
		$mysqli->close();
	?>

	<!-- Manual Input without video links -->
	<p>
		<h3> Or Leave a Community Message</h3>
    <h2>______________________</h2>
	</p>
  <div class="formDec">
	<form Id="AddMsg">
		<fieldset>
			<legend>Yoga Practice : </legend>
      <p>
        Your message will be available to all users.
      </p>
      <p>
        The <b>message</b>must be 100 characters or less. Please keep it polite.
      </p>

			<!-- Title of exercise -->
			<p>
		  		<label>Message: </label>
		   		<input type ="text" Id="msg">
			</p>
			<p align="center">

				<!-- Send information to loginCheck function for error handling and ajax call if wrong -->
				<button Id ="submit" type ="button" onclick="addMsg()" align="center">Post My Message</button>
			</p>
		</fieldset>
		</form>
  </div>
	</br>

  <!-- display area for user initiated errors -->
	<div id="output9">
	</br>
</div>
<p>
	</br>
</p>
</div>
	</body>
</html>