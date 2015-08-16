

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title> Yoga Practice Tracker Login </title>
  <link rel="stylesheet" href="stylesheet.css" />
  <script>

  /************************************************************************
  * 				Error handling login
  ************************************************************************/
 

function login(){

  /* get values from form */
  var user = document.getElementById("username").value;
  var password = document.getElementById("password").value;


  /* check for blanks in the form */
  if(user == ""){
    document.getElementById("output").innerHTML = "Please Enter a Username";
    document.getElementById("LForm").reset();
   return;
  }

  if(password == ""){
    document.getElementById("output").innerHTML ="Please Enter a Password";
    document.getElementById("LForm").reset();
    return;
  }

  /* if no blanks, make the request and check for password match */
  else{
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
      if(req.readyState == 4 && req.status == 200){

        /* add user to DB */
        if(req.responseText == 1){
        /* everything has passed! Yay! Go into your session */
        window.location.href = "http://web.engr.oregonstate.edu/~masseyta/final/main.php";
        }

        /* false, errors. Notify  user, no addition to DB */
        if(req.responseText == 0){
            document.getElementById("output").innerHTML = "Username or Password Incorrect. Please try again or register now!";
            document.getElementById("LForm").reset(); 
         }

         /* errors I couldn't think of will print, destroying my grade */
        else if(req.responseText != 1 && req.responseText != 0){
          document.getElementById("output").innerHTML = req.responseText;
        }
      }
    }

    /* send to login.php for the session and db connection */
    req.open("POST","login.php", true);
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
		<!-- Get the user's login information -->
		<p>
			<h2> Login Information </h2>
			<h2> _________________ </h2>
		</p>
    <div class="formDec">
		<form Id="LForm">
      <p>
			   <label>Enter your username: </label>
			   <input type ="text" Id="username">
      </p>
      <p>
        <label>Enter your password: </label>
        <input type ="password" Id ="password">
      </p>
			<p align="center">

			<!-- Send information to loginCheck function for error handling and ajax call if wrong -->
			<button Id ="submit" type ="button" onclick="login()" align="center">Login</button>
			</p>
		</form>
	</div>

    <!-- display area for user initiated errors -->
  <div Id= "output"></div>
  </div>
  <p align="center">
    <h3>New User? Click <a href='http://web.engr.oregonstate.edu/~masseyta/final/Register.php'> here </a> to register now!</h3>
  </p>
	</body>
</html>