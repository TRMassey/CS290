<!-- CITATION: Outline for correct table creation came from: SharkofMirkwood, StackOverflow.com, -->
<!-- Response Post March 30, 2014, "How to build a multiplication table in php and html" -->
<!-- http://stackoverflow.com/questions/22745645/how-to-make-a-multiplication-table-in-php-and-html -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">		
		<title>Multiplication Table</title>
		<link rel="stylesheet" href="assign4style.css" />
	</head>
	<body>
		<!-- Introduce the assignment -->
		<h1> Assignment Four: Multtable.php</h1>
		<h3> Author: Tara Massey </h3>
		<h3> CS 290 Spring Term </h3>
		</br>

		<?php
		# set values for error handling
		$error = false;

		# error handling - if an input was left blank tell the user and exit
		if(empty($_GET['min-multiplicand'])){
			echo "Missing parameter min-multiplicand";
			echo '<br/>';
			$error = true;
		} 
		if(empty($_GET['max-multiplicand'])){
			echo "Missing parameter max-multiplicand.";
			echo '<br/>';
			$error = true;
		} 
		if(empty($_GET['min-multiplier'])){
			echo "Missing parameter min-multiplier.";
			echo '<br/>';
			$error = true;
		}
		if(empty($_GET['max-multiplier'])){
			echo "Missing parameter max-multiplier.";
			echo '<br/>';
			$error = true;
		}


		# all input was entered, now test it
		else{

			# assign variables
			$minNum = $_GET['min-multiplicand'];
			$maxNum = $_GET['max-multiplicand'];
			$min = $_GET['min-multiplier'];
			$max = $_GET['max-multiplier'];
			$noNeg = 1;

			# error handling -- not an integer
			# only evaluates one at a time....
			if(!is_numeric($minNum) || !is_numeric($maxNum) || !is_numeric($min) || !is_numeric($max)){
				echo "Input must be a whole integer.";
					$error = true;
			}


			# set the variables type for testing, otherwise was getting errors
			settype($minNum, "integer");
			settype($maxNum, "integer");
			settype($min, "integer");
			settype($max, "integer");

			#error handling - per teacher on Piazza, no negative numbers
			if($minNum < $noNeg){
				echo "Input must be a positive whole number.";
				echo '<br/>';
				$error = true;
			}

			if($min < $noNeg){
				echo "Input must be a positive whole number.";
				echo '<br/>';
				$error = true;
			}

			# error handling - is a number, but out of range
			if($minNum > $maxNum){
				echo "Minimum multiplicand larger than maximum.";
				echo '<br/>';
				$error = true;
			}

			if($min > $max){
				echo "Minimum multiplier larger than maximum.";
				echo '<br/>';
				$error = true;
			}


			# stop the table from being created if there is an error
			if($error == true){
				exit();
			}

			# input all valid, continue
			else{

				# create the output table of results
				# max-multiplicand +2 for height and max+2 for length
				echo '<table border="1" style="width:100%">';
					
					# give it a nice title
					echo '<caption>Multiplication Table</caption>';
					
					# body of the table
					echo '<tbody>';

						# set up top row, min starts at -1 to create blank space
						for($i = $min-1; $i <= $max; $i++){
					
							#create a blank space
							if($i == ($min-1)){
								echo '<th></th>';
							}

							# fill in the rest with the numbers
							else{	
								echo '<th>'.$i.'</th>';
							}
						}

						# set up the left column and rows
						for($i = $minNum; $i <= $maxNum; $i++){
							echo '<tr>';
							echo '<th>'.$i.'</th>';

							# fill in with resulting calculation
							for($j = $min; $j <= $max; $j++){
								$result = $i*$j;
								echo '<td>'.$result.'</td>';
							}
							echo '</tr>';
						}

					echo '</tbody>';
				echo '</table>';
			}
		}
		?>
	</body>
</html>
