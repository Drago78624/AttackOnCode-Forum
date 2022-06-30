<?php 
    session_start();
    require "partials/_connection.php";
    $tokenExpire = false;

    if(isset($_GET['token'])){
        $token = $_GET['token'];

        $stmt = $mysqli->prepare("SELECT * FROM `token_service` WHERE token = ? AND token_of = 'email-verification'");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $emailVerifyResult = $stmt->get_result();
        $num = mysqli_num_rows($emailVerifyResult);

        if(!$num){
            $tokenExpire = true;
            $_SESSION['verify_msg']="Token Expired !";
            header('location: login.php');
            exit();
        }else {
            $row = mysqli_fetch_assoc($emailVerifyResult);
            $userid = $row['user_id'];
            $today = date('Y/m/d H:i:s');
            $expireDate = $row['expire_date'];
            $today_dt = new DateTime($today);
            $expire_dt = new DateTime($expireDate);

            if ($expire_dt < $today_dt) { 
                $tokenExpire = true;
                $stmt = $mysqli->prepare("DELETE FROM `token_service` WHERE `token_service`.`user_id` = ? AND token_of = 'email-verification'");
                $stmt->bind_param("i", $userid);
                $stmt->execute();
                $emailVerifyResult = $stmt->get_result();
                $_SESSION['verify_msg']="Token Expired !";
                header('location: login.php');
                exit();
            }
        }

        $stmt = $mysqli->prepare("UPDATE `users` SET `status` = 'active' WHERE user_id = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $statusUpdationResult = $stmt->get_result();

        $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE status = 'active' AND user_id = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $statusUpdationResult = $stmt->get_result();

        if($statusUpdationResult){
            if(isset($_SESSION['verify_msg'])){
                $stmt = $mysqli->prepare("DELETE FROM `token_service` WHERE `token_service`.`user_id` = ? AND token_of = 'email-verification'");
                $stmt->bind_param("i", $userid);
                $stmt->execute();
                $passwordResetResult = $stmt->get_result();
                $_SESSION['verify_msg'] = "Account verified! you can now login";
                header('location: login.php');
            }else{
                $_SESSION['verify_msg'] = "You are logged out.";
                header('location: login.php');       
           }
        }else{
            $_SESSION['verify_msg']="Account is not verified";
            header('location: signup.php');
        }
    }
?>