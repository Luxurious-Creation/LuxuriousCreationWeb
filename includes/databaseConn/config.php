<?php
ob_start(); //Turns on output buffering 

// Set timezone
$timezone = date_default_timezone_set("Europe/London");

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "luxurious_creation";

// Create connection
$con = mysqli_connect($host, $username, $password, $database);

// Check connection
if(mysqli_connect_errno()) 
{
    die("Database connection failed: " . mysqli_connect_error());
}

// Set charset to utf8mb4 for better character support
mysqli_set_charset($con, "utf8mb4");

// Enable error reporting in development (remove in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>