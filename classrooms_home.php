<?php
require "library.php";
needUserInfo();
?>
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php printDeps();?>

    <style>
	* {
		border-radius: 0 !important;
	}
	#blackboard{
		background: url("https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/BB.png") no-repeat center center fixed; 
		background-size: cover;
	}
	.big-image{
		height: 500px;
	}
	</style>
      
    <title>Chalk it up!</title>
	
  </head>
  <body> 
		<?php printNav(); ?> <div class="container"> <?php

function printClassFromId($classid){
    $class = runSql1('get_class', 'SELECT * FROM class WHERE classid = $1;', array($classid));
    if($class){
        printClass($class);
    }else{
        echo "<li><h3>Failed to retrieve info for class with id $classid</h3></li>";
    }
}
function printClass($class){
    echo '<li><h3><a href="/classroom_detail.php?classid='.$class['classid'].'">'.$class['display_name'].'</a></h3></li>';
}

if($logged_in === FALSE){
    echo '<h1>You must <a data-toggle="modal" data-target="#loginModal" href="javascript:true">login</a> to view your classes.</ht>';
}else{
    $student_of = runSql('student_of', 'SELECT classid FROM class_student_link WHERE uid = $1;', array($uid)) or die('<h1>Failed to retrieve your classes</h1>');
    $teacher_of = runSql('student_of', 'SELECT classid FROM class_teacher_link WHERE uid = $1;', array($uid)) or die('<h1>Failed to retrieve your classes</h1>');
    if(pg_num_rows($teacher_of) > 0 ){
        echo '<h2>You teach:</h2><br/><ul>';
        for($i = 0; $i < pg_num_rows($teacher_of); $i++){
            printClassFromId(pg_fetch_assoc($teacher_of, $i)['classid']);
        }
    }
    if(pg_num_rows($student_of) === 0){
        if(pg_num_rows($teacher_of) === 0){
            echo '<h2>You are not part of any classes.</h2>';
        }
    }else{
        echo '<h2>You attend:</h2><br/><ul>';
        for($i = 0; $i < pg_num_rows($student_of); $i++){
            printClassFromId(pg_fetch_assoc($student_of, $i)['classid']);
        }
    }
}
?>
</div>


  </body>

</html>
