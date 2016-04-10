<?php
	$servername = 'localhost';
	$username = 'root';
	$password = 'tuesday';
	$dbname = 'chalkupDB';
	
	function importXML($filename){
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($filename);
		echo $xmlDoc -> saveXML();
	}
	function printNav(){
		echo '<nav class="navbar navbar-inverse navbar-fixed">
          <div class="container"> 
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#my-nav">
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span>
					</button>
					<a href="index.php" class="navbar-brand"> <img style="height:1em;" alt="Chalk it up" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/logo_horzontal.png"/></a>
				</div>
				<div class="collapse navbar-collapse" id="my-nav">
					<div class="navbar-right">
							 <div class="g-signin2 navbar-btn" data-onsuccess="onSignIn" data-theme="dark"></div>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="play_home.php"> Play </a> </li>
						<li><a href="classrooms_home.php"> Classrooms </a> </li>
						<li><a href="feedback.php"> Feedback </a> </li>
					</ul>
				</div>
			</div>
      </nav>';
	}
	function sanitize_input($inputString){
		$inputString = trim($inputString);
		$inputString = stripslashes($inputString);
		$inputString = htmlspecialchars($inputString);
		return $ret;
	}
	function printHead(){
		echo '<!-- Latest compiled and minified CSS -->
	 <link rel="stylesheet" href="css/bootstrap.min.css"></link>
	 <!-- Optional theme -->
	 <link rel="stylesheet" href="css/bootstrap-theme.min.css"></link>
	 <!-- Personal Deafult Theme-->
	 <link rel="stylesheet" href="css/default.css"></link>
	 
	 <meta name="google-signin-scope" content="profile email"/>
     <meta name="google-signin-client_id" content="1054699344422-jr8acquecheeh5lrghtcvhabto42hni4.apps.googleusercontent.com"/>
	 <script src="https://apis.google.com/js/platform.js" async defer></script>
	 <link rel="icon" type="img/ico" href="cp.ico">
     <title>Chalk it up!</title>';
	}
	function loadBasicScripts(){
		echo '<!-- Jquery -->
      <script src="js/jquery-2.2.2.js"> </script>
      <!-- Latest compiled and minified JavaScript -->
	  <script src="js/bootstrap.min.js"></script>
	  <!-- Textfill JS-->
	  <script src="js/jquery.textfill.min.js"></script>
	  <script type="text/javascript">
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        
        //profile.getName());
        //profile.getGivenName());
        //profile.getFamilyName());
        //profile.getImageUrl());
        //profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
      };
    </script>';
	}
		function create_deckID($conn){
		//Keep generating random values until we get no output from master
		do {
			$rand = mt_rand(0,2000000000);
			$command = "SELECT * FROM master_card WHERE deckID=$rand"; 
			$result = $conn -> query($command) or die("Querry failed");
		} while($result->num_rows !== 0);
		return $rand; 
	}
?>
