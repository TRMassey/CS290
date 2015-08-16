<?php
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title> Yoga Practice Log Registration </title>
  <link rel="stylesheet" href="stylesheet.css" />
  <script>

  /************************************************************************
  * 				Error handling login
   * Error handling structure with true/false reponses came from -
   * Citation: Dottoro Web Reference, "responseText property", 
   * Example HTML Code 3, http://help.dottoro.com/ljvlqrpi.php
  ************************************************************************/
 

function createUser(){

  /* get values from form */
  var user = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var userLength = user.length;
  var passLength = password.length;


  /* check for blanks in the form and validate length parameters*/
  if(user == ""){
    document.getElementById("output").innerHTML = "ERROR: Please Enter a Username";
    document.getElementById("LForm").reset();
   return;
  }
  if(userLength > 20){
    document.getElementById("output").innerHTML = "ERROR: Username must be 20 characters or less.";
    document.getElementById("LForm").reset();
    return;
  }

  if(password == ""){
    document.getElementById("output").innerHTML ="ERROR: Please Enter a Password";
    document.getElementById("LForm").reset();
    return;
  }
  if(passLength > 20){
        document.getElementById("output").innerHTML = "ERROR: Username must be 20 characters or less.";
        document.getElementById("LForm").reset();
        return;
  }


  /* if no blanks, make the request and check for password match */
  else{
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

      /* true response, good to go */
     if(req.responseText == 1){
        /* everything has passed! Yay! Go into your session */
        window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/main.php";
     }

     /* false response for situation */
    if(req.responseText == 0){
      document.getElementById("output").innerHTML = " ERROR: Username is taken. Please select a new username.";
      document.getElementById("LForm").reset(); 
    }

     /* some weird error I didn't think of, for testing */
     else if(req.responseText != 1 && req.responseText != 0){
          document.getElementById("output").innerHTML = req.responseText;
       }
    }
  }
    /* send to login.php for the session and db connection */
    req.open("POST","CreateLogin.php", true);
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var loginData ="username="+user+"&password="+password;
    req.send(loginData);

  }
}
</script>
</head>
<body>

  <!-- Header Image with Title and Logo -->
  <div class="header">
  <!-- IMAGE SOURCE: http://www.clker.com/clipart-purple-lotus-5.html, CLKER -->
    <img alt="mainPic" src="http://i60.tinypic.com/6gh3f7.png">
  </div>

  <!-- Line seperating title -->
  <div class="bars">
    <img alt="lines" src="http://i59.tinypic.com/2572lns.png" width="100%">
  </div>
  <div class="main">
  	<div class="forms">

		<!-- Get the user's login information -->
		<p>
			<h2> Registration Information </h2>
			<h2> _________________ </h2>
		</p>
    <p>
      You will select a username and a password to access your account.
    </p>
    <p>
      Your <b>username</b> must be less than 20 characters, and is not case sensitive.
    </p>
    <p>
      Your <b>password</b> must be less than 20 characters, and is case sensitive.
      <h2> _________________ </h2>
    </p>
  </br>
		<form Id="LForm">
      <fieldset>
        <legend> User Information </legend>
      <p>
			   <label>Enter a username: </label>
			   <input type ="text" Id="username">
      </p>
      <p>
        <label>Enter a password: </label>
        <input type ="password" Id ="password">
      </p>
			<p align="center">

			<!-- Send information to loginCheck function for error handling and ajax call if wrong -->
			<button Id ="submit" type ="button" onclick="createUser()" align="center">Register</button>
			</p>
    </fieldset>
		</form>
	</div>

  <!-- display area for user initiated errors -->
  <div Id= "output"></div>
    </br>
  </div>
  </div>
</body>
</html>