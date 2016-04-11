<!DOCTYPE html>

<html>
<head>
	<?php require 'library.php'; needUserInfo(); printDeps(); ?>
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
	//SQL Config
	$servername = "localhost";		
	$username = "root";				
	$password = "tuesday";				
	$dbname = "chalkitDB";
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}	
	
	$deckID = "1135093967";
	//get things from the table
	//to use other sets, use replace all and replace occurances of "english1" with the set name
	//Load new questions
	$sql = "SELECT * FROM card_$deckID";
	$result = $conn->query($sql);
	
	//checks to see if answer has been chosen. if true, evaluates correctness of previous
	//question. if false, skips this step and moves on to the next
	if(isset($_POST['chosen_answer'])) 
	{ 
		$previous_id = $_POST['question_id'];
		$answer_queue = "SELECT Answer FROM card_$deckID WHERE CardNumber='" . (int)$previous_id . "'";
		$result_selected = $conn->query($answer_queue);
		$row = $result_selected->fetch_assoc();
		$correct_answer = $row["Answer"];
		$user_answer = $_POST['chosen_answer'];
		echo "User Has submitted the form and entered this answer : <b> $user_answer </b><br>";
		echo "Correct Answer was : <b> $correct_answer </b><br>";
		if (strcmp($user_answer,$correct_answer)==0)
			echo "Good job!";
		else echo "Ur wrong noob.";
	}

	
	//really messy code to select random question
	$total_rows = $result->num_rows;
	$row_num = mt_rand(1,$total_rows);
	$selected_row = "SELECT * FROM card_$deckID WHERE CardNumber='".$row_num."'";
	$result_selected_row = $conn->query($selected_row);
	$current_row = $result_selected_row ->fetch_assoc();
	
	$id = $current_row["CardNumber"];
	$question = $current_row["Question"];
		
	$possible_answers = array($current_row["Answer"],$current_row["Distractor1"],$current_row["Distractor2"], $current_row["Distractor3"]);
	
	shuffle($possible_answers);
	
	$answer1 = $possible_answers[0];
	$answer2 = $possible_answers[1];
	$answer3 = $possible_answers[2];
	$answer4 = $possible_answers[3];
	//close connection
	$conn->close();
	
?>

<body>
	<?php printNav(); ?>

	<!-- 
	This is the actual form that is displayed.
	The answers will be randomized.
	To make it look prettier, just add some CSS.
	-->

	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	
		<input type="hidden" name="question_id" value=<?php echo "\"" . $id . "\"" ?>>
		<div class="row">
			<div class="button-group">
				<div class="col-lg-6">
					<input type="submit" name="chosen_answer" value=<?php echo "\"" . $answer1 . "\"" ?> class="answer-choice btn btn-primary" id="answer-1">
				</div>
				<div class="col-lg-6">
					<input type="submit" name="chosen_answer" value=<?php echo "\"" . $answer2 . "\"" ?> class="answer-choice btn btn-warning" id="answer-2">
				</div>
			</div>
		</div>
		<div class="row well question-area">
			<div class="col-lg-12 text-center" id="question">
				<span> <?php echo $question ?> </span>
			</div>
		</div>
		<div class="row">
			<div class="button-group">
				<div class="col-lg-6">
					<input type="submit" name="chosen_answer" value=<?php echo "\"" . $answer3 . "\"" ?> class="answer-choice btn btn-danger" id="answer-3">
				</div>
				<div class="col-lg-6" id="answer-4">
					<span><input type="submit" name="chosen_answer" value=<?php echo "\"" . $answer4 . "\"" ?> class="answer-choice btn btn-success" ></span>
				</div>
			</div>
		</div>
	
	</form>
	<script type="text/javascript">
		$('#question').textfill({
			minFontPixels: 20
		});
	</script>
</body>
