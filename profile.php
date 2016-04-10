<?php
require "library.php";
needUserInfo();

$_GET['uid'] = $_GET['uid'] === '' ? NULL : $_GET['uid'];
$_GET['login_name'] = $_GET['login_name'] === '' ? NULL : $_GET['login_name'];

$invalid_profile = FALSE;
$profile_uid = NULL;
if($_GET['uid'] === NULL){
    if($_GET['login_name'] === NULL){
        $invalid_profile = "No user was specified in the query part of the URL.<br/>$goHome";
    }else{
        $profile_uid = getUidFromLoginName($_GET['login_name']);
    }
}else{
    $profile_uid = $_GET['uid'];
    if($_GET['login_name'] != NULL){
        $login_names_uid = getUidFromLoginName($_GET['login_name']);
        if($profile_uid != $login_names_uid){
            $uids_name = getUserRow($profile_uid);
            $uids_name = ($uids_name === NULL or $uids_name === FALSE) ? NULL : $uids_name['login_name'];
            $invalid_profile = "This URL asks for a user with the login name '" . $_GET['login_name'] . "' and the user id '" . $_GET['uid'] . "' which don't match.
 (the user with the login name '".$_GET['login_name'].($login_names_uid === FALSE ? "' does not exist" : "' has id '".$login_names_uid."'").
", the user with the id '".
$profile_uid.($uids_name === NULL ? "' does not exist" : "' has login name''".$uids_name."'").").
<br/>$goHome";
        }
    }
}
$orofile_display_name = NULL;
if($invalid_profile === FALSE){
    $profile_user_row = getUserRow($profile_uid);
    if($profile_user_row === FALSE){
        $invalid_profile = "The user with the " .
                         ($_GET['uid'] !== NULL ?
                          "id '".$_GET['uid']."'" :
                          "login name '".$_GET['login_name']."'") .
                         " does not exist.<br/>$goHome";
    }
    $profile_display_name = $profile_user_row['display_name'];
}
?>

<html>
<head>
<title><?php echo $invalid_profile ? (rand(0, 100) === 0 ? "missingno" : "Nobody") : $profile_display_name;?>&lsquo;s Profile</title>
<?php printDeps();?>
</head>
<body>
<?php
printNav();

echo $invalid_profile ? $invalid_profile : 
    ($profile_display_name . "<br/>he's a pretty cool guy.");

?>
</body>
</html>