<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <?php 
		require "library.php";
		needUserInfo();
		printDeps();
	?>
     <title>Chalk it up!</title>
	<style>
		text-area{
			resize:vertical;
		}
	</style>
  </head>
  <body>
	<?php printNav(); ?>
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1 well">
				<h3> Feedback </h3>
				<p> Write to use and let us know how we are doing </p>
				<form class="form-group" id="full-message" action="feedback_sent.php" method="post">
					<input type="text" name = "head" class="form-control" id="header" placeholder="Message Head" required>
					  <div class="checkbox">
						<label>
						  <input type="checkbox" name="report-type[]" value="--Bug Report--"> Bug Report
						</label>
					 </div>
					 <div class="checkbox">
						<label>
						  <input type="checkbox" name="report-type[]" value="--Feature Request--"> Feature Request
						</label>
					 </div>
					 <div class="checkbox">
						<label>
						  <input type="checkbox" name="report-type[]" value="--General Feedback--"> Genneral Feedback
						</label>
					 </div>
					<label> Content: </label> 
					<textarea class="form-control" COLS=65 ROWS=5 placeholder="Message Contents" name="message" required></textarea>
					<input type="submit" class="button btn-primary" id="submit">
				</form>
				
		</div>
	</div>

  </body>
