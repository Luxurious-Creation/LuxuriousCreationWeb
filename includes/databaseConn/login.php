<?php 
ob_start(); 
require 'config.php';

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<script>alert("Invalid request method!"); location.replace("../../authentication/index.html");</script>';
    exit();
}

// Validate and sanitize input
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($username) || empty($password)) {
    echo '<script>alert("Username and password are required!"); location.replace(document.referrer);</script>';
    exit();
}

// Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($con, "SELECT id, username FROM login_lc WHERE username = ? AND password = ?");
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Login successful
    $user = mysqli_fetch_assoc($result);
    
    // Update last login time
    $update_stmt = mysqli_prepare($con, "UPDATE login_lc SET last_login = NOW() WHERE username = ?");
    mysqli_stmt_bind_param($update_stmt, "s", $username);
    mysqli_stmt_execute($update_stmt);
    mysqli_stmt_close($update_stmt);
    
    // Redirect to user page
    echo '<script>window.location.href="../../welcome/user.html";</script>';
} else {
    // Login failed
    echo '<script>alert("Invalid Username or Password!"); location.replace(document.referrer);</script>';
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>