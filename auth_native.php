<?php
require "library.php";
sql();

$name = $_POST["login_name"];
$secret = $_POST["secret"];
$callback = $_POST["callback"];

if(strpos($callback, "?") === FALSE){
    $callback .= "?";
}

function getAuth($uid){
    return runSql1("get_auth", 'SELECT * FROM auth_native WHERE uid = $1;', array($uid));}

function fail_login($msgid, $name, $uid){
    global $protocol, $rootDomain, $callback;
    header("Location: " . $protocol . $rootDomain . $callback . "&fail_auth_native_msgid=$msgid&fail_auth_login_name=$name&fail_auth_uid=$uid");
    exit();
}

$uid = getUidFromLoginName($name) or fail_login(0, $name, NULL);

#substr(sha1(password_hash("bcrypt", PASSWORD_BCRYPT, ["cost" => 4, "salt" => "bcryptbcryptbcryptbcry"])), 0, 6)
$BCRYPT_HASH_TYPE = "c34d5d";

#echo password_hash($secret, PASSWORD_BCRYPT, ["cost" => 10]);

$auth = getAuth($uid) or fail_login(1, $name, $uid);
switch($auth['secret_hash_type']){
case $BCRYPT_HASH_TYPE:
    if(password_verify($secret, $auth['secret_hash']) !== TRUE){
        fail_login(2, $name, $uid);
    };
    break;
default: fail_login(3);
}

$sessionid = newSession($uid) or fail_login(4);
doneWithSql();


//name, value, expires, path, domain, secure, httpon
# HEY! YOU! CHANGE secure TO TRUE ONCE WE'RE USING SSL!
setcookie("sessionid", $sessionid, 0, "/", $rootDomain, false, true);
header("Location: " . $protocol . $rootDomain . $callback);
