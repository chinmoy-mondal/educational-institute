<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc(env('clinic.name') ?? 'Clinic Management System') ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css'); ?>">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/cbc3035612.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* 🌿 GLOBAL */
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        /* 🌟 TOP BAR (medical info strip) */
        .topbar {
            background: #0f172a;
            color: #cbd5e1;
            font-size: 13px;
            padding: 6px 0;
        }

        .topbar i {
            color: #38bdf8;
            margin-right: 5px;
        }

        /* 🌈 MAIN NAVBAR */
        .navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: #0d6efd;
            font-size: 20px;
        }

        .nav-link {
            font-weight: 500;
            color: #374151 !important;
            margin: 0 8px;
        }

        .nav-link:hover {
            color: #0d6efd !important;
        }

        /* 🏥 HERO (clinic feel) */
        .hero {
            background: linear-gradient(135deg, #0d6efd, #06b6d4);
            color: white;
            padding: 90px 20px;
            text-align: center;
            border-radius: 0 0 40px 40px;
        }

        .hero h1 {
            font-size: 44px;
            font-weight: 700;
        }

        .hero p {
            font-size: 17px;
            opacity: 0.9;
        }

        /* BUTTON */
        .btn-clinic {
            background: white;
            color: #0d6efd;
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
        }

        /* 📦 SECTIONS */
        .section {
            padding: 60px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-weight: 700;
            color: #0f172a;
        }

        /* 💎 SERVICE CARD */
        .service-card {
            background: white;
            border-radius: 18px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .service-card:hover {
            transform: translateY(-6px);
        }

        .service-card i {
            font-size: 38px;
            color: #0d6efd;
            margin-bottom: 10px;
        }

        /* 👨‍⚕️ DOCTOR CARD */
        .doctor-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .doctor-card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .doctor-card h5 {
            margin-top: 10px;
            font-weight: 600;
        }

        /* 🦶 FOOTER */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 40px 0;
            margin-top: 60px;
        }

        .footer a {
            color: #94a3b8;
            text-decoration: none;
        }

        .footer a:hover {
            color: white;
        }
    </style>

</head>

<body>

    <!-- 🔵 TOP BAR -->
    <div class="topbar text-center">
        <i class="fas fa-phone"></i> <?= esc(env('clinic.phone') ?? '+8801XXXXXXXXX') ?>
        &nbsp;&nbsp; | &nbsp;&nbsp;
        <i class="fas fa-envelope"></i> <?= esc(env('clinic.email') ?? 'info@clinic.com') ?>
    </div>

    <!-- 🧭 NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand" href="#">
                🏥 <?= esc(env('clinic.name') ?? 'Clinic Pro') ?>
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
                ☰
            </button>

            <div class="collapse navbar-collapse" id="menu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Appointment</a></li>

                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2" href="/login">Login</a>
                    </li>

                </ul>

            </div>

        </div>
    </nav>

    <!-- 🏥 PAGE CONTENT -->
    <?= $this->renderSection("content"); ?>

    <!-- 🦶 FOOTER -->
    <div class="footer text-center">
        <div class="container">
            <p>© <?= date('Y') ?> <?= esc(env('clinic.name')) ?> | All Rights Reserved</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js') ?>"></script>

</body>

</html>