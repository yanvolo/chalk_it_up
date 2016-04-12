<?php
require "library.php";

if(!isset($_POST['login_name']) or $_POST['login_name'] == ''){die('invalid request, login_name is empty');}
if(!isset($_POST['display_name']) or $_POST['display_name'] == ''){die('invalid request, display_name is empty');}
if(!isset($_POST['email']) or $_POST['email'] == ''){die('invalid request, email is empty');}
if(!isset($_POST['password']) or $_POST['password'] == ''){die('invalid request, password is empty');}
if(!isset($_POST['g-recaptcha-response']) or $_POST['g-recaptcha-response'] == ''){die('invalid request, g-recaptcha-response is empty');}

$captcha = $_POST['g-recaptcha-response'];
$post = array('response'=> $captcha,
              'secret'=> '6LfLKB0TAAAAAEG3cE72AA5FW7L_iOCr-9soMvZG',
              'remoteip' => $_SERVER['REMOTE_ADDR']);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
$captcha_check = curl_exec($curl) or die('failed to send message to google for captcha validation');
$captcha_obj = json_decode($captcha_check) or die('failed to decode google captcha validation response');;
if(!$captcha_obj->{'success'}){die('google denied captcha');}

$new_login_name = $_POST['login_name'];
$new_display_name = $_POST['display_name'];

$new_uid = base64_encode(random_bytes(16));

sql();
runSql('new_user', 'INSERT INTO user_ (uid, login_name, display_name) VALUES ($1, $2, $3);', array($new_uid, $new_login_name, $new_display_name)) or die('failed to create user');

#substr(sha1(password_hash("bcrypt", PASSWORD_BCRYPT, ["cost" => 4, "salt" => "bcryptbcryptbcryptbcry"])), 0, 6)
$BCRYPT_HASH_TYPE = "c34d5d";
$hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 10]);
$pass_success = runSql('add_password', 'INSERT INTO auth_native (uid, secret_hash_type, secret_hash, hash_type_specific) VALUES ($1, $2, $3, $4);', array($new_uid, $BCRYPT_HASH_TYPE, $hash, NULL));

doneWithSql();
header("Location: " . $root . '/?fail_auth_native_msgid=5&fail_auth_login_name='.$new_login_name);