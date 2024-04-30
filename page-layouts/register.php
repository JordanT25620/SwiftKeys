<?php
    include '../database_scripts/connect_db.php';
    try{
		$conn = mysqli_connect($servername, $username, $password, $db);
	} catch (Throwable $t) {
		$connectionError = true;
	}
    if(isset($_POST['register-btn'])){
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $cpass = mysqli_real_escape_string($conn, md5($_POST['password-confirm']));
        if(strlen($username) > 25){
            $messages[] = "Username exceeds character limit!";
        } elseif(strlen($email) > 50) {
            $messages[] = "Email address exceeds character limit!";
        } elseif(strlen($phone) > 20) {
            $messages[] = "Phone number exceeds character limit!";
        } elseif(strlen($password) > 100) {
            $messages[] = "Password exceeds character limit!";
        } elseif(strlen($password) < 5) {
            $messages[] = "Password should be at least 5 characters long!";
        } else {
            $checkForExistingUsername = "SELECT * FROM users WHERE username='$username'" or die("Registration: Error checking database for existing username!");
            $result = mysqli_query($conn, $checkForExistingUsername);
    
            if(mysqli_num_rows($result) > 0){
                $messages[] = "This username is taken!";
            } else {
                $checkForExistingEmail = "SELECT * FROM users WHERE email='$email'" or die("Registration: Error checking database for existing email!");
                $result = mysqli_query($conn, $checkForExistingEmail);
                if (mysqli_num_rows($result) > 0) {
                    $messages[] = "This email is already in use!";
                } else {
                    $checkForExistingPhone = "SELECT * FROM users WHERE phone='$phone'" or die("Registration: Error checking database for existing phone!");
                    $result = mysqli_query($conn, $checkForExistingPhone);
                    if (mysqli_num_rows($result) > 0) {
                        $messages[] = "This phone number is already in use!";
                    } elseif ($password != $cpass) {
                        $messages[] = "Passwords do not match!";
                    } else {
                        $insertUserQuery = "INSERT INTO users (username, email, phone, pass) VALUES('$username', '$email', '$phone', '$password');" or die("Registration: Error inserting user into database!");
                        $result = mysqli_query($conn, $insertUserQuery);
                        if($result){
                            $messages[] = "Registered successfully!";
                            header("location:login.php");
                        } else {
                            $messages[] = "Registration failed!";
                        }
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>SwiftKeys - Register</title>

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
                    <span class="px-5 box-header">Register</span>
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
                            <i class="fa-solid fa-envelope" style="color: yellow;"></i>
                            <label for="email"></label>
                            <input name="email" type="email" placeholder="Email" class="loginInput" required></input>
                        </div>
                        <div class="form-item">
                            <i class="fa-solid fa-phone" style="color: yellow;"></i>
                            <label for="phone"></label>
                            <input name="phone" type="tel" placeholder="Phone" class="loginInput" required></input>
                        </div>
                        <div class="form-item">
                            <i class="fa-solid fa-lock" style="color: yellow;"></i>
                            <label for="password"></label>
                            <input name="password" type="password" placeholder="Password" class="loginInput"required></input>
                        </div>
                        <div class="form-item">
                            <i class="fa-solid fa-lock" style="color: yellow;"></i>
                            <label for="password-confirm"></label>
                            <input name="password-confirm" type="password" placeholder="Retype password" class="loginInput" required></input>
                        </div>
                        <input type="submit" name="register-btn" value="Register" class="myButton"></input>
                        <a href="login.php" style="display: block; line-height: 0.95;" class="mt-2">Already have an account?</a>
                        <a href="login.php?guest=true" style="display: block; line-height: 0.95; font-size: 87%;">Continue as guest</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>