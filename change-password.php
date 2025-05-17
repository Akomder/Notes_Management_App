<?php
    session_start();
    include_once('includes/config.php');
    if(strlen($_SESSION["noteid"])==0){
        header('location:logout.php');
    }
    else{
        if(isset($_POST['update'])){
            $uid=$_SESSION["noteid"];
            $currentpassword=$_POST['cpass']; // Get plain text password from form
            $newpassword=md5($_POST['newpass']); // Hash the new password (consider stronger hashing)

            // Using prepared statement to check current password safely
            $stmt_check = mysqli_prepare($con, "SELECT id FROM tblregistration WHERE id=? AND userPassword=?");
            // You need to hash the current password entered by the user for comparison
            $hashed_current_password = md5($currentpassword); // Hash the input
            mysqli_stmt_bind_param($stmt_check, 'is', $uid, $hashed_current_password);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);
            $num = mysqli_stmt_num_rows($stmt_check);
            mysqli_stmt_close($stmt_check);

            if($num>0){
                // Using prepared statement for password update
                $stmt_update = mysqli_prepare($con, "UPDATE tblregistration SET userPassword=? WHERE id=?");
                mysqli_stmt_bind_param($stmt_update, 'si', $newpassword, $uid);

                if(mysqli_stmt_execute($stmt_update)){
                     mysqli_stmt_close($stmt_update);
                    echo "<script>alert('Password changed successfully.');</script>";
                    echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
                }
                else{
                     mysqli_stmt_close($stmt_update);
                    echo "<script>alert('Error updating password: " . mysqli_error($con) . "');</script>";
                     echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
                }
            }
            else{
                echo "<script>alert('Current Password is wrong.');</script>";
                echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
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
        <title>Change Password | Notes Management System</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
         <link href="css/light.css" rel="stylesheet" id="theme-stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

        <style>
            /* Dashboard Background and general body styles */
            body {
                font-family: 'SF Pro Display', 'SF Pro Icons', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                background: linear-gradient(135deg, #f5f7fa,rgb(196, 200, 255)); /* Dashboard background */
                color: #111; /* Dashboard text color */
                transition: background-color 0.4s ease, color 0.4s ease;
            }

            /* Dark mode styles */
            body.dark-mode {
                background-color: #1c1c1e;
                color: #f2f2f7;
            }

            /* --- Styling for the Change Password Card (like login/recovery card) --- */
            .change-password-form-card {
                 background: #fff; /* White background in light mode */
                padding: 2rem; /* Increased padding */
                border-radius: 1rem; /* Rounded corners */
                box-shadow: 0 8px 24px rgba(0,0,0,0.1); /* Subtle shadow */
                width: 100%;
                max-width: 480px; /* Set a max-width */
                margin: 2rem auto; /* Center the card and add vertical margin */
                 color: #111; /* Dark text in light mode */
                transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
                 border: none; /* Remove default card border */
            }

             body.dark-mode .change-password-form-card {
                 background: rgba(45,45,45,0.9); /* Dark background in dark mode */
                 color: #eee; /* Light text in dark mode */
             }

             .change-password-form-card .card-header {
                 /* Hide the default card-header for a cleaner look like login page */
                 display: none;
             }

             .change-password-form-card .card-body {
                 padding: 0; /* Remove default card-body padding as padding is on the card itself */
             }

             .change-password-form-card h4 { /* Styling for the title inside the card */
                 font-weight: 600;
                 font-size: 1.5rem;
                 margin-bottom: 1.5rem;
                 text-align: center;
                 color: #111; /* Dark color in light mode */
                 transition: color 0.3s ease;
             }

             body.dark-mode .change-password-form-card h4 {
                 color: #eee; /* Light color in dark mode */
             }

             /* --- Form controls styling (from login page) --- */
             .change-password-form-card .form-floating {
                margin-bottom: 1.5rem;
                position: relative;
            }

             .change-password-form-card label {
                 color: #555;
                 transition: color 0.3s ease;
             }

             body.dark-mode .change-password-form-card label {
                 color: #ddd;
             }

             .change-password-form-card input.form-control {
                background-color: #fff;
                border: 1px solid #ccc;
                color: #111;
                transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            }

            .change-password-form-card input.form-control:focus {
                background-color: #fff;
                border-color: #007aff; /* Apple blue highlight */
                color: #111;
                box-shadow: 0 0 5px rgba(0, 122, 255, 0.5);
            }

             body.dark-mode .change-password-form-card input.form-control {
                 background-color: #333;
                 border-color: #666;
                 color: #eee;
             }

             body.dark-mode .change-password-form-card input.form-control:focus {
                 background-color: #444;
                 border-color: #bbb;
                 color: #fff;
             }

            /* --- Buttons styling (from login page) --- */
            .change-password-form-card .btn-primary {
                background-color: #007aff;
                border-color: #007aff;
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                border-radius: 50px;
                font-size: 1.2rem;
                width: 100%; /* Full width button */
                transition: background-color 0.3s ease;
                color: white;
            }
            .change-password-form-card .btn-primary:hover {
                background-color: #005ecb;
                border-color: #005ecb;
            }

             body.dark-mode .change-password-form-card .btn-primary {
                 background-color: #495057;
                 border-color: #495057;
                 color: #eee;
             }

             body.dark-mode .change-password-form-card .btn-primary:hover {
                 background-color: #343a40;
                 border-color: #343a40;
             }


            /* Password toggle button inside input */
            .change-password-form-card .position-relative {
                position: relative;
            }

            .change-password-form-card .btn-outline-secondary {
                color: #888;
                border-color: #ccc;
                background-color: transparent;
                padding: 0.25rem 0.5rem;
                transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            }
            .change-password-form-card .btn-outline-secondary:hover {
                background-color: #e5e5e5;
                color: #005ecb;
                border-color: #005ecb;
            }
            .change-password-form-card .btn-outline-secondary:focus {
                box-shadow: none;
            }

             body.dark-mode .change-password-form-card .btn-outline-secondary {
                 color: #ddd;
                 border-color: #888;
             }

             body.dark-mode .change-password-form-card .btn-outline-secondary:hover {
                 background-color: #666;
                 color: #fff;
                 border-color: #bbb;
             }


            .change-password-form-card .position-absolute {
                position: absolute !important;
            }
            .change-password-form-card .top-50 {
                top: 50% !important;
            }
            .change-password-form-card .end-0 {
                right: 0 !important;
            }
            .change-password-form-card .translate-middle-y {
                transform: translateY(-50%);
            }
            .change-password-form-card .me-2 {
                margin-right: 0.5rem !important;
            }

            /* --- Footer links (from login page) --- */
            .change-password-form-card .card-footer {
                background: transparent;
                border-top: 1px solid #ddd;
                color: #555;
                text-align: center;
                margin-top: 1.5rem; /* Add space above footer */
                padding-top: 1rem;
                transition: color 0.3s ease, border-color 0.3s ease;
            }

            body.dark-mode .change-password-form-card .card-footer {
                 color: #ccc;
                 border-color: #666;
             }

            .change-password-form-card .card-footer .small a {
                color: #555;
                text-decoration: none;
                font-size: 0.9rem;
            }
             body.dark-mode .change-password-form-card .card-footer .small a {
                 color: #ccc;
             }
            .change-password-form-card .card-footer .small a:hover {
                color: #007aff;
                text-decoration: underline;
             }
             body.dark-mode .change-password-form-card .card-footer .small a:hover {
                 color: #fff;
             }

            /* --- Standard dashboard styles for other elements on the page --- */
            /* Keep these for the breadcrumbs, h1, etc. */
             .card { /* Standard card styles */
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
                border: none;
                transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            }

            body.dark-mode .card {
                background-color: #2c2c2e !important;
                color: #f2f2f7 !important;
                border-color: #3a3a3c !important;
            }

            .card-header {
                background-color: #ffffff;
                border-bottom: 1px solid #e0e0e0;
                font-weight: 600;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            }

            body.dark-mode .card-header {
                background-color: #3a3a3c !important;
                color: #f2f2f7 !important;
                border-color: #3a3a3c !important;
            }
             /* ... other dashboard styles like breadcrumbs, table, etc. if needed on this page ... */


        </style>
         <script>
            function valid(){
                // Check if new password and confirm password match
                if(document.changepassword.newpass.value != document.changepassword.cnfpass.value){
                    alert("New Password and Confirm Password fields do not match!");
                    document.changepassword.cnfpass.focus();
                    return false;
                }
                 // Check if current password is empty
                 if(document.changepassword.cpass.value.length === 0){
                      alert("Please enter your current password.");
                      document.changepassword.cpass.focus();
                      return false;
                 }
                 // Check if new password meets a minimum length (optional)
                 if(document.changepassword.newpass.value.length < 6){ // Example: require at least 6 characters
                      alert("New password must be at least 6 characters long.");
                      document.changepassword.newpass.focus();
                      return false;
                 }
                return true; // If all checks pass
            }

             // Password toggle function
            function togglePassword(fieldId, iconId) {
                const passwordInput = document.getElementById(fieldId);
                const icon = document.getElementById(iconId);
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

            // Dark mode toggle handler (ensure this function is available globally or within a script tag)
            // Assuming this is already in scripts.js or included elsewhere. If not, add it here
            /*
            function toggleDarkMode() {
                document.body.classList.toggle('dark-mode');
                if(document.body.classList.contains('dark-mode')){
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    localStorage.removeItem('darkMode');
                }
            }
             window.addEventListener('DOMContentLoaded', () => {
                if(localStorage.getItem('darkMode') === 'enabled'){
                    document.body.classList.add('dark-mode');
                }
            });
            */
        </script>
    </head>
    <body class="sb-nav-fixed">
        <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
            <?php include_once('includes/leftbar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                         <h1 class="mt-4">Change Password</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>

                        <div class="card mb-4 change-password-form-card">
                            <div class="card-header">
                                <i class="fas fa-key me-1"></i>
                                Update Your Password
                            </div>
                            <div class="card-body">
                                 <h4 class="text-center mb-4">Change Your Password</h4>

                                <form name="changepassword" method="post" onSubmit="return valid();">
                                     <div class="form-floating position-relative mb-3">
                                        <input type="password" class="form-control" id="cpass" name="cpass" placeholder="Current Password" required="required" >
                                         <label for="cpass">Current Password</label>
                                         <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('cpass', 'toggleCurrentPasswordIcon')" aria-label="Toggle current password visibility" tabindex="-1">
                                             <i id="toggleCurrentPasswordIcon" class="fa fa-eye"></i>
                                         </button>
                                    </div>
                                    <div class="form-floating position-relative mb-3">
                                        <input type="password" class="form-control" id="newpass" name="newpass" placeholder="New Password" required="required" >
                                         <label for="newpass">New Password</label>
                                          <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('newpass', 'toggleNewPasswordIcon')" aria-label="Toggle new password visibility" tabindex="-1">
                                             <i id="toggleNewPasswordIcon" class="fa fa-eye"></i>
                                         </button>
                                    </div>
                                    <div class="form-floating position-relative mb-3">
                                        <input type="password" class="form-control" id="cnfpass" name="cnfpass" placeholder="Confirm Password" required="required" >
                                        <label for="cnfpass">Confirm Password</label>
                                         <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('cnfpass', 'toggleConfirmPasswordIcon')" aria-label="Toggle confirm password visibility" tabindex="-1">
                                             <i id="toggleConfirmPasswordIcon" class="fa fa-eye"></i>
                                         </button>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <input type="submit" name="update" id="update" class="btn btn-primary" value="Change Password" required>
                                    </div>
                                </form>

                                 <div class="card-footer text-center py-3">
                                     <div class="small"><a href="dashboard.php">Back to Dashboard</a></div>
                                     <hr>
                                     <div class="small"><a href="logout.php">Logout</a></div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
         <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>