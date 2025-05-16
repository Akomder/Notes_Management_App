<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Notes Management App</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <link id="theme-stylesheet" href="css/light.css" rel="stylesheet">

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Notes Management App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="registration.php"><i class="fa fa-user"></i> Registration</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="fa fa-sign-in-alt"></i> Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 text-center">Notes Management App</h1>
                <ol class="breadcrumb mb-4 justify-content-center">
                    <li class="breadcrumb-item"></li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img src="assets/img/banner.jpg" class="img-fluid rounded" alt="Banner" style="max-height: 400px; width: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php');?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
