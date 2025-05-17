<?php
include_once('includes/config.php');

if (isset($_GET['code']) && isset($_GET['email'])) {
    $email = $_GET['email'];
    $code = $_GET['code'];

    $query = mysqli_query($con, "SELECT * FROM tblregistration WHERE emailId='$email' AND activation_code='$code' AND is_active=0");

    if (mysqli_num_rows($query) > 0) {
        mysqli_query($con, "UPDATE tblregistration SET is_active=1, activation_code=NULL WHERE emailId='$email'");
        echo "Your account has been activated. You can now <a href='login.php'>login</a>.";
    } else {
        echo "Invalid or already used activation link.";
    }
}
