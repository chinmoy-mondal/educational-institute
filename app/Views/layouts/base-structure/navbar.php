<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">

        <a class="navbar-brand fw-bold text-primary" href="#">
            🏥 <?= esc(env('clinic.name') ?? 'Clinic') ?>
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/doctors">Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="/services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>

                <li class="nav-item ms-2">
                    <a class="btn btn-primary btn-sm" href="/login">Login</a>
                </li>

            </ul>

        </div>

    </div>
</nav>