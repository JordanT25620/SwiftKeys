<?php
    session_start();
    if(isset($_SESSION['user_id'])){

        include 'connect_db.php'; //Connecting to the DB

        try{
            $conn = mysqli_connect($servername, $username, $password, $db);
        } catch (Throwable $t) {
            $connectionError = true;
        }

        $tenthBest = "-1.000";

        $sqlGrabTenthBestWpm= "SELECT typingSpeedInWpm FROM submissions ORDER BY typingSpeedInWpm DESC LIMIT 1 OFFSET 9";
        $result = mysqli_query($conn, $sqlGrabTenthBestWpm);
        if(mysqli_num_rows($result) > 0){
            $tenthBest = mysqli_fetch_assoc($result)['typingSpeedInWpm'];
        }

        mysqli_close($conn);

        echo $tenthBest;
    }

?>