
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Recipe Search</title>
	</head>
	<body>
		<h1> RECIPE SEARCH REQUEST </h1>
		<br/>
		<form action ="samplePage.php" method="GET">
			<fieldset>
				<legend> Search Criteria (if no ingredient is entered, the top 10 ranked recipes will display) </legend>
					<label>Ingredient: </label>
					<input type ="text" name="q"></br>
      				<input type ="submit" name="submit" value="Get Recipes">
			</fieldset>
		</form>
		</br>
		<h1>INGREDIENT SEARCH LIST</h1>
 		<form action ="samplePage.php" method="GET">
			<fieldset>
				<legend> Specific Recipe Info </legend>
					<label>Recipe ID: </label>
					<input type ="text" name="id"></br>
      				<input type ="submit" name="recipeReq" value="Get Recipes">
			</fieldset>
		</form>
	</body>
</html>

<?php

	if(isset($_GET['submit'])){

	if(isset($_GET['sort'])){
			$filter=$_GET['sort'];
			echo "Filter: ".$filter;
			echo "</br>";
	}

	if(isset($_GET['q'])){
			$ingredient= $_GET['q'];
			echo "Ingredient: ".$ingredient;
			echo "</br>";
	}

		$apiURL = "http://food2fork.com/api/search?key=KEYHERE=".$ingredient."&sort=".$filter;
		$curl = curl_init();
  		curl_setopt ($curl, CURLOPT_URL, $apiURL);
 		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
 		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 		$result= json_decode(curl_exec($curl));

		for($i = 0; $i < 10; $i++){
			echo "Recipe Name: " .$result->recipes[$i]->title;
			echo "</br>";
			echo "Recipe ID: " .$result->recipes[$i]->recipe_id;
			echo "</br>";
			echo "Recipe URL: ".$result->recipes[$i]->f2f_url;
			echo "</br>";
			echo "Social Ranking: ".$result->recipes[$i]->social_rank;
  		echo "</br>";
  		echo "</br>";
 		}
 	}
curl_close($curl);
?>

<?php
 	if(isset($_GET['recipeReq'])){

 		if(isset($_GET['id'])){
			$ident=$_GET['id'];
		}

		$apiURL = "http://food2fork.com/api/get?key=KEYHERE&rId=".$ident;
 		$curl = curl_init();
  		curl_setopt ($curl, CURLOPT_URL, $apiURL);
 		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
 		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


 		$result= json_decode(curl_exec($curl));
 		$size = count($result->recipe->ingredients);

 		echo "Ingredients: ";
 		echo "</br>";
 		for($i = 0; $i < $size; $i++){
			echo $result->recipe->ingredients[$i];
  		echo "</br>";
  		}
 	}
curl_close($curl);
?>
