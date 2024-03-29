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
            $categoryAddResult = $stmt->get_result();
        }

    }

    $stmt =  $mysqli->prepare("SELECT * FROM `categories`");
    $stmt->execute();
    $categoriesFetchingResult = $stmt->get_result();
    $categoriesFetchingArray = mysqli_fetch_all($categoriesFetchingResult, MYSQLI_ASSOC);


    // COMMENTS
    $comId = $comContent = $comCode = $comThreadId = $comUserId = $errMsgComContent = $errMsgComCode = $errMsgComThreadId = $errMsgComUserId = "";

    if(isset($_POST['updateComment'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['comContent'])) {
            $errMsgComContent = "Please enter a comment";
        } else {
            $comContent = test_input($_POST['comContent']);
        }
        if (empty($_POST['comThreadId'])) {
            $errMsgComThreadId = "Please enter thread id";
        } else {
            $comThreadId = test_input($_POST['comThreadId']);
        }
        if (empty($_POST['comUserId'])) {
            $errMsgComUserId = "Please enter user id";
        } else {
            $comUserId = test_input($_POST['comUserId']);
        }

        $comCode = test_input($_POST['comCode']); 
        $comId = $_POST['comId'];

        if($comId && $comContent && $comThreadId && $comUserId) {
            $stmt = $mysqli->prepare("UPDATE `comments` SET `comment_content` = ?, `comment_code` = '$comCode', `thread_id` = ?, `user_id` = ? WHERE `comments`.`comment_id` = ?;");
            $stmt->bind_param("siii", $comContent, $comThreadId, $comUserId, $comId);
            $stmt->execute();
            $commentUpdateResult = $stmt->get_result();
        }

    }

    if(isset($_POST['comDelete'])){
        $comId = $_POST['comDeleteId'];

        $stmt = $mysqli->prepare("DELETE FROM `comments` WHERE `comments`.`comment_id` = ?");
        $stmt->bind_param("i", $comId);
        $stmt->execute();
        $comDeleteResult = $stmt->get_result();

    }

    if(isset($_POST['addComment'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['comAddContent'])) {
            $errMsgComContent= "Please enter comment";
        } else {
            $comContent = test_input($_POST['comAddContent']);
        }
        if (empty($_POST['comAddThreadId'])) {
            $errMsgComThreadId = "Please enter thread id";
        } else {
            $comThreadId = test_input($_POST['comAddThreadId']);
        }
        if (empty($_POST['comAddUserId'])) {
            $errMsgComUserId = "Please enter user id";
        } else {
            $comUserId = test_input($_POST['comAddUserId']);
        }

        $comCode = test_input($_POST['comAddCode']);

        if($comContent && $comThreadId && $comUserId) {
            $stmt = $mysqli->prepare("INSERT INTO `comments` (`comment_content`, `comment_code`, `thread_id`, `user_id`) VALUES (?, ?, ?, ?);");
            $stmt->bind_param("ssii", $comContent, $comCode, $comThreadId, $comUserId);
            $stmt->execute();
            $commentAddResult = $stmt->get_result();
        }

    }
    
    $stmt =  $mysqli->prepare("SELECT * FROM `comments`");
    $stmt->execute();
    $commentsFetchingResult =  $stmt->get_result();
    $commentsFetchingArray = mysqli_fetch_all($commentsFetchingResult, MYSQLI_ASSOC);

    // THREADS
    $threadId = $threadTitle = $threadDesc = $threadCode = $threadCategoryId = $threadUserId = $errMsgThreadTitle = $errMsgThreadCode = $errMsgThreadDesc  = $errMsgThreadCategoryId = $errMsgThreadUserId = "";

    if(isset($_POST['updateThread'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['threadTitle'])) {
            $errMsgThreadTitle = "Please enter thread title";
        } else {
            $threadTitle = test_input($_POST['threadTitle']);
        }
        if (empty($_POST['threadDesc'])) {
            $errMsgThreadDesc = "Please enter description";
        } else {
            $threadDesc = test_input($_POST['threadDesc']);
        }
        if (empty($_POST['threadCategoryId'])) {
            $errMsgThreadCategoryId = "Please enter category id";
        } else {
            $threadCategoryId = test_input($_POST['threadCategoryId']);
        }
        if (empty($_POST['threadUserId'])) {
            $errMsgThreadUserId = "Please enter user id";
        } else {
            $threadUserId = test_input($_POST['threadUserId']);
        }

        $threadCode = $_POST['threadCode'];
        $threadId = $_POST['threadId'];

        if($threadId && $threadTitle && $threadDesc && $threadCategoryId && $threadUserId) {
            $stmt = $mysqli->prepare("UPDATE `threads` SET `thread_title` = ?, `thread_desc` = ?, `thread_code` = ?, `thread_cat_id` = ?, `thread_user_id` = ? WHERE `threads`.`thread_id` = ?;");
            $stmt->bind_param("sssiii", $threadTitle, $threadDesc, $threadCode, $threadCategoryId, $threadUserId, $threadId);
            $stmt->execute();
            $threadUpdateResult = $stmt->get_result();
        }

    }

    if(isset($_POST['threadDelete'])){
        $threadId = $_POST['threadDeleteId'];

        $stmt = $mysqli->prepare("DELETE FROM `threads` WHERE `threads`.`thread_id` = ?");
        $stmt->bind_param("i", $threadId);
        $stmt->execute();
        $threadDeleteResult = $stmt->get_result();

    }

    if(isset($_POST['addThread'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['threadAddTitle'])) {
            $errMsgThreadTitle= "Please enter thread title";
        } else {
            $threadTitle = test_input($_POST['threadAddTitle']);
        }
        if (empty($_POST['threadAddDesc'])) {
            $errMsgThreadDesc = "Please enter thread id";
        } else {
            $threadDesc = test_input($_POST['threadAddDesc']);
        }
        if (empty($_POST['threadAddCategoryId'])) {
            $errMsgThreadCategoryId = "Please enter user id";
        } else {
            $threadCategoryId = test_input($_POST['threadAddCategoryId']);
        }
        if (empty($_POST['threadAddUserId'])) {
            $errMsgThreadUserId = "Please enter user id";
        } else {
            $threadUserId = test_input($_POST['threadAddUserId']);
        }

        $threadCode = test_input($_POST['threadAddCode']);

        if($threadTitle && $threadDesc && $threadCategoryId && $threadUserId) {
            $stmt = $mysqli->prepare("INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_code`, `thread_cat_id`, `thread_user_id`) VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("sssii", $threadTitle, $threadDesc, $threadCode, $threadCategoryId, $threadUserId);
            $stmt->execute();
            $threadAddResult = $stmt->get_result();
        }

    }

    $stmt =  $mysqli->prepare("SELECT * FROM `threads`");
    $stmt->execute();
    $threadsFetchingResult = $stmt->get_result();
    $threadsFetchingArray = mysqli_fetch_all($threadsFetchingResult, MYSQLI_ASSOC);

    // USERS
    $userId = $userName = $userEmail = $userPassword = $userStatus = $userType = $errMsgUserName = $errMsgUserEmail = $errMsgUserPassword = $errMsgUserStatus = $errMsgUserType = "";

    if(isset($_POST['updateUser'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['userName'])) {
            $errMsgUserName = "Please enter your name";
        } else {
            $userName = test_input($_POST['userName']);
        }
        if (empty($_POST['userEmail'])) {
            $errMsgUserEmail = "Please enter an email";
        } else {
            if (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
                $errMsgUserEmail = "Please enter a valid email";
            } else {
                $userEmail = test_input($_POST['userEmail']);
            }
        }
        if (empty($_POST['userPassword'])) {
            $errMsgUserPassword = "Please enter a password";
        } else {
            $userPassword = test_input($_POST['userPassword']);
            $hash = password_hash($userPassword, PASSWORD_DEFAULT);
        }
        if (empty($_POST['userStatus'])) {
            $errMsgUserStatus = "please enter user status (active or inactive)";
        } else {
            $userStatus = test_input($_POST['userStatus']);
        }
        if (empty($_POST['userType'])) {
            $errMsgUserType = "please enter user type (admin or user)";
        } else {
            $userType = test_input($_POST['userType']);
        }

        $userId = $_POST['userId'];

        if($userId && $userName && $userEmail && $userPassword && $userStatus && $userType) {
            $stmt = $mysqli->prepare("UPDATE `users` SET `user_name` = ?, `user_email` = ?, `user_password` = ?, `status` = ?, `user_type` = ? WHERE `users`.`user_id` = ?;");
            $stmt->bind_param("sssssi", $userName, $userEmail, $hash, $userStatus, $userType, $userId);
            $stmt->execute();
            $userUpdateResult = $stmt->get_result();
        }

    }

    if(isset($_POST['userDelete'])){
        $userId = $_POST['userDeleteId'];

        $stmt = $mysqli->prepare("DELETE FROM `users` WHERE `users`.`user_id` = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $userDeleteResult = $stmt->get_result();

    }

    if(isset($_POST['addUser'])){
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST['userAddName'])) {
            $errMsgUserName = "Please enter your name";
        } else {
            $userName = test_input($_POST['userAddName']);
        }
        if (empty($_POST['userAddEmail'])) {
            $errMsgUserEmail = "Please enter an email";
        } else {
            if (!filter_var($_POST['userAddEmail'], FILTER_VALIDATE_EMAIL)) {
                $errMsgUserEmail = "Please enter a valid email";
            } else {
                $userEmail = test_input($_POST['userAddEmail']);
            }
        }
        if (empty($_POST['userAddPassword'])) {
            $errMsgUserPassword = "Please enter a password";
        } else {
            $userPassword = test_input($_POST['userAddPassword']);
            $hash = password_hash($userPassword, PASSWORD_DEFAULT);
        }
        if (empty($_POST['userAddStatus'])) {
            $errMsgUserStatus = "please enter user status (active or inactive)";
        } else {
            $userStatus = test_input($_POST['userAddStatus']);
        }
        if (empty($_POST['userAddType'])) {
            $errMsgUserType = "please enter user type (admin or user)";
        } else {
            $userType = test_input($_POST['userAddType']);
        }

        if($userName && $userEmail && $userPassword && $userStatus && $userType) {
            $stmt = $mysqli->prepare("INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `status`, `user_type`) VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("sssss", $userName, $userEmail, $hash, $userStatus, $userType);
            $stmt->execute();
            $userAddResult = $stmt->get_result();
        }

    }

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
    <div  class="sidebar-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
    </div>
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
                        <td class=""><?php echo htmlspecialchars($category['category_createdat']) ?></td>
                        <td>
                            <button class="dashboard-edit-btn">Edit</button>
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
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" >
                                <input type="hidden" name="comDeleteId" value="<?php echo htmlspecialchars($comment['comment_id']) ?>">
                                <button class="dashboard-delete-btn" name="comDelete" value="comDeleted">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button id="openAddCategoryModal" class="add-com-btn add-btn">+ Add Comment</button>
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
                    <tr class="thread-row">
                        <td class="thread_id"><?php echo htmlspecialchars($thread['thread_id']) ?></td>
                        <td class="thread_title text-overflow"><?php echo htmlspecialchars($thread['thread_title']) ?></td>
                        <td class="thread_desc text-overflow"><?php echo htmlspecialchars($thread['thread_desc']) ?></td>
                        <td class="thread_code text-overflow"><?php echo htmlspecialchars($thread['thread_code']) ?></td>
                        <td class="thread_category_id"><?php echo htmlspecialchars($thread['thread_cat_id']) ?></td>
                        <td class="thread_user_id"><?php echo htmlspecialchars($thread['thread_user_id']) ?></td>
                        <td><?php echo htmlspecialchars($thread['timestamp']) ?></td>
                        <td>
                            <button class="dashboard-edit-btn">Edit</button>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" >
                                <input type="hidden" name="threadDeleteId" value="<?php echo htmlspecialchars($thread['thread_id']) ?>">
                                <button class="dashboard-delete-btn" name="threadDelete" value="threadDeleted">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="add-thread-btn add-btn">+ Add Thread</button>
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
                    <tr class="user-row">
                        <td class="user_id"><?php echo htmlspecialchars($user['user_id']) ?></td>
                        <td class="user_name"><?php echo htmlspecialchars($user['user_name']) ?></td>
                        <td class="user_email"><?php echo htmlspecialchars($user['user_email']) ?></td>
                        <td class="user_password text-overflow"><?php echo htmlspecialchars($user['user_password']) ?></td>
                        <td class="user_status"><?php echo htmlspecialchars($user['status']) ?></td>
                        <td class="user_type"><?php echo htmlspecialchars($user['user_type']) ?></td>
                        <td><?php echo htmlspecialchars($user['timestamp']) ?></td>
                        <td>
                            <button class="dashboard-edit-btn">Edit</button>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" >
                                <input type="hidden" name="userDeleteId" value="<?php echo htmlspecialchars($user['user_id']) ?>">
                                <button class="dashboard-delete-btn" name="userDelete" value="userDeleted">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="add-user-btn add-btn">+ Add User</button>
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
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="categoryAddForm" class="dashboardForm">
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
            <h1 class="dashboardFormHeading">Comment</h1>
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
            <h1 class="dashboardFormHeading">Comment</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="commentsAddForm" class="dashboardForm">
            <input type="text" placeholder="Comment" name="comAddContent" class="input com-add-content">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComContent) ?></span>
            <textarea name="comAddCode" class="input com-add-code" placeholder="Code" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComCode) ?></span>
            <input type="number" name="comAddThreadId" placeholder="Thread Id" class="input com-add-thread-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComThreadId) ?></span>
            <input type="number" name="comAddUserId" placeholder="User Id" class="input com-add-user-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgComUserId) ?></span>
            <input type="submit" name="addComment" class="input" id="addComment" value="+ Add Comment">
          </form>
        </div>
    </div>

    <!-- THREADS MODALS -->
    <div id="threadUpdateModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">Thread</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="threadForm" class="dashboardForm">
            <input type="hidden" name="threadId" class="thread-id">
            <input type="text" placeholder="Thread Title" name="threadTitle" class="input thread-title">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadTitle) ?></span>
            <textarea name="threadDesc" class="input thread-desc" placeholder="Thread Description" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadDesc) ?></span>
            <textarea name="threadCode" class="input thread-code" placeholder="Thread Code" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadCode) ?></span>
            <input type="number" name="threadCategoryId" placeholder="Thread Id" class="input thread-category-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadCategoryId) ?></span>
            <input type="number" name="threadUserId" placeholder="User Id" class="input thread-user-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadUserId) ?></span>
            <input type="submit" name="updateThread" class="input" id="updateThread" value="+ Update Thread">
          </form>
        </div>
    </div>
    <div id="threadAddModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">Thread</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="threadAddForm" class="dashboardForm">
            <input type="text" placeholder="Thread Title" name="threadAddTitle" class="input thread-add-title">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadTitle) ?></span>
            <textarea name="threadAddDesc" class="input thread-add-desc" placeholder="Description" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadDesc) ?></span>
            <textarea name="threadAddCode" class="input thread-add-code" placeholder="Code" cols="60" rows="10"></textarea>
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadCode) ?></span>
            <input type="number" name="threadAddCategoryId" placeholder="Category Id" class="input thread-add-category-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadCategoryId) ?></span>
            <input type="number" name="threadAddUserId" placeholder="User Id" class="input thread-add-user-id">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgThreadUserId) ?></span>
            <input type="submit" name="addThread" class="input" id="addThread" value="+ Add Thread">
          </form>
        </div>
    </div>

    <!-- USERS MODALS -->
    <div id="userUpdateModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">User</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="userForm" class="dashboardForm">
            <input type="hidden" name="userId" class="user-id">
            <input type="text" placeholder="Name" name="userName" class="input user-name">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserName) ?></span>
            <input type="email" placeholder="Email" name="userEmail" class="input user-email">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserEmail) ?></span>
            <input type="password" placeholder="Password" name="userPassword" class="input user-password">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserPassword) ?></span>
            <input type="text" name="userStatus" placeholder="Status" class="input user-status">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserStatus) ?></span>
            <input type="text" name="userType" placeholder="Type" class="input user-type">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserType) ?></span>
            <input type="submit" name="updateUser" class="input" id="updateUser" value="+ Update User">
          </form>
        </div>
    </div>
    <div id="userAddModal" class="modal">
        <div class="modal-content">
            <h1 class="dashboardFormHeading">User</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" id="userAddForm" class="dashboardForm">
            <input type="text" placeholder="Name" name="userAddName" class="input user-add-name">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserName) ?></span>
            <input type="email" placeholder="Email" name="userAddEmail" class="input user-add-email">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserEmail) ?></span>
            <input type="password" placeholder="Password" name="userAddPassword" class="input user-add-password">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserPassword) ?></span>
            <input type="text" name="userAddStatus" placeholder="Status" class="input user-add-status">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserStatus) ?></span>
            <input type="text" name="userAddType" placeholder="Type" class="input user-add-type">
            <span class="err-msg"><?php echo htmlspecialchars($errMsgUserType) ?></span>
            <input type="submit" name="addUser" class="input" id="addUser" value="+ Add User">
          </form>
        </div>
    </div>
    <?php include "./partials/_footer.php" ?>
    <script src="./script/dashboard.js"></script>
    <script src="./script/app.js"></script>
</body>

</html>