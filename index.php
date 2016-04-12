<?
require "library.php";
needUserInfo();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <?php printDeps();?>
     <title>Chalk it up!</title>
	 <style>
	 #blackboard{
		background: url("https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/BB.png") no-repeat center center fixed; 
		background-size: cover;
	}
	.big-image{
		width: 100%;
		background-color:black;
	}
	.jumbotron{
		margin:0px !important;
	}
	h3{
		font-weight:bold;
		font-size: 30px;
	}
	nav{
		margin:0px !important;
		
	}
	.small-image{
		width: 50%;
		background-color: white;
	}
	.news-image{
		width: 100%;
		background-color: white;
	}
	.bordered-image{
		width: 100%;
		background-color: white;
		border-style: solid;
		border-width: 27px 0px;
		border-color: white;
	}
	</style>
  </head>
  <body>
	<?php printNav();?>
	<div class="jumbotron text-center" id="blackboard">
		<div class="container">
			<h1 style='color:white'> Welcome to ChalkItUp! </h1>
			<p style='color:white'>  Fun Learning throughout the day! </p>
			
		</div>
	</div>
        <section>
			<div class="well">
				<div class="page-header" id="summary">
				    <h1> <center> What is ChalkItUp? </center> </h1>
                	<center> <div class="row">
            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            	    <h3> Education </h3>
                    <h4> ChalkItUp is an educational tool to help teach students the knowledge they need to succeed. </h4>
                     <img class="small-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/sqrt-1_sketch.png"/>
     			</div>
     			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
     				<h3> Teamwork </h3>
      				<h4> Students work together in classrooms to defeat "enemies" and reach the goal of gaining knowledge. </h4>
      				     				<div class="progress">
					  <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" style="width:30%" id="bar">
						<span class="sr-only"></span>
					  </div>
					</div>
      			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/chemisludge_digital.png"/>
     			</div>
     			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
     				<h3> Fun </h3>
      				<h4> Entertaining visuals and trivia create an enjoyable experience that keeps students focused. </h4>
      			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/UI.png"/>
     			</div>
    		</div> 
				</div>
			</div>
	<div class="jumbotron text-center" id="blackboard">
		<div class="container">
			<h1 style='color:white'> News and Plans </h1>
			<p style='color:white'>  The going ons of Chalk it Up! </p>
			
		</div>
	</div>
	<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<h3> IT Expo at UC (4/12/16) </h3>
						<p> Walnut Hills INTERalliance presentation of ChalkItUp at University of Cincinnati at 10 AM and website launch. Be there by 8:30 AM to prepare for presentation and to watch the website go live. </p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<center> <img class="news-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/uc.png" /> </center>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<h3> INTERalliance Meeting (4/14/16) </h3>
						<p> INTERalliance meeting after school to discuss information technology and business, as well as future plans for the club and the web project next year. </p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<center> <img class="news-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/interalliance.jpg" /> </center>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<h3> Gaming Day (4/21/16) </h3>
						<p> INTERalliance will host a gaming day, where we will play and discuss videogames and their impact in the IT field. But really, we mostly just play games.</p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<center> <img class="news-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/game.png" /> </center>
					</div>
				</div>

				<hr>

			
		</div>	
		<script type="text/javascript">
			  var width = 30;
	  $(document).ready(function(){
		
		setInterval(animateBar, 100)
		setInterval(addJerk, 1500);
	  });
	  function addJerk(){
		 width+=10;
		 $("#bar").css({'width':width+'%'});
	  }
	  function animateBar(){
		if(width<=0){
			width=100;
		}
		else{
			width--;
		}
		$("#bar").css({'width':width+'%'});
	  }
    </script>

  </body>

</html>
