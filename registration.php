<?php
include_once('includes/config.php');
require_once 'includes/send_mail.php'; // Make sure send_mail.php path is correct

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $emailid = $_POST['emailid'];
    $username = $_POST['username'];
    $npwd = md5($_POST['newpassword']); // Note: md5 is outdated and insecure for passwords. Consider stronger hashing like bcrypt.

    // Check if email or username already exists using prepared statements
    $stmt_check = mysqli_prepare($con, "SELECT id FROM tblregistration WHERE emailId=? OR username=?");
    mysqli_stmt_bind_param($stmt_check, 'ss', $emailid, $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);
    $count = mysqli_stmt_num_rows($stmt_check);
    mysqli_stmt_close($stmt_check);

    if ($count == 0) {
        $activation_code = md5(rand() . time());
        // Insert user with activation code using prepared statements
        $stmt_insert = mysqli_prepare($con, "INSERT INTO tblregistration(firstName, lastName, emailId, username, userPassword, activation_code, is_active) VALUES (?, ?, ?, ?, ?, ?, 0)");
        mysqli_stmt_bind_param($stmt_insert, 'ssssss', $fname, $lname, $emailid, $username, $npwd, $activation_code);

        if (mysqli_stmt_execute($stmt_insert)) {
            mysqli_stmt_close($stmt_insert);

            // Send activation email
            $to = $emailid;
            $subject = "Account Activation - Notes Management App";
            // Construct activation link carefully
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            $script_dir = dirname($_SERVER['PHP_SELF']);
            $activation_link = $protocol . "://" . $host . $script_dir . "/activate.php?code=" . urlencode($activation_code) . "&email=" . urlencode($emailid);

            $message = "Hi $fname $lname,\n\nPlease click the following link to activate your account:\n$activation_link\n\nIf you did not register, please ignore this email.";

            if (sendActivationMail($to, $subject, $message, "$fname $lname")) {
                echo "<script>alert('Registration successful. Please check your email to activate your account.');</script>";
                echo "<script>window.location.href ='login.php'</script>";
            } else {
                // Log the mail error if possible for debugging
                // error_log("Failed to send activation email to $emailid: " . $mail->ErrorInfo); // Requires $mail object from send_mail.php
                echo "<script>alert('Registration successful, but failed to send activation email. Please contact support.');</script>";
                echo "<script>window.location.href ='login.php'</script>"; // Redirect to login even if email failed
            }
        } else {
            mysqli_stmt_close($stmt_insert);
            echo "<script>alert('Something went wrong with database insertion. Please try again: " . mysqli_error($con) . "');</script>";
            echo "<script>window.location.href ='registration.php'</script>";
        }
    } else {
        echo "<script>alert('Email or Username already registered. Please try again.');</script>";
        echo "<script>window.location.href ='registration.php'</script>";
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
    <title>Notes Management App | Register </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/light.css" rel="stylesheet" id="theme-stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        /* Paste the entire <style> block from your login.php here */
        /* LIGHT MODE & GENERAL */

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa, rgb(233, 247, 245));
            color: #111;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            background-color: transparent;
            /* overridden by gradient */
            color: #111;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Remove animated background blur in light mode */
        body:not(.dark-mode)::before {
            content: none;
        }

        .login-card {
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            /* Adjusted max-width for more form fields */
            color: #111;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Adjusted style for the logo image */
        .login-card img {
            max-width: 200px;
            /* Adjust as needed */
            display: block;
            margin: 0 auto 1.5rem auto;
            /* Center image and add bottom margin */
            height: auto;
            /* Maintain aspect ratio */
        }

        /* === NEW: Invert logo colors in light mode === */
        body:not(.dark-mode) .login-card img {
            filter: invert(1);
        }

        /* =========================================== */


        .login-card h3 {
            /* This h3 was replaced by the img tag */
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* New style for the registration title */
        .login-card h4 {
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }


        label {
            color: #555;
            transition: color 0.3s ease;
        }

        input.form-control {
            background-color: #fff;
            border: 1px solid #ccc;
            color: #111;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        input.form-control:focus {
            background-color: #fff;
            border-color: #007aff;
            /* Apple blue highlight */
            color: #111;
            box-shadow: 0 0 5px rgba(0, 122, 255, 0.5);
        }

        .btn-primary {
            background-color: #007aff;
            border-color: #007aff;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 1.2rem;
            width: 100%;
            transition: background-color 0.3s ease;
            color: white;
        }

        .btn-primary:hover {
            background-color: #005ecb;
            border-color: #005ecb;
        }

        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }

        /* Password toggle button inside input */
        .position-relative {
            position: relative;
        }

        .btn-outline-secondary {
            color: #888;
            border-color: #ccc;
            background-color: transparent;
            padding: 0.25rem 0.5rem;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #e5e5e5;
            color: #005ecb;
            border-color: #005ecb;
        }

        .btn-outline-secondary:focus {
            box-shadow: none;
        }

        .position-absolute {
            position: absolute !important;
        }

        .top-50 {
            top: 50% !important;
        }

        .end-0 {
            right: 0 !important;
        }

        .translate-middle-y {
            transform: translateY(-50%);
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        a.small {
            color: #007aff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        a.small:hover {
            text-decoration: underline;
            color: #005ecb;
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid #ddd;
            color: #555;
            text-align: center;
            transition: color 0.3s ease, border-color 0.3s ease;
        }

        .card-footer .small a {
            color: #555;
        }

        .card-footer .small a:hover {
            color: #007aff;
        }

        @media (max-width: 576px) {
            .login-card {
                margin: 1rem;
                padding: 1.5rem;
                max-width: 100%;
            }
        }

        /* DARK MODE */

        /* Dark mode toggle button */
        .dark-mode-toggle {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1050;
        }

        .dark-mode-toggle button {
            background: none;
            border: none;
            color: #eee;
            font-size: 1.5rem;
            cursor: pointer;
            outline: none;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease-in-out;
        }

        .dark-mode-toggle button:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Dark mode overrides */
        body.dark-mode {
            background: linear-gradient(135deg, rgb(54, 54, 54), rgb(39, 39, 39));
            color: #eee;
        }

        body.dark-mode .login-card {
            background: rgba(45, 45, 45, 0.9);
            color: #eee;
        }

        body.dark-mode label {
            color: #ddd;
        }

        body.dark-mode input.form-control {
            background-color: #333;
            border-color: #666;
            color: #eee;
        }

        body.dark-mode input.form-control:focus {
            background-color: #444;
            border-color: #bbb;
            color: #fff;
        }

        body.dark-mode .btn-primary {
            background-color: #495057;
            border-color: #495057;
        }

        body.dark-mode .btn-primary:hover {
            background-color: #343a40;
            border-color: #343a40;
        }

        body.dark-mode .btn-outline-secondary {
            color: #ddd;
            border-color: #888;
        }

        body.dark-mode .btn-outline-secondary:hover {
            background-color: #666;
            color: #fff;
            border-color: #bbb;
        }

        body.dark-mode .card-footer {
            color: #ccc;
            border-color: #666;
        }

        body.dark-mode a.small {
            color: #ccc;
        }

        body.dark-mode a.small:hover {
            color: #fff;
        }

        body.dark-mode .card-footer .small a {
            color: #ccc;
        }

        body.dark-mode .card-footer .small a:hover {
            color: #fff;
        }

        /* Animated background similar to home page hero - only dark mode */
        body.dark-mode::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: radial-gradient(circle at 20% 30%, rgb(63, 63, 63), transparent 50%),
                radial-gradient(circle at 80% 20%, rgb(41, 41, 41), transparent 50%),
                radial-gradient(circle at 50% 70%, rgb(110, 163, 248), transparent 60%),
                radial-gradient(circle at 70% 90%, rgb(48, 48, 48), transparent 60%);
            background-blend-mode: overlay;
            filter: blur(30px) brightness(1.1);
            animation: moveBackground 20s infinite ease-in-out;
            z-index: -1;
        }

        @keyframes moveBackground {
            0% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-10px, 10px);
            }

            100% {
                transform: translate(0, 0);
            }
        }
    </style>

    <script>
        function valid() {
            // Check if passwords match
            if (document.registration.newpassword.value != document.registration.confirmpassword.value) {
                alert("Password and Confirm Password fields do not match!");
                document.registration.confirmpassword.focus();
                return false;
            }
            // Check if mobile number field exists and validate (assuming it's still needed based on your original script comment)
            // Note: Your provided registration HTML doesn't have a mobileno field.
            // If you add a mobileno field, uncomment and adjust the validation below:
            /*
            const mobileInput = document.registration.mobileno;
            if (mobileInput) { // Check if the element exists
                if (mobileInput.value.length !== 10) {
                    alert("Mobile Number not valid! It should be 10 digits.");
                    mobileInput.focus();
                    return false;
                }
            }
            */

            return true; // If all checks pass
        }

        // Dark mode toggle handler (copied from login.php)
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            // Optional: Save preference in localStorage
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.removeItem('darkMode');
            }
        }

        // On page load: apply saved preference (copied from login.php)
        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
            }
        });
    </script>
</head>

<body>
    <div class="dark-mode-toggle">
        <button onclick="toggleDarkMode()" title="Toggle Dark Mode">
            <i class="fa fa-adjust"></i>
        </button>
    </div>

    <main class="d-flex align-items-center justify-content-center w-100 h-100">
        <div class="login-card shadow-lg">
            <img src="assets/img/logo.png" alt="Notes Management App Logo" style="max-width: 200px; display: block; margin: 0 auto 1.5rem auto;">

            <h4 class="text-center mb-4">User Registration</h4>
            <form method="post" name="registration" onSubmit="return valid();">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputFirstName" type="text" name="fname" placeholder="Enter your first name" required />
                            <label for="inputFirstName">First name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputLastName" type="text" name="lname" placeholder="Enter your last name" required />
                            <label for="inputLastName">Last name</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputEmail" type="email" name="emailid" placeholder="name@example.com" required />
                    <label for="inputEmail">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" name="username" maxlength="20" required /> <label for="inputUsername">Username</label>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" name="newpassword" required />
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" name="confirmpassword" required />
                            <label for="inputPasswordConfirm">Confirm Password</label>
                        </div>
                    </div>
                </div>
                <div class="d-grid mb-3 mt-4"> <button type="submit" name="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>

            <div class="card-footer text-center py-3">
                <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                <hr>
                <div class="small"><a href="index.php">Back to Home Page</a></div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>