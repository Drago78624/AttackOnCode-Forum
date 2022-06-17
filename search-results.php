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
    <link rel="stylesheet" href="./css/search-results.css">
    <title>AttackOnCode - Search Results</title>
</head>
<body>
    <?php include "./partials/_navbar.php" ?>
    <main>
    <section id="threadlist">
            <h1 class="search-results-heading">Search Results for - <em> 'honolulu'</em> : </h1>
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