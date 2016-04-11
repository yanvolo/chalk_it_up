<?php
require "library.php";
if(isset($_COOKIE['sessionid'])){
    sql();
    delSession($_COOKIE['sessionid']);
    doneWithSql();
}
setcookie("sessionid", NULL, 0, "/", $rootDomain, false, true);
header("Location: " . $protocol . $rootDomain . "/");
