<?php
	function create_deckID($conn){
		//Keep generating random values until we get no output from master
		do {
			$rand = mt_rand(0,2000000000);
			$command = "SELECT * FROM master_card WHERE deckID=$rand"; 
			$result = $conn -> query($command) or die("Querry failed");
		} while($result->num_rows !== 0);
		return $rand; 
	}
	function sanitize_input($inputString){
		$inputString = trim($inputString);
		$inputString = addslashes($inputString);
		$inputString = htmlspecialchars($inputString);
		return $inputString;
	}

	//Some objects, in an array, wrapped in an object, wrapped in a mystery, wrapped in an enigma.
	$cards = array($_POST['cards']);
	$deck = $cards[0];
	echo "Got Deck";
	//@Param, first item in deck is name, rest are cards
	//Make connection
	$conn = new mysqli("localhost","root","tuesday","chalkitDB");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connection Good";
	//Generate Unique ID for set
	$deckID = create_deckID($conn);
	//Make entry in master table
	$name = sanitize_input($deck[0]);
	$description = "";
	$size = count($deck)-1;
	$score = 0;
	$command = "INSERT INTO master_card VALUES (\"$name\", \"$description\", $deckID, $size,$score);";
	$conn->query($command);
	echo "Master Updated";
	
	//Create Empty Deck
	$command = "CREATE TABLE card_$deckID(
		CardNumber int NOT NULL,
		Question varchar(1024) NOT NULL,
		Answer varchar(1024) NOT NULL,
		Distractor1 varchar(1024) NOT NULL,
		Distractor2 varchar(1024) NOT NULL,
		Distractor3 varchar(1024) NOT NULL
	);";
	echo $deckID; 
	$conn->query($command);
	echo "Made Deck";
	//Fill Deck
	#Prepare for insert
	$stmt = $conn->prepare("INSERT INTO card_$deckID(CardNumber, Question, Answer, Distractor1, Distractor2,Distractor3) VALUES (?,?,?,?,?,?)");
	$stmt->bind_param("isssss", $cardindex, $question, $answer,$distractor1, $distractor2,$distractor3);
	for($i=1;$i<count($deck);$i++){
		$cardindex = $i;
		$question = sanitize_input($deck[$i]["question"]);
		$answer = sanitize_input($deck[$i]["answer"]);
		//@TODO Refactor to make variable names more consistant
		$distractor1 = sanitize_input($deck[$i]["distractorA"]);
		$distractor2 = sanitize_input($deck[$i]["distractorB"]);
		$distractor3 = sanitize_input($deck[$i]["distractorC"]);
		$stmt->execute(); 
	}
	echo "Filled Deck";
	//Done! Phew!
	$conn->close();
	echo "Deck Sucessfully Created"; 
?>