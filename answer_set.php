<?php
require 'library.php';
needUserInfo();
if($logged_in === FALSE){
    header("Location: ".$root);
}
?>
<!DOCTYPE html>

<html>
<head>
	<?php printDeps(); ?>
	<style>
		.answer-choice{
			width:100%;
			height:30vh;
			
		}
		.question-area{
			font-weight: bold;
			height:20vh;
		}

	</style>
</head>
<?php
sql();

if(!isset($_GET['deckid']) or $_GET['deckid'] == ''){die("No deck was specified. $goHome");}

$deckid = $_GET['deckid'];

$deck = runSQL1('get_deck', 'SELECT * FROM deck WHERE deckid = $1;', array($deckid)) or die('failed to get deck '.$deckid);
$cards_csv = $deck['questionids_csv'];
$card_ids = str_getcsv($cards_csv);
$cards = array();
foreach($card_ids as $cardid){
    $card = runSql1('get_card', 'SELECT * FROM card WHERE cardid = $1;', array($cardid)) or die('failed to get card '.$cardid);
    array_push($cards, $card);
}

$cardix = -1;
if(isset($_POST['cardid']) and $_POST['cardid'] != ''){
    for($i = 0; $i < count($cards); $i++){
        if($cards[$i]['cardid'] == $_POST['cardid']){
            $cardid = $card['cardid'];
            $cardix = $i;
        }
    }
    if($cardix === -1){
        die("Card '{$_POST['cardid']}' does not exist in set '$deckid'. $goHome");
    }
}

//checks to see if answer has been chosen. if true, evaluates correctness of previous
//question. if false, skips this step and moves on to the next
$correct_msg = NULL;
$was_correct = NULL;
if(isset($_POST['chosen_answer']) and $_POST['chosen_answer'] != ''){ 
    $previous = $cards[$cardix];
    $sha1_try = base64_decode($_POST['chosen_answer']);
    $answers = str_getcsv($previous['answers_csv']);
    
    if(sha1($answers[0]) == $sha1_try){
        $correct_msg =  "Good job, $display_name!";
        $was_correct = TRUE;
    }else{
        $correct_msg = "You're wrong, $display_name. The correct answer to '{$previous['long']}' is '{$answers[0]}'";
        $was_correct = FALSE;
    }
}

$next = rand(0, count($cards) - 1 - ($cardix == -1 ? 0 : 1));
if($cardix != -1 and $next >= $cardix){$next++;}

$question = $cards[$next];

$possible_answers = str_getcsv($question['answers_csv']);

shuffle($possible_answers);

$answer1 = $possible_answers[0];
$answer2 = $possible_answers[1];
$answer3 = $possible_answers[2];
$answer4 = $possible_answers[3];

doneWithSql();

?>

<body>
<?php
printNav(); 

echo "<div class='container'>";

if($was_correct !== NULL){
echo "<div style='text-align: center;' class='alert ".($was_correct ? "alert-success" : "alert-danger")."' role='alert'>
 $correct_msg
</div>
";
}

echo "<form method='post' action='$protocol$rootDomain/answer_set.php?deckid=$deckid'>
	
    <input type='hidden' name='cardid' value='{$question['cardid']}'>"
?>
<style>
    button[type="submit"] {
        white-space: normal;
    }
.row {

 }
</style>
		<div class="row">
			<div class="button-group">
				<div class="col-lg-6">

    <button type="submit" name="chosen_answer" value=<?php echo base64_encode(sha1($answer1)); ?> class="answer-choice btn btn-primary" id="answer-1"><?php echo $answer1;?></button>
				</div>
				<div class="col-lg-6">
    <button type="submit" name="chosen_answer" value=<?php echo base64_encode(sha1($answer2)); ?> class="answer-choice btn btn-warning" id="answer-2"><?php echo $answer2;?></button>
				</div>
			</div>
		</div>
		<div class="row well question-area">
			<div class="col-lg-12 text-center" id="question">
    <span> <?php echo $question['long']; ?> </span>
			</div>
		</div>
		<div class="row">
			<div class="button-group">
				<div class="col-lg-6">
    <button type="submit" name="chosen_answer" value=<?php echo base64_encode(sha1($answer3)); ?> class="answer-choice btn btn-danger" id="answer-3"><?php echo $answer3;?></button>
				</div>
				<div class="col-lg-6" id="answer-4">
    <span><button type="submit" name="chosen_answer" value=<?php echo base64_encode(sha1($answer4)); ?> class="answer-choice btn btn-success" ><?php echo $answer4;?></button></span>
				</div>
			</div>
		</div>
	
	</form>
</div>
	<script>
$(".answer-choice").fitText();
$("#question").fitText(1.4);
	</script>
</body>
