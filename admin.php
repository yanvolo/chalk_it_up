<?php
require "library.php";
needUserInfo();
if(!$is_admin){
    header("Location: ".$root);
    exit();
}
?>
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php printDeps();?>
                                                     <title>Chalk it Up | Admin</title>
</head>
<body>
<?php printNav();?>
<div class="container">
    <div class="col-lg-12">
<h1>Admin</h!>
                                                     <h2>Add class</h2>
                                                     <form action='new_class.php' method='POST'>
                                                     <input class="form-control" type='text' name='display_name' placeholder="Display Name class(display_name)"/><br/>
                                                     <?php $select_teacher_modal = userSelectionInput('teachers', 'Teachers');?><br/>
                                                     <input class="btn btn-primary" type='submit' value='Create'/><br/>
                                                     </form>
<?php echo $select_teacher_modal;?>

                                                     <h2>Add user</h2>
                                                     <form action='new_user.php' method='POST'>
                                                     <input class="form-control" type='text' name='login_name' placeholder="Login Name"/><br/>
                                                     <input class="form-control" type='text' name='display_name' placeholder="Display Name"/><br/>
                                                     <input class="form-control" type='password' name='password' placeholder="(optional) Default Password"/><br/>
                                                     <input class="btn btn-primary" type='submit' value='Create'/><br/>
                                                     </form>

                                                     <h2>Add boss</h2>
                                                     <form action='new_boss.php' method='POST'>
                                                     <input class="form-control" type='text' name='classid' placeholder="Class ID"/><br/>
                                                     <input class="form-control" type='text' name='display_name' placeholder="New Boss Name"/><br/>
                                                     <input class="form-control" type='text' name='img_url' placeholder="Image URL"/><br/>
                                                     <input class="form-control" type='text' name='hp' placeholder="HP"/><br/>
                                                     <input class="btn btn-primary" type='submit' value='Create'/><br/>
                                                     </form>


</div></div>
</body>
                                                     <html>
                                                     
