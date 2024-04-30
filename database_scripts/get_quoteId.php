<?php

    include 'connect_db.php'; //Connecting to the DB

    try {
        $conn = mysqli_connect($servername, $username, $password, $db);
    } catch (Throwable $t) {
        $connectionError = true;
    }

    $quote = $_GET['quote'];

    $escapedQuote = mysqli_real_escape_string($conn, $quote);
    $sqlGrabQuoteId = "SELECT quoteId FROM quotes WHERE quote = '$escapedQuote'";
    $assocArrayOfRows = mysqli_fetch_assoc(mysqli_query($conn, $sqlGrabQuoteId));
    $quoteId = $assocArrayOfRows['quoteId'];

    mysqli_close($conn);

    echo $quoteId;

?>