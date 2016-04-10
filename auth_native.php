<?php
require "library.php";
sql();

$name = $_POST["login_name"];
$secret = $_POST["secret"];
$callback = $_POST["callback"];

function getAuth($uid){
    return runSql1("get_auth", 'SELECT * FROM auth_native WHERE uid = $1;', array($uid));}

$uid = getUidFromLoginName($name);

#substr(sha1(password_hash("bcrypt", PASSWORD_BCRYPT, ["cost" => 4, "salt" => "bcryptbcryptbcryptbcry"])), 0, 6)
$BCRYPT_HASH_TYPE = "c34d5d";

#echo password_hash($secret, PASSWORD_BCRYPT, ["cost" => 10]);

$auth = getAuth($uid) or die("Your account was found, but you have no password set. Perhaps you've only logged in through an external service?");
switch($auth['secret_hash_type']){
case $BCRYPT_HASH_TYPE:
    if(password_verify($secret, $auth['secret_hash']) !== TRUE){
        die("invalid password");
    };
    break;
default: die("internal server error (your account has an invalid hash type)");
}

$sessionid = newSession($uid) or die("failed to create a session for you ¯\_('')_/¯");
doneWithSql();


//name, value, expires, path, domain, secure, httpon
# HEY! YOU! CHANGE secure TO TRUE ONCE WE'RE USING SSL!
setcookie("sessionid", $sessionid, 0, "/", $rootDomain, false, true);
header("Location: " . $protocol . $rootDomain . $callback);
