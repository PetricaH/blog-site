<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- get all topics from db -->
<?php $topics = getAllTopics(); ?>
<title>Admin | Manage Topics</title>
</head>
<body>
    <!-- admin navbar -->
    <?php include(ROOT_PATH . '/admin/includes/navbar.php'); ?>
    <div class="container content">
        <!-- left side menu -->
        <?php include(ROOT_PATH . '/admin/includes/menu.php'); ?>
        <!-- middle form - to create and edit -->
        <div class="action">
            <h1 class="page-title">Create/Edit Topics</h1>
            <form method="post" action="<?php echo BASE_URL . 'admin/topics.php'; ?>">
                <!-- validation errors for the form -->
                <?php include(ROOT_PATH . '/includes/errors.php'); ?>
                <!-- if editing topic, the id is required to identify that topic -->
                <?php if ($isEditingTopic === true): ?>
                    <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                <?php endif ?>
                <input type="text" name="topic_name" value="<?php echo $topic_name; ?>" placeholder="Topic">
                <!-- if editing topic, display the update button instead of create button -->
                <?php if ($isEditingTopic === true): ?>
                    <button type="submit" class="btn" name="update_topic">UPDATE</button>
                <?php else: ?>
                    <button type="submit" class="btn" name="create_topic">Save Topic</button>
                <?php endif ?>
            </form>            
        </div>
        <!-- // middle form - to create and edit -->
        <!-- display records from DB -->
        <div class="table-div">
            <!-- display notification message -->
            <?php include(ROOT_PATH . '/includes/message.php'); ?>
            <?php if (empty($topics)): ?>
                <h1>No topics in the database.</h1>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <th>N</th>
                        <th>Topic Name</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                    <?php foreach ($topics as $key => $topic): ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</body>