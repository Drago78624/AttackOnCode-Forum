<?php 
    require "./partials/_connection.php";

    $showAlert = false;

    $category_id = $_GET['category_id'];

    $categoryFetchingSql = "SELECT * FROM `categories` WHERE category_id = '$category_id'";
    $categoryFetchingResult = mysqli_query($conn, $categoryFetchingSql);
    $categoryFetchingArray = mysqli_fetch_assoc($categoryFetchingResult);

    // FUNCTIONALITY FOR POSTING THREADS
    $thread_title = $thread_description = $errorMsgTitle = $errorMsgDesc ="";

    if(isset($_POST['postThread'])){
        $thread_title = $_POST['thread_title'];
        $thread_description = $_POST['thread_description'];
        if(!empty($_POST['thread_title']) && !empty($_POST['thread_description'])){
            $threadPostingSql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$thread_title', '$thread_description', '$category_id', '0')";
            $threadPostingResult = mysqli_query($conn, $threadPostingSql);
    
            if($threadPostingResult){
                $showAlert = true;
                $thread_title = $thread_description = $errorMsgTitle = $errorMsgDesc ="";
            }
        }else if(empty($_POST['thread_title']) && empty($_POST['thread_description'])){
            $errorMsgDesc = "Enter a description";
            $errorMsgTitle = "Enter a title";
        }else if(empty($_POST['thread_title'])){
            $errorMsgTitle = "Enter a title";
        }else if(empty($_POST['thread_description'])){
            $errorMsgDesc = "Enter a description";
        }
    }

    $threadsFetchingSql = "SELECT * FROM `threads` WHERE thread_cat_id = '$category_id'";
    $threadsFetchingResult = mysqli_query($conn, $threadsFetchingSql);
    $threadsFetchingArray = mysqli_fetch_all($threadsFetchingResult, MYSQLI_ASSOC);

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
    <link rel="stylesheet" href="./css/thread-list.css">
    <title>AttackOnCode - PHP Forum</title>
</head>
<body>
    <?php include "./partials/_navbar.php" ?>
    <?php if($showAlert): ?>
    <div class="alert-box success">
        <p class="alert-msg"> <strong> Success!!</strong>  Your thread has been posted successfully</p>
    </div>
    <?php endif; ?>
    <main class="thread-list-section">
        <div class="category-container">
            <div class="category">
                    <h2 class="category__heading"><?php echo htmlspecialchars($categoryFetchingArray['category_name']) ?> Forum</h2>
                    <div class="category--padding">
                            <h5 class="category__title"><?php echo htmlspecialchars($categoryFetchingArray['category_name']) ?></h5>
                            <p class="category__description"><?php echo htmlspecialchars($categoryFetchingArray['category_description']) ?></p>
                            <a class="category__btn" href="#threadlist">Read Threads</a>
                    </div>
            </div>
        </div>
        <section class="post-thread">
            <h2 class="post-thread-heading">Post a Thread</h2>
            <div class="post-thread-container">
                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST" class="post-thread-form">
                    <input type="text" name="thread_title" placeholder="Thread Title" class="thread-title" value="<?php echo htmlspecialchars($thread_title)?>">
                    <span class="mb-2"><?php echo htmlspecialchars($errorMsgTitle) ?></span>
                    <textarea name="thread_description" placeholder="Thread Description" class="thread-description" id="thread_description" cols="30" rows="10" value="<?php echo htmlspecialchars($thread_description)?>"></textarea>
                    <span class="mb-2"><?php echo htmlspecialchars($errorMsgDesc) ?></span>
                    <input type="submit" value="Post Thread" name="postThread" class="post-thread-btn">
                </form>
            </div>
        </section>
        <section id="threadlist">
            <h2 class="threadlist-heading">Browse Threads</h2>
            <div class="threadlist-container">
                <?php foreach($threadsFetchingArray as $threads => $thread): ?>
                <a class="thread" href="thread.php?thread_id=<?php echo htmlspecialchars($thread['thread_id']) ?>">
                    <h3 class="thread-heading"><?php echo htmlspecialchars($thread['thread_title']) ?></h3>
                    <p class="thread-desc"><?php echo htmlspecialchars($thread['thread_desc']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>
</html>