<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0 text-dark">My Profile</h1>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">User Information</h3>
            </div>
            <div class="card-body">
              <p><strong>Name:</strong> <?= esc($user['name']) ?></p>
              <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
              <p><strong>Phone:</strong> <?= esc($user['phone']) ?></p>
              <p><strong>Role:</strong> <?= esc($user['role']) ?></p>
            </div>
            <div class="card-footer">
              <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Back to Dashboard</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
