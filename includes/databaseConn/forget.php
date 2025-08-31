<?php 
ob_start(); 
require 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$npassword = $_POST['newPassword'];


// Use prepared statements to prevent SQL injection

$result1 = pg_query_params($con, "SELECT * FROM register_lc WHERE username = $1", array($username));
$flag = false;
if($rows = pg_fetch_assoc($result1)){
    $flag = true;
}
if ($result1) pg_free_result($result1);

if($flag){
    if($password == $npassword){
        // Hash the new password before saving
        $hashed_new_password = password_hash($npassword, PASSWORD_DEFAULT);
    $result2 = pg_query_params($con, "UPDATE login_lc SET password = $1 WHERE username = $2", array($hashed_new_password, $username));
    $result3 = pg_query_params($con, "UPDATE register_lc SET password = $1 WHERE username = $2", array($hashed_new_password, $username));
    if ($result2) pg_free_result($result2);
    if ($result3) pg_free_result($result3);
    pg_close($con);
    echo '<script>alert("Password Changed Successfully!"); location.replace(document.referrer);</script>';
    }else{
        echo '<script>alert("New passwords did not matched! Try Again!"); location.replace(document.referrer);</script>';
    }
}else{
    echo '<script>alert("No account found with this Username! Try Again!"); location.replace(document.referrer);</script>';
}

?>