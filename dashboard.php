<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
if (strlen($_SESSION["noteid"]) == 0) {
    header('location:logout.php');
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard | Your App Name</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

        <style>
            body {
                font-family: 'SF Pro Display', 'SF Pro Icons', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                background: linear-gradient(135deg, #f5f7fa, rgb(187, 218, 213));
                color: #1c1c1e;
                /* Dark text */
                transition: background-color 0.4s ease, color 0.4s ease;
                /* Fluid transition */
            }

            /* Dark mode styles */
            body.dark-mode {
                background-color: #1c1c1e;
                /* Dark background */
                color: #f2f2f7;
                /* Light text */
            }

            body.dark-mode .card {
                background-color: #2c2c2e !important;
                /* Darker card background */
                color: #f2f2f7 !important;
                border-color: #3a3a3c !important;
            }

            body.dark-mode .card-header {
                background-color: #3a3a3c !important;
                /* Darker header background */
                color: #f2f2f7 !important;
                border-color: #3a3a3c !important;
            }

            body.dark-mode .card-footer {
                background-color: #3a3a3c !important;
                /* Darker footer background */
                border-color: #3a3a3c !important;
            }

            body.dark-mode .text-white {
                color: #f2f2f7 !important;
                /* Ensure white text is visible in dark mode */
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
                /* Example link color in dark mode */
            }


            /* Cards - Made Square */
            .card {
                border-radius: 0;
                /* Square corners */
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                /* Slightly more pronounced shadow */
                border: 1px solid #e0e0e0;
                /* Subtle border */
                transition: all 0.3s ease-in-out;
                /* Fluid transition for all changes */
            }

            body.dark-mode .card {
                border-color: #3a3a3c !important;
            }


            .card-header {
                background-color: #ffffff;
                border-bottom: 1px solid #e0e0e0;
                font-weight: 600;
                border-radius: 0;
                /* Square corners */
                transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            }

            .card-footer {
                background-color: #ffffff;
                border-top: 1px solid #e0e0e0;
                border-radius: 0;
                /* Square corners */
                transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            }


            /* Specific colors for the blue and green cards */
            .card.bg-primary {
                background-color: #007aff !important;
                /* Apple blue */
                color: #ffffff !important;
            }

            body.dark-mode .card.bg-primary {
                background-color: #0a84ff !important;
                /* Slightly different blue in dark mode */
                color: #ffffff !important;
            }

            .card.bg-success {
                background-color: #30d158 !important;
                /* Apple green */
                color: #ffffff !important;
            }

            body.dark-mode .card.bg-success {
                background-color: #32d74f !important;
                /* Slightly different green in dark mode */
                color: #ffffff !important;
            }


            /* Buttons */
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

            /* Table */
            #datatablesSimple {
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 10px;
                overflow: hidden;
                /* Ensures rounded corners apply to content */
                border: 1px solid #e0e0e0;
                /* Subtle border for table */
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
                /* Added padding */
            }

            body.dark-mode #datatablesSimple thead th {
                background-color: #3a3a3c;
                color: #f2f2f7;
                border-bottom-color: #505052;
            }

            #datatablesSimple tbody tr {
                border-bottom: 1px solid #e9e9eb;
                transition: background-color 0.2s ease;
                /* Fluid transition on hover */
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
                /* Added padding */
            }

            body.dark-mode #datatablesSimple tbody td {
                background-color: #2c2c2e;
                color: #f2f2f7;
            }

            #datatablesSimple tbody tr:hover td {
                background-color: #f5f5f5;
                /* Light hover effect */
            }

            body.dark-mode #datatablesSimple tbody tr:hover td {
                background-color: #3a3a3c;
                /* Dark mode hover effect */
            }


            /* Dashboard Header with Description */
            .dashboard-header-container {
                margin-top: 20px;
                /* Space from the top */
                margin-bottom: 20px;
            }

            .dashboard-header-container h1 {
                font-size: 2rem;
                /* Adjust size as needed */
                font-weight: 700;
                /* Bold */
                color: #1c1c1e;
                /* Dark color */
                margin-bottom: 5px;
                /* Space between heading and description */
            }

            body.dark-mode .dashboard-header-container h1 {
                color: #f2f2f7;
                /* Light color in dark mode */
            }

            .dashboard-description {
                font-size: 1rem;
                /* Adjust size as needed */
                color: #636366;
                /* Medium gray */
                margin-bottom: 0;
                /* No bottom margin */
            }

            body.dark-mode .dashboard-description {
                color: #8e8e93;
                /* Lighter gray in dark mode */
            }


            /* Dark mode toggle button */
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
                        <div class="dashboard-header-container">
                            <h1>Dashboard</h1>
                            <p class="dashboard-description">A quick overview of your categories and notes.</p>
                        </div>

                        <hr>
                        <div class="row">
                            <?php
                            $userid = $_SESSION["noteid"];
                            $ret = mysqli_query($con, "select id from tblcategory where createdBy='$userid'");
                            $listedcategories = mysqli_num_rows($ret);
                            $query = mysqli_query($con, "select * from tblnotes where createdBy='$userid'");
                            $totalnotes = mysqli_num_rows($query);
                            ?>
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6 col-xl-4 mb-4">
                                    <div class="card bg-primary text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">Listed Categories</div>
                                                    <div class="text-lg fw-bold"><?php echo $listedcategories; ?></div>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar feather-xl text-white-50">
                                                    <rect x="10" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between small">
                                            <a class="text-white stretched-link" href="manage-categories.php">View Details</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-4 mb-4">
                                    <div class="card bg-success text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">Total Notes</div>
                                                    <div class="text-lg fw-bold"><?php echo $totalnotes; ?></div>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square feather-xl text-white-50">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between small">
                                            <a class="text-white stretched-link" href="manage-notes.php">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-table me-1"></i>
                                        Recently Added Notes
                                    </div>
                                    <div>
                                        <button id="listViewBtn" class="btn btn-sm btn-secondary me-2">List View</button>
                                        <button id="gridViewBtn" class="btn btn-sm btn-secondary">Grid View</button>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <!-- List View -->
                                    <div id="listView">
                                        <table id="datatablesSimple" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Note Title</th>
                                                    <th>Category</th>
                                                    <th>Creation date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cnt = 1;
                                                $query = mysqli_query($con, "SELECT * FROM tblnotes WHERE createdBy='$userid' ORDER BY creationDate DESC");
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($row['noteTitle']); ?></td>
                                                        <td><?php echo htmlentities($row['noteCategory']); ?></td>
                                                        <td><?php echo htmlentities($row['creationDate']); ?></td>
                                                        <td>
                                                            <a href="view-note.php?noteid=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                                            <a href="manage-notes.php?id=<?php echo $row['id']; ?>&del=delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Grid View -->
                                    <div id="gridView" class="row d-none">
                                        <?php
                                        $query2 = mysqli_query($con, "SELECT * FROM tblnotes WHERE createdBy='$userid' ORDER BY creationDate DESC");
                                        while ($row = mysqli_fetch_array($query2)) {
                                        ?>
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo htmlentities($row['noteTitle']); ?></h5>
                                                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlentities($row['noteCategory']); ?></h6>
                                                        <p class="card-text"><small class="text-muted">Created on <?php echo htmlentities($row['creationDate']); ?></small></p>
                                                        <a href="view-note.php?noteid=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                                        <a href="manage-notes.php?id=<?php echo $row['id']; ?>&del=delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        </tbody>
                        </table>
                    </div>
            </div>
        </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
        </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <!-- JS Dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script>
            // DataTables init
            $(document).ready(function() {
                $('#datatablesSimple').DataTable();
            });

            // View Toggle Logic
            const listBtn = document.getElementById('listViewBtn');
            const gridBtn = document.getElementById('gridViewBtn');
            const listView = document.getElementById('listView');
            const gridView = document.getElementById('gridView');

            listBtn.addEventListener('click', () => {
                listView.classList.remove('d-none');
                gridView.classList.add('d-none');
            });

            gridBtn.addEventListener('click', () => {
                gridView.classList.remove('d-none');
                listView.classList.add('d-none');
            });
        </script>
        <script>
            // Add JavaScript for dark mode toggle if you have it
            const darkModeToggle = document.getElementById('darkModeToggle');
            // ... rest of your JavaScript ...
        </script>
    </body>
<?php } ?>