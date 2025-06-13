<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">My Profile</h1>
      </div>
    </div>
  </div>
</div>

<!-- Profile Content -->
<div class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center mb-3">
              <img class="profile-user-img img-fluid img-circle"
                   src="<?= base_url('adminlte/dist/img/user.png') ?>"
                   alt="User profile picture"
                   style="width: 100px;">
            </div>

            <h3 class="profile-username text-center"><?= esc(session('user_name')) ?></h3>
            <p class="text-muted text-center"><?= esc(session('user_role')) ?></p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Email</b> <span class="float-right"><?= esc(session('user_email')) ?></span>
              </li>
              <li class="list-group-item">
                <b>Role</b> <span class="float-right"><?= esc(session('user_role')) ?></span>
              </li>
            </ul>

            <a href="<?= base_url('dashboard') ?>" class="btn btn-primary btn-block">
              <b><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</b>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
