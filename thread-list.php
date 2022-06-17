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
    <main class="thread-list-section">
        <div class="category-container">
            <div class="category">
                        <h2 class="category__heading">PHP Forum</h2>
                        <div class="category--padding">
                            <h5 class="category__title">PHP</h5>
                            <p class="category__description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis, vel.lorem10 Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quidem necessitatibus non magnam ea natus. Minus natus explicabo adipisci provident. Nam distinctio tempora enim facilis delectus corporis debitis, facere libero sit?</p>
                            <a class="category__btn" href="#threadlist">Read Threads</a>
                        </div>
                    </div>
        </div>
        <section class="post-thread">
            <h2 class="post-thread-heading">Post a Thread</h2>
            <div class="post-thread-container">
                <form action="" class="post-thread-form">
                    <input type="text" name="thread_title" placeholder="Thread Title" class="thread-title">
                    <textarea name="thread_description" placeholder="Thread Description" class="thread-description" id="thread_description" cols="30" rows="10"></textarea>
                    <input type="submit" value="Post Thread" class="post-thread-btn">
                </form>
            </div>
        </section>
        <section id="threadlist">
            <h2 class="threadlist-heading">Browse Threads</h2>
            <div class="threadlist-container">
                <a class="thread" href="thread.php">
                    <h3 class="thread-heading">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Id, inventore.</h3>
                    <p class="thread-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore illum at incidunt distinctio, est libero minima. Neque obcaecati distinctio repudiandae.</p>
                </a>

                <a class="thread" href="">
                    <h3 class="thread-heading">Thread Title</h3>
                    <p class="thread-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore illum at incidunt distinctio, est libero minima. Neque obcaecati distinctio repudiandae.</p>
                </a>
            </div>
        </section>
    </main>
    <?php include "./partials/_footer.php" ?>


    <script src="./script/app.js"></script>
</body>
</html>