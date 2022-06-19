<?php 
    session_start();
    require "./partials/_connection.php";

    $showAlert = false;

    $category_id = $_GET['category_id'];

    $categoryFetchingSql = "SELECT * FROM `categories` WHERE category_id = '$category_id'";
    $categoryFetchingResult = mysqli_query($conn, $categoryFetchingSql);
    $categoryFetchingArray = mysqli_fetch_assoc($categoryFetchingResult);

    // FUNCTIONALITY FOR POSTING THREADS
    $thread_title = $thread_description = $errorMsgTitle = $errorMsgDesc = $user_id = "";

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }

    if(isset($_POST['postThread'])){
        $thread_title = mysqli_real_escape_string($conn, $_POST['thread_title']);
        $thread_description = mysqli_real_escape_string($conn, $_POST['thread_description']);
        $thread_code = mysqli_real_escape_string($conn, $_POST['thread_code']);
        if(!empty($_POST['thread_title']) && !empty($_POST['thread_description'])){
            $threadPostingSql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_code`, `thread_cat_id`, `thread_user_id`) VALUES ('$thread_title', '$thread_description', '$thread_code', '$category_id', '$user_id')";
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
        <div class="close-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div>
    </div>
    <?php endif; ?>
    <main class="thread-list-section">
        <div class="category-container">
            <div class="category">
                    <h2 class="category__heading"><?php echo htmlspecialchars($categoryFetchingArray['category_name']) ?> Forum</h2>
                    <div class="category--padding">
                            <p class="category__description"><?php echo htmlspecialchars($categoryFetchingArray['category_description']) ?></p>
                            <a class="category__btn" href="#threadlist">Read Threads</a>
                    </div>
            </div>
        </div>
        <?php if(isset($_SESSION['loggedin'])): ?>
        <section class="post-thread">
            <h2 class="post-thread-heading">Post a Thread</h2>
            <div class="post-thread-container">
                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST" class="post-thread-form">
                    <input type="text" name="thread_title" placeholder="Thread Title" class="thread-title" value="<?php echo htmlspecialchars($thread_title)?>">
                    <span class="mb-2"><?php echo htmlspecialchars($errorMsgTitle) ?></span>
                    <textarea name="thread_description" placeholder="Thread Description" class="thread-description" id="thread_description" cols="30" rows="10" value="<?php echo htmlspecialchars($thread_description)?>"></textarea>
                    <span class="mb-2"><?php echo htmlspecialchars($errorMsgDesc) ?></span>
                    <textarea style="margin-bottom: 2rem;" name="thread_code" placeholder="Paste code here" class="thread-code" id="thread_code" cols="30" rows="10" value="<?php echo htmlspecialchars($thread_description)?>"></textarea>
                    <input type="submit" value="Post Thread" name="postThread" class="post-thread-btn">
                </form>
            </div>
        </section>
        <?php else: ?>
        <section id="nothing">
            <div class="nothing-box">
                <p>You need to be logged in to post a thread ! <a style="text-decoration: underline; cursor: pointer;" href="login.php">Click here</a> to Login</p>
            </div>
        </section>
        <?php endif; ?>
        <section id="threadlist">
            <h2 class="threadlist-heading">Browse Threads</h2>
            <div class="threadlist-container">
                <?php if($threadsFetchingArray): ?>
                <?php foreach($threadsFetchingArray as $threads => $thread): ?>
                <?php
                    $thread_id = $thread['thread_id'];
                    $countingCommentsSql = "SELECT COUNT(*) FROM `comments` WHERE thread_id = '$thread_id'";
                    $countingCommentsResult = mysqli_query($conn, $countingCommentsSql);
                    $commentCount = mysqli_fetch_array($countingCommentsResult);
                ?>
                <a class="thread" href="thread.php?thread_id=<?php echo htmlspecialchars($thread['thread_id']) ?>">
                    <h3 class="thread-heading"><?php echo htmlspecialchars($thread['thread_title']) ?></h3>
                    <div class="btn-info-container">
                        <p class="thread-desc"><?php echo substr(htmlspecialchars($thread['thread_desc']), 0, 250) ?>......</p>
                        <div class="number-of-threads">
                        <span><?php echo htmlspecialchars($commentCount[0]); ?> comments</span>
                            <img src="assets/icons8-chat-24.png" alt="">
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <?php else: ?>
                    <section id="nothing">
                        <div class="nothing-box">
                            <p>No threads are available in this category</p>
                        </div>
                   </section>
                <?php endif;?>
            </div>
        </section>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>
</html>