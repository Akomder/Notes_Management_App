<?php
    session_start();
    include_once('includes/config.php');
    if(isset($_POST['login'])){
            $emailcon=$_POST['logindetail'];
            $password=md5($_POST['userpassword']);
            $query = mysqli_query($con, "SELECT * FROM tblregistration WHERE (emailId='$emailcon' || username='$emailcon') AND userPassword='$password'");
            $user = mysqli_fetch_assoc($query);
            if($user){
               // if($user['is_active'] == 1){//
                    $_SESSION['noteid']=$user['id'];
                    $_SESSION['uemail']=$user['emailId'];
                    echo "<script>window.location.href='dashboard.php'</script>";
                //} else {
                //  echo "<script>alert('Please activate your account via the email sent to you.');window.location='login.php';</script>";
                //}
            } else {
                echo "<script>alert('Invalid credentials');</script>";
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
        <title>Notes Management App</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script>
            function valid(){
            if(document.login.logindetail.tostring().length !== 10){
                alert("Username not valid");
                document.login.logindetail.focus();
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
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Notes Management App</h3></div>
                                <h3 class="text-center font-weight-light my-4">User Login</h3>
                                <div class="card-body">
                                    <form  name="login" method="post" onsubmit="return valid();">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" name="logindetail" placeholder="Registered Email id / Username" required />
                                            <label for="inputEmail">Enter username or email address</address></label>
                                        </div>
                                        <div class="form-floating mb-3 position-relative">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="userpassword" required />
                                            <label for="inputPassword">Password</label>
                                            <button type="button" class="btn btn-outline-secondary btn-sm position-absolute top-50 end-0 translate-middle-y me-2" 
                                                onclick="togglePassword()" tabindex="-1" style="z-index:2;">
                                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                            </button>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password-recovery.php">Forgot Password?</a>
                                            <button  class="btn btn-primary"  type="submit" name="login">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="registration.php">Need an account? Sign up!</a></div>
                                    <hr>
                                    <div class="small"><a href="index.php">Back to Home Page</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </main>
            </div>
            <?php include_once('includes/footer.php');?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('inputPassword');
                const icon = document.getElementById('togglePasswordIcon');
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = "password";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    </body>
</html>
