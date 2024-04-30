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
        $sqlGrabPersonalBestWpm= "SELECT MAX(typingSpeedInWpm) AS best FROM submissions WHERE userId = $user_id";
        $best = mysqli_fetch_assoc(mysqli_query($conn, $sqlGrabPersonalBestWpm))['best'];

        mysqli_close($conn);

        echo $best;
    }

?>