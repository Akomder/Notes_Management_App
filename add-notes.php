<?php
session_start();
include_once('includes/config.php');
if(strlen( $_SESSION["noteid"])==0){
    header('location:logout.php');
}
else{
    if(isset($_POST['submit'])){
        $category=$_POST['category'];
        $ntitle=$_POST['notetitle'];
        $ndescription=$_POST['notediscription'];
        $createdby=$_SESSION['noteid'];

        // Image upload handling
        $imagePath = '';
        if(isset($_FILES['noteimage']) && $_FILES['noteimage']['error'] == 0){
            $targetDir = "uploads/";
            if(!is_dir($targetDir)){
                mkdir($targetDir, 0777, true);
            }
            $fileName = basename($_FILES["noteimage"]["name"]);
            $targetFilePath = $targetDir . time() . '_' . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath,PATHINFO_EXTENSION));
            $allowedTypes = array('jpg','jpeg','png','gif');
            if(in_array($fileType, $allowedTypes)){
                if(move_uploaded_file($_FILES["noteimage"]["tmp_name"], $targetFilePath)){
                    $imagePath = $targetFilePath;
                }
            }
        }

        // Insert with image path
        $sql = mysqli_query($con, "INSERT INTO tblnotes (noteCategory, noteTitle, noteDescription, noteImage, createdBy) VALUES ('$category', '$ntitle', '$ndescription', '$imagePath', '$createdby')");
        if($sql){
            $_SESSION['msg'] = "Note Added successfully";
            header('Location: manage-notes.php');
            exit();
        } else {
            echo "<script>alert('Failed to add note');</script>";
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
        <title>Notes Management System</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
            <?php include_once('includes/leftbar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Add Note</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Note</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <form  method="post" enctype="multipart/form-data">                                
                                    <div class="row">
                                        <div class="col-2">Category Name</div>
                                        <div class="col-6">
                                            <select name="category" id="category" class="form-control" required>
                                            <option value="">Select Category</option> 
                                            <?php $userid=$_SESSION["noteid"];
                                            $query=mysqli_query($con,"select * from tblcategory where createdBy='$userid'");
                                            while($row=mysqli_fetch_array($query))
                                            {?>
                                            <option value="<?php echo $row['id'];?>"><?php echo $row['categoryName'];?></option>
                                            <?php } ?>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Note Title</div>
                                        <div class="col-6"><input type="text" name="notetitle" placeholder="Enter the note title" class="form-control"></div>
                                    </div>
                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Note Description</div>
                                        <div class="col-6"><textarea  name="notediscription"  placeholder="Enter Note Description" rows="6" class="form-control"></textarea></div>
                                    </div>
                                    <div class="row" style="margin-top:1%;">
                                        <div class="col-2">Note Image</div>
                                        <div class="col-6"><input type="file" name="noteimage" accept="image/*" class="form-control"></div>
                                    </div>
                                    <div class="row" style="margin-top:1%">
                                        <div class="col-2">&nbsp;</div>
                                        <div class="col-2"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                                    </div>
                                </form>
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
<?php }  ?>
