<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- HERO -->
<div class="hero">
    <div class="container">
        <h1>Best Healthcare For You</h1>
        <p>Trusted Doctors | Modern Treatment | 24/7 Care</p>
        <a href="#" class="btn btn-light btn-lg rounded-pill mt-3 px-4">
            Book Appointment
        </a>
    </div>
</div>

<!-- SERVICES -->
<div class="container section">

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
<div class="container section">

    <div class="section-title">
        <h2>Our Doctors</h2>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="doctor-card">
                <img src="<?= base_url('public/assets/img/doc1.jpg') ?>">
                <h5>Dr. Rahman</h5>
                <p class="text-center">Cardiologist</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="doctor-card">
                <img src="<?= base_url('public/assets/img/doc2.jpg') ?>">
                <h5>Dr. Sultana</h5>
                <p class="text-center">Dentist</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="doctor-card">
                <img src="<?= base_url('public/assets/img/doc3.jpg') ?>">
                <h5>Dr. Karim</h5>
                <p class="text-center">Neurologist</p>
            </div>
        </div>

    </div>
</div>

<!-- CTA -->
<div class="container section">
    <div class="cta">
        <h2>Need Medical Help?</h2>
        <p>Book appointment instantly with our doctors</p>
        <a href="#" class="btn btn-light px-4 rounded-pill">Book Now</a>
    </div>
</div>

<?= $this->endSection(); ?>