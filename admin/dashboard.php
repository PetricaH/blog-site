<?php include('../config.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
    <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
    <title>Admin | Dashboard</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
                <h1>LifeBlog - Admin</h1>
            </a>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
            <div class="user-info">
                <span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
                <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
            </div>
        <?php endif ?>
    </div>
    <div class="container dashboard">
        <h1>Welcome</h1>
        <div class="stats">
            <a href="users.php" class="first">
                <span>43 "this is just a number, it does not update dinamically, do it</span><br>
                <span>Newly registered users</span>
            </a>
            <a href="posts.php">
                <span>43</span><br>
                <span>Published posts</span>
            </a>
            <a href="comments.php">
                <span>43</span><br>
                <span>Published comments</span>
            </a>
        </div>
        <br><br><br>
        <div class="buttons">
            <a href="users.php">Add Users</a>
            <a href="posts.php">Add Posts</a>
        </div>
    </div>
</body>
</html>