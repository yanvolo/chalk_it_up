<?php
	require 'library.php';
	$conn = new mysqli("localhost","root","tuesday","chalkitDB");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

//Create Empty Deck
	$command = "CREATE TABLE card_500(
		CardNumber int NOT NULL,
		Question varchar(1024) NOT NULL,
		Answer varchar(1024) NOT NULL,
		Distractor1 varchar(1024) NOT NULL,
		Distractor2 varchar(1024) NOT NULL,
		Distractor3 varchar(1024) NOT NULL
	);";

	$conn->query($command);
	echo "Made Deck";
	//Fill Deck
	#Prepare for insert
	$stmt = $conn->prepare("INSERT INTO card_500(CardNumber, Question, Answer, Distractor1, Distractor2,Distractor3) VALUES (?,?,?,?,?,?)");
	$stmt->bind_param("isssss", $cardindex, $question, $answer,$distractor1, $distractor2,$distractor3);

	$cardindex = 7;
	$question = "Question";
	$answer = "Answer";
	//@TODO Refactor to make variable names more consistant
	$distractor1 = "1";
	$distractor2 = "1";
	$distractor3 = "1";
	$stmt->execute(); 

	echo "Command Sent";
	$conn->close();
	
?>