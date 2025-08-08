<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php
            $profilePicture = session('picture');
            $profilePictureUrl = (!empty($profilePicture) && file_exists(FCPATH . $profilePicture))
                ? base_url($profilePicture)
                : base_url('public/assets/img/default-user.png');
            ?>

            <div class="card shadow-sm border-0">
                <div class="row g-0">
                    
                    <!-- Left Column -->
                    <div class="col-md-4 text-center bg-light p-4">
                        <img src="<?= $profilePictureUrl ?>" alt="Profile Picture" 
                             class="img-fluid rounded-circle mb-3 border" 
                             style="width: 120px; height: 120px; object-fit: cover;">
                        <h4 class="mb-0"><?= esc(session('name') ?? 'Unknown') ?></h4>
                        <span class="badge bg-primary"><?= esc(session('role') ?? 'N/A') ?></span>
                        <p class="text-muted mt-2 mb-1"><?= esc(session('designation') ?? '') ?></p>
                        <small class="<?= session('account_status') == 'active' ? 'text-success' : 'text-danger' ?>">
                            <?= ucfirst(session('account_status') ?? 'Unknown') ?>
                        </small>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-8 p-4">
                        <h5 class="mb-3">Profile Information</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Subject:</strong> <?= esc(session('subject') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Assigned Subject:</strong> <?= esc(session('assagin_sub') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Gender:</strong> <?= esc(session('gender') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Religion:</strong> <?= esc(session('religion') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Blood Group:</strong> <?= esc(session('blood_group') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Phone:</strong> <?= esc(session('phone') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Email:</strong> <?= esc(session('email') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Permit By:</strong> <?= esc(session('permit_by') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Created At:</strong> <?= esc(session('created_at') ?? 'N/A') ?></li>
                            <li class="list-group-item"><strong>Last Updated:</strong> <?= esc(session('updated_at') ?? 'N/A') ?></li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>