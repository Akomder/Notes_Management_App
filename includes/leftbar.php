<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="categories.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Categories
                </a>

                <a class="nav-link" href="notes.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Notes
                </a>

                <div class="sb-sidenav-menu-heading">Profile Setting</div>
                <a class="nav-link" href="change-password.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                    Change Password
                </a>
                <a class="nav-link" href="my-profile.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                    My Profile
                </a>
                <a class="nav-link" href="logout.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-sign-out"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <?php
        $id = intval($_SESSION["noteid"]);
        $query = mysqli_query($con, "select * from tblregistration where id='$id'");
        while ($row = mysqli_fetch_array($query)) {
            $fullname = $row['firstName'] . " " . $row['lastName'];
        }
        ?>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $fullname ?>
        </div>
    </nav>
</div>

<style>
<<<<<<< HEAD
    /* Apple-inspired styles for the left sidebar with blur and white text */
    .sb-sidenav-dark {
        background-color: rgba(28, 28, 30, 0.8);
        /* Semi-transparent dark background */
        color: #f2f2f7;
        /* Light text */
        backdrop-filter: blur(10px);
        /* Apply blur effect */
        -webkit-backdrop-filter: blur(10px);
        /* Safari support */
    }

    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: rgba(242, 242, 247, 0.6);
        /* Slightly less opaque white for headings */
=======
    /* Paste the <style> block from your leftbar.php (with blur and white text) here */
    /* Apple-inspired styles for the left sidebar with blur and white text */
    .sb-sidenav-dark {
        background-color: rgba(28, 28, 30, 0.8) !important; /* Semi-transparent dark background */
        color: #f2f2f7 !important; /* Light text */
        backdrop-filter: blur(10px); /* Apply blur effect */
        -webkit-backdrop-filter: blur(10px); /* Safari support */
    }

    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for headings */
>>>>>>> 750112553fa5a49fe9e63471fd63728494de956c
        font-size: 12px;
        padding: 10px 15px;
        margin-top: 10px;
    }

    .sb-sidenav-dark .nav-link {
<<<<<<< HEAD
        color: #f2f2f7;
        /* White text for links */
        padding: 10px 15px;
        margin: 5px 10px;
        border-radius: 8px;
        /* Rounded corners */
=======
        color: #f2f2f7 !important; /* White text for links */
        padding: 10px 15px;
        margin: 5px 10px;
        border-radius: 8px; /* Rounded corners */
>>>>>>> 750112553fa5a49fe9e63471fd63728494de956c
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .sb-sidenav-dark .nav-link .sb-nav-link-icon {
<<<<<<< HEAD
        color: rgba(242, 242, 247, 0.6);
        /* Slightly less opaque white for icons */
=======
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for icons */
>>>>>>> 750112553fa5a49fe9e63471fd63728494de956c
        transition: color 0.2s ease;
    }

    .sb-sidenav-dark .nav-link:hover {
<<<<<<< HEAD
        background-color: rgba(242, 242, 247, 0.1);
        /* Semi-transparent white background on hover */
        color: #f2f2f7;
        /* White text on hover */
    }

    .sb-sidenav-dark .nav-link:hover .sb-nav-link-icon {
        color: #f2f2f7;
        /* White icon on hover */
=======
        background-color: rgba(242, 242, 247, 0.1) !important; /* Semi-transparent white background on hover */
        color: #f2f2f7 !important; /* White text on hover */
    }

    .sb-sidenav-dark .nav-link:hover .sb-nav-link-icon {
         color: #f2f2f7 !important; /* White icon on hover */
>>>>>>> 750112553fa5a49fe9e63471fd63728494de956c
    }


    .sb-sidenav-dark .nav-link.collapsed {
<<<<<<< HEAD
        color: #f2f2f7;
        /* White text for collapsed links */
    }

    .sb-sidenav-dark .nav-link.active {
        color: #007aff;
        /* Apple blue for active link (stands out against white) */
    }

    .sb-sidenav-dark .sb-sidenav-collapse-arrow {
        color: rgba(242, 242, 247, 0.6);
        /* Slightly less opaque white for arrows */
    }

    .sb-sidenav-dark .sb-sidenav-menu-nested .nav-link {
        padding: 8px 15px 8px 30px;
        /* Adjust padding for nested links */
        color: #f2f2f7;
        /* White text for nested links */
    }

    .sb-sidenav-dark .sb-sidenav-menu-nested .nav-link:hover {
        background-color: rgba(242, 242, 247, 0.1);
        /* Semi-transparent white background on hover for nested links */
        color: #f2f2f7;
        /* White text on hover for nested links */
    }

    .sb-sidenav-dark .sb-sidenav-footer {
        background-color: rgba(50, 50, 52, 0.8);
        /* Slightly darker semi-transparent footer background */
        color: #f2f2f7;
        /* White text */
        padding: 15px;
        border-top: 1px solid rgba(70, 70, 72, 0.8);
        /* Semi-transparent border top */
    }

    .sb-sidenav-dark .sb-sidenav-footer .small {
        color: rgba(242, 242, 247, 0.6);
        /* Slightly less opaque white for "Logged in as" */
    }

    /* Ensure all text within the sidebar is white */
    .sb-sidenav-dark * {
        color: inherit !important;
        /* Inherit color from parent (should be white) */
    }

    .sb-sidenav-dark .nav-link.active {
        color: #007aff !important;
        /* Keep active link blue */
    }
</style>

=======
         color: #f2f2f7 !important; /* White text for collapsed links */
    }

     .sb-sidenav-dark .nav-link.active {
        color: #007aff !important; /* Apple blue for active link (stands out against white) */
     }

    .sb-sidenav-dark .sb-sidenav-collapse-arrow {
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for arrows */
    }

    .sb-sidenav-dark .sb-sidenav-menu-nested .nav-link {
        padding: 8px 15px 8px 30px; /* Adjust padding for nested links */
        color: #f2f2f7 !important; /* White text for nested links */
    }

    .sb-sidenav-dark .sb-sidenav-menu-nested .nav-link:hover {
         background-color: rgba(242, 242, 247, 0.1) !important; /* Semi-transparent white background on hover for nested links */
         color: #f2f2f7 !important; /* White text on hover for nested links */
    }

    .sb-sidenav-dark .sb-sidenav-footer {
        background-color: rgba(50, 50, 52, 0.8) !important; /* Slightly darker semi-transparent footer background */
        color: #f2f2f7 !important; /* White text */
        padding: 15px;
        border-top: 1px solid rgba(70, 70, 72, 0.8) !important; /* Semi-transparent border top */
    }

     .sb-sidenav-dark .sb-sidenav-footer .small {
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for "Logged in as" */
     }

     /* Ensure all text within the sidebar is white */
     .sb-sidenav-dark * {
         color: inherit !important; /* Inherit color from parent (should be white) */
     }

     .sb-sidenav-dark .nav-link.active {
         color: #007aff !important; /* Keep active link blue */
     }

</style><div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="categories.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Categories
                </a>

                <a class="nav-link" href="notes.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Notes
                </a>

                <div class="sb-sidenav-menu-heading">Profile Setting</div>
                <a class="nav-link" href="change-password.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                    Change Password
                </a>
                <a class="nav-link" href="my-profile.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                    My Profile
                </a>
                <a class="nav-link" href="logout.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-sign-out"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <?php
            $id=intval($_SESSION["noteid"]);
            $query=mysqli_query($con,"select * from tblregistration where id='$id'");
            while($row=mysqli_fetch_array($query)){
                $fullname=$row['firstName']." ".$row['lastName'];
            }
        ?>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $fullname?>
        </div>
    </nav>
</div>

<style>
    /* Paste the <style> block from your leftbar.php (with blur and white text) here */
    /* Apple-inspired styles for the left sidebar with blur and white text */
    .sb-sidenav-dark {
        background-color: rgba(28, 28, 30, 0.8) !important; /* Semi-transparent dark background */
        color: #f2f2f7 !important; /* Light text */
        backdrop-filter: blur(10px); /* Apply blur effect */
        -webkit-backdrop-filter: blur(10px); /* Safari support */
    }

    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for headings */
        font-size: 12px;
        padding: 10px 15px;
        margin-top: 10px;
    }

    .sb-sidenav-dark .nav-link {
        color: #f2f2f7 !important; /* White text for links */
        padding: 10px 15px;
        margin: 5px 10px;
        border-radius: 8px; /* Rounded corners */
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .sb-sidenav-dark .nav-link .sb-nav-link-icon {
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for icons */
        transition: color 0.2s ease;
    }

    .sb-sidenav-dark .nav-link:hover {
        background-color: rgba(242, 242, 247, 0.1) !important; /* Semi-transparent white background on hover */
        color: #f2f2f7 !important; /* White text on hover */
    }

    .sb-sidenav-dark .nav-link:hover .sb-nav-link-icon {
         color: #f2f2f7 !important; /* White icon on hover */
    }


    .sb-sidenav-dark .nav-link.collapsed {
         color: #f2f2f7 !important; /* White text for collapsed links */
    }

     .sb-sidenav-dark .nav-link.active {
        color: #007aff !important; /* Apple blue for active link (stands out against white) */
     }

    .sb-sidenav-dark .sb-sidenav-collapse-arrow {
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for arrows */
    }

    .sb-sidenav-dark .sb-sidenav-menu-nested .nav-link {
        padding: 8px 15px 8px 30px; /* Adjust padding for nested links */
        color: #f2f2f7 !important; /* White text for nested links */
    }

    .sb-sidenav-dark .sb-sidenav-menu-nested .nav-link:hover {
         background-color: rgba(242, 242, 247, 0.1) !important; /* Semi-transparent white background on hover for nested links */
         color: #f2f2f7 !important; /* White text on hover for nested links */
    }

    .sb-sidenav-dark .sb-sidenav-footer {
        background-color: rgba(50, 50, 52, 0.8) !important; /* Slightly darker semi-transparent footer background */
        color: #f2f2f7 !important; /* White text */
        padding: 15px;
        border-top: 1px solid rgba(70, 70, 72, 0.8) !important; /* Semi-transparent border top */
    }

     .sb-sidenav-dark .sb-sidenav-footer .small {
        color: rgba(242, 242, 247, 0.6) !important; /* Slightly less opaque white for "Logged in as" */
     }

     /* Ensure all text within the sidebar is white */
     .sb-sidenav-dark * {
         color: inherit !important; /* Inherit color from parent (should be white) */
     }

     .sb-sidenav-dark .nav-link.active {
         color: #007aff !important; /* Keep active link blue */
     }
</style>
>>>>>>> 750112553fa5a49fe9e63471fd63728494de956c
