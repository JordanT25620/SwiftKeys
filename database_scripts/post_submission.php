<?php
    session_start();
    if(isset($_SESSION['user_id'])){

        include 'connect_db.php'; //Connecting to the DB

        try{
            $conn = mysqli_connect($servername, $username, $password, $db);
        } catch (Throwable $t) {
            $connectionError = true;
        }

        $user_id = $_SESSION['user_id'];
        $quoteId = $_POST['quoteId'];
        $timeTaken = $_POST['timeTaken'];
        $typingSpeedInWpm = $_POST['wpm'];

        $sqlInsertSubmission = "INSERT INTO submissions (userId, quoteId, timeTaken, typingSpeedInWpm) VALUES ($user_id, $quoteId, $timeTaken, $typingSpeedInWpm)";
        mysqli_query($conn, $sqlInsertSubmission);

        mysqli_close($conn);
    }

?>