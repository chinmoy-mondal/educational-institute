<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("layouts/base-structure/header"); ?>
        </div>
        <div class="container content">





<!-- Mission & Vision Section -->
<section class="mission-vision py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Our Mission & Vision</h2>
            <p class="text-muted">Guiding principles that define our educational excellence.</p>
        </div>
        
        <div class="row align-items-center">
            <!-- Mission -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-bullseye text-primary fa-3x mb-3"></i> <!-- Mission Icon -->
                        <h3 class="fw-semibold">Our Mission</h3>
                        <p class="text-muted">
                            We strive to provide a nurturing learning environment that fosters academic excellence, character development, and lifelong learning.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vision -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-eye text-success fa-3x mb-3"></i> <!-- Vision Icon -->
                        <h3 class="fw-semibold">Our Vision</h3>
                        <p class="text-muted">
                            To empower students with knowledge, skills, and values to become responsible and successful global citizens.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Styles -->
<style>
    .mission-vision {
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
    }

    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>















        </div>


        <?= $this->include("layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>
  