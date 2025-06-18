<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('public/images/profile-placeholder.png') ?>" class="rounded-circle" width="120" height="120" alt="Profile Picture">
                        <h3 class="mt-3 mb-0"><?= esc(session('user_name')) ?></h3>
                        <span class="text-muted"><?= esc(session('user_role')) ?></span>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Designation</div>
                        <div class="col-sm-8"><?= esc(session('designation') ?? 'N/A') ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Subject</div>
                        <div class="col-sm-8"><?= esc(session('subject') ?? 'N/A') ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Gender</div>
                        <div class="col-sm-8"><?= esc(session('gender') ?? 'N/A') ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Phone</div>
                        <div class="col-sm-8"><?= esc(session('phone') ?? 'N/A') ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Email</div>
                        <div class="col-sm-8"><?= esc(session('user_email')) ?></div>
                    </div>

                    <div class="text-end">
                        <small class="text-muted">Last updated: <?= esc(session('updated_at') ?? 'Unknown') ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
