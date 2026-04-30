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

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f9ff;
    }

    .top-bar {
        background: #0d6efd;
        color: white;
        padding: 6px 0;
        font-size: 14px;
    }

    .navbar {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .nav-link {
        font-weight: 500;
    }

    .hero {
        background: linear-gradient(to right, #0d6efd, #00c6ff);
        color: white;
        padding: 100px 0;
        text-align: center;
    }

    .btn-clinic {
        background: white;
        color: #0d6efd;
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: bold;
    }

    .card-clinic {
        border-radius: 15px;
        padding: 25px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: .3s;
    }

    .card-clinic:hover {
        transform: translateY(-8px);
    }

    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    footer {
        background: #0d6efd;
        color: white;
        padding: 40px 0;
        margin-top: 50px;
    }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <div class="top-bar text-center">
        📞 <?= esc(env('clinic.phone') ?? '01XXXXXXXXX') ?> |
        ✉ <?= esc(env('clinic.email') ?? 'info@clinic.com') ?>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <?= esc(env('clinic.name') ?? 'Victoria Clinic') ?>
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
        <div class="container">
            <h1>Welcome to <?= esc(env('clinic.name') ?? 'Victoria Clinic') ?></h1>
            <p>Your Health, Our Priority</p>
            <button class="btn btn-clinic">Book Appointment</button>
        </div>
    </div>

    <!-- SERVICES -->
    <div class="container mt-5">
        <div class="section-title">
            <h2>Our Services</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-clinic text-center">
                    👨‍⚕️
                    <h5>Expert Doctors</h5>
                    <p>Qualified professionals</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-clinic text-center">
                    🩺
                    <h5>Health Checkup</h5>
                    <p>Regular medical check</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-clinic text-center">
                    🚑
                    <h5>Emergency</h5>
                    <p>24/7 service</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ABOUT -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= base_url('public/assets/img/clinic.jpg') ?>" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2>About Us</h2>
                <p>We provide high quality healthcare services with experienced doctors.</p>
            </div>
        </div>
    </div>

    <!-- DOCTORS -->
    <div class="container mt-5">
        <div class="section-title">
            <h2>Our Doctors</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-clinic text-center">
                    <img src="<?= base_url('public/assets/img/doc1.jpg') ?>" class="img-fluid rounded">
                    <h5>Dr. Rahman</h5>
                    <p>Cardiologist</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-clinic text-center">
                    <img src="<?= base_url('public/assets/img/doc2.jpg') ?>" class="img-fluid rounded">
                    <h5>Dr. Sultana</h5>
                    <p>Dentist</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-clinic text-center">
                    <img src="<?= base_url('public/assets/img/doc3.jpg') ?>" class="img-fluid rounded">
                    <h5>Dr. Karim</h5>
                    <p>Neurologist</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="container mt-5 text-center">
        <div class="card-clinic">
            <h3>Need Help?</h3>
            <p>Book appointment now</p>
            <button class="btn btn-primary">Book Now</button>
        </div>
    </div>

    <!-- CONTACT -->
    <div class="container mt-5">
        <div class="section-title">
            <h2>Contact</h2>
        </div>

        <p><strong>Address:</strong> <?= esc(env('clinic.address') ?? 'Dhaka') ?></p>
        <p><strong>Phone:</strong> <?= esc(env('clinic.phone')) ?></p>
        <p><strong>Email:</strong> <?= esc(env('clinic.email')) ?></p>
    </div>

    <!-- FOOTER -->
    <footer class="text-center">
        <p>© <?= date('Y') ?> <?= esc(env('clinic.name')) ?></p>
    </footer>

</body>

</html>