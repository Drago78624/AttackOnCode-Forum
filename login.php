<?php 
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
            $loginSql = "SELECT * FROM `users` WHERE user_email = '$email'";
            $loginResult = mysqli_query($conn, $loginSql);
            $num = mysqli_num_rows($loginResult);

            if($num){
                $row = mysqli_fetch_assoc($loginResult);
                if(password_verify($password, $row['user_password'])){
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $row['user_name'];
                    $_SESSION['user_id'] = $row['user_id'];
                    header("Location: index.php");
                }else {
                    $errMsgPassword = "Wrong Password";
                }
            }else {
                $errMsgEmail = "User does not exist";
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
    <main class="login-section">
        <div class="login-container">
            <h1 class="login-heading">Login</h1>
            <div class="login">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"  class="login-form">
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email);?>" placeholder="Email">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgEmail) ?></span>
                    <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password);?>" placeholder="Password">
                    <span class="err-msg"><?php echo htmlspecialchars($errMsgPassword) ?></span>
                    <input type="submit" name="login" value="Login">
                </form>
            </div>
        </div>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>
</html>