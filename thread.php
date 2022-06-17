<?php 
    require "./partials/_connection.php";

    $showAlert = false;

    $thread_id = $_GET['thread_id'];

    $threadFetchingSql = "SELECT * FROM `threads` WHERE thread_id = '$thread_id'";
    $threadFetchingResult = mysqli_query($conn, $threadFetchingSql);
    $threadFetchingArray = mysqli_fetch_assoc($threadFetchingResult);

    // FUNCTIONALITY FOR ADDING COMMENTS

    $comment_description = $errorMsgComment = "";

    if(isset($_POST['addComment'])){
        if(!empty($_POST['comment_description'])){
            $comment_description = $_POST['comment_description'];
    
            $commentAddingSql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `user_id`) VALUES ('$comment_description', '$thread_id', '0');";
            $commentAddingResult = mysqli_query($conn, $commentAddingSql);

            if($commentAddingResult){
                $showAlert = true;
            }
        }else {
            $errorMsgComment = "Enter a comment";
        }

    }

    $commentsFetchingSql = "SELECT * FROM `comments` WHERE thread_id = '$thread_id'";
    $commentsFetchingResult = mysqli_query($conn, $commentsFetchingSql);
    $commentsFetchingArray = mysqli_fetch_all($commentsFetchingResult, MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="./css/thread.css">
    <title>AttackOnCode - Thread</title>
</head>
<body>
    <?php include "./partials/_navbar.php" ?>
    <?php if($showAlert): ?>
    <div class="alert-box success">
        <p class="alert-msg"> <strong> Success!!</strong>  Your comment has been added successfully</p>
    </div>
    <?php endif; ?>
    <main>
        <section id="thread">
            <div class="thread-container">
            <div class="thread" href="thread.php">
                    <h3 class="thread-heading"><?php echo htmlspecialchars($threadFetchingArray['thread_title']) ?></h3>
                    <p class="thread-desc"><?php echo htmlspecialchars($threadFetchingArray['thread_desc']) ?></p>
                    <p><strong>Posted By : </strong> <span>username</span></p>
                </div>
            </div>
        </section>
        <section class="add-comment">
            <h2 class="add-comment-heading">Add a Comment</h2>
            <div class="add-comment-container">
                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST" class="add-comment-form">
                    <textarea name="comment_description" placeholder="Add a Comment ........." class="comment-description" id="comment-description" cols="30" rows="5"></textarea>
                    <span class="mb-2"><?php echo htmlspecialchars($errorMsgComment) ?></span>
                    <input type="submit" value="Add Comment" name="addComment" class="add-comment-btn">
                </form>
            </div>
        </section>
        <section id="commentlist">
            <h2 class="commentlist-heading">Browse Comments</h2>
            <div class="commentlist-container">
                <?php foreach($commentsFetchingArray as $comments => $comment): ?>
                <div class="comment" href="thread.php">
                    <h3 class="comment-heading">username</h3>
                    <p class="comment-desc"><?php echo htmlspecialchars($comment['comment_content']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>
</html>