<?php
ob_start();
// Use your Supabase credentials
$host = "aws-1-us-east-1.pooler.supabase.com";
$port = "6543";
$dbname = "postgres";
$user = "postgres.etwqavsycsuchuovnuui";
$password = "d7xi4UUQlPizla1Z";
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require";
$con = pg_connect($conn_string);
if (!$con) {
    die("Database connection failed: " . pg_last_error());
}
