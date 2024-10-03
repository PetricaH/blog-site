<?php require_once('config.php'); ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php'); ?>
<?php require_once( ROOT_PATH . '/includes/public_functions.php'); ?>
<?php require_once( ROOT_PATH . '/includes/registration_login.php'); ?>

<!-- retrieve all posts from database -->
<?php $pots = getPublishedPosts(); ?>

    <title>LifeBlog | Home</title>
</head>
<body> 
    <!-- container - wraps the whole page -->
    <div class="container">
        <?php include( ROOT_PATH . '/includes/navbar.php'); ?>
        <?php include( ROOT_PATH . '/includes/banner.php'); ?>
        <!-- page content -->
        <div class="content">
            <h2 class="content-title">Recent Articles</h2>
            <hr>
            <?php foreach ($posts as $post): ?>
                <div class="post" style="margin-left: 0px;">
                    <img src="<?php echo BASE_URL . '/static/images/' .$post['image']; ?>" class="post_image" alt="">

                    <?php if (isset($post['topic']['name'])): ?>
                        <a href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>" class="btn category">
                            <?php echo $post['topic']['name'] ?>
                        </a>
                    <?php endif ?>

                    <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>"></a>
                        <div class="post_info">
                            <h3><?php echo $post['title'] ?></h3>
                            <div class="info">
                                <span><?php echo date("F j, Y", strtotime($post["created_at"])); ?></span>
                                <span class="read_more">Read more...</span>
                            </div>
                        </div>
                </div>
            <?php endforeach ?>
            <!-- more content still to come here... -->
        </div>
        <!-- // page content -->

<?php include( ROOT_PATH . '/includes/footer.php'); ?>