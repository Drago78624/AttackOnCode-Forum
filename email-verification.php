<?php 
    session_start();
    require "partials/_connection.php";

    if(isset($_GET['token'])){
        $token = $_GET['token'];

        $stmt = $mysqli->prepare("UPDATE `users` SET `status` = 'active' WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $statusUpdationResult = $stmt->get_result();

        $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE status = 'active' AND token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $statusUpdationResult = $stmt->get_result();

        if($statusUpdationResult){
            if(isset($_SESSION['verify_msg'])){
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