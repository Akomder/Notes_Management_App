<?php
session_start();
include_once('includes/config.php');
if(strlen($_SESSION["noteid"])==0){
    header('location:logout.php');
    exit();
}

$userid = $_SESSION["noteid"];
$noteid = isset($_GET['noteid']) ? intval($_GET['noteid']) : 0;

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
    <title>View Note</title>
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
                    <h1 class="mt-4">View Note</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="manage-notes.php">Manage Notes</a></li>
                        <li class="breadcrumb-item active">View Note</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-sticky-note me-1"></i>
                            Note Details
                        </div>
                        <div class="card-body">
                            <h4><?php echo htmlentities($row['noteTitle']); ?></h4>
                            <p><strong>Category:</strong> <?php echo htmlentities($row['noteCategory']); ?></p>
                            <p><strong>Created On:</strong> <?php echo htmlentities($row['creationDate']); ?></p>
                            <hr>
                            <div>
                                <?php echo nl2br(htmlentities($row['noteContent'])); ?>
                            </div>
                            <a href="edit-note.php?noteid=<?php echo $row['id']; ?>" class="btn btn-primary mt-3">Edit Note</a>
                            <a href="manage-notes.php" class="btn btn-secondary mt-3">Back to Notes</a>
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