<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-4 mb-4">
    <div class="card shadow-sm p-4">
        <h2 class="mb-4">My Profile</h2>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Name:</div>
            <div class="col-md-9"><?= esc($user['name']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Role:</div>
            <div class="col-md-9"><?= esc($user['role']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Designation:</div>
            <div class="col-md-9"><?= esc($user['designation']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Email:</div>
            <div class="col-md-9"><?= esc($user['email']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Phone:</div>
            <div class="col-md-9"><?= esc($user['phone']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Subject:</div>
            <div class="col-md-9"><?= esc($user['subject']) ?></div>
        </div>

        <?php if (!empty($user['picture'])): ?>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Picture:</div>
            <div class="col-md-9">
                <img src="<?= base_url('uploads/' . $user['picture']) ?>" 
                     alt="Profile Picture" 
                     class="img-thumbnail" 
                     style="max-width: 150px;">
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

