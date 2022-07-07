<!-- <?php 
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

    $errMsgName = $errMsgEmail = $errMsgMessage = $errMsgSubject = $fullName = $email = $subject = $message = "";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $row = mysqli_fetch_assoc($userResult);
        $userName = $row['user_name'];
        $userEmail= $row['user_email'];
    }
    $showAlert = false;

    if(isset($_POST['contact'])){
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if(empty($_POST['fullname'])){
            $errMsgName = "Please enter your name";
        }else {
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
        if(empty($_POST['subject'])){
            $errMsgSubject = "Please enter your subject";
        }else {
            $subject = test_input($_POST['subject']);
        }
        if(empty($_POST['message'])){
            $errMsgMessage = "Please enter your message";
        }else {
            $message = test_input($_POST['message']);
        }

        if($fullName && $subject && $email && $message){
            try {
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_SERVER'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['USERNAME'];
                $mail->Password = $_ENV['PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 25;
                $mail->setFrom($_ENV['USERNAME'], 'AttackOnCode');
                $mail->addAddress('maazahmed78624@gmail.com', 'Joe User');
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body = <<<body
                    <p><strong>From: </strong>$email</p>
                    <p><strong>Name: </strong>$fullName</p>
                    <p>$message</p>
                body;
                $mail->send();
                // echo 'Message has been sent';
                session_start();
                $_SESSION['mail_msg'] = "Your Concern has been sent to the admin successfully";
            
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        
    }
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/contact.css">
    <title>AttackOnCode - Contact</title>
</head>
<body>
    <?php include "./partials/_navbar.php" ?>
    <main class="contact-section">
    <div class="contact-container">
            <h1 class="contact-heading">Contact</h1>
            <div class="contact">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"  class="contact-form">
                    <input type="text" name="fullname" id="fullname" placeholder="Full Name"
                        <?php if(isset($_SESSION['user_id'])): ?>
                            value=<?php echo $userName?>
                            readonly
                        <?php else: ?>
                            value="<?php echo htmlspecialchars($fullName);?>"
                        <?php endif ?>
                    >
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgName) ?></span>
                    <input type="email" name="email" id="email" placeholder="Email"
                        <?php if(isset($_SESSION['user_id'])): ?>
                            value=<?php echo $userEmail?>
                            readonly
                        <?php else: ?>
                            value="<?php echo htmlspecialchars($email);?>"
                        <?php endif ?>
                    >
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgEmail) ?></span>
                    <input type="text" name="subject" id="subject" value="<?php echo htmlspecialchars($subject);?>" placeholder="Subject">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgSubject) ?></span>
                    <textarea name="message" id="message" cols="30" rows="7" placeholder="Type your message...."></textarea>
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgMessage) ?></span>
                    <input type="submit" name="contact" value="Send">
                </form>
            </div>
        </div>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>
</html>