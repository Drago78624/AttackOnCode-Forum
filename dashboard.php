<?php
    session_start();

    require "partials/_connection.php";

    if(!isset($_SESSION['admin_active'])){
        header("Location: index.php");
    }

    // CATEGORIES
    $catId = $catName = $catDesc = $catIconUrl = $errMsgCatName = $errMsgCatDesc = $errMsgCatIconUrl = "";

    if(isset($_POST['updateCategory'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['catName'])) {
            $errMsgCatName = "Please enter category name";
        } else {
            $catName = test_input($_POST['catName']);
        }
        if (empty($_POST['catDesc'])) {
            $errMsgCatDesc = "Please enter category description";
        } else {
            $catDesc = test_input($_POST['catDesc']);
        }
        if (empty($_POST['catIconUrl'])) {
            $errMsgCatIconUrl = "Please enter category icon url";
        } else {
            $catIconUrl = test_input($_POST['catIconUrl']);
        }

        $catId = $_POST['catId'];

        if($catId && $catName && $catDesc && $catIconUrl) {
            $stmt = $mysqli->prepare("UPDATE `categories` SET `category_name` = ?, `category_description` = ?, `icon_url` = ? WHERE `categories`.`category_id` = ?;");
            $stmt->bind_param("sssi", $catName, $catDesc, $catIconUrl, $catId);
            $stmt->execute();
            $categoryUpdateResult = $stmt->get_result();
        }

    }

    if(isset($_POST['catDelete'])){
        $catId = $_POST['catDeleteId'];

        $stmt = $mysqli->prepare("DELETE FROM `categories` WHERE `categories`.`category_id` = ?");
        $stmt->bind_param("i", $catId);
        $stmt->execute();
        $categoryDeleteResult = $stmt->get_result();

    }

    if(isset($_POST['addCategory'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['catAddName'])) {
            $errMsgCatName = "Please enter category name";
        } else {
            $catName = test_input($_POST['catAddName']);
        }
        if (empty($_POST['catAddDesc'])) {
            $errMsgCatDesc = "Please enter category description";
        } else {
            $catDesc = test_input($_POST['catAddDesc']);
        }
        if (empty($_POST['catAddIconUrl'])) {
            $errMsgCatIconUrl = "Please enter category icon url";
        } else {
            $catIconUrl = test_input($_POST['catAddIconUrl']);
        }

        if($catName && $catDesc && $catIconUrl) {
            $stmt = $mysqli->prepare("INSERT INTO `categories` (`category_name`, `category_description`, `icon_url`) VALUES (?, ?, ?);");
            $stmt->bind_param("sss", $catName, $catDesc, $catIconUrl);
            $stmt->execute();
            $categoryUpdateResult = $stmt->get_result();
        }

    }

    $stmt =  $mysqli->prepare("SELECT * FROM `categories`");
    $stmt->execute();
    $categoriesFetchingResult = $stmt->get_result();
    $categoriesFetchingArray = mysqli_fetch_all($categoriesFetchingResult, MYSQLI_ASSOC);


    // COMMENTS
    $comId = $comContent = $comCode = $comThreadId = $comUserId = $errMsgComContent = $errMsgComCode = $errMsgComThreadId = $errMsgComUserId = "";
    
    $stmt =  $mysqli->prepare("SELECT * FROM `comments`");
    $stmt->execute();
    $commentsFetchingResult =  $stmt->get_result();
    $commentsFetchingArray = mysqli_fetch_all($commentsFetchingResult, MYSQLI_ASSOC);

    // THREADS
    $stmt =  $mysqli->prepare("SELECT * FROM `threads`");
    $stmt->execute();
    $threadsFetchingResult = $stmt->get_result();
    $threadsFetchingArray = mysqli_fetch_all($threadsFetchingResult, MYSQLI_ASSOC);

    // USERS
    $stmt = $mysqli->prepare("SELECT * FROM `users`");
    $stmt->execute();
    $usersFetchingResult = $stmt->get_result();
    $usersFetchingArray = mysqli_fetch_all($usersFetchingResult, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <title>AttackOnCode - Admin Dashboard</title>
</head>

<body>
    <?php include "./partials/_navbar.php"; ?>
    <main class="dashboard">
        <div class="sidebar">
            <h1>Admin</h1>
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'Categories')"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-list dashboard-icon">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg> Categories</button>
                <button class="tablinks" onclick="openTab(event, 'Comments')"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-message-square dashboard-icon">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg> Comments</button>
                <button class="tablinks" onclick="openTab(event, 'Threads')"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-help-circle dashboard-icon">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> Threads</button>
                <button class="tablinks" onclick="openTab(event, 'Users')"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-users dashboard-icon">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg> Users</button>
            </div>
        </div>
        <div class="data-container">
            <div class="tabcontent" id="Categories">
                <h1>Categories</h1>
                <table class="myTable">
                    <thead>
                        <tr>
                            <th>Category Id</th>
                            <th>Category Name</th>
                            <th>Category Description</th>
                            <th>Icon Url</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($categoriesFetchingArray as $categories => $category): ?>
                    <tr class="category-row">
                        <td class="cat_id"><?php echo htmlspecialchars($category['category_id']) ?></td>
                        <td class="cat_name"><?php echo htmlspecialchars($category['category_name']) ?></td>
                        <td class="cat_desc text-overflow"><?php echo htmlspecialchars($category['category_description']) ?></td>
                        <td class="cat_icon_url"><?php echo htmlspecialchars($category['icon_url']) ?></td>
                        <td><?php echo htmlspecialchars($category['category_createdat']) ?></td>
                        <td>
                            <button class="dashboard-edit-btn" class="openCategoryUpdateModal">Edit</button>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" >
                                <input type="hidden" name="catDeleteId" value="<?php echo htmlspecialchars($category['category_id']) ?>">
                                <button class="dashboard-delete-btn" name="catDelete" value="catDeleted">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button id="openAddCategoryModal"  class="add-cat-btn add-btn">+ Add Category</button>
            </div>
            <div class="tabcontent" id="Comments">
                <h1>Comments</h1>
                <table class="myTable">
                    <thead>
                    <tr>
                        <th>Comment Id</th>
                        <th>Comment Content</th>
                        <th>Comment Code</th>
                        <th>Thread Id</th>
                        <th>User Id</th>
                        <th>Timestamp</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($commentsFetchingArray as $comments => $comment): ?>
                    <tr class="comment-row">
                        <td class="com_id"><?php echo htmlspecialchars($comment['comment_id']) ?></td>
                        <td class="text-overflow com_content"><?php echo htmlspecialchars($comment['comment_content']) ?></td>
                        <td class="text-overflow com_code"><?php echo htmlspecialchars($comment['comment_code']) ?></td>
                        <td class="com_thread_id"><?php echo htmlspecialchars($comment['thread_id']) ?></td>
                        <td class="com_user_id"><?php echo htmlspecialchars($comment['user_id']) ?></td>
                        <td><?php echo htmlspecialchars($comment['timestamp']) ?></td>
                        <td>
                            <button class="dashboard-edit-btn">Edit</button>
                            <form action="">
                                <button class="dashboard-delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="add-btn">+ Add Comment</button>
            </div>
            <div class="tabcontent" id="Threads">
                <h1>Threads</h1>
                <table class="myTable">
                    <thead>
                    <tr>
                        <th>Thread Id</th>
                        <th>Thread Title</th>
                        <th>Thread Description</th>
                        <th>Thread Code</th>
                        <th>Category Id</th>
                        <th>User Id</th>
                        <th>Timestamp</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($threadsFetchingArray as $threads => $thread): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($thread['thread_id']) ?></td>
                        <td><?php echo substr(htmlspecialchars($thread['thread_title']), 0, 50) ?>....</td>
                        <td><?php echo substr(htmlspecialchars($thread['thread_desc']), 0, 50) ?>....</td>
                        <td><?php echo substr(htmlspecialchars($thread['thread_code']), 0, 50) ?>....</td>
                        <td><?php echo htmlspecialchars($thread['thread_cat_id']) ?></td>
                        <td><?php echo htmlspecialchars($thread['thread_user_id']) ?></td>
                        <td><?php echo htmlspecialchars($thread['timestamp']) ?></td>
                        <td>
                            <button class="dashboard-edit-btn">Edit</button>
                            <form action="">
                                <button class="dashboard-delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="add-btn">+ Add Thread</button>
            </div>
            <div class="tabcontent" id="Users">
                <h1>Users</h1>
                <table class="myTable">
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>User Password</th>
                            <th>Status</th>
                            <th>User Type</th>
                            <th>Timestamp</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($usersFetchingArray as $users => $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']) ?></td>
                        <td><?php echo htmlspecialchars($user['user_name']) ?>....</td>
                        <td><?php echo htmlspecialchars($user['user_email']) ?>....</td>
                        <td><?php echo substr(htmlspecialchars($user['user_password']), 0, 50) ?>....</td>
                        <td><?php echo htmlspecialchars($user['status']) ?></td>
                        <td><?php echo htmlspecialchars($user['user_type']) ?></td>
                        <td><?php echo htmlspecialchars($user['timestamp']) ?></td>
                        <td>
                            <button class="dashboard-edit-btn">Edit</button>
                            <form action="">
                                <button class="dashboard-delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="add-btn">+ Add User</button>
            </div>
        </div>
    </main>
    <!-- CATEGORY MODALS -->
    <div id="categoryUpdateModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">Category</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="categoryForm" class="dashboardForm">
            <input type="hidden" name="catId" class="cat-id">
            <input type="text" placeholder="Name" name="catName" class="input cat-name">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatName) ?></span>
            <textarea name="catDesc" class="input cat-desc" placeholder="Description" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatDesc) ?></span>
            <input type="text" name="catIconUrl" placeholder="Icon Url" class="input cat-icon-url">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatIconUrl) ?></span>
            <input type="submit" name="updateCategory" class="input" id="updateCategory" value="+ Update Category">
          </form>
        </div>
    </div>
    <div id="categoryAddModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">Category</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="categoryForm" class="dashboardForm">
            <input type="text" placeholder="Name" name="catAddName" class="input cat-add-name">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatName) ?></span>
            <textarea name="catAddDesc" class="input cat-add-desc" placeholder="Description" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatDesc) ?></span>
            <input type="text" name="catAddIconUrl" placeholder="Icon Url" class="input cat-add-icon-url">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatIconUrl) ?></span>
            <input type="submit" name="addCategory" class="input" id="addCategory" value="+ Add Category">
          </form>
        </div>
    </div>

    <!-- COMMENTS MODALS -->
    <div id="commentUpdateModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">Comments</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="commentsForm" class="dashboardForm">
            <input type="hidden" name="comId" class="com-id">
            <input type="text" placeholder="Comment Content" name="comContent" class="input com-content">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComContent) ?></span>
            <textarea name="comCode" class="input com-code" placeholder="Comment Code" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComCode) ?></span>
            <input type="number" name="comThreadId" placeholder="Thread Id" class="input com-thread-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComThreadId) ?></span>
            <input type="number" name="comUserId" placeholder="User Id" class="input com-user-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComUserId) ?></span>
            <input type="submit" name="updateComment" class="input" id="updateComment" value="+ Update Comment">
          </form>
        </div>
    </div>
    <div id="commentAddModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">Category</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="categoryForm" class="dashboardForm">
            <input type="text" placeholder="Name" name="catAddName" class="input cat-add-name">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatName) ?></span>
            <textarea name="catAddDesc" class="input cat-add-desc" placeholder="Description" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatDesc) ?></span>
            <input type="text" name="catAddIconUrl" placeholder="Icon Url" class="input cat-add-icon-url">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgCatIconUrl) ?></span>
            <input type="submit" name="addCategory" class="input" id="addCategory" value="+ Add Category">
          </form>
        </div>
    </div>
    <?php include "./partials/_footer.php" ?>
    <script src="./script/dashboard.js"></script>
    <script src="./script/app.js"></script>
</body>

</html>