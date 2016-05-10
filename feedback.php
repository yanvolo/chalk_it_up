<?php 
require "library.php";
needUserInfo();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
		printDeps();
	?>
     <title>Chalk it up!</title>
	<style>
		text-area{
			resize: none;
			overflow: auto;
		}
	</style>
  </head>
  <body>
<?php printNav();?>
<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<iframe src="http://goo.gl/forms/9LeVf3abF5" style="width:100%;height:90em;" frameborder="0" scrolling="no"></iframe>	
		</div>
	</div>

  </body>
