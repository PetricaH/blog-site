<?php 

session_start();

$conn = mysqli_connect("localhost", "root", "", "complete-blog-php");

if (!$conn) {
    die("Error conencting to database: " . mysqli_connect_error());
}

define ('ROOT_PATH', realpath(dirname(__FILE__)));
define ('BASE_URL', 'http://localhost/complete-blog-php/');

?>