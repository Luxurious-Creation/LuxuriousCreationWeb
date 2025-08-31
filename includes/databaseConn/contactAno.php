<?php 
ob_start(); 
require 'config.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

// Use prepared statements to prevent SQL injection
$result = pg_query_params($con, "INSERT INTO contactano_lc (name, phone, email, message) VALUES ($1, $2, $3, $4)", array($name, $phone, $email, $message));
if ($result) pg_free_result($result);
pg_close($con);
echo '<script>alert("We will contact you shortly"); location.replace(document.referrer);</script>';
?>