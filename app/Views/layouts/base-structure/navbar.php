<!-- TOP INFO BAR -->
<div style="background:#0f172a;color:#cbd5e1;font-size:13px;padding:6px 0;">
    <div class="container text-center">
        <i class="fas fa-phone text-info"></i>
        <?= esc(env('clinic.phone') ?? '+8801XXXXXXXXX') ?>

        &nbsp;&nbsp; | &nbsp;&nbsp;

        <i class="fas fa-envelope text-info"></i>
        <?= esc(env('clinic.email') ?? 'info@clinic.com') ?>
    </div>
</div>

<!-- MAIN NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top" style="top:30px;">
    <div class="container">

        <a class="navbar-brand fw-bold text-primary" href="#">
            🏥 <?= esc(env('clinic.name') ?? 'Clinic Pro') ?>
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/doctors">Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="/services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="/appointment">Appointment</a></li>

                <li class="nav-item ms-2">
                    <a class="btn btn-primary btn-sm" href="/login">Login</a>
                </li>

            </ul>

        </div>

    </div>
</nav>