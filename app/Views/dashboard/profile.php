<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-3">Student Profile</h1>
    <a href="<?= site_url('ad-student') ?>" class="btn btn-secondary mb-3">← Back to List</a>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <!-- Profile Card -->
        <div class="card card-primary card-outline position-relative" style="overflow: hidden;">

          <!-- Ribbon -->
          <div class="ribbon-wrapper ribbon-lg">
            <div class="ribbon bg-success text-lg">
              Active
            </div>
          </div>

          <!-- Profile Body -->
          <div class="card-body box-profile text-center" style="padding-top: 50px;">

            <!-- Profile Image -->
            <img class="profile-user-img img-fluid img-circle mb-3"
                 src="<?= base_url('uploads/profile/' . $student['photo']) ?>"
                 alt="Profile picture">

            <!-- Student Name -->
            <h3 class="profile-username"><?= esc($student['name']) ?></h3>

            <!-- Basic Info -->
            <p class="text-muted mb-1">Roll: <?= esc($student['roll']) ?></p>
            <p class="text-muted mb-3">Class: <?= esc($student['class']) ?></p>

            <!-- Contact Info -->
            <ul class="list-group list-group-unbordered mb-3 text-left">
              <li class="list-group-item">
                <b>Father's Name</b> <span class="float-right"><?= esc($student['father_name']) ?></span>
              </li>
              <li class="list-group-item">
                <b>Mother's Name</b> <span class="float-right"><?= esc($student['mother_name']) ?></span>
              </li>
              <li class="list-group-item">
                <b>Phone</b> <span class="float-right"><?= esc($student['phone']) ?></span>
              </li>
              <li class="list-group-item">
                <b>Address</b> <span class="float-right"><?= esc($student['address']) ?></span>
              </li>
            </ul>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

