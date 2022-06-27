<?php
require "./partials/_connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$mail = new PHPMailer(true);
$errMsgName = $errMsgEmail = $errMsgCPassword = $errMsgPassword = $fullName = $email = $password = $cpassword = "";
$showAlert = false;

if (isset($_POST['signup'])) {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (empty($_POST['fullname'])) {
        $errMsgName = "Please enter your name";
    } else {
        $fullName = test_input($_POST['fullname']);
    }
    if (empty($_POST['email'])) {
        $errMsgEmail = "Please enter an email";
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errMsgEmail = "Please enter a valid email";
        } else {
            $email = test_input($_POST['email']);
        }
    }
    if (empty($_POST['password'])) {
        $errMsgPassword = "Please enter a password";
    } else {
        $password = test_input($_POST['password']);
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
    if (empty($_POST['cpassword'])) {
        $errMsgCPassword = "Please confirm your passsword";
    } else {
        $cpassword = test_input($_POST['cpassword']);
    }

    $token = bin2hex(random_bytes(15));

    if ($fullName && $email && $password && $cpassword) {
        if ($password != $cpassword) {
            $errMsgCPassword = "Passwords do not match";
        } else {
            //$existenceCheckingSql = "SELECT user_email FROM `users` WHERE user_email = '$email'";
            $stmt = $mysqli->prepare("SELECT user_email FROM `users` WHERE user_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $existenceCheckingResult = $stmt->get_result();
            $num = mysqli_num_rows($existenceCheckingResult);
            if ($num) {
                $errMsgEmail = "User already exists";
            } else {
                //$signupSql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES ('$fullName', '$email', '$hash');";
                $stmt = $mysqli->prepare("INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `token`, `status`) VALUES (?, ?, ?, ?, 'inactive');");
                $stmt->bind_param("ssss", $fullName, $email, $hash, $token);
                $stmt->execute();
                $signupResult = $stmt->get_result();

                $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE user_email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $signupResult = $stmt->get_result();
                if ($signupResult) {
                    try {
                        $mail->isSMTP();
                        $mail->Host = $_ENV['SMTP_SERVER'];
                        $mail->SMTPAuth = true;
                        $mail->Username = $_ENV['USERNAME'];
                        $mail->Password = $_ENV['PASSWORD'];
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 25;
                        $mail->setFrom($_ENV['USERNAME'], 'AttackOnCode');
                        $mail->addAddress($email, 'Joe User');
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Email Verification';
                        $mail->Body = "Hi $fullName, Click on the link below to activate you AttackOnCode account
//                               http://localhost/AttackOnCode/email-verification.php?token=$token";
                        $mail->send();
                        // echo 'Message has been sent';
                        session_start();
                        $_SESSION['verify_msg'] = "Please check mail and verify your account $email";
                        header("location: login.php");

                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                    $errMsgName = $errMsgEmail = $errMsgCPassword = $errMsgPassword = $fullName = $email = $password = $cpassword = "";
                }
            }
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
    <link rel="stylesheet" href="./css/signup.css">
    <title>AttackOnCode - Signup</title>
</head>

<body>
    <?php include "./partials/_navbar.php" ?>
    <?php if ($showAlert): ?>
    <div class="alert-box success">
        <p class="alert-msg"><strong> Success!!</strong> Your account has been successfully added</p>
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
    <main class="signup-section">
        <div class="signup-container">
            <h1 class="signup-heading">Sign up</h1>
            <div class="signup">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="signup-form">
                    <label for="fullname"></label><input type="text" name="fullname" id="fullname"
                        value="<?php echo htmlspecialchars($fullName); ?>" placeholder="Full Name">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgName) ?></span>
                    <label for="email"></label><input type="email" name="email" id="email"
                        value="<?php echo htmlspecialchars($email); ?>" placeholder="Email">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgEmail) ?></span>
                    <label for="password"></label><input type="password" name="password" id="password"
                        value="<?php echo htmlspecialchars($password); ?>" placeholder="Password">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgPassword) ?></span>
                    <label for="cpassword"></label><input type="password" name="cpassword" id="cpassword"
                        value="<?php echo htmlspecialchars($cpassword); ?>" placeholder="Confirm Password">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgCPassword) ?></span>
                    <input type="submit" name="signup" value="Sign up">
                </form>
                <p class="form-text"><a href="login.php">Already have an account ? </a></p>
            </div>
        </div>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>

</html>