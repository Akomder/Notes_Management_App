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

            // Save new avatar file
            file_put_contents($targetPath, $decodedData);

            // Delete old avatar if exists
            $oldResult = mysqli_query($con, "SELECT avatar FROM tblregistration WHERE id='$id'");
            $oldRow = mysqli_fetch_assoc($oldResult);
            if ($oldRow['avatar'] && file_exists('uploads/' . $oldRow['avatar'])) {
                unlink('uploads/' . $oldRow['avatar']);
            }

            $sql = mysqli_query($con, "UPDATE tblregistration SET firstName='$fname', lastName='$lname', avatar='$avatarName' WHERE id='$id'");

        } else {
            // No avatar uploaded/cropped
            $sql = mysqli_query($con, "UPDATE tblregistration SET firstName='$fname', lastName='$lname' WHERE id='$id'");
        }

        echo "<script>alert('Profile Updated successfully');</script>";
        echo "<script>window.location.href='my-profile.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Notes Management App </title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        #cropperModal {
            display:none; 
            position:fixed; 
            top:10%; left:10%; 
            width:80%; height:80%; 
            background:#fff; 
            border:1px solid #ccc; 
            z-index:1050; 
            padding:10px; 
            box-sizing:border-box;
            overflow: auto;
        }
    </style>
</head>
<body>
    <?php include_once('includes/header.php');?>
    <div id="layoutSidenav">
        <?php include_once('includes/leftbar.php');?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Update Profile</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update Profile</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php
                                $id = intval($_SESSION["noteid"]);
                                $query = mysqli_query($con, "SELECT * FROM tblregistration WHERE id='$id'");
                                $row = mysqli_fetch_array($query);
                            ?>	                            	
                            <form method="post" enctype="multipart/form-data">                                
                                <div class="row mb-3">
                                    <div class="col-3">Profile Picture</div>
                                    <div class="col-4">
                                        <?php if ($row['avatar']) { ?>
                                            <img id="currentAvatar" src="uploads/<?php echo htmlentities($row['avatar']); ?>" width="100" height="100" style="border-radius: 50%; border:1px solid #ccc;">
                                        <?php } else { ?>
                                            <img id="currentAvatar" src="uploads/default-avatar.png" width="100" height="100" style="border-radius: 50%; border:1px solid #ccc;">
                                        <?php } ?>
                                        <br>
                                        <input type="file" id="avatarInput" accept="image/*" class="form-control mt-2" />
                                        <input type="hidden" name="croppedImage" id="croppedImage" />
                                    </div>
                                </div>

                                <!-- Cropper modal -->
                                <div id="cropperModal">
                                    <h5>Crop your picture</h5>
                                    <div>
                                        <img id="imageToCrop" style="max-width:100%; max-height:70vh; display:block; margin:auto;" />
                                    </div>
                                    <button type="button" id="cropBtn" class="btn btn-success mt-2">Crop & Upload</button>
                                    <button type="button" id="cancelCropBtn" class="btn btn-secondary mt-2">Cancel</button>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-3">First name</div>
                                    <div class="col-4"><input type="text" value="<?php echo htmlentities($row['firstName']); ?>" name="fname" class="form-control" required></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">Last Name</div>
                                    <div class="col-4"><input type="text" value="<?php echo htmlentities($row['lastName']); ?>" name="lname" class="form-control" required></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">Email</div>
                                    <div class="col-4"><input type="text" value="<?php echo htmlentities($row['emailId']); ?>" name="emailid" class="form-control" readonly></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">Username</div>
                                    <div class="col-4"><input type="text" value="<?php echo htmlentities($row['username']); ?>" name="username" class="form-control" readonly></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">Reg. Date</div>
                                    <div class="col-4"><input type="text" value="<?php echo htmlentities($row['regDate']); ?>" name="regdate" class="form-control" readonly></div>
                                </div>
                                <div class="row mb-3" align="center">
                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('includes/footer.php');?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        const avatarInput = document.getElementById('avatarInput');
        const cropperModal = document.getElementById('cropperModal');
        const imageToCrop = document.getElementById('imageToCrop');
        const cropBtn = document.getElementById('cropBtn');
        const cancelCropBtn = document.getElementById('cancelCropBtn');
        const croppedImageInput = document.getElementById('croppedImage');
        const currentAvatar = document.getElementById('currentAvatar');
        let cropper;

        // Max file size 2MB
        const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

        avatarInput.addEventListener('change', function(e){
            const file = e.target.files[0];
            if(!file) return;

            // Check file size
            if(file.size > MAX_FILE_SIZE){
                alert('File size exceeds 2MB. Please choose a smaller file.');
                avatarInput.value = ""; // Reset input
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event){
                imageToCrop.src = event.target.result;
                cropperModal.style.display = "block";

                if(cropper) cropper.destroy();
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 1,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                    minCropBoxWidth: 100,
                    minCropBoxHeight: 100,
                    background: false,
                });
            };
            reader.readAsDataURL(file);
        });

        cropBtn.addEventListener('click', function(){
            if(!cropper) return;

            cropper.getCroppedCanvas({
                width: 200,
                height: 200,
                imageSmoothingQuality: 'high'
            }).toBlob(function(blob){
                const reader = new FileReader();
                reader.onloadend = function() {
                    croppedImageInput.value = reader.result;
                    currentAvatar.src = reader.result; // update preview immediately
                    cropperModal.style.display = "none";
                }
                reader.readAsDataURL(blob);
            }, 'image/jpeg');
        });

        cancelCropBtn.addEventListener('click', function(){
            cropperModal.style.display = "none";
            avatarInput.value = ""; // Reset input
        });
    </script>
</body>
</html>
<?php } ?>
