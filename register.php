<?php include('config.php'); ?>
<!-- source code for handling registration and login -->
<?php include('includes/restration_login.php'); ?>

<?php include('includes/head_section.php'); ?>

<title>LifeBlog | Sign Up</title>
</head>
<body>
    <div class="container">
        <!-- navbar -->
            <?php include( ROOT_PATH . '/includes/navbar.php'); ?>
        <!-- // navbar -->
        <div style="width: 40%; margin: 20px auto;">
            <form method="post" action="register.php">
                <h2>Register on LifeBlog</h2>
                <?php include(ROOT_PATH . '/includes/errors.php'); ?>
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
                <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
                <input type="password" name="password_1" placeholder="Password">
                <input type="password" name="password_2" placeholder="Password Confirmation">
                <button type="submit" class="btn" name="reg_user">Register</button>
                <p>
                    Already a member? <a href="login.php">Sign In</a>
                </p>
            </form>
        </div>
    </div>
    <!-- // container -->
    <!-- footer -->
    <?php include( ROOT_PATH . '/includes/footer.php'); ?>
    <!-- // footer -->
</body>