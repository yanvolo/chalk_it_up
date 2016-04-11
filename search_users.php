<?php
require "library.php";
sql();

if(isset($_POST['login_name']) and strlen($_POST['login_name']) >= 3){
    $res = runSql('search_users_login_name', 'SELECT * FROM user_ WHERE login_name LIKE $1;', array("%".$_POST['login_name']."%")) or die('fail');
}else if(isset($_POST['display_name']) and strlen($_POST['display_name']) >= 3){
    $res = runSql('search_users_display_name', 'SELECT * FROM user_ WHERE LOWER(display_name) LIKE $1;', array("%".$_POST['display_name']."%")) or die('fail');
}
$text = pg_num_rows($res).",";
for($i = 0; $i < pg_num_rows($res); $i++){
    $user = pg_fetch_assoc($res, $i);
    $text .= $user['uid'].','.$user['login_name'].','.$user['display_name']."\n";
}
echo $text;
doneWithSql();
