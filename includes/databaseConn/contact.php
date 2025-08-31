<?php 
ob_start(); 
require 'config.php';

$name = $_POST['name'];
$subject = $_POST['subject'];
$email = $_POST['email'];
$message = $_POST['message'];

// Use prepared statements to prevent SQL injection
$result = pg_query_params($con, "INSERT INTO contact_messages (name, email, subject, message) VALUES ($1, $2, $3, $4)", array($name, $email, $subject, $message));
if ($result) pg_free_result($result);
pg_close($con);
echo '<script>location.replace(document.referrer);</script>';
?>