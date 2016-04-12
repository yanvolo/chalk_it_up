<?php
require "library.php";

if(!isset($_POST['classid']) or $_POST['classid'] == ''){die('invalid request, classid is empty');}

$classid = $_POST['classid'];

needUserInfo();

$teacher = runSql1('is_teacher_of_class', 'SELECT * FROM class_teacher_link WHERE uid = $1 AND classid = $2;', array($uid, $classid));
if(!$teacher and !$is_admin){die("You do not have permission to do this, or this class does not exist.");}
if(!$teacher){
    runSql1('class_exist', 'SELECT * FROM class WHERE classid = $2;', array($classid)) or die("This class does not exist.");
}

if(!isset($_POST['students'])){die('invalid request, students is empty');}

$students = str_getcsv($_POST['students']);
if(count($students) < 1){die('invalid request, no students specified');}


$fails = array();
foreach($students as $student_uid){
    if($student_uid == ''){continue;}
    $exist = runSql('check_user_existance_by_uid', 'SELECT * FROM user_ WHERE uid = $1;', array($student_uid));
    if(!$exist){
        array_push($fails, 'student does not exist w/ id '.$student_uid);
        continue;
    }
    $already = runSql1('is_student_of_class', 'SELECT * FROM class_student_link WHERE uid = $1 AND classid = $2;', array($student_uid, $classid));
    if($already){
        //ignore it
        continue;
    }
    $res = runSql('add_student', 'INSERT INTO class_student_link (classid, uid) VALUES ($1, $2);', array($classid, $student_uid));
    if(!$res){
        array_push($fails, "failed to add student w/ id $student_uid");
    }
}
doneWithSql();
foreach($fails as $fail){
    echo "$fail<br/>";
}
if(count($fails) == 0){
    header("Location: ". $protocol . $rootDomain . "/classroom_detail.php?classid=" . $classid);
    echo "<a href='".$protocol . $rootDomain . "/classroom_detail.php?classid=" . $classid."'>Redirecting you... "."Location: ", $protocol . $rootDomain . "/classroom_detail.php?classid=" . $classid."</a>";
}
