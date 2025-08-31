<?php 
ob_start(); 
require 'config.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

$query = mysqli_query($con, "INSERT INTO `contactano_lc`(`name`,`phone`, `email`, `message`) VALUES ('".$name."', '".$phone."','".$email."','".$message."')");
echo '<script>alert("We will contact you shortly"); location.replace(document.referrer);</script>';
?>