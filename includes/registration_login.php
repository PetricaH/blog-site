<?php 
// variable declaration
$username = "";
$email = "";
$errors = array();

// register user
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = esc($_POST['username']);
    $email = esc($_POST['email']);
    $password_1 = esc($_POST['password_1']);
    $password_2 = esc($_POST['password_1']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) { array_push($errors, "Username needed"); }
    if (empty($email)) { array_push($errors, "Email is needed"); }
    if (empty($password_1)) { array_push($errors, "Password is not correct"); }
    if (empty($password_1 != $password_2)) { array_push($errors, "the passwords do not match"); }

    // ensure that no user its  registered twice
    // the email and username should be unique
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists 
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists.");
        }
        if ($user['email'] == $email) {
            array_push($errors, "Email already exists");
        }
    }
    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); // encrypt the password before saving in the database
        $query = "INSERT INTO users (username, email, password, created_at, updated_at)
                        VALUES('$username', '$email', '$password"
    }
}

?>