<?php
    session_start();
require "./partials/_connection.php";

$errMsgCPassword = $errMsgPassword = $password = $cpassword = "";
$tokenExpire = false;
$showAlert = false;

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $stmt = $mysqli->prepare("SELECT * FROM `token_service` WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $passwordResetResult = $stmt->get_result();
    $num = mysqli_num_rows($passwordResetResult);

    if(!$num){
        $tokenExpire = true;
    }else {
        $row = mysqli_fetch_assoc($passwordResetResult);
        $userid = $row['user_id'];
        $today = date('Y/m/d H:i:s');
        $expireDate = $row['expire_date'];
        $today_dt = new DateTime($today);
        $expire_dt = new DateTime($expireDate);

        if ($expire_dt < $today_dt) { 
            $tokenExpire = true;
            $stmt = $mysqli->prepare("DELETE FROM `token_service` WHERE `token_service`.`user_id` = ?");
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $passwordResetResult = $stmt->get_result();
        }
    }


    if (isset($_POST['reset-password'])) {
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
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
    
        if ($password && $cpassword) {
            if ($password != $cpassword) {
                $errMsgCPassword = "Passwords do not match";
            } else {
                $stmt = $mysqli->prepare("UPDATE `users` SET user_password = ? WHERE user_id = ?");
                $stmt->bind_param("si", $hash, $userid);
                $stmt->execute();
                $passwordResetResult = $stmt->get_result();

                $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE user_id = ?");
                $stmt->bind_param("i", $userid);
                $stmt->execute();
                $passwordResetResult = $stmt->get_result();
                $num = mysqli_num_rows($passwordResetResult);
                $row = mysqli_fetch_assoc($passwordResetResult);

                if(password_verify($password, $row['user_password'])){
                    $stmt = $mysqli->prepare("DELETE FROM `token_service` WHERE `token_service`.`user_id` = ?");
                    $stmt->bind_param("i", $userid);
                    $stmt->execute();
                    $passwordResetResult = $stmt->get_result();
                    $_SESSION['verify_msg'] = "Password reset completed successfully";
                    header('location: login.php');
                }else{
                    $_SESSION['verify_msg']="Something went wrongs";
                    header('location: login.php');
                }
            }
        }
    }
}else{
    $_SESSION['verify_msg'] = "Something went wrong";
    header('location: login.php');       
    // echo "token error";

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
    <link rel="stylesheet" href="./css/reset-password.css">
    <title>AttackOnCode - reset-password</title>
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
    <main class="reset-password-section">
        <div class="reset-password-container">
            <?php if($tokenExpire): ?>
                <h1 class="reset-password-heading">Token Expired !</h1>
            <?php else: ?>
            <h1 class="reset-password-heading">Reset Password</h1>
            <div class="reset-password">
                <form action="" method="POST" class="reset-password-form">
                    <label for="password"></label><input type="password" name="password" id="password"
                        value="<?php echo htmlspecialchars($password); ?>" placeholder="New Password">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgPassword) ?></span>
                    <label for="cpassword"></label><input type="password" name="cpassword" id="cpassword"
                        value="<?php echo htmlspecialchars($cpassword); ?>" placeholder="Confirm Password">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgCPassword) ?></span>
                    <input type="submit" name="reset-password" value="Rest password">
                </form>
            </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>

</html>