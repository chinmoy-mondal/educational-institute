<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <div class="d-flex align-items-center">
            <img src="<?= base_url('uploads/' . $user['picture']) ?>" 
                 alt="Profile Picture" 
                 class="rounded-circle" 
                 width="120" height="120">
            <div class="ms-3">
                <h4><?= esc($user['name']) ?></h4>
                <p class="mb-1"><strong>Email:</strong> <?= esc($user['email']) ?></p>
                <p class="mb-1"><strong>Phone:</strong> <?= esc($user['phone']) ?></p>
                <p class="mb-1"><strong>Designation:</strong> <?= esc($user['designation']) ?></p>
                <p class="mb-1"><strong>Role:</strong> <?= esc($user['role']) ?></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

