<?php 
ob_start(); 
require 'config.php';

$rating = $_POST['rating'];
$category = $_POST['category'];
$name = $_POST['name'];
$comments = $_POST['comments'];
$email = $_POST['email'];
$num = $_POST['num'];


// Use prepared statements to prevent SQL injection
$result = pg_query_params($con, "INSERT INTO feedback_lc (name, email, phone, category, rating, suggestions) VALUES ($1, $2, $3, $4, $5, $6)", array($name, $email, $num, $category, $rating, $comments));
if ($result) pg_free_result($result);
pg_close($con);
echo '<script>location.replace(document.referrer);</script>';
?>