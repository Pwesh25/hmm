<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login_samp";

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$con) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}

// Set the character set to utf8mb4
mysqli_set_charset($con, "utf8mb4");
?>
