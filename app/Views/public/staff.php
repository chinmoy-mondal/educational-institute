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
            <div class="text-center mb-4">
                <h2 class="fw-bold">Meet Our Faculty & Staff</h2>
                <p class="text-muted">Dedicated professionals committed to excellence in education.</p>
            </div>

            <div class="row">
                <?php if (!empty($faculty)): ?>
                    <?php foreach ($faculty as $member): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card text-center shadow-sm border-0">
                                <img src="<?= base_url($member['picture'] ?? 'public/assets/img/default.jpg'); ?>"
                                    class="card-img-top faculty-img"
                                    alt="<?= esc($member['name']); ?>">
                                <div class="card-body">
                                    <h5 class="fw-bold"><?= esc($member['name']); ?></h5>
                                    <p class="text-muted"><?= esc($member['designation']); ?></p>
                                    <p class="small"><?= esc($member['bio']); ?></p>
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