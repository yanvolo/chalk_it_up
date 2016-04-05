<?php
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
					<a href="index.php" class="navbar-brand"> <img style="height:1em;" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/logo_horzontal.png"/></a>
				</div>
				<div class="collapse navbar-collapse" id="my-nav">
					
					
					<div class="navbar-right">
							 <div class="g-signin2 navbar-btn" data-onsuccess="onSignIn" data-theme="dark"></div>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="play_home.php"> Play </a> </li>
						<li><a href="classrooms_home.php"> Classrooms </a> </li>
						<li><a href="create_set.php"> @DEBUG: Create a set </a> </li>
						<li><a href="#"> Report an Issue </a> </li>
					</ul>
				</div>
			</div>
      </nav>';
	}

?>
