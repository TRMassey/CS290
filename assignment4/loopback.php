<!-- Citation -->
<!-- JSON_encode built from examples from PHP Manual -->
<!-- http://php.net/manual/en/function.json-encode.php -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Assignment Four Loopback </title>
		<link rel="stylesheet" href="assign4style.css" /></title>
	</head>
	<body>
		<h1> Assignment Four: Loopback.php </h1>
		<h3> Author: Tara Massey </h3>
		<h3> CS 290 Spring Term </h3>
		<br/>
		<?php

		# post
		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			# per instructions, handle null
			# changed from = null to strings due to instructions to have TYPE and PARAMETERS printed w/null
			if(empty($_POST)){
				$metArray = array('Type'=> "POST", 'Parameters' => "null");
				$metArray = json_encode($metArray);
				echo $metArray;
			}

			# if there's content, turn it into a string.
			else{
				$metArray = array('Type'=> $_SERVER['REQUEST_METHOD'], 'Parameters' => $_POST);
				$metArray = json_encode($metArray);
				echo $metArray;
			}
		}

		# get
		elseif($_SERVER['REQUEST_METHOD'] == 'GET'){

			# per instructions, handle null
			# changed from = null to strings due to instructions to have TYPE and PARAMETERS printed w/null
			if(empty($_GET)){
				$metArray = array('Type'=> "GET", 'Parameters' => "null");
				$metArray = json_encode($metArray);
				echo $metArray;		
			}

			# if there's content, turn it into a string
			else{
				$metArray = array('Type'=> $_SERVER['REQUEST_METHOD'], 'Parameters' => $_GET);
				$metArray = json_encode($metArray);
				echo $metArray;
			}
		}
		?>
	</body>
</html>