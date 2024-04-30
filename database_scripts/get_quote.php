<?php
	include 'connect_db.php'; //Connecting to the DB
	
    $quote = "No quotes available with your current preferences!";
	$quoteExists = false;

	try{
		$conn = mysqli_connect($servername, $username, $password, $db);
	} catch (Throwable $t) {
		$connectionError = true;
	}

	$easy = $_GET['easy'];
	$medium = $_GET['medium'];
	$hard = $_GET['hard'];

	$levelOne = $_GET['levelOne'];
	$levelTwo = $_GET['levelTwo'];
	$levelThree = $_GET['levelThree'];
	$levelFour = $_GET['levelFour'];
	$levelFive = $_GET['levelFive'];

	$difficulties = array();
	$numWordsArr = array();

	if($easy == "1"){
		array_push($difficulties, "'easy'");
	}
	if($medium == "1"){
		array_push($difficulties, "'medium'");
	}
	if($hard == "1"){
		array_push($difficulties, "'hard'");
	}

	if($levelOne == "1"){
		array_push($numWordsArr, "(quoteNumWords <= 10)");
	}
	if($levelTwo == "1"){
		array_push($numWordsArr, "(quoteNumWords BETWEEN 11 AND 25)");
	}
	if($levelThree == "1"){
		array_push($numWordsArr, "(quoteNumWords BETWEEN 26 AND 50)");
	}
	if($levelFour == "1"){
		array_push($numWordsArr, "(quoteNumWords BETWEEN 51 AND 100)");
	}
	if($levelFive == "1"){
		array_push($numWordsArr, "(quoteNumWords > 100)");
	}

	$listOfNumWordsString = implode(" OR ", $numWordsArr);
	$listDifficultiesString = implode(",", $difficulties);
	
    $sqlGrabQuote = "SELECT quote FROM quotes WHERE difficulty IN (" . $listDifficultiesString . ") AND (" 
	. $listOfNumWordsString . ") ORDER BY RAND() LIMIT 1";
	$result = mysqli_query($conn, $sqlGrabQuote);
	if(mysqli_num_rows($result) > 0){
		$quote = mysqli_fetch_assoc($result)['quote'];
		$quoteExists = true;
	}

	mysqli_close($conn);
	echo json_encode(array('quoteExists'=>$quoteExists, 'quoteIfExists'=>$quote));
?>