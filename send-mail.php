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

$userid = $_GET['user_id'];

$stmt = $mysqli->prepare("SELECT * FROM `users` WHERE user_id = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
$num = mysqli_num_rows($result);
if($num){
    $row = mysqli_fetch_assoc($result);
}
$email = $row['user_email'];
$fullName = $row['user_name'];
$token = bin2hex(random_bytes(15));

$expireDate = date('Y/m/d H:i:s', strtotime("1 minute"));

$stmt = $mysqli->prepare("INSERT INTO `token_service` (`user_id`, `token`, `token_of`, `expire_date`) VALUES (?, ?, 'email-verification', ?)");
$stmt->bind_param("iss", $userid, $token, $expireDate);
$stmt->execute();
$signupResult = $stmt->get_result();

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
                               http://localhost/AttackOnCode-Forum/email-verification.php?token=$token";
    $mail->send();
    // echo 'Message has been sent';
    session_start();
    $_SESSION['verify_msg'] = "Please check mail and verify your account $email";
    header("location: login.php");

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
