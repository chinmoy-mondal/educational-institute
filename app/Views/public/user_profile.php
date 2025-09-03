<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content">

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
                                    <img src="<?= base_url('uploads/users/' . ($member['picture'] ?? 'default.jpg')) ?>"
                                        class="rounded-circle img-fluid faculty-img mb-3"
                                        style="width:150px; height:150px; object-fit:cover; border:4px solid #f1f1f1;"
                                        alt="<?= esc($member['name']); ?>">
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1"><?= esc($member['name']); ?></h5>
                                    <p class="text-primary small mb-2"><?= esc(strtoupper($member['designation'])); ?></p>
                                    <p class="text-primary small mb-2"><?= esc($member['subject']); ?></p>
                                    <p class="text-muted small" style="text-align: justify;">
                                        <?= esc($member['bio'], 'raw') ?>
                                    </p>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer bg-white border-0 d-flex justify-content-center gap-2 flex-wrap">
                                    <!-- Email -->
                                    <?php if (!empty($member['email'])): ?>
                                        <a href="mailto:<?= esc($member['email']); ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-envelope"></i> Email
                                        </a>
                                    <?php endif; ?>

                                    <!-- Phone -->
                                    <?php if (!empty($member['phone'])): ?>
                                        <a href="tel:<?= esc($member['phone']); ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-phone"></i> Call
                                        </a>
                                    <?php endif; ?>

                                    <!-- Social Profile -->
                                    <?php if (!empty($member['social_profile'])): ?>
                                        <?php
                                            $social = $member['social_profile'];
                                            $url = '#';
                                            $icon = 'fab fa-linkedin';

                                            // Determine social type by prefix
                                            if (str_starts_with($social, 'f:')) {
                                                $icon = 'fab fa-facebook';
                                                $url = substr($social, 2);
                                            } elseif (str_starts_with($social, 'y:')) {
                                                $icon = 'fab fa-youtube';
                                                $url = substr($social, 2);
                                            } elseif (str_starts_with($social, 'l:')) {
                                                $icon = 'fab fa-linkedin';
                                                $url = substr($social, 2);
                                            }
                                            $url = trim($url);
                                        ?>
                                        <a href="<?= esc($url) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="<?= esc($icon) ?>"></i> Profile
                                        </a>
                                    <?php endif; ?>

                                    <!-- ID Card -->
                                    <a href="<?= base_url('teacher_idcard/' . $member['id']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
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

    <style>
        .faculty-staff {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }
        .faculty-img {
            object-fit: cover;
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