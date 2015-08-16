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
	* 					Database setup and change
	************************************************************************/

	/* include sensitive information */
	include "info.php";

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
	if($mysqli->connect_errno){
		echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}

  if(isset($_GET['delete'])){
    $delID = $_GET['delete'];
    $mysqli->query("DELETE FROM YogaLog WHERE id='$delID'");
  } 

?>

<!-- I like my printed output inside it's HTML shell -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">		
		<title>Yoga Log</title>
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



  /************************************************************************
  *         Add practice to Table
   * Error handling structure with true/false reponses came from -
   * Citation: Dottoro Web Reference, "responseText property", 
   * Example HTML Code 3, http://help.dottoro.com/ljvlqrpi.php
  ************************************************************************/

function addTable(){

  /* get values from form */
  var title = document.getElementById("title").value;
  var purpose = document.getElementById("purpose").value;
  var length = document.getElementById("length").value;
  var before = document.getElementById("Before").value;
  var after = document.getElementById("After").value;

  /* check for blanks in the form */
  if(title > 20){
    document.getElementById("output2").innerHTML = "Please enter a title that is 20 characters or less";
    document.getElementById("AddForm").reset();
   return;
  }

  if(isNaN(length)){
    document.getElementById("output2").innerHTML ="Length input should be numeric.";
    document.getElementById("AddForm").reset();
    return;
  }

  else{
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

      /* response was true, allow the user to continue */
     if(req.responseText == 1){
        /* redirect with updates */
        window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/YogaLog.php";
     }

     /* response was false, can't add to DB */
    if(req.responseText == 0){
      document.getElementById("output2").innerHTML = "Error adding practice to log.";
      document.getElementById("AddForm").reset(); 
    }

    /* horrible weirdness happened. Print it */
     else if(req.responseText != 1 && req.responseText != 0){
          document.getElementById("output2").innerHTML = req.responseText;
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
			echo "<h2>Welcome to your Yoga Log, ".$_SESSION['username']."!</h2>";
			echo "<h2>_______________________</h2>";
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
				echo "<th>Practice Purpose</th>";
				echo "<th>Video Title</th>";
				echo "<th>Length</th>";
				echo "<th>Mood Before</th>";
				echo "<th>Mood After</th>";
        echo "<th>Remove from Log</th>";
			echo "</tr>";

			/* fill in the table from the db */
			$result = mysqli_query($mysqli, 'SELECT * FROM YogaLog WHERE user="'.$_SESSION['username'].'"');
			while($row = mysqli_fetch_array($result)){
				echo '<tr>';
				echo '<td>'.$row['purpose'].'</td>';
				echo '<td>'.$row['title'].'</td>';
				echo '<td>'.$row['length'].'</td>';
				echo '<td>'.$row['befMood'].'</td>';
				echo '<td>'.$row['aftMood'].'</td>';
                echo "<form action ='YogaLog.php' method = 'GET'>";
            echo "<td>";
              $statID = $row['id'];
              echo "<input type='hidden' name='delete' value='$statID'><input type='submit' value='Delete This Practice' name='del'>";   # Should, in theory, send ID to function for update
            echo "</td>";
          echo "</form>";
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
		<h3> Or, if you practiced outside of these guides, enter your practice in manually </h3>
    <h2>______________________</h2>
	</p>
  <div class="formDec">
	<form Id="AddForm">
		<fieldset>
			<legend>Yoga Practice : </legend>
      <p>
        Your exercise <b>title</b> should be no more than 50 characters.
      </p>
      <p>
        The <b>length</b>of time spent practicing is measured in full minutes, and should be entered as a number.
      </p>

			<!-- Title of exercise -->
			<p>
		  		<label>Title: </label>
		   		<input type ="text" Id="title">
			</p>

			<!-- Purpose of exercise -->
      		<p>
      			<label>Enter the purpose of the practice:</label>
      			<select name="purpose" id="purpose">
      				<option value="Balance" name="Balance">Balance</option>
      				<option value="Strength" name="Strength">Strength</option>
      				<option value="Flexibility" name="Flexibility">Flexibility</option>
      				<option value="Relaxation" name="Relaxation">Relaxation</option>
              <option valu="Energy" name="Energy">Energy</option>
      			</select>
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
  </div>
	</br>

	<!-- display area for user initiated errors -->
  <div id="output2">
		</br>
  </div>
  <p>
	 </br>
  </p>
  </div>
	</body>
</html>