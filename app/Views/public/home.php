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
    <script src="https://kit.fontawesome.com/cbc3035612.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f6f9fc;
    }

    /* TOP BAR */
    .top-bar {
        background: #0d6efd;
        color: white;
        font-size: 13px;
        padding: 6px 0;
    }

    .top-bar i {
        margin-right: 5px;
    }

    /* NAVBAR */
    .navbar {
        background: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand {
        font-weight: 700;
        color: #0d6efd;
    }

    .nav-link {
        font-weight: 500;
        margin-left: 10px;
    }

    /* HERO */
    .hero {
        background: linear-gradient(135deg, #0d6efd, #00c6ff);
        color: white;
        padding: 110px 20px;
        text-align: center;
    }

    .hero h1 {
        font-size: 48px;
        font-weight: 700;
    }

    .hero p {
        font-size: 18px;
        opacity: 0.9;
    }

    .btn-hero {
        background: #fff;
        color: #0d6efd;
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: 600;
        margin-top: 15px;
        border: none;
    }

    /* SECTION TITLE */
    .section-title {
        text-align: center;
        margin: 60px 0 30px;
    }

    .section-title h2 {
        font-weight: 700;
        color: #0d6efd;
    }

    /* SERVICE CARD */
    .service-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        transition: 0.3s;
        height: 100%;
    }

    .service-card:hover {
        transform: translateY(-8px);
    }

    .service-card i {
        font-size: 40px;
        color: #0d6efd;
        margin-bottom: 10px;
    }

    /* DOCTOR CARD */
    .doctor-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        transition: 0.3s;
        text-align: center;
    }

    .doctor-card:hover {
        transform: translateY(-8px);
    }

    .doctor-card img {
        width: 100%;
        height: 230px;
        object-fit: cover;
    }

    .doctor-card h5 {
        margin-top: 10px;
        font-weight: 600;
    }

    /* CTA */
    .cta {
        background: #0d6efd;
        color: white;
        padding: 60px 20px;
        border-radius: 15px;
        text-align: center;
        margin: 60px 0;
    }

    .cta button {
        background: white;
        color: #0d6efd;
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        border: none;
    }

    /* FOOTER */
    footer {
        background: #0b3d91;
        color: white;
        padding: 40px 0;
        margin-top: 60px;
    }

    footer a {
        color: #fff;
        text-decoration: none;
        opacity: 0.8;
    }

    footer a:hover {
        opacity: 1;
    }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <div class="top-bar text-center">
        <i class="fas fa-phone"></i> <?= esc(env('clinic.phone')) ?>
        &nbsp;&nbsp; | &nbsp;&nbsp;
        <i class="fas fa-envelope"></i> <?= esc(env('clinic.email')) ?>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                🏥 <?= esc(env('clinic.name') ?? 'Clinic') ?>
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                ☰
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <div class="hero">
        <h1>Best Healthcare For You</h1>
        <p>Trusted Doctors | Modern Treatment | 24/7 Care</p>
        <button class="btn-hero">Book Appointment</button>
    </div>

    <!-- SERVICES -->
    <div class="container">
        <div class="section-title">
            <h2>Our Services</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="service-card">
                    <i class="fas fa-user-md"></i>
                    <h5>Expert Doctors</h5>
                    <p>Professional specialists</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="service-card">
                    <i class="fas fa-heartbeat"></i>
                    <h5>Emergency Care</h5>
                    <p>24/7 emergency support</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="service-card">
                    <i class="fas fa-stethoscope"></i>
                    <h5>Diagnosis</h5>
                    <p>Advanced medical checkups</p>
                </div>
            </div>
        </div>
    </div>

    <!-- DOCTORS -->
    <div class="container">
        <div class="section-title">
            <h2>Our Doctors</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="doctor-card">
                    <img src="<?= base_url('public/assets/img/doc1.jpg') ?>">
                    <h5>Dr. Rahman</h5>
                    <p>Cardiologist</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="doctor-card">
                    <img src="<?= base_url('public/assets/img/doc2.jpg') ?>">
                    <h5>Dr. Sultana</h5>
                    <p>Dentist</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="doctor-card">
                    <img src="<?= base_url('public/assets/img/doc3.jpg') ?>">
                    <h5>Dr. Karim</h5>
                    <p>Neurologist</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="container">
        <div class="cta">
            <h2>Need Medical Help?</h2>
            <p>Book appointment instantly</p>
            <button>Book Now</button>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <p>© <?= date('Y') ?> <?= esc(env('clinic.name')) ?></p>
        </div>
    </footer>

</body>

</html>