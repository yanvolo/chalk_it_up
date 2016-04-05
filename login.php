<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css"> </link>

		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"> </link>
		  
		<meta name="google-signin-scope" content="profile email"/>
		<meta name="google-signin-client_id" content="1054699344422-jr8acquecheeh5lrghtcvhabto42hni4.apps.googleusercontent.com"/>
	   <script src="https://apis.google.com/js/platform.js" async defer></script>
		<style>
		* {
			border-radius: 0 !important;
		}
		#blackboard{
			background: url("https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/BB.png") no-repeat center center fixed; 
			background-size: cover;
		}
		</style>
		  
		<title>Chalk it up!</title>
	
	</head>
	<body>
		<?php require 'library.php'; printNav(); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-4"> </div>
				<div class="col-lg-4"> <div class="g-signin2 text-center pagination-centered" data-onsuccess="onSignIn" data-theme="dark"></div></div>
				<div class="col-lg-4"> </div>
				
			</div>
		</div>
	
	</body>

</html>