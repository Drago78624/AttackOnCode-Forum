<?php
    session_start();

    require "./partials/_connection.php";

    //$categoriesFetchingSql = "SELECT * FROM `categories`";
    $stmt =  $mysqli->prepare("SELECT * FROM `categories`");
    //$stmt->bind_param("s", $email);
    $stmt->execute();
    $categoriesFetchingResult = $stmt->get_result();
    $categoriesFetchingArray = mysqli_fetch_all($categoriesFetchingResult, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/homepage.css">
    <title>AttackOnCode - Home</title>
</head>

<body>
    <?php include "./partials/_navbar.php"; ?>
    <?php if(isset($_SESSION['loggedin'])): ?>
    <div class="username-banner">
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    </div>
    <?php endif; ?>
     <!-- <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-heading">AttackOnCode</h1>
            <p class="hero-description">A place for attacking each other with coding questions</p>
            <a href="#categories" class="hero-btn"><span class="hero-btn-text">Explore categories</span> </a>
        </div>
    </div>  -->
    <main id="categories">
        <div class="categories-container">
            <?php foreach($categoriesFetchingArray as $categories => $category): ?>
            <?php
                    $thread_cat_id = $category['category_id'];
                    //$countingThreadsSql = "SELECT COUNT(*) FROM `threads` WHERE thread_cat_id = '$thread_cat_id'";
                    $stmt =  $mysqli->prepare("SELECT COUNT(*) FROM `threads` WHERE thread_cat_id = ?");
                    $stmt->bind_param("i", $thread_cat_id);
                    $stmt->execute();
                    $countingThreadsResult = $stmt->get_result();
                    $threadCount = mysqli_fetch_array($countingThreadsResult);
            ?>
            <div class="category">
                <h2 class="category__heading">
                <img src="<?php echo $category['icon_url']?>" alt="" class="category-icon">    
                <!-- <img src="assets/react.png" class="category-icon" alt=""> -->
                <?php echo htmlspecialchars($category['category_name']) ?> Forum</h2>
                <div class="category--padding">
                    <p class="category__description text"><?php echo htmlspecialchars($category['category_description']) ?></p>
                    <div class="btn-info-container">
                    <a class="category__btn" href="thread-list.php?category_id=<?php echo htmlspecialchars($category['category_id']) ?>">Explore</a>
                    <div class="number-of-threads">
                    <span><?php echo htmlspecialchars($threadCount[0]) ?> threads</span>
                        <!-- <img src="assets/icons8-chat-24.png" alt=""> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#c82471" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include "./partials/_footer.php" ?>
    <script src="./script/app.js"></script>
</body>

</html>