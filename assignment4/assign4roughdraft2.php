<?php

	error_reporting(E_all);
	ini_set('display_errors',1);

	/* include security sensitive information */
	include 'info.php';

	/* connect to the database */
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", $dbpass, "masseyta-db");
	if($mysqli->connect_errno){
		echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}
	else{
		echo "TESTING PURPOSES : Connection Passed.";
	}

	/* delete every last video */
	if(isset($_GET['massDelete'])){
        $mysqli->query("DELETE FROM videos");
        echo '</br>';
		echo "Click <a href='http://web.engr.oregonstate.edu/~masseyta/assign4prt2/interface.html'> here </a> to return to add some movies.";
		exit();
	}

	/* if the filter is set, save it for future use */
	if(isset($_GET['filter'])){
		$finalfilter=$_GET['catFilter'];
		echo "TEST Category: ".$finalfilter."!";
	}

	if(!isset($_GET['filter'])){
		$finalfilter="all";
	}

	/* if the add video button has been clicked, update the database */
	if(isset($_POST['addVid'])){
		/* call the error checking program */

		$errorChk = 0;

		/* Check requirements for name */
		if(!isset($_POST['title']) || $_POST['title'] ==""){
			echo "ERROR : Missing video title.";
			$errorChk++;
		}

		if($_POST['name'].length > 255){
			echo "ERROR : Maximum title length of 255 characters.";
			$errorChk++;
		}

		 /*Check requirements for length*/ 
		if(isset($_POST['length']) && $_POST['length'] < 0){
			echo "ERROR : Movie length must be a positive integer.";
			$errorChk++;
		}

		/* if missing info, stop the table creation */
		if($errorChk > 0){
			echo "Click <a href='http://web.engr.oregonstate.edu/~masseyta/assign4prt2/interface.html'> here </a> to address your errors.";
			exit();
		}


		/*if it passes, add the video */

		/* prepare the statement*/
		 if (!($stmt = $mysqli->prepare("INSERT INTO videos (name, category, length) VALUES (?, ?, ?)"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* assign the posts to variables for easier use */
		$name = $_POST['title'];
		if(!isset($_POST['category']) || $_POST['category'] == ""){
			$category = " ";
		}
		else{
			$category = $_POST['category'];
		}
		if(!isset($_POST['length']) || $_POST['length']== ""){
			$length = " ";
		}
		else{
			$length = $_POST['length'];
		}

		/* bind the variables */
	 	if(!$stmt->bind_param('ssi', $name, $category, $length)){
	 		echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
	 	}

		/* execute */
		if(!$stmt->execute()){
			echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}
	} 

	/* states of change for the table once at least one movie has been added */
	if(isset($_GET['CheckIn'])){
		$statusID =$_GET['CheckIn'];
		$mysqli->query("UPDATE videos SET rented=0 WHERE id='$statusID'");
	}

	if(isset($_GET['CheckOut'])){
		$statusID =$_GET['CheckOut'];
		$mysqli->query("UPDATE videos SET rented=1 WHERE id='$statusID'");
	}
	
	if(isset($_GET['delete'])){
		$delID = $_GET['delete'];
		$mysqli->query("DELETE FROM videos WHERE id='$delID'");
	}	

?>

<!-- I like my printed output inside it's HTML shell -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">		
		<title>Yoga Log</title>
		<link rel="stylesheet" href="assign4style.css" />
	</head>
	<body>
		<?php
		/* table for each of the db contents */
		echo "<table border ='1' style='width:100%'>";
			echo "<tr>";
				echo "<th>Movie Name</th>";
				echo "<th>Category</th>";
				echo "<th>Length</th>";
				echo "<th>Status</th>";
				echo "<th>Check In/Out</th>";
				echo "<th>Delete Video</th>";
			echo "</tr>";

			if($finalfilter == "all"){
			$result = mysqli_query($mysqli, 'SELECT * FROM videos');
			while($row = mysqli_fetch_array($result)){
				echo '<tr>';
				echo '<td>'.$row['name'].'</td>';
				echo '<td>'.$row['category'].'</td>';
				echo '<td>'.$row['length'].'</td>';

				/* add buttons for check in or check out, depending on current state */
				echo "<form action = 'assign4roughdraft.php' method = 'GET'>";
					if($row['rented'] == 1){
						echo "<td>";
							echo "Checked Out";
						echo "</td>";
						echo "<td>";
							$statID = $row['id'];
							echo "<input type='hidden' name='CheckIn' value='$statID'><input type='submit' value='Check In' name='in'>";			# Should, in theory, send ID to function for update
						echo "</td>";
					}
				echo "</form>";
				echo "<form action = 'assign4roughdraft.php' method = 'GET'>";
					if($row['rented'] == 0){
						echo "<td>";
							echo "Checked In";
						echo "</td>";
						echo "<td>";
							$statID = $row['id'];
							echo "<input type='hidden' name='CheckOut' value='$statID'><input type='submit' value='Check Out' name='out'>";		# Should, in theory, send ID to function for update
						echo "</td>";
					}
				echo "</form>";

				/* add button to delete a single video, one per row */
				echo "<form action = 'assign4roughdraft.php' method = 'GET'>";
					echo "<td>";
						$statID = $row['id'];
						echo "<input type='hidden' name='delete' value='$statID'><input type='submit' value='Delete This Video' name='del'>";		# Should, in theory, send ID to function for update
					echo "</td>";
				echo "</form>";
				echo "</tr>";		
			}							
			echo "</form>";	
		echo "</table>";
		echo "</br>";
	}
	else{
			$result = mysqli_query($mysqli, 'SELECT DISTINCT category FROM videos WHERE category ="'.$finalfilter.'"');
			while($row = mysqli_fetch_array($result)){
				echo '<tr>';
				echo '<td>'.$row['name'].'</td>';
				echo '<td>'.$row['category'].'</td>';
				echo '<td>'.$row['length'].'</td>';

				/* add buttons for check in or check out, depending on current state */
				echo "<form action = 'assign4roughdraft.php' method = 'GET'>";
					if($row['rented'] == 1){
						echo "<td>";
							echo "Checked Out";
						echo "</td>";
						echo "<td>";
							$statID = $row['id'];
							echo "<input type='hidden' name='CheckIn' value='$statID'><input type='submit' value='Check In' name='in'>";			# Should, in theory, send ID to function for update
						echo "</td>";
					}
				echo "</form>";
				echo "<form action = 'assign4roughdraft.php' method = 'GET'>";
					if($row['rented'] == 0){
						echo "<td>";
							echo "Checked In";
						echo "</td>";
						echo "<td>";
							$statID = $row['id'];
							echo "<input type='hidden' name='CheckOut' value='$statID'><input type='submit' value='Check Out' name='out'>";		# Should, in theory, send ID to function for update
						echo "</td>";
					}
				echo "</form>";

				/* add button to delete a single video, one per row */
				echo "<form action = 'assign4roughdraft.php' method = 'GET'>";
					echo "<td>";
						$statID = $row['id'];
						echo "<input type='hidden' name='delete' value='$statID'><input type='submit' value='Delete This Video' name='del'>";		# Should, in theory, send ID to function for update
					echo "</td>";
				echo "</form>";
				echo "</tr>";		
			}							
			echo "</form>";	
		echo "</table>";
		echo "</br>";
	}
		/* add a DELETE ALL button here */
		echo "<form action='assign4roughdraft.php' method='GET'>";
			echo "<fieldset>";
				echo "<legend> Delete Absolutely ALL of the Database </legend>";
				echo "No take-sy-back-sies </br>";
				echo "<input type='submit' value='DELETE ALL' name='massDelete'>";
			echo "</fieldset>";
		echo "</form>";
		echo "</br>";
		echo "<p>";
		echo "Click <a href='http://web.engr.oregonstate.edu/~masseyta/assign4prt2/interface.html'> here </a> to to add some movies.";
		?>
	</body>
</html>

<?php
	/* close connection */
	$stmt->close();
	$mysqli->close();

?>