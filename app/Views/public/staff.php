<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!--  Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>
<div class="container content">







    <!--start-->
    <section class="faculty-staff py-5">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Meet Our Faculty & Staff</h2>
                <p class="text-muted fs-5">Dedicated professionals committed to excellence in education</p>
            </div>

            <div class="row g-4">
                <?php if (!empty($faculty)): ?>
                    <?php foreach ($faculty as $member): ?>
                        <div class="col-md-4">
                            <div class="card h-100 text-center border-0 shadow-sm faculty-card">
                                <!-- Profile Image -->
                                <div class="p-3">
                                    <img src="<?= base_url($member['picture'] ?? 'public/assets/img/default.jpg'); ?>"
                                        class="rounded-circle img-fluid faculty-img mb-3"
                                        style="width:150px; height:150px; object-fit:cover; border:4px solid #f1f1f1;"
                                        alt="<?= esc($member['name']); ?>">
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1"><?= esc($member['name']); ?></h5>
                                    <p class="text-primary small mb-2"><?= esc($member['designation']); ?></p>
                                    <p class="text-muted small" style="text-align: justify;">
                                        <?= esc($member['bio']); ?>
                                    </p>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer bg-white border-0">
                                    <a href="mailto:<?= esc($member['email'] ?? ''); ?>" class="btn btn-outline-primary btn-sm me-2">
                                        <i class="fas fa-envelope"></i> Email
                                    </a>
                                    <a href="" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="fab fa-linkedin"></i> Profile
                                    </a>
                                    <a href="#" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-id-card"></i> Card
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No faculty members found.</p>
                <?php endif; ?>
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


<?= $this->include("layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>