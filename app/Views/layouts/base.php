<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TechNova Solutions'; ?></title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css'); ?>">

    <!-- AdminLTE CSS for frontend components -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte/dist/css/adminlte.min.css'); ?>">

    <style>
        /* General */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        a {
            text-decoration: none;
        }

        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        /* Navbar */
        .navbar {
            background-color: #0d6efd;
        }

        .navbar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            margin-left: 15px;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
        }

        /* Hero Section */
        .hero {
            background: url('<?= base_url("public/assets/img/tech-banner.jpg"); ?>') center/cover no-repeat;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: #fff;
            text-align: center;
        }

        .hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        /* Services Section */
        .services {
            padding: 80px 0;
        }

        .service-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .service-card i {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 15px;
        }

        .service-card h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Portfolio / Projects */
        .portfolio {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .portfolio-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .portfolio-card img {
            width: 100%;
            border-radius: 15px;
        }

        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 123, 255, 0.7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
            text-align: center;
        }

        .portfolio-card:hover .portfolio-overlay {
            opacity: 1;
        }

        /* Footer */
        footer {
            background-color: #0d6efd;
            color: #fff;
            padding: 30px 0;
        }

        footer a {
            color: #ffc107;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>">TechNova</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-outline-light ms-3"
                            href="<?= base_url('login'); ?>">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Innovative Software Solutions</h1>
            <p>We create cutting-edge applications, embedded systems, and custom software for businesses.</p>
            <a href="#services" class="btn btn-custom">Our Services</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="content">
        <?= $this->renderSection('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; <?= date('Y'); ?> TechNova Solutions. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Scripts test-->
    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>