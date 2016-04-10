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
        <h3> What is Chalk it Up ? </h3>
			<div class="well">
				<div class="page-header" id="feedback">
					<h2> Feedback <small> This is feedback </small> </h2>
				</div>
				<div class="row">
					<div class="col-lg-4">
                        <p> MORE TEXT  <img class="big-image" style="height:300px" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/logo_horzontal.png"/> </p>
					</div>
					<div class="col-lg-4">
						<p> Lorum Ipsum </p>
					</div>
					<div class="col-lg-4">
						<p> Lorum Ipsum </p>
					</div>
				</div>
			</div>
		</section>
		<h2> Chalk it Image Library </h2>
		<p> Images with sources for web devs </p>
		<figure>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/logo_horzontal.png"/>
			<figcaption> logo_horzontal.png </figcaption>
		</figure>
		<figure>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/logo_vertical.png"/>
			<figcaption> logo_vertical.png </figcaption>
		</figure>
		<figure>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/sqrt-1_sketch.jpg"/>
			<figcaption> /bosses/sqrt-1_sketch.jpg </figcaption>
		</figure>
		<figure>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/grock_sketch.jpg"/>
			<figcaption> /bosses/grock_sketch.jpg </figcaption>
		</figure>
		<figure>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/chemisludge_sketch.jpg"/>
			<figcaption> /bosses/chemisludge_sketch.jpg </figcaption>
		</figure>
		<figure>
			<img class="big-image" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/bosses/bookworm_sketch.jpg"/>
			<figcaption> /bosses/bookworm_sketch.jpg </figcaption>
		</figure>		
  </body>

</html>
