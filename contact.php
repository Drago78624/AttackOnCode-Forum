<!-- <?php 
    session_start();
    require "./partials/_connection.php";

    $errMsgName = $errMsgEmail = $errMsgMessage = $errMsgSubject = $fullName = $email = $subject = $message = "";
    $user_id = $_SESSION['user_id'];
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
        if(empty($_POST['email'])){
            $errMsgEmail = "Please enter an email";
        }else {
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errMsgEmail = "Please enter a valid email";
            }else {
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

        if($fullName && $email && $message){
                // $sendingMessageSql = "";
                // $sendingMessageResult = mysqli_query($conn, $sendingMessageSql);
                // $num = mysqli_num_rows($sendingMessageResult);
                // if($num){
                //     $errMsgEmail = "User already exists";
                // }else {
                //     $signupSql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES ('$fullName', '$email', '$hash');";
                //     $signupResult = mysqli_query($conn, $signupSql);
                //     if($signupResult){
                //         $showAlert = true;
                //         $errMsgName = $errMsgEmail = $errMsgCPassword = $errMsgPassword = $fullName = $email = $password = $cpassword = "";
                //     }
                // }
                $to = "maazahmed78624@gmail.com";
                $msg = $message;
                $subj = $subject;
                mail($to,$subj,$msg);
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
                    <input type="text" name="fullname" id="fullname" value="<?php echo htmlspecialchars($fullName);?>" placeholder="Full Name">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgName) ?></span>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email);?>" placeholder="Email">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgEmail) ?></span>
                    <input type="text" name="subject" id="subject" value="<?php echo htmlspecialchars($subject);?>" placeholder="Subject">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgSubject) ?></span>
                    <textarea name="message" id="message" cols="30" rows="10" placeholder="Type your message...."></textarea>
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