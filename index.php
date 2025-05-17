<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Notes Management App</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/light.css" rel="stylesheet" id="theme-stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        main {
            height: 100%;
        }

        .hero-section {
            height: 100vh;
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }

        @keyframes moveBackground {
            0% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-10px, 10px);
            }

            100% {
                transform: translate(0, 0);
            }
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgb(63, 63, 63), transparent 50%),
                radial-gradient(circle at 80% 20%, #fad0c4, transparent 50%),
                radial-gradient(circle at 50% 70%, rgb(195, 201, 211), transparent 60%),
                radial-gradient(circle at 70% 90%, rgb(48, 48, 48), transparent 60%);
            background-blend-mode: overlay;
            filter: blur(30px) brightness(1.1);
            z-index: -1;
            animation: moveBackground 20s infinite ease-in-out;
        }

        .hero-content {
            z-index: 1;
        }

        .hero-logo {
            width: 500px;
            height: auto;
            margin-bottom: 1rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
        }

        .hero-content p {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: #e9ecef;
        }

        /* Improved Buttons */
        .hero-buttons .btn {
            margin: 0.5rem;
            padding: 0.75rem 2rem;
            font-size: 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .hero-buttons .btn-light {
            color: #333;
            background-color: #f8f9fa;
            border: 2px solid #ddd;
        }

        .hero-buttons .btn-light:hover {
            background-color: #e2e6ea;
            color: #000;
        }

        .hero-buttons .btn-dark {
            color: #fff;
            background-color: #343a40;
            border: 2px solid #222;
        }

        .hero-buttons .btn-dark:hover {
            background-color: #495057;
            color: #fff;
        }

        /* Dark Mode Toggle Button */
        #darkModeToggle {
            font-size: 1rem;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        #darkModeToggle:hover {
            background-color: #6c757d;
            color: #fff;
        }

        @media (max-width: 768px) {
            .hero-logo {
                width: 80px;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .hero-buttons .btn {
                display: block;
                width: 70%;
                margin: 0.5rem auto;
            }

            #darkModeToggle {
                width: 70%;
                display: block;
                margin: 0.5rem auto 0 auto;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <main>
        <div class="hero-section">
            <div class="hero-content">
                <img src="assets/img/logo.png" alt="Notes Management App Logo" class="hero-logo mb-4" />
                <h1>Your personal note management website.</h1>
                <p>Organize your lifestyle in such simple clicks!</p>
                <div class="hero-buttons">
                    <a href="registration.php" class="btn btn-light">Register</a>
                    <a href="login.php" class="btn btn-dark">Login</a>
                </div>
                <button id="darkModeToggle" class="btn btn-outline-secondary mt-3">
                    <i class="fas fa-moon"></i> Dark Mode
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script>
        const toggleBtn = document.getElementById('darkModeToggle');
        const themeStylesheet = document.getElementById('theme-stylesheet');

        toggleBtn.addEventListener('click', () => {
            if (themeStylesheet.getAttribute('href') === 'css/light.css') {
                themeStylesheet.setAttribute('href', 'css/dark.css'); // Make sure to create this file
                toggleBtn.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
            } else {
                themeStylesheet.setAttribute('href', 'css/light.css');
                toggleBtn.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
            }
        });
    </script>

</body>

</html>