<?php
require "library.php";

if(!isset($_POST['classid']) or $_POST['classid'] == ''){die('classid');}
if(!isset($_POST['display_name']) or $_POST['display_name'] == ''){die('invalid request, display_name is empty');}
if(!isset($_POST['img_url']) or $_POST['display_name'] == ''){die('invalid request, img_url is empty');}
if(!isset($_POST['hp']) or $_POST['hp'] == ''){die('invalid request, hp is empty');}

needUserInfo();
if(!$is_admin){die('You are not allowed to do this.');}

$classid = $_POST['classid'];
$boss_display_name = $_POST['display_name'];
$img_url = $_POST['img_url'];
$hp = $_POST['hp'];

$bossid = base64_encode(random_bytes(16));


runSql1('check_class', 'SELECT * FROM class WHERE classid = $1;', array($classid)) or die('not class with id '.$classid.'  exists');

runSql('new_boss', 'INSERT INTO boss (bossid, classid, display_name, img_url, hp) VALUES ($1, $2, $3, $4, $5);', array($bossid, $classid, $boss_display_name, $img_url, $hp)) or die('failed to create boss');


doneWithSql();

echo 'Created boss w/ id '.$bossid;
