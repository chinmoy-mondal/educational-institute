<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
    .profile-header {
        position: relative;
        height: 180px;
        background: linear-gradient(135deg, #0062E6, #33AEFF);
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }
    .profile-img {
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        border: 4px solid #fff;
        border-radius: 50%;
    }
    .profile-name {
        margin-top: 60px;
    }
    .profile-card {
        border-radius: 1rem;
        overflow: hidden;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 profile-card">
                
                <!-- Profile Header -->
                <div class="profile-header"></div>

                <!-- Profile Body -->
                <div class="card-body text-center">
                    <img src="<?= base_url('public/assets/img/logo.jpg') ?>" width="100" height="100" class="profile-img shadow">
                    <h3 class="profile-name"><?= esc(session('user_name') ?? 'Unknown User') ?></h3>
                    <span class="badge bg-primary"><?= esc(session('user_role') ?? 'User') ?></span>
                    <p class="text-muted mb-4">
                        <?= esc(session('designation') ?? 'No designation set') ?>
                    </p>

                    <hr>

                    <!-- User Info -->
                    <div class="row text-start px-4">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-book"></i> Subject:</strong> 
                            <span class="text-muted"><?= esc(session('subject') ?? 'N/A') ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-gender-ambiguous"></i> Gender:</strong> 
                            <span class="text-muted"><?= esc(session('gender') ?? 'N/A') ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-telephone"></i> Phone:</strong> 
                            <span class="text-muted"><?= esc(session('phone') ?? 'N/A') ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-envelope"></i> Email:</strong> 
                            <span class="text-muted"><?= esc(session('user_email') ?? 'N/A') ?></span>
                        </div>
                    </div>

                    <hr>
                    <div class="text-muted small">
                        <i class="bi bi-clock-history"></i> Last updated: <?= esc(session('updated_at') ?? 'Unknown') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<?= $this->endSection() ?>