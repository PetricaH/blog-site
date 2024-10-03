<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php 
    $admins = getAdminUsers();
    $roles = ['Admin', 'Author'];
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<title>Admin | Manage Users</title>
</head>
<body>
    <!-- admin navbar -->
    <?php include(ROOT_PATH . '/admin/includes/navbar.php'); ?>
    <div class="container content">
        <!-- left side menu -->
        <?php include(ROOT_PATH . '/admin/includes/menu.php'); ?>
        <!-- middle form - to create and edit -->
        <div class="action">
            <div class="page-title">Create/Edit Admin User</div>

            <form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>">
                <!-- validation errors for the form -->
                <?php include(ROOT_PATH . '/includes/errors.php'); ?>
                <!-- // if editing user, the id is required to identify that user -->
                <?php if ($isEditingUser === true): ?>
                    <input type="hidden" name="admin_id" value="<?php echo $admin_id;?>">
                <?php endif ?>
                
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
                <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="passwordConfirmation" placeholder="Password confirmation">
                <select name="role">
                    <option value="" selected disabled>Assign role</option>
                    <?php foreach ($roles as $key => $role): ?>
                        <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                    <?php endforeach ?>
                </select>

                <!-- if editing user, display the updated button instead of create button -->
                <?php if ($isEditingUser === true): ?>
                    <button type="submit" class="btn" name="update_admin">UPDATE</button>
                <?php else: ?>
                    <button type="submit" class="btn" name="create_admin">Save User</button>
                <?php endif ?>
            </form>
        </div>
        <!-- // middle form - used to create and edit -->

        <!-- display records from database -->
        <div class="table-div">
            <!-- display notification message -->
            <?php include(ROOT_PATH . '/includes/messages.php'); ?>

            <?php if (empty($admins)): ?>
                <h1>No admins in the database</h1>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <th>N</th>
                        <th>Admin</th>
                        <th>Role</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $key => $admin): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo $admin['username']; ?>
                                    <?php echo $admin['email']; ?>
                                </td>
                                <td><?php echo $admin['role']; ?></td>
                                <td>
                                    <a href="users.php?delete-admin=<?php echo $admin['id'] ?>" class="fa fa-trash btn delete">
                                    </a>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            
    </div>
</body>
