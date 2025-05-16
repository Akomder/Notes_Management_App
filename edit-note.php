<?php
session_start();
include_once('includes/config.php');
if(strlen($_SESSION["noteid"])==0){
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
    $imageName = $row['noteImage']; // keep old image by default
    if (isset($_FILES['noteImage']) && $_FILES['noteImage']['error'] === UPLOAD_ERR_OK) {
        $imgTmp = $_FILES['noteImage']['tmp_name'];
        $imgName = basename($_FILES['noteImage']['name']);
        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imgExt, $allowed)) {
            $newImgName = uniqid('note_', true) . '.' . $imgExt;
            $uploadPath = __DIR__ . '/uploads/' . $newImgName;
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
if($noteid){
    $query = mysqli_query($con, "SELECT * FROM tblnotes WHERE id='$noteid' AND createdBy='$userid'");
    $row = mysqli_fetch_array($query);
}
if(!$row){
    ?>
    <script>
        alert('Note not found or access denied.');
        window.location='manage-notes.php';
    </script>
    <?php
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Edit Note</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include_once('includes/header.php');?>
    <div id="layoutSidenav">
        <?php include_once('includes/leftbar.php');?>
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
            <?php include_once('includes/footer.php');?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>