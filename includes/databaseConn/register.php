<?php 
ob_start(); 

require 'config.php';
if (!$con) {
    echo '<script>alert("Database connection failed! Please try again later."); location.replace("../../authentication/index.html");</script>';
    exit();
}

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


$check_result = pg_query_params($con, "SELECT id FROM register_lc WHERE username = $1 OR email = $2", array($username, $email));
if (!$check_result) {
    echo '<script>alert("Server error! Please try again later."); location.replace(document.referrer);</script>';
    exit();
}
if (pg_num_rows($check_result) > 0) {
    echo '<script>alert("Username or email already exists!"); location.replace(document.referrer);</script>';
    pg_free_result($check_result);
    exit();
}
pg_free_result($check_result);

// Hash the password before saving
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Use prepared statements to prevent SQL injection


$result1 = pg_query_params($con, "INSERT INTO register_lc (name, username, email, contact, password) VALUES ($1, $2, $3, $4, $5)", array($name, $username, $email, $contact, $hashed_password));
$result2 = pg_query_params($con, "INSERT INTO login_lc (username, password) VALUES ($1, $2)", array($username, $hashed_password));
if ($result1 && $result2) {
    echo '<script>alert("Registration Successful! Redirecting to Login page"); location.replace(document.referrer);</script>';
} else {
    $err = pg_last_error($con);
    echo '<script>alert("Registration failed! '."$err".'"); location.replace(document.referrer);</script>';
}
if ($result1) pg_free_result($result1);
if ($result2) pg_free_result($result2);
pg_close($con);
?>