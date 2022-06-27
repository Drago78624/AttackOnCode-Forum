<?php 
    session_start();
    require "./partials/_connection.php";

    $errMsgEmail = $errMsgPassword = $email = $password = "";
    $showAlert = false;

    if(isset($_POST['login'])){
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if(empty($_POST['email'])){
            $errMsgEmail = "Please enter an email";
        }else {
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errMsgEmail = "Please enter a valid email";
            }else {
                $email = test_input($_POST['email']);
            }
        }
        if(empty($_POST['password'])){
            $errMsgPassword = "Please enter your password";
        }else {
            $password = test_input($_POST['password']);
        }

        if($email && $password){
            //$loginSql = "SELECT * FROM `users` WHERE user_email = '$email'";
            $stmt =  $mysqli->prepare("SELECT * FROM `users` WHERE user_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $loginResult = $stmt->get_result();
            $num = mysqli_num_rows($loginResult);

            if($num){

                $stmt =  $mysqli->prepare("SELECT * FROM `users` WHERE status = 'active' AND user_email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $statusCheckResult = $stmt->get_result();
                $statusNum = mysqli_num_rows($statusCheckResult);

                if($statusNum){
                    $row = mysqli_fetch_assoc($statusCheckResult);
                    if(password_verify($password, $row['user_password'])){
                        session_start(['cookie_lifetime' => 143200,'cookie_secure' => true,'cookie_httponly' => true, "cookie_samesite" => "Strict"]);
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $row['user_name'];
                        $_SESSION['user_id'] = $row['user_id'];
                        header("Location: index.php");
                    }else {
                        $errMsgPassword = "Bad email or password";
                    }
                }else {
                    $_SESSION['verify_msg'] = "Account is not verified yet check your mail to verify";
                }

            }else {
                $errMsgEmail = "Bad email or password";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>AttackOnCode - Login</title>
</head>

<body>
    <?php include "./partials/_navbar.php" ?>
    <?php if (isset($_SESSION['verify_msg'])): ?>
    <div class="alert-box success">
        <p class="alert-msg"><?php echo htmlspecialchars($_SESSION['verify_msg']) ?></p>
        <div class="close-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </div>
    </div>
    <?php endif; ?>
    <main class="login-section">
        <div class="login-container">
            <h1 class="login-heading">Login</h1>
            <div class="login">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" class="login-form">
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email);?>"
                        placeholder="Email">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgEmail) ?></span>
                    <input type="password" name="password" id="password"
                        value="<?php echo htmlspecialchars($password);?>" placeholder="Password">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgPassword) ?></span>
                    <input type="submit" name="login" value="Login">
                </form>
                <div class="form-text-container">
                    <p class="form-text"><a href="recover.php">Forgot password ? </a></p>
                    <p class="form-text"><a href="signup.php">Create account</a></p>
                </div>
            </div>
        </div>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>

</html>