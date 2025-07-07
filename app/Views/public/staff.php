<?= $this->include("../layouts/base-structure/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("../layouts/base-structure/header"); ?>
        </div>
        <div class="container content">







<!--start-->
<!-- Faculty & Staff Section -->
<section class="faculty-staff py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Meet Our Faculty & Staff</h2>
            <p class="text-muted">Dedicated professionals committed to excellence in education.</p>
        </div>

        <div class="row">
            <!-- Faculty Member 1 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 1">
                    <div class="card-body">
                        <h5 class="fw-bold">Dr. John Doe</h5>
                        <p class="text-muted">Principal</p>
                        <p class="small">With over 20 years of experience in education, Dr. John is dedicated to shaping the future.</p>
                    </div>
                </div>
            </div>

            <!-- Faculty Member 2 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 2">
                    <div class="card-body">
                        <h5 class="fw-bold">Ms. Jane Smith</h5>
                        <p class="text-muted">Vice Principal</p>
                        <p class="small">Passionate about innovative teaching methods and student success.</p>
                    </div>
                </div>
            </div>

            <!-- Faculty Member 3 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 3">
                    <div class="card-body">
                        <h5 class="fw-bold">Mr. Alex Johnson</h5>
                        <p class="text-muted">Head of Science Department</p>
                        <p class="small">Bringing the wonders of science to life with hands-on learning.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Faculty Member 1 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 1">
                    <div class="card-body">
                        <h5 class="fw-bold">Dr. John Doe</h5>
                        <p class="text-muted">Principal</p>
                        <p class="small">With over 20 years of experience in education, Dr. John is dedicated to shaping the future.</p>
                    </div>
                </div>
            </div>

            <!-- Faculty Member 2 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 2">
                    <div class="card-body">
                        <h5 class="fw-bold">Ms. Jane Smith</h5>
                        <p class="text-muted">Vice Principal</p>
                        <p class="small">Passionate about innovative teaching methods and student success.</p>
                    </div>
                </div>
            </div>

            <!-- Faculty Member 3 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 3">
                    <div class="card-body">
                        <h5 class="fw-bold">Mr. Alex Johnson</h5>
                        <p class="text-muted">Head of Science Department</p>
                        <p class="small">Bringing the wonders of science to life with hands-on learning.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Faculty Member 1 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 1">
                    <div class="card-body">
                        <h5 class="fw-bold">Dr. John Doe</h5>
                        <p class="text-muted">Principal</p>
                        <p class="small">With over 20 years of experience in education, Dr. John is dedicated to shaping the future.</p>
                    </div>
                </div>
            </div>

            <!-- Faculty Member 2 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 2">
                    <div class="card-body">
                        <h5 class="fw-bold">Ms. Jane Smith</h5>
                        <p class="text-muted">Vice Principal</p>
                        <p class="small">Passionate about innovative teaching methods and student success.</p>
                    </div>
                </div>
            </div>

            <!-- Faculty Member 3 -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0">
                    <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" class="card-img-top faculty-img" alt="Faculty 3">
                    <div class="card-body">
                        <h5 class="fw-bold">Mr. Alex Johnson</h5>
                        <p class="text-muted">Head of Science Department</p>
                        <p class="small">Bringing the wonders of science to life with hands-on learning.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    .faculty-staff {
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
    }

    .faculty-img {
        height: 250px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>
<!--end-->













        </div>


        <?= $this->include("../layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>
  