<?php
    session_start();
    $loggedIn = false;
    $user_id = "";
    $isAdmin = false;
    if(isset($_SESSION['user_id'])){
      $loggedIn = true;
      $user_id = $_SESSION['user_id'];
      $isAdmin = $_SESSION['isAdmin'];
    }

    if(isset($_GET['logout'])){
        unset($user_id);
        unset($isAdmin);
        $loggedIn = false;
        session_destroy();
        header('location:page-layouts/login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Swift Keys</title>

  <!-- Custom font links -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dongle&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500&display=swap" rel="stylesheet">

  <!-- Bootstrap include link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <!-- AJAX library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FontAwesome Kit -->
  <script src="https://kit.fontawesome.com/8e14032615.js" crossorigin="anonymous"></script>
  <!-- Custom External Stylesheet -->
  <link href="style.css" rel="stylesheet" type="text/css" />
  <!-- Custom Javascript file -->
  <script type="text/javascript" src="script.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: yellow;">
    <a class="navbar-brand ml-3" href="home.php">
        <img src="images/SKIcon.png" width=23%>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <?php if($loggedIn){
          echo "
          <li class='nav-item'>
            <a class='nav-link' href='leaderboard.php'>Leaderboard<span class='sr-only'>(current)</span></a>
          </li>";
          if($isAdmin){
            echo "
            <li class='nav-item'>
              <a class='nav-link' href='quoteEditor.php'>Editor<span class='sr-only'>(current)</span></a>
            </li>";
          }
          echo "
          <li class='nav-item'>
            <a class='nav-link' href='profile.php'>Profile</a>
          </li> 
          <li class='nav-item'>
            <a class='nav-link' href='home.php?logout=<?php echo $user_id; ?>'>Logout</a>
          </li> ";
        } else {
          echo "
          <li class='nav-item'>
            <a class='nav-link' href='page-layouts/login.php'>Login<span class='sr-only'>(current)</span></a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='page-layouts/register.php'>Register</a>
          </li> ";
        }
        ?>
      </ul>
    </div>
  </nav>
  <div class="webPage">
    <div class="game-box">
      <div class="pregame">
        <img id="logo" src="images/SwiftKeysLogo.png">
        <hr style="border-color: rgba(128, 128, 128, 0.4); width: 60%;">
        <div class='no-quotes-avail'>
          <i class='fa-solid fa-circle-exclamation' style='color: yellow; margin-top: auto; margin-bottom: auto; margin-right: auto;'></i>
          <span style='margin-right: auto;'>
            No quotes available with your current preferences!
          </span>
        </div>
        <div class='no-selections'>
          <i class='fa-solid fa-circle-exclamation' style='color: yellow; margin-top: auto; margin-bottom: auto; margin-right: auto;'></i>
          <span style='margin-right: auto;'>
            Please select at least 1 preference from each category!
          </span>
        </div>
        <div class="preferences row w-100 justify-content-center my-auto">
          <div class="col-10 col-md-3 py-3 mx-auto my-1 text-center bg-primary rounded">
            <h5>Difficulty</h5>
            <input type="checkbox" id="easyCheckBox" name="easyCheckBox" value="easy" checked>
            <label for="easyCheckBox">Easy</label><br>
            <input type="checkbox" id="mediumCheckBox" name="mediumCheckBox" value="medium" checked>
            <label for="mediumCheckBox">Medium</label><br>
            <input type="checkbox" id="hardCheckBox" name="hardCheckBox" value="hard" checked>
            <label for="hardCheckBox">Hard</label><br>
          </div>
          <div class="col-10 col-md-3 py-3 mx-auto my-1 text-center bg-primary rounded">
            <h5>Length (Words)</h5>
            <input type="checkbox" id="levelOneCheckBox" name="levelOneCheckBox" value="levelOne" checked>
            <label for="levelOneCheckBox">1-10 words</label><br>
            <input type="checkbox" id="levelTwoCheckBox" name="levelTwoCheckBox" value="levelTwo" checked>
            <label for="levelTwoCheckBox">11-25 words</label><br>
            <input type="checkbox" id="levelThreeCheckBox" name="levelThreeCheckBox" value="levelThree" checked>
            <label for="levelThreeCheckBox">26-50 words</label><br>
            <input type="checkbox" id="levelFourCheckBox" name="levelFourCheckBox" value="levelFour" checked>
            <label for="levelFourCheckBox">51-100 words</label><br>
            <input type="checkbox" id="levelFiveCheckBox" name="levelFiveCheckBox" value="levelFive" checked>
            <label for="levelFiveCheckBox">100+ words</label><br>
          </div>
          <div class="col-10 col-md-3 py-3 mx-auto my-1 text-center bg-primary rounded">
            <h5>Mode</h5>
            <input type="radio" id="casual" name="modeGroup" value="casual">
            <label for="casual">Casual</label><br>
            <input type="radio" id="timed" name="modeGroup" value="timed" checked>
            <label for="timed">Timed</label><br>
          </div>
        </div>
        <div class="row w-100 mt-auto justify-content-center">
          <button id="start-btn" class="menu-btn col-10 col-md-5 bg-primary" type="button"><span style="font-family: 'Nunito', sans-serif; font-size: 140%;">Start</span></button>
        </div>
      </div>
      <div class="game">
        <div class="timer" id="timer"></div>
        <div class="container">
          <div class="quote-display" id="quoteDisplay"></div>
          <textarea id="quoteInput" class="quote-input" autocomplete="off" spellcheck="false" autofocus readonly></textarea>
        </div>
      </div>
      <div class="endgame">
        <div id="finished-block" class="mt-5 mb-1 text-center">
          <span id="finished-text">Finished!</span>
          <?php if($loggedIn){
            echo 
            "<span id='personal-record'>New Personal Best!</span>
            <span id='leaderboard-score'>Top Leaderboard Record!</span>";
          } else {
            echo 
            "<span id='login-to-track'>Log in to track your personal best and compete with others!</span>";
          }
          ?>
        </div>
        <div class="row w-100 justify-content-center my-auto text-center">
          <div class="col-4 align-self-center" id="time-spent">
            <span id="results-timeSpent" class="results-text"></span>
          </div>
          <div class="col-4 align-self-center">
            <img id="results-pic" src="images/finishFlag.png" width=75%>
          </div>
          <div class="col-4 align-self-center">
            <span id="results-wpm" class="results-text"></span>
          </div>
        </div>
        <div class="d-flex w-100 justify-content-center my-3 text-center">
          <div class="col">
            <button id="home-btn" class="menu-btn w-75 bg-primary" type="button"><span style="font-family: 'Nunito', sans-serif; font-size: 32px;">Back Home</span></button>
          </div>
          <div class="col">
            <button id="again-btn" class="menu-btn w-75 bg-primary" type="button"><span style="font-family: 'Nunito', sans-serif; font-size: 32px;">Play Again</span></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  

</body>
</html>