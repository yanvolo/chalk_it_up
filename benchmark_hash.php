<?php

$timeTarget = 0.5;

$cost = 3;

echo "bcrypt going until >= ".(1000 * $timeTarget)."ms starting w/ cost ".($cost+1)."<br/>";

echo "hash type id:".substr(sha1(password_hash("bcrypt", PASSWORD_BCRYPT, ["cost" => 4, "salt" => "bcryptbcryptbcryptbcry"])), 0, 6)." (substr(sha1(password_hash(\"bcrypt\", PASSWORD_BCRYPT, [\"cost\" => 4, \"salt\" => \"bcryptbcryptbcryptbcry\"])), 0, 6))<br/>";

$tests = array();

do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
    array_push($tests, "cost $cost = " . (1000 * ($end - $start)) . "ms<br/>");
} while (($end - $start) < $timeTarget);

foreach($tests as $i){
    echo $i;
}
