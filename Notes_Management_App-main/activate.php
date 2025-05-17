<?php
include_once('includes/config.php');
if(isset($_GET['code']) && isset($_GET['email'])){
    $code = $_GET['code'];
    $email = $_GET['email'];
    $query = mysqli_query($con, "SELECT id FROM tblregistration WHERE emailId='$email' AND activation_code='$code' AND is_active=0");
    if(mysqli_num_rows($query) > 0){
        mysqli_query($con, "UPDATE tblregistration SET is_active=1, activation_code=NULL WHERE emailId='$email'");
        echo "<script>alert('Account activated successfully. You can now login.');window.location='login.php';</script>";
    } else {
        echo "<script>alert('Invalid or expired activation link.');window.location='login.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.');window.location='login.php';</script>";
}
?>