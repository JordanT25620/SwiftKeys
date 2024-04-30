<?php

    include 'connect_db.php'; //Connecting to the DB

    try {
        $conn = mysqli_connect($servername, $username, $password, $db);
    } catch (Throwable $t) {
        $connectionError = true;
    }

    $quoteId = $_GET['quoteId'];
    $timeTaken = $_GET['timeTaken'];
    
    $sqlGrabQuoteNumWords = "SELECT quoteNumWords FROM quotes WHERE quoteId = $quoteId";
    $assocArrayOfRows = mysqli_fetch_assoc(mysqli_query($conn, $sqlGrabQuoteNumWords));
    $quoteNumWords = $assocArrayOfRows['quoteNumWords'];

    $typingSpeedInWpm = number_format(60 * $quoteNumWords / $timeTaken, 3);

    mysqli_close($conn);

    echo $typingSpeedInWpm;

?>