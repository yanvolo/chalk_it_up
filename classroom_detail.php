<?php
require "library.php";
needUserInfo();
if(!isset($_GET['classid']) || $_GET['classid'] == ''){die("No class id was specified. $goHome");}
$classid = $_GET['classid'];

$student = runSql1('is_student_of_class', 'SELECT * FROM class_student_link WHERE uid = $1 AND classid = $2;', array($uid, $classid));
$teacher = runSql1('is_teacher_of_class', 'SELECT * FROM class_teacher_link WHERE uid = $1 AND classid = $2;', array($uid, $classid));

if(!($student or $teacher)){die("You are not part of this class, or it does not exist. $goHome");}

$class = runSql1('get_class', 'SELECT * FROM class WHERE classid = $1;', array($classid)) or die('Internal server error: failed to get class info.');
?>
<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php printDeps();?>
                                                     <title><?php echo $class['display_name'];?> - Chalk it Up</title>
</head>
<body>

<?php
printNav();


echo "<h1>{$class['display_name']}</h1>";

$teachers = runSql('get_teachers', 'SELECT uid FROM class_teacher_link WHERE classid = $1;', array($classid));

echo '<h3>Taught by ';
$teachers_count = pg_num_rows($teachers);
if($teachers_count == 0){
    echo 'Nobody (which is probably not a good thing)';
}
for($i = 0; $i < $teachers_count; $i++){
    $teacher = getUserRow(pg_fetch_assoc($teachers, $i)['uid']);
    
    echo multiple($i, $teachers_count)."<a href='/profile.php?login_name={$teacher['login_name']}'>{$teacher['display_name']}</a>";
}
echo '</h3>';

$students = runSql('get_students', 'SELECT uid FROM class_student_link WHERE classid = $1;', array($classid));
$students_count = pg_num_rows($students);
if($students_count == 0){
    echo '<h3>There are no students (which is probably not a good thing)</h3>';
}else{
    echo '<h3>Students:</h3>';
}

if($teacher){
    echo "<form action='add_students.php' method='POST'>
<input type='hidden' name='classid' value='$classid'/>
";
    $select_students_modal = userSelectionInput('students', 'Students to add');
                                                echo "<input type='submit' value='Submit'/>
</form><br/>";
                                                echo $select_students_modal;

}



echo '<ul>';
for($i = 0; $i < $students_count; $i++){
    $student = getUserRow(pg_fetch_assoc($students, $i)['uid']);
    echo "<li><a href='/profile.php?login_name={$student['login_name']}'>{$student['display_name']}</a></li>";
}
echo '</ul>';

?>

</body>
</html>
