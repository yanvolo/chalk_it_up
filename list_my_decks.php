<?php
require "library.php";
needUserInfo();

if($logged_in === FALSE){die('not logged in');}

$res = runSql('get_decks', 'SELECT * FROM deck WHERE owner = $1;', array($uid)) or die('failed to get decks');
if(pg_num_rows($res) == 0){
    echo 'you have no decks';
}
for($i = 0; $i < pg_num_rows($res); $i++){
    $row = pg_fetch_assoc($res, $i);
    echo 'Name: '.$row['display_name'].'<br/>
Description: '.$row['description'].'<br/>';
    $cardids = str_getcsv($row['questionids_csv']);
    
    foreach($cardids as $cardid){
        $res2 = runSql1('get_answer', 'SELECT * FROM card WHERE cardid = $1;', array($cardid)) or die('failed to get card id:'.$cardid);
        echo 'Card Title: '.$res2['short'].'<br/>
Card Body: '.$res2['long'].'<br/>';
        $answers = str_getcsv($res2['answers_csv']);
        foreach($answers as $answer){
            echo $answer.'<br/>';
        }
    }
    echo '<br/>';
    
}