<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<?php 
			require "library.php";
			needUserInfo();
			printDeps();
		?>
     <title>Chalk it up!</title>
  </head>
	<body>
	<div class="conatiner">
		<?php printNav(); 
			//Generate Message
						$from = "yanvolo@gmail.com";
			$to = "yanvolo@gmail.com";
			$body = filter_var($_POST['message'],FILTER_SANITIZE_SPECIAL_CHARS);
			$body = str_replace("\n.", "\n..", $body);
			$subject = filter_var($_POST['head'], FILTER_SANITIZE_SPECIAL_CHARS);
			mail("yanvolo@gmail.com","test subject","test body");
		  
		?>
	</div>	

	
	</body>
</html>
