<?php
    session_start();

    require "./partials/_connection.php";

    $showAlert = false;
    if(isset($_SESSION['loggedin'])){
        $showAlert = true;
    }

    $categoriesFetchingSql = "SELECT * FROM `categories`";
    $categoriesFetchingResult = mysqli_query($conn, $categoriesFetchingSql);
    $categoriesFetchingArray = mysqli_fetch_all($categoriesFetchingResult, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/homepage.css">
    <title>AttackOnCode - Home</title>
</head>

<body>
    <?php include "./partials/_navbar.php"; ?>
    <?php if($showAlert): ?>
    <div class="alert-box success">
        <p class="alert-msg"> <strong> Success!!</strong>  Your have successfully been logged in</p>
        <div class="close-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div>
    </div>
    <?php endif; ?>
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
    </div> -->
    <main id="categories">
        <div class="categories-container">
            <?php foreach($categoriesFetchingArray as $categories => $category): ?>
            <?php
                    $thread_cat_id = $category['category_id'];
                    $countingThreadsSql = "SELECT COUNT(*) FROM `threads` WHERE thread_cat_id = '$thread_cat_id'";
                    $countingThreadsResult = mysqli_query($conn, $countingThreadsSql);
                    $threadCount = mysqli_fetch_array($countingThreadsResult);
            ?>
            <div class="category">
                <h2 class="category__heading"><?php echo htmlspecialchars($category['category_name']) ?> Forum</h2>
                <div class="category--padding">
                    <p class="category__description"><?php echo htmlspecialchars($category['category_description']) ?></p>
                    <div class="btn-info-container">
                    <a class="category__btn" href="thread-list.php?category_id=<?php echo htmlspecialchars($category['category_id']) ?>">Explore</a>
                    <div class="number-of-threads">
                    <span><?php echo htmlspecialchars($threadCount[0]) ?></span>
                        <img src="assets/icons8-chat-24.png" alt="">
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