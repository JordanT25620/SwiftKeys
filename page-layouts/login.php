<?php
    include '../database_scripts/connect_db.php';
    try{
		$conn = mysqli_connect($servername, $username, $password, $db);
	} catch (Throwable $t) {
		$connectionError = true;
	}
    session_start();
    if(isset($_POST['login-btn'])){
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $doesAccountExist = "SELECT * FROM users WHERE username='$username' AND pass='$password'";
        $result = mysqli_query($conn, $doesAccountExist);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['isAdmin'] = $row['isAdmin'];
            header('location:../home.php');
        } else {
            $messages[] = "Incorrect username or password!";
        }
    } else if(isset($_GET['guest'])){
        if(isset($_SESSION['user_id'])){
            unset($_SESSION['user_id']);
        }
        if(isset($_SESSION['isAdmin'])){
            unset($_SESSION['isAdmin']);
        }
        header('location:../home.php');
    }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>SwiftKeys - Login</title>

  <!-- Custom font links -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dongle&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500&display=swap" rel="stylesheet">

  <!-- Bootstrap include link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FontAwesome Kit -->
  <script src="https://kit.fontawesome.com/8e14032615.js" crossorigin="anonymous"></script>
  <!-- Custom External Stylesheet -->
  <link href="../style.css" rel="stylesheet" type="text/css" />
  <!-- Custom Javascript file -->
  <script type="text/javascript" src="../script.js"></script>
</head>

<body class="dongle" style="background-color: navy;">
  
    <div class="notLoggedInPage">
        <div class="container box my-auto">
            <div class="row justify-content-center">
                <div class="col-7 col-lg-4">
                    <span class="px-5 box-header">Login</span>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-9 col-lg-7">
                    <form class="px-5 box-body" action="" method="post" enctype="multipart/form-data">
                        <?php
                            if(isset($messages)){
                                foreach($messages as $msg){
                                    echo "<div class='authMessage'>
                                            <i class='fa-solid fa-circle-exclamation' style='color: yellow; margin-top: auto; margin-bottom: auto; margin-right: auto;'></i>
                                            <span style='margin-right: auto;'>
                                                $msg
                                            </span>
                                        </div>";
                                }
                            }
                        ?>
                        <div class="form-item">
                            <i class="fa-solid fa-image-portrait" style="color: yellow;"></i>
                            <label for="username"></label>
                            <input name="username" type="text" placeholder="Username" class="loginInput" required autofocus></input>
                        </div>
                        <div class="form-item">
                            <i class="fa-solid fa-lock" style="color: yellow;"></i>
                            <label for="password"></label>
                            <input name="password" type="password" placeholder="Password" class="loginInput" required></input>
                        </div>
                        <input type="submit" name="login-btn" value="Login" class="myButton"></input>
                        <a href="register.php" style="display: block; line-height: 0.95;" class="mt-2">Don't have an account?</a>
                        <a href="login.php?guest=true" style="display: block; line-height: 0.95; font-size: 87%;">Continue as guest</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>