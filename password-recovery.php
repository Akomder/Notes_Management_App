<?php
session_start();
//error_reporting(0);
include("includes/config.php");
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $newpassword = md5($_POST['inputPassword']);

    // Check only by email/username
    $ret = mysqli_query($con, "SELECT id FROM tblregistration WHERE emailId='$username' OR username='$username'");
    $num = mysqli_num_rows($ret);
    if ($num > 0) {
        $query = mysqli_query($con, "UPDATE tblregistration SET userPassword='$newpassword' WHERE emailId='$username' OR username='$username'");
        echo "<script>alert('Password reset successfully.');</script>";
        echo "<script type='text/javascript'> document.location ='index.php'; </script>";
    } else {
        echo "<script>alert('Invalid username');</script>";
        echo "<script type='text/javascript'> document.location ='password-recovery.php'; </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Notes Management System </title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript">
            function valid(){
                if(document.passwordrecovery.inputPassword.value!= document.passwordrecovery.cinputPassword.value){
                    alert("Password and Confirm Password Field do not match  !!");
                    document.passwordrecovery.cinputPassword.focus();
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Notes Management System | Password Recovery</h3></div>
                                    <div class="card-body">
                                        <form method="post" name="passwordrecovery" onSubmit="return valid();">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="username" name="username" type="text" placeholder="Username" required />
                                                <label for="username">Email or username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Password" required />
                                                <label for="inputPassword">New Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="cinputPassword" name="cinputPassword" type="password" placeholder="Password" required />
                                                <label for="inputPassword">Confirm Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password-recovery.php">Forgot Password?</a>
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                        <div class="card-footer text-center py-3">
                                        <div class="small"><a href="index.php">Back to Home Page</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>