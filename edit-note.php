<?php
session_start();
include_once('includes/config.php');
if (strlen($_SESSION["noteid"]) == 0) {
    header('location:logout.php');
    exit();
}

$userid = $_SESSION["noteid"];
$noteid = isset($_GET['noteid']) ? intval($_GET['noteid']) : 0;

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_note'])) {
    $title = mysqli_real_escape_string($con, $_POST['noteTitle']);
    $category = mysqli_real_escape_string($con, $_POST['noteCategory']);
    $content = mysqli_real_escape_string($con, $_POST['noteContent']);

    // Handle image upload
    $imageName = isset($row['noteImage']) ? $row['noteImage'] : ''; // keep old image by default, added check
    if (isset($_FILES['noteImage']) && $_FILES['noteImage']['error'] === UPLOAD_ERR_OK) {
        $imgTmp = $_FILES['noteImage']['tmp_name'];
        $imgName = basename($_FILES['noteImage']['name']);
        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imgExt, $allowed)) {
            $newImgName = uniqid('note_', true) . '.' . $imgExt;
            $uploadPath = __DIR__ . '/uploads/' . $newImgName;
            // Ensure the uploads directory exists
            if (!is_dir(__DIR__ . '/uploads/')) {
                mkdir(__DIR__ . '/uploads/', 0777, true);
            }
            if (move_uploaded_file($imgTmp, $uploadPath)) {
                $imageName = $newImgName;
            }
        }
    }

    // Update the database
    $update = mysqli_query($con, "UPDATE tblnotes SET noteTitle='$title', noteCategory='$category', noteContent='$content', noteImage='$imageName' WHERE id='$noteid' AND createdBy='$userid'");
    if ($update) {
        echo "<script>alert('Note updated successfully');window.location='view-note.php?noteid=$noteid';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update note. Please try again.');</script>";
    }
}

// Fetch note
$row = null;
if ($noteid) {
    $query = mysqli_query($con, "SELECT * FROM tblnotes WHERE id='$noteid' AND createdBy='$userid'");
    $row = mysqli_fetch_array($query);
}
if (!$row) {
?>
    <script>
        alert('Note not found or access denied.');
        window.location = 'manage-notes.php';
    </script>
<?php
    exit();
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
    <title>Edit Note | Notes Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'SF Pro Display', 'SF Pro Icons', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, rgb(196, 200, 255));
            /* Dashboard background */
            color: #111;
            /* Dashboard text color */
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
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include_once('includes/header.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/leftbar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Note</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="manage-notes.php">Manage Notes</a></li>
                        <li class="breadcrumb-item active">Edit Note</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-sticky-note me-1"></i>
                            Edit Note
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="noteTitle" class="form-label"><strong>Note Title</strong></label>
                                    <input type="text" class="form-control" id="noteTitle" name="noteTitle" value="<?php echo htmlentities($row['noteTitle']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="noteCategory" class="form-label"><strong>Category</strong></label>
                                    <input type="text" class="form-control" id="noteCategory" name="noteCategory" value="<?php echo htmlentities($row['noteCategory']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="noteContent" class="form-label"><strong>Note Content</strong></label>
                                    <textarea class="form-control" id="noteContent" name="noteContent" rows="8" required><?php echo htmlentities($row['noteContent']); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="noteImage" class="form-label"><strong>Note Image</strong></label>
                                    <input type="file" class="form-control" id="noteImage" name="noteImage" accept="image/*">
                                    <?php if (!empty($row['noteImage'])): ?>
                                        <img src="uploads/<?php echo htmlentities($row['noteImage']); ?>" alt="Note Image" style="max-width:150px;margin-top:10px;">
                                    <?php endif; ?>
                                </div>
                                <button type="submit" name="update_note" class="btn btn-primary">Save Changes</button>
                                <a href="view-note.php?noteid=<?php echo $row['id']; ?>" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>