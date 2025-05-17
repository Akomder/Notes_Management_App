<?php
session_start();
include_once('includes/config.php');
if(strlen($_SESSION["noteid"])==0){
    header('location:logout.php');
}
else {
    if(isset($_POST['submit'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $id = intval($_SESSION["noteid"]);

        $avatarName = null; // Initialize avatarName to null

        if (!empty($_POST['croppedImage'])) {
            $croppedData = $_POST['croppedImage'];

            // Extract base64 data
            list($type, $data) = explode(';', $croppedData);
            list(, $data)      = explode(',', $data);
            $decodedData = base64_decode($data);

            // Detect extension from mime type
            if (strpos($type, 'image/jpeg') !== false) $ext = 'jpg';
            elseif (strpos($type, 'image/png') !== false) $ext = 'png';
            elseif (strpos($type, 'image/gif') !== false) $ext = 'gif';
            else $ext = 'jpg'; // fallback

            $avatarName = time() . '.' . $ext;
            $targetPath = 'uploads/' . $avatarName;

            // Ensure the uploads directory exists
            if (!is_dir(__DIR__ . '/uploads/')) {
                mkdir(__DIR__ . '/uploads/', 0777, true);
            }

            // Save new avatar file
            if (file_put_contents($targetPath, $decodedData) === FALSE) {
                 // Handle file saving error
                 echo "<script>alert('Error saving new avatar file.');</script>";
                 $avatarName = null; // Reset avatarName if saving failed
            } else {
                 // Delete old avatar if exists and new one saved successfully
                 // FIX: Check if 'avatar' key exists in $oldRow before accessing it
                $oldResult = mysqli_query($con, "SELECT avatar FROM tblregistration WHERE id='$id'");
                $oldRow = mysqli_fetch_assoc($oldResult);
                if ($oldRow && isset($oldRow['avatar']) && $oldRow['avatar'] && file_exists('uploads/' . $oldRow['avatar'])) {
                    // Optional: Add a check to ensure the old avatar is not the default one before deleting
                    $oldAvatarFilename = basename($oldRow['avatar']);
                    if ($oldAvatarFilename !== 'default-avatar.png') {
                         unlink('uploads/' . $oldRow['avatar']);
                    }
                }
            }
        }

        // Prepare the update query based on whether a new avatar was saved
        if ($avatarName !== null) {
             $sql = mysqli_prepare($con, "UPDATE tblregistration SET firstName=?, lastName=?, avatar=? WHERE id=?");
             mysqli_stmt_bind_param($sql, 'sssi', $fname, $lname, $avatarName, $id);
        } else {
             $sql = mysqli_prepare($con, "UPDATE tblregistration SET firstName=?, lastName=? WHERE id=?");
             mysqli_stmt_bind_param($sql, 'ssi', $fname, $lname, $id);
        }


        // Execute the update query
        if (mysqli_stmt_execute($sql)) {
             echo "<script>alert('Profile Updated successfully');</script>";
             echo "<script>window.location.href='my-profile.php'</script>";
        } else {
             echo "<script>alert('Failed to update profile: " . mysqli_error($con) . "');</script>";
        }

        mysqli_stmt_close($sql); // Close the prepared statement
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
    <title>My Profile | Notes Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        /* Paste the entire <style> block from your dashboard.php here */
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

        body.dark-mode .card {
            background-color: #2c2c2e !important;
            color: #f2f2f7 !important;
            border-color: #3a3a3c !important;
        }

        body.dark-mode .card-header {
            background-color: #3a3a3c !important;
            color: #f2f2f7 !important;
            border-color: #3a3a3c !important;
        }

        body.dark-mode .card-footer {
            background-color: #3a3a3c !important;
            border-color: #3a3a3c !important;
        }

        body.dark-mode .text-white {
            color: #f2f2f7 !important;
        }

        body.dark-mode .text-white-75 {
            color: rgba(242, 242, 247, 0.75) !important;
        }

        body.dark-mode .text-white-50 {
            color: rgba(242, 242, 247, 0.5) !important;
        }

        body.dark-mode .breadcrumb-item.active {
            color: #f2f2f7 !important;
        }

        body.dark-mode .breadcrumb-item a {
            color: #bf5aff !important;
        }

        /* Cards - Dashboard style */
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            border: none;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            font-weight: 600;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .card-footer {
            background-color: #ffffff;
            border-top: 1px solid #e0e0e0;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Buttons - Dashboard style */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.2s ease, opacity 0.2s ease;
        }

        .btn-primary {
            background-color: #007aff;
            border-color: #007aff;
        }

        .btn-primary:hover {
            background-color: #005ce6;
            border-color: #005ce6;
            opacity: 0.9;
        }

        .btn-danger {
            background-color: #ff3b30;
            border-color: #ff3b30;
        }

        .btn-danger:hover {
            background-color: #cc2d24;
            border-color: #cc2d24;
            opacity: 0.9;
        }

         /* Form controls - Basic styling to fit the theme */
         .form-control {
             border-radius: 8px;
             border-color: #ced4da;
             transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
         }

         .form-control:focus {
             border-color: #007aff;
             box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
         }

        body.dark-mode .form-control {
            background-color: #3a3a3c;
            color: #f2f2f7;
            border-color: #505052;
        }

        body.dark-mode .form-control:focus {
             border-color: #0a84ff;
             box-shadow: 0 0 0 0.25rem rgba(10, 132, 255, 0.25);
        }


        /* Table - Dashboard style (if applicable) */
        #datatablesSimple { /* Adjust if your table has a different ID/class */
             border-collapse: separate;
             border-spacing: 0;
             border-radius: 10px;
             overflow: hidden;
             border: 1px solid #e0e0e0;
        }

         body.dark-mode #datatablesSimple {
              border-color: #3a3a3c;
         }

        #datatablesSimple thead th {
             background-color: #e0e0e0;
             font-weight: 600;
             color: #1c1c1e;
             border-bottom: 1px solid #d0d0d0;
             padding: 12px 15px;
         }

         body.dark-mode #datatablesSimple thead th {
             background-color: #3a3a3c;
             color: #f2f2f7;
             border-bottom-color: #505052;
         }

        #datatablesSimple tbody tr {
             border-bottom: 1px solid #e9e9eb;
             transition: background-color 0.2s ease;
         }

         body.dark-mode #datatablesSimple tbody tr {
             border-bottom-color: #3a3a3c;
         }


        #datatablesSimple tbody tr:last-child {
             border-bottom: none;
         }

        #datatablesSimple tbody td {
             background-color: #ffffff;
             color: #1c1c1e;
              padding: 12px 15px;
         }

         body.dark-mode #datatablesSimple tbody td {
             background-color: #2c2c2e;
             color: #f2f2f7;
         }

         #datatablesSimple tbody tr:hover td {
             background-color: #f5f5f5;
         }

         body.dark-mode #datatablesSimple tbody tr:hover td {
             background-color: #3a3a3c;
         }


        /* Dashboard Header with Description (if applicable to this page) */
        .dashboard-header-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .dashboard-header-container h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1c1c1e;
            margin-bottom: 5px;
        }

         body.dark-mode .dashboard-header-container h1 {
             color: #f2f2f7;
         }

        .dashboard-description {
            font-size: 1rem;
            color: #636366;
            margin-bottom: 0;
        }

         body.dark-mode .dashboard-description {
            color: #8e8e93;
         }


        /* Dark mode toggle button (if present on this page) */
        #darkModeToggle {
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            background-color: #e0e0e0;
            color: #1c1c1e;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s ease, opacity 0.2s ease;
        }

        body.dark-mode #darkModeToggle {
            background-color: #3a3a3c;
            color: #f2f2f7;
        }

        #darkModeToggle:hover {
            opacity: 0.9;
        }

        /* Cropper Modal Styles (from my-profile.php) */
         /* Using Bootstrap Modal structure */
        #imageCropModal.modal {
             position: fixed;
             top: 0;
             left: 0;
             z-index: 1055; /* Higher z-index */
             display: none; /* Hidden by default */
             width: 100%;
             height: 100%;
             overflow-x: hidden;
             overflow-y: auto;
             outline: 0;
             background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent backdrop */
        }

        #imageCropModal .modal-dialog {
            margin: 1.75rem auto;
            max-width: 700px; /* Adjust max-width as needed */
        }

        #imageCropModal .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            color: #1c1c1e; /* Dark text */
            pointer-events: auto;
            background-color: #fff; /* White background */
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem; /* Subtle border radius */
            outline: 0;
        }

         body.dark-mode #imageCropModal .modal-content {
             background-color: #2c2c2e;
             color: #f2f2f7;
             border-color: #3a3a3c;
         }


        #imageCropModal .modal-header {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: calc(0.3rem - 1px);
            border-top-right-radius: calc(0.3rem - 1px);
        }

         body.dark-mode #imageCropModal .modal-header {
             border-bottom-color: #3a3a3c;
         }


        #imageCropModal .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 1rem;
        }
         #imageCropModal .modal-body .img-container { /* Style for cropper container */
             max-width: 100%;
             max-height: 400px; /* Limit height for larger images */
         }


        #imageCropModal .modal-footer {
            display: flex;
            flex-wrap: wrap;
            flex-shrink: 0;
            align-items: center;
            justify-content: flex-end;
            padding: 0.75rem;
            border-top: 1px solid #dee2e6;
            border-bottom-right-radius: calc(0.3rem - 1px);
            border-bottom-left-radius: calc(0.3rem - 1px);
        }

         body.dark-mode #imageCropModal .modal-footer {
              border-top-color: #3a3a3c;
         }


        #imageCropModal .btn-close {
             box-sizing: content-box;
             width: 1em;
             height: 1em;
             padding: 0.25em 0.25em;
             color: #000;
             background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
             border: 0;
             border-radius: 0.25rem;
             opacity: 0.5;
         }

          body.dark-mode #imageCropModal .btn-close {
              filter: invert(1); /* Make close button white in dark mode */
          }

        #imageCropModal .btn-close:hover {
            opacity: 1;
        }


    </style>
</head>
<body class="sb-nav-fixed">
    <?php include_once('includes/header.php');?>
    <div id="layoutSidenav">
        <?php include_once('includes/leftbar.php');?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">My Profile</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                             <i class="fas fa-user me-1"></i>
                             Profile Information
                        </div>
                        <div class="card-body">
                            <?php
                                $id = intval($_SESSION["noteid"]);
                                $query = mysqli_query($con, "SELECT * FROM tblregistration WHERE id='$id'");
                                $row = mysqli_fetch_array($query);
                            ?>
                            <form method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-md-3 col-form-label">Profile Picture</div> <div class="col-md-6">
                                        <?php
                                            $avatarSrc = 'assets/img/default-avatar.png'; // Default avatar path
                                            // FIX: Check if 'avatar' key exists in $row before accessing it
                                            if (isset($row['avatar']) && $row['avatar'] && file_exists('uploads/' . $row['avatar'])) {
                                                $avatarSrc = 'uploads/' . htmlentities($row['avatar']);
                                            }
                                        ?>
                                        <img id="currentAvatar" src="<?php echo $avatarSrc; ?>" alt="Current Avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                        <br>
                                        <input type="file" class="form-control mt-2" id="avatarInput" name="avatar" accept="image/*">
                                        <input type="hidden" id="croppedImage" name="croppedImage"> </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fname" class="col-md-3 col-form-label">First Name</label>
                                    <div class="col-md-6">
                                        <input type="text" value="<?php echo  htmlentities($row['firstName']);?>"  name="fname" id="fname" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="lname" class="col-md-3 col-form-label">Last Name</label>
                                    <div class="col-md-6">
                                        <input type="text" value="<?php echo  htmlentities($row['lastName']);?>"  name="lname" id="lname" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                     <label for="emailid" class="col-md-3 col-form-label">Email Id</label>
                                     <div class="col-md-6">
                                          <input type="email" value="<?php echo  htmlentities($row['emailId']);?>"  name="emailid" id="emailid" class="form-control" readonly> </div>
                                 </div>

                                  <div class="row mb-3">
                                      <label for="username" class="col-md-3 col-form-label">Username</label>
                                      <div class="col-md-6">
                                           <input type="text" value="<?php echo  htmlentities($row['username']);?>"  name="username" id="username" class="form-control" readonly> </div>
                                  </div>

                                 <div class="row mb-3">
                                     <label for="regDate" class="col-md-3 col-form-label">Registration Date</label>
                                     <div class="col-md-6">
                                          <input type="text" value="<?php echo  htmlentities($row['regDate']);?>"  name="regDate" id="regDate" class="form-control" readonly> </div>
                                 </div>


                                <div class="mt-4 row">
                                     <div class="col-md-3"></div> <div class="col-md-6">
                                        <button type="submit" name="submit" class="btn btn-primary">Update Profile</button>
                                     </div>
                                </div>
                            </form>
                        </div>
                    </div>

                     <div class="modal fade" id="imageCropModal" tabindex="-1" aria-labelledby="imageCropModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="imageCropModalLabel">Crop Profile Picture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="img-container">
                                <img id="imageToCrop" style="max-width: 100%; display: block;" src="#" alt="Picture to crop">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="cropButton">Crop & Save</button>
                          </div>
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
     <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
         // JavaScript for Cropper.js modal
        const avatarInput = document.getElementById('avatarInput');
        const imageToCrop = document.getElementById('imageToCrop');
        const cropButton = document.getElementById('cropButton');
        const croppedImageInput = document.getElementById('croppedImage');
        const currentAvatar = document.getElementById('currentAvatar'); // To update preview
        let cropper; // Variable to hold the cropper instance

        // Use Bootstrap's modal instance
        const imageCropModal = new bootstrap.Modal(document.getElementById('imageCropModal'), {
             keyboard: false // Prevent closing with keyboard
        });

         // Max file size 2MB (added in a previous step)
        const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB


        avatarInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];

                // Check file size
                if(file.size > MAX_FILE_SIZE){
                    alert('File size exceeds 2MB. Please choose a smaller file.');
                    avatarInput.value = ""; // Reset input
                    return;
                }


                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file.');
                    avatarInput.value = ""; // Reset input
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    imageCropModal.show(); // Show Bootstrap modal

                    // Destroy existing cropper instance if any
                    if (cropper) {
                        cropper.destroy();
                    }

                    // Initialize Cropper.js
                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 1, // Square crop box
                        viewMode: 1, // View the canvas in the container
                        movable: true,
                        zoomable: true,
                        rotatable: false,
                        scalable: false,
                        minCropBoxWidth: 100,
                        minCropBoxHeight: 100,
                        background: false, // Hide cropper background
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        cropButton.addEventListener('click', function() {
            if (!cropper) return;

            // Get cropped canvas data URL
            cropper.getCroppedCanvas({
                width: 200, // Output width
                height: 200, // Output height
                imageSmoothingQuality: 'high'
            }).toDataURL('image/jpeg', 0.9, function(base64data) { // Get data URL, 0.9 quality
                 croppedImageInput.value = base64data; // Store base64 data in hidden input
                 currentAvatar.src = base64data; // update preview immediately
                 imageCropModal.hide(); // Hide Bootstrap modal
                 // Clean up cropper
                 cropper.destroy();
                 cropper = null; // Set to null to allow new instance later
            });
        });

        // Reset input and cropper on modal close
        document.getElementById('imageCropModal').addEventListener('hidden.bs.modal', function () {
             avatarInput.value = ""; // Reset file input
             if(cropper) {
                cropper.destroy();
                cropper = null;
             }
        });


         // Dark mode toggle handler (ensure this function is available globally or within a script tag)
            // Assuming this is already in scripts.js or included elsewhere. If not, copy from dashboard/login.php
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
</body>
</html>
<?php } ?>