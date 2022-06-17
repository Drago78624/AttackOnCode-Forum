<?php

    require "./partials/_connection.php";

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
    <div class="username-banner">
        <span>Welcome, Muhammd Maaz Ahmed</span>
    </div>
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-heading">AttackOnCode</h1>
            <p class="hero-description">A place for attacking each other with coding questions</p>
            <a href="#categories" class="hero-btn"><span class="hero-btn-text">Explore categories</span> </a>
        </div>
    </div>
    <main id="categories">
        <div class="categories-container">
            <h2 class="category__header">Browse Categories</h2>
            <?php foreach($categoriesFetchingArray as $categories => $category): ?>
            <div class="category">
                <h2 class="category__heading"><?php echo htmlspecialchars($category['category_name']) ?> Forum</h2>
                <div class="category--padding">
                    <h5 class="category__title"><?php echo htmlspecialchars($category['category_name']) ?></h5>
                    <p class="category__description"><?php echo htmlspecialchars($category['category_description']) ?></p>
                    <a class="category__btn" href="thread-list.php?category_id=<?php echo htmlspecialchars($category['category_id']) ?>">Explore</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include "./partials/_footer.php" ?>
    <script src="./script/app.js"></script>
</body>

</html>