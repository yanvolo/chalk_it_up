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
	</style>
  </head>
  <body>
	<?php printNav();?>
	<div class="jumbotron text-center" id="blackboard">
		<div class="container">
			<h1 style='color:white'> Welcome to Chalk up! </h1>
			<p style='color:white'>  Fun Learning throughout the day! </p>
			
		</div>
	</div>
        <section>
			<div class="well">
				<div class="page-header" id="summary">
				    <h1> <center> What is ChalkItUp? </center> </h1>
                	<center> <div class="row">
            	<div class="col-lg-4">
            	    <h3> Education </h3>
                    <h4> ChalkItUp is an educational tool to help teach students the knowledge they need to succeed. </h4>
     			</div>
     			<div class="col-lg-4">
     				<h3> Teamwork </h3>
      				<h4> Students work together in classrooms to defeat "enemies" and reach the goal of gaining knowledge. </h4>
      			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/chemisludge_digital.jpg"/>
     			</div>
     			<div class="col-lg-4">
     				<h3> Fun </h3>
      				<h4> Entertaining visuals and trivia create an enjoyable experience that keeps students focused. </h4>
      			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/UI.png"/>
     			</div>
    		</div> <center>
				</div>
			</div>
			//delete this section when finished
		<div class="row">
   			<div class="col-lg-6">
 		<figure>
		    <h3> SQRT-1 (Mathematics) </h3>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/sqrt-1_sketch.jpg"/>
		</figure>
		<figure>
			<h3> Grock (Social Studies) </h3>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/grock_sketch.jpg"/>
		</figure>
     		</div>
     		<div class="col-lg-6">
      	<figure>
			<h3> Chemisludge (Science) </h3>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/chemisludge_digital.jpg"/>
		</figure>
		<figure>
			<h3> Bookworm (Language Arts) </h3>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/bookworm_sketch.jpg"/>
		</figure>
		<div class="container">
			<container>
				<div class="page-header" id="features">
					<h2> Features <small> This is still not feedback </small> </h2>
				</div>

				<div class="row">
					<div class="col-lg-8">
						<h3> This is the heading </h3>
						<p> More lorum ipsum text that does not matter </p>
					</div>
					<div class="col-lg-4">
						<img src="img/imac.jpg" class="img-responsive" alt="image">
					</div>
				</div>

				<div class="row">
					<div class="col-lg-8">
						<h3> This is the heading </h3>
						<p> More lorum ipsum text that does not matter </p>
					</div>
					<div class="col-lg-4">
						<img src="img/smartphone.jpg" class="img-responsive" alt="image">
					</div>
				</div>

				<div class="row">
					<div class="col-lg-8">
						<h3> This is the heading </h3>
						<p> More lorum ipsum text that does not matter </p>
					</div>
					<div class="col-lg-4">
						<img src="img/user.jpg" class="img-responsive" alt="image">
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-lg-4">
							<div class="panel panel-default">
								<div class="panel-body text-center">
									<span class="glyphicon glyphicon-info-sign"> </span>
									<h4> Sure</h4>
									<p> This is more content</h4>
								</div>
							</div>
					</div>

					<div class="col-lg-4">
							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h4> Sure</h4>
									<p> This is more content</h4>
								</div>
							</div>
					</div>

					<div class="col-lg-4">
							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h4> Sure</h4>
									<p> This is more content</h4>
								</div>
							</div>
					</div>


				</div>
			</container>
		</div>

  </body>

</html>
