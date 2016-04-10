<?php
require "library.php";
if($_COOKIE['sessionid'] !== NULL){
    sql();
    delSession($_COOKIE['sessionid']);
    doneWithSql();
}
setcookie("sessionid");
header("Location: " . $protocol . $rootDomain . "/");
