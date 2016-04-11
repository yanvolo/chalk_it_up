<?php
require "library.php";
needUserInfo();
if(!$is_admin){die("You do not have permission to do this.");}

if(!isset($_POST['display_name']) or $_POST['display_name'] == ''){die('invalid request, display_name is empty');}
if(!isset($_POST['teachers'])){die('invalid request, teachers is empty');}

$teachers = str_getcsv($_POST['teachers']);
if(count($teachers) < 1){die('invalid request, no teachers specified');}

foreach($teachers as $teacher_uid){
    runSql('check_user_existance_by_uid', 'SELECT * FROM user_ WHERE uid = $1;', array($teacher_uid)) or die('teacher does not exist w/ id '.$teacher_uid);
}


$classid = base64_encode(random_bytes(16));
runSql('new_class', 'INSERT INTO class (classid, display_name) VALUES ($1, $2);', array($classid, san($_POST['display_name']))) or die('failed to create class');

$fails = array();
foreach($teachers as $teacher_uid){
    if($teacher_uid == ''){continue;}
    $res = runSql('add_teacher', 'INSERT INTO class_teacher_link (classid, uid) VALUES ($1, $2);', array($classid, $teacher_uid));
    if(!$res){
        array_push($fails, $teacher_uid);
    }
}
foreach($fails as $fail){
    echo 'failed to add teacher w/ id '.$fail.'<br/>';
}
echo 'Done. <a href="/admin.php">Back to admin page.</a>';
