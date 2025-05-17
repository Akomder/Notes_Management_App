<?php
    session_start();
    include_once('includes/config.php');
    if(strlen($_SESSION["noteid"])==0){
        header('location:logout.php');
    }
    else {
    // For deleting
        if($_GET['del']){
            $catid=$_GET['id'];
            $userid=$_SESSION["noteid"];
            mysqli_query($con,"delete from tblcategory where id ='$catid' and  createdBy='$userid'");
            echo "<script>alert('Data Deleted');</script>";
            echo "<script>window.location.href='manage-categories.php'</script>";
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
        <title>Manage Categories | Notes Management System</title> <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

        <style>
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


            /* Table - Dashboard style */
            #datatablesSimple {
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 10px;
                overflow: hidden; /* Ensures rounded corners apply to content */
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

        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
            <?php include_once('includes/leftbar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Manage Categories</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Categories</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Categories Details
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>Creation date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>#</th> <th>Category</th>
                                            <th>Creation date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $userid=$_SESSION["noteid"];
                                            $query=mysqli_query($con,"select id,categoryName,creationDate from tblcategory where createdBy='$userid'");
                                            $cnt=1;
                                            while($row=mysqli_fetch_array($query)){
                                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row['categoryName']);?></td>
                                            <td> <?php echo htmlentities($row['creationDate']);?></td>
                                            <td>
                                                <a href="edit-category.php?id=<?php echo $row['id']?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="manage-categories.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a> </td>
                                        </tr>
                                        <?php $cnt=$cnt+1; } ?>
                                    </tbody>
                                </table>
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