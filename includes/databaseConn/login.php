<?php 
ob_start(); 

require 'config.php';
if (!$con) {
    echo '<script>alert("Database connection failed! Please try again later."); location.replace("../../index.html");</script>';
    exit();
}

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


$result = pg_query_params($con, "SELECT password FROM login_lc WHERE username = $1", array($username));
if (!$result) {
    echo '<script>alert("Server error! Please try again later."); location.replace(document.referrer);</script>';
    exit();
}
$row = pg_fetch_assoc($result);
if ($row) {
    if (password_verify($password, $row['password'])) {
        // Update last login time
        $update_result = pg_query_params($con, "UPDATE login_lc SET last_login = NOW() WHERE username = $1", array($username));
        if ($update_result) pg_free_result($update_result);
        // Redirect to user page
        echo '<script>window.location.href="../../welcome/user.html";</script>';
    } else {
        echo '<script>alert("Invalid Username or Password!"); location.replace(document.referrer);</script>';
    }
} else {
    echo '<script>alert("Invalid Username or Password!"); location.replace(document.referrer);</script>';
}
pg_free_result($result);
pg_close($con);
?>