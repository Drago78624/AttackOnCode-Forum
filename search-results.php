<?php 
    require "./partials/_connection.php";

    $searchedItem = $_GET['searched-item'];
    // $sql = "SELECT * FROM `threads` WHERE MATCH (`thread_title`, `thread_desc`) against ('$searchedItem')";
    // $result = mysqli_query($conn, $sql);

    $stmt =  $mysqli->prepare("SELECT * FROM `threads` WHERE MATCH (`thread_title`, `thread_desc`) against (?)");
    $stmt->bind_param("s", $searchedItem);
    $stmt->execute();
    $categoryFetchingResult = $stmt->get_result();

    $row = mysqli_fetch_all($categoryFetchingResult, MYSQLI_ASSOC);

    
    // print_r($row);
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
    <link rel="stylesheet" href="./css/search-results.css">
    <title>AttackOnCode - Search Results</title>
</head>
<body>
    <?php include "./partials/_navbar.php" ?>
    <main>
    <section id="threadlist">
            <h1 class="search-results-heading">Search Results for - <em> '<?php echo htmlspecialchars($searchedItem); ?>'</em> : </h1>
            <div class="threadlist-container">
                <?php if($row): ?>
                <?php foreach($row as $searchedThread => $thread): ?>
                <a class="thread" href="thread.php?thread_id=<?php echo htmlspecialchars($thread['thread_id']);?>">
                    <h3 class="thread-heading"><?php echo htmlspecialchars($thread['thread_title']) ?></h3>
                    <p class="thread-desc"><?php echo substr(htmlspecialchars($thread['thread_desc']), 0, 250) ?>......</p>
                </a>
                <?php endforeach; ?>
                <?php else: ?>
                <section id="nothing">
                    <div class="nothing-box">
                        <p>No threads available according to your query !</p>
                    </div>
            </section>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>
</html>