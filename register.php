<?php
require "library.php";
needUserInfo();
if($logged_in){
    header("Location: ".$root);
    exit();
}
?>
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php printDeps();?>
                                                     <title>Chalk it Up | Register</title>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<?php printNav();?>
<div class='container'>
<h1>Welcome to our wonderful website</h1>
                                                     <h2>Register</h2>
                                                     <form action='register_submit.php' method='POST'>
                                                     <input class='form-control' type='text' name='login_name' placeholder="Login Name"/><br/>
                                                     <input class='form-control' type='text' name='display_name' placeholder="Display Name"/><br/>
                                                     <input class='form-control' type='text' name='email' placeholder="Email"/><br/>
                                                     <input class='form-control' type='password' name='password' placeholder="Password"/><br/>
                                                     <input class='form-control' type='password' name='password' placeholder="Password Confirm"/><br/>
                                                     <div class="g-recaptcha" data-sitekey="6LfLKB0TAAAAACKEmXnQkE1pECT3R2XUJQDIDm7d"></div>
                                                     <input class='form-control btn btn-primary' type='submit' value='Join'/><br/>
                                                     </form>
                                                     </div>
</body>
</html>
