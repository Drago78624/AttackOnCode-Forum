<?php

session_start();
require "./partials/_connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$mail = new PHPMailer(true);
$errMsgEmail = $email = "";
$showAlert = false;


if (isset($_POST['recover'])) {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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

    if ($email) {
            $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE user_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $existenceCheckingResult = $stmt->get_result();
            $num = mysqli_num_rows($existenceCheckingResult);
            if ($num) {
                $row = mysqli_fetch_assoc($existenceCheckingResult);
                $username = $row['user_name'];
                $userid = $row['user_id'];
                $token = bin2hex(random_bytes(15));
                $expireDate = date('Y/m/d H:i:s', strtotime("2 minutes"));

                $stmt = $mysqli->prepare("INSERT INTO `token_service` (`user_id`, `token`, `token_of`, `expire_date`) VALUES (?, ?, 'password-recovery', ?)");
                $stmt->bind_param("iss", $userid, $token, $expireDate);
                $stmt->execute();
                $existenceCheckingResult = $stmt->get_result();
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
                        $mail->Subject = 'Password Reset';
                        $mail->Body = "Hi $username, Click on the link below to reset password of your AttackOnCode account
//                               http://localhost/AttackOnCode/reset-password.php?token=$token";
                        $mail->send();
                        // echo 'Message has been sent';
                        // session_start();
                        $_SESSION['recover_msg'] = "Check your mail to reset password of your account at $email";
                        $showAlert = true;
                        // header("location: login.php");

                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                   $errMsgEmail = $email = "";
            } else {
                $errMsgEmail = "User does not exists";
                
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
    <link rel="stylesheet" href="./css/recover.css">
    <title>AttackOnCode - recover</title>
</head>

<body>
    <?php include "./partials/_navbar.php" ?>
    <?php if ($showAlert): ?>
    <div class="alert-box success">
        <p class="alert-msg"><?php echo htmlspecialchars($_SESSION['recover_msg']) ?></p>
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
    <main class="recover-section">
        <div class="recover-container">
            <h1 class="recover-heading">Recover Account</h1>
            <div class="recover">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="recover-form">
                    <label for="email"></label><input type="email" name="email" id="email"
                        value="<?php echo htmlspecialchars($email); ?>" placeholder="Email">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgEmail) ?></span>
                    <input type="submit" name="recover" value="Send mail">
                </form>
            </div>
        </div>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>

</html>