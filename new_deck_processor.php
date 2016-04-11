<?php
require "library.php";
sql();
needUserInfo();

$deckID = base64_encode(random_bytes(16));
$name = san($_POST['name']);
$description = san($_POST['desc']);
$house = $_POST['cards'];


$card_ids = array();

txStart();

foreach($house as $card){
    $id = base64_encode(random_bytes(16));
    array_push($card_ids, $id);
    for($i = 0; $i < count($card['answers']); $i++){
        $card['answers'][$i] = san($card['answers'][$i]);
    }
    $answers_csv = str_putcsv($card['answers']);
    runSql('new_card', 'INSERT INTO card (cardid, owner, short, long, answers_csv) VALUES ($1, $2, $3, $4, $5);',
array($id, $uid, san($card['question']), san($card['question']), $answers_csv));
}
runSql('new_deck', 'INSERT INTO deck (deckid, owner, display_name, description, questionids_csv) VALUES ($1, $2, $3, $4, $5);',
       array($deckID, $uid, $name, $description, str_putcsv($card_ids)));

txCommit();

doneWithSql();

echo 'Success!';