<?php 
ob_start(); 
require 'config.php';

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<script>alert("Invalid request method!"); location.replace("../../authentication/index.html");</script>';
    exit();
}

// Validate and sanitize input
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Basic validation
if (empty($name) || empty($email) || empty($username) || empty($contact) || empty($password)) {
    echo '<script>alert("All fields are required!"); location.replace(document.referrer);</script>';
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<script>alert("Invalid email format!"); location.replace(document.referrer);</script>';
    exit();
}

// Check if username or email already exists
$check_stmt = mysqli_prepare($con, "SELECT id FROM register_lc WHERE username = ? OR email = ?");
mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    echo '<script>alert("Username or email already exists!"); location.replace(document.referrer);</script>';
    mysqli_stmt_close($check_stmt);
    exit();
}
mysqli_stmt_close($check_stmt);

// Use prepared statements to prevent SQL injection
$stmt1 = mysqli_prepare($con, "INSERT INTO register_lc (name, username, email, contact, password) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt1, "sssss", $name, $username, $email, $contact, $password);

$stmt2 = mysqli_prepare($con, "INSERT INTO login_lc (username, password) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt2, "ss", $username, $password);

// Execute both statements
if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {
    echo '<script>alert("Registration Successful! Redirecting to Login page"); location.replace(document.referrer);</script>';
} else {
    echo '<script>alert("Registration failed! Please try again."); location.replace(document.referrer);</script>';
}

mysqli_stmt_close($stmt1);
mysqli_stmt_close($stmt2);
mysqli_close($con);
?>