<?php 
ob_start(); 
require 'config.php';

$rating = $_POST['rating'];
$category = $_POST['category'];
$name = $_POST['name'];
$comments = $_POST['comments'];
$email = $_POST['email'];
$num = $_POST['num'];


$query = mysqli_query($con, "INSERT INTO `feedback_lc`(`name`, `email`, `phone`, `category`, `rating`, `suggestions`) VALUES ('$name','$email','$num','$category', '$rating', '$comments')");
echo '<script>location.replace(document.referrer);</script>';
?>