<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.html">
        <img src="assets/img/logo.png" alt="App Logo" style="height: 30px;"> </a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
</nav>

<style>
    /* Styles for the header to look like the left sidebar */
    .sb-topnav {
        background-color: rgba(28, 28, 30, 0.8) !important;
        /* Semi-transparent dark background */
        color: #f2f2f7 !important;
        /* Light text */
        backdrop-filter: blur(10px);
        /* Apply blur effect */
        -webkit-backdrop-filter: blur(10px);
        /* Safari support */
        transition: background-color 0.4s ease, color 0.4s ease, backdrop-filter 0.4s ease;
        /* Fluid transition */
        padding: 0 15px;
        /* Adjust padding as needed */
        min-height: 56px;
        /* Ensure a minimum height */
        display: flex;
        /* Use flexbox for alignment */
        align-items: center;
        /* Vertically align items */
    }

    .sb-topnav .navbar-brand {
        color: #f2f2f7 !important;
        /* White color for the brand text */
        font-weight: 600;
        padding-top: 0;
        padding-bottom: 0;
        transition: color 0.2s ease;
    }

    .sb-topnav .navbar-brand:hover {
        color: rgba(242, 242, 247, 0.8) !important;
        /* Subtle hover effect */
    }


    .sb-topnav .btn-link {
        color: #f2f2f7 !important;
        /* White color for the toggle button icon */
        transition: color 0.2s ease, opacity 0.2s ease;
    }

    .sb-topnav .btn-link:hover {
        color: rgba(242, 242, 247, 0.8) !important;
        /* Subtle hover effect */
        opacity: 0.9;
    }

    /* Ensure all text within the header is white by default */
    .sb-topnav * {
        color: inherit !important;
    }

    /* Adjust logo styling if necessary to fit the new header look */
    .sb-topnav .navbar-brand img {
        filter: brightness(0) invert(1);
        /* Make image white */
        height: 30px;
        /* Maintain height */
        transition: filter 0.4s ease;
    }

    body.dark-mode .sb-topnav {
        background-color: rgba(28, 28, 30, 0.8) !important;
        /* Maintain dark background in dark mode */
        color: #f2f2f7 !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    body.dark-mode .sb-topnav .navbar-brand img {
        filter: brightness(1) invert(0);
        /* Revert image color in dark mode if needed, or keep white */
    }
</style>