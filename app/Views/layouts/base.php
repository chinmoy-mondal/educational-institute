<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc(env('clinic.name') ?? 'Victoria Clinic') ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css'); ?>">
    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/cbc3035612.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
    body {
        background: #f5f9ff;
        font-family: 'Poppins', sans-serif;
    }

    /* TOP BAR */
    .top-bar {
        background: #0d6efd;
        color: white;
        padding: 6px 0;
        font-size: 14px;
    }

    .top-bar a {
        color: white;
        text-decoration: none;
        margin-right: 15px;
    }

    /* NAVBAR */
    .navbar {
        background: #ffffff !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand img {
        height: 40px;
        margin-right: 8px;
    }

    .nav-item {
        margin-left: 15px;
    }

    .nav-link {
        font-weight: 500;
        color: #333 !important;
    }

    .nav-link:hover {
        color: #0d6efd !important;
    }

    /* HERO */
    .hero {
        background: linear-gradient(to right, #0d6efd, #00c6ff);
        color: white;
        padding: 100px 0;
        text-align: center;
    }

    .hero h1 {
        font-size: 42px;
        font-weight: 700;
    }

    .hero p {
        font-size: 18px;
        margin-top: 10px;
    }

    /* BUTTON */
    .btn-clinic {
        background: #ffffff;
        color: #0d6efd;
        font-weight: 600;
        border-radius: 30px;
        padding: 10px 25px;
        margin-top: 15px;
    }

    .btn-clinic:hover {
        background: #e6f0ff;
    }

    /* CARDS */
    .card-clinic {
        border: none;
        border-radius: 15px;
        padding: 25px;
        transition: 0.3s;
        background: #ffffff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .card-clinic:hover {
        transform: translateY(-8px);
    }

    /* SECTION TITLE */
    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title h2 {
        font-weight: 700;
        color: #0d6efd;
    }

    /* DOCTOR CARD */
    .doctor-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 15px;
    }

    /* FOOTER */
    footer {
        background: #0d6efd;
        color: white;
        padding: 40px 0;
        margin-top: 60px;
    }

    footer a {
        color: white;
        text-decoration: none;
    }

    /* CONTENT SPACING */
    .content {
        margin-top: 120px;
    }

    /* MOBILE */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 28px;
        }

        .hero {
            padding: 70px 0;
        }

        .content {
            margin-top: 100px;
        }
    }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between">
            <div>
                <i class="fas fa-phone"></i>
                <a href="#"><?= esc(env('clinic.phone') ?? '01XXXXXXXXX') ?></a>

                <i class="fas fa-envelope ms-3"></i>
                <a href="#"><?= esc(env('clinic.email') ?? 'info@clinic.com') ?></a>
            </div>

            <div>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
                <img src="<?= base_url('public/assets/img/logo.jpg'); ?>">
                <?= esc(env('clinic.name') ?? 'Victoria Clinic') ?>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">

                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="<?= base_url('login') ?>" class="btn btn-primary">Login</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="content">
        <?= $this->renderSection("content") ?>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p><?= esc(env('clinic.address') ?? 'Dhaka, Bangladesh') ?></p>
                    <p><?= esc(env('clinic.phone')) ?></p>
                </div>

                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Doctors</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Appointments</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5>Location</h5>
                    <iframe width="100%" height="150" style="border:0"
                        src="https://maps.google.com/maps?q=dhaka&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                </div>

            </div>

            <div class="text-center mt-3">
                <p>© <?= date('Y') ?> <?= esc(env('clinic.name') ?? 'Victoria Clinic') ?></p>
            </div>
        </div>
    </footer>

</body>

</html>