<?php 
// admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
// general variables
$errors = [];

// - admin user actions from here downwards
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
    createAdmin($_POST);
}

// if user clicks the edit admin button
if (isset($_GET['edit-admin'])) {
    $isEditingUser = true;
    $admin_id = $_GET['edit-admin'];
    editAdmin($admin_id);
}

// if user clicks the update admin button
if (isset($_POST['update_admin'])) {
    updateAdmin($_POST);
}

// if user clicks the delete admin button
if (isset($_GET['delete-admin'])) {
    $admin_id = $_GET['delete-admin'];
    deleteAdmin($admin_id);
}

// - returnsa all admin users and their corresponding roles | the things downwards
function getAdminUsers() {
    global $conn, $roles;
    $sql = "SELECT * FROM users WHERE role IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $users;
}

// - escapes from submitted value, so i guess this prevents sql injecting something somewhere
function esc(String $value) {
    // bring the global db connect object into function
    global $conn;
    // remove empty space surrounding string (this is done by the code below I guess)
    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $value);
    return $val;
}

// receives a string like 'some sample string'
// and returns 'some-sample-string'
function makeSlug(String $string) {
    $string = strtolower($string);
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return $slug;
}

// admin user functions downwards
function createAdmin($request_values){
    global $conn, $errors, $role, $username, $email;
    $username = esc($request_values['username']);
    $email = esc($request_values['email']);
    $password = esc($request_values['password']);
    $passwordConfirmation = esc($request_values['passwordConfirmation']);

    if(isset($request_values['role'])){
        $role = esc($request_values['role']);
    }

    // form validation ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Invalid Username");
    }
    if (empty($email)) {
        array_push($errors, "Invalid Email");
    }
    if (empty($password)) {
        array_push($errors, "Wrong Password");
    }
    if ($password != $passwordConfirmation) { array_push($errors, "The two passwords do not matchs"); }
    // ensure that no user is registered twice
    // the email and username should be unique
    $user_check_query = "SELECT * FROM users WHERE username='$username'
                                                    OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }
    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password); // encrypt the password before saving in the database
        $query = "INSERT INTO users (username, email, role, password, created_at, updated_at)
                            VALUES ('$username', '$email', '$role', '$password', now(), now())";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Admin user created successfully";
        header('location: users.php');
        exit(0);
    }
}

// takes admin id as parameter
// fetch the admin from database
// sets admin fields on form for editing
function editAdmin($admin_id) {
    global $conn, $username, $role, $isEditingUser, $admin_id, $email;

    $sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);

    // set form values ($username and $email) on the form to be updated
    $username = $admin['username'];
    $email = $admin['email'];
}

// receives admin request from form and updates in the database
function updateAdmin($request_values) {
    global $conn, $errors, $role, $username, $isEditingUser, $admin_id, $email;
    // get id of the admin to be updated
    $admin_id = $request_values['admin_id'];
    // set edit state to false
    $isEditingUser = false;

    $username = esc($request_values['username']);
    $email = esc($request_values['email']);
    $password = esc($request_values['password']);
    $passwordConfirmation = esc($request_values['passwordConfirmation']);
    if (isset($request_values['role'])) {
        $role = $request_values['role'];
    }
    // register user if there are no errors  in the form
    if (count($errors) == 0) {
        // encrypt the password (security purposes)
        $password = md5($password);

        $query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Admin user updated successfully";
        header('location: users.php');
        exit(0);
    }
}
// delete admin user
function deleteAdmin($admin_id) {
    global $conn;
    $sql = "DELTE FROM users WHERE id=$admin_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "User successfully deleted";
        header("location: users.php");
        exit(0);
    }
}

// admin user variables
// variables here

// topic variables
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";

// admin users actions

// topic actions

// if user clicks the create topic button
if (isset($_POST['create_topic'])) {
    createTopic($_POST);;
}

// if user clicks the edit topic button
if (isset($_GET['edit-topic'])) {
    $isEditingTopic = true;
    $topic_id = $_GET['edit-topic'];
    editTopic($topic_id);
}

// if user clicks the update topic button
if (isset($_GET['delete-topic'])) {
    $topic_id = $_GET['delete-topic'];
    deleteTopic($topic_id);
}

// Admin users functions 
// get all topics from database
function getAllTopics() {
    global $conn;
    $sql = "SELECT * FROM topics";
    $result = myslqi_query($conn, $sql);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $topics;
}

function createTopic($request_values) {
    global $conn, $errors, $topic_name;
    $topic_name = esc($request_values['topic_name']);
    // create slug if topic is "Life Advice", return "life-advice" as slug
    $topic_slug = makeSlug($topic_name);
    // validate form
    if (empty($topic_name)) {
        array_push($errors, "Topic name required");
    }
    // ensure that no topic is saved twice
    $topic_check_query = "SELECT * FROM topics WHERE slug='$topic_slug' LIMIT 1";
    $result = mysqli_query($conn, $topic_check_query);
    if (mysqli_num_rows($result) > 0) { // if topic exists
        array_push($errors, "Topic already exists");    
    }
    // register topic if there are no errors in the form 
    if (count($errors) == 0) {
        $query = "INSERT INTO topics (name, slug) 
                            VALUES('$topic_name', '$topic_slug')";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Topic created successfully!";
        header('location: topic.php');
        exit(0);
    }
}

// takes topic id as parameter 
// fetches the topic from database
// sets topic fileds on form for editing
function editTopic($topic_id) {
    global $conn, $topic_name, $isEditingTopic, $topic_id;
    $sql = "SELECT * FROM topics WHERE id=$topic_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $topic = mysqli_fetch_assoc($result);
    // set form values ($topic_name) on the form to be updated 
    $topic_name = $topic['name'];
}

?>
