<?php
require "library.php";

if(!isset($_POST['login_name']) or $_POST['login_name'] == ''){die('invalid request, login_name is empty');}
if(!isset($_POST['display_name']) or $_POST['display_name'] == ''){die('invalid request, display_name is empty');}

$new_login_name = $_POST['login_name'];
$new_display_name = $_POST['display_name'];

needUserInfo();
if(!$is_admin){die('You are not allowed to do this.');}

$new_uid = base64_encode(random_bytes(16));

runSql('new_user', 'INSERT INTO user_ (uid, login_name, display_name) VALUES ($1, $2, $3);', array($new_uid, $new_login_name, $new_display_name)) or die('failed to create user');


$added_password = " with NO password";
if(isset($_POST['password']) and $_POST['password'] != ''){
    #substr(sha1(password_hash("bcrypt", PASSWORD_BCRYPT, ["cost" => 4, "salt" => "bcryptbcryptbcryptbcry"])), 0, 6)
    $BCRYPT_HASH_TYPE = "c34d5d";
    $hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 10]);
    $pass_success = runSql('add_password', 'INSERT INTO auth_native (uid, secret_hash_type, secret_hash, hash_type_specific) VALUES ($1, $2, $3, $4);', array($new_uid, $BCRYPT_HASH_TYPE, $hash, NULL));
    $added_password = $pass_success ? " with password" : " and FAILED to add password";
}

doneWithSql();

echo 'Created user w/ id '.$new_uid.' login_name '.$new_login_name.' display_name '.$new_display_name . $added_password;
