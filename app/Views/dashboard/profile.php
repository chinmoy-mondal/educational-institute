<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- Top Profile Card -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body p-4 d-flex align-items-center">
            <!-- Left: Profile Image -->
            <div class="me-4">
                <img src="<?= base_url('public/assets/img/logo.jpg') ?>" 
                     class="rounded-circle border"
                     alt="Profile" 
                     width="120" height="120">
            </div>

            <!-- Right: Info -->
            <div>
                <h4 class="mb-1"><?= esc(session('user_name')) ?></h4>
                <p class="text-muted mb-2"><?= esc(session('user_role')) ?></p>
                
                <div><strong>Designation:</strong> <?= esc(session('designation') ?? 'N/A') ?></div>
                <div><strong>Subject:</strong> <?= esc(session('subject') ?? 'N/A') ?></div>
                <div><strong>Gender:</strong> <?= esc(session('gender') ?? 'N/A') ?></div>
                <div><strong>Phone:</strong> <?= esc(session('phone') ?? 'N/A') ?></div>
                <div><strong>Email:</strong> <?= esc(session('user_email')) ?></div>
                <small class="text-muted d-block mt-2">
                    Last updated: <?= esc(session('updated_at') ?? 'Unknown') ?>
                </small>
            </div>
        </div>
    </div>

    <!-- Section Cards -->
    <div class="row g-3">

        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 rounded-4">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Photo & Personal Information</h5>
                    <p class="text-muted flex-grow-1">Manage your profile picture and personal details.</p>
                    <a href="#" class="btn btn-primary mt-auto">Edit</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 rounded-4">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Assign Class</h5>
                    <p class="text-muted flex-grow-1">Assign or change your teaching classes.</p>
                    <a href="#" class="btn btn-primary mt-auto">Edit</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 rounded-4">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Attendance</h5>
                    <p class="text-muted flex-grow-1">View and manage your attendance records.</p>
                    <a href="#" class="btn btn-primary mt-auto">Edit</a>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>

