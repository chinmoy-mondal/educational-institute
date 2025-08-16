<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
  <!-- Edit Profile Card -->
  <div class="card card-primary card-outline mb-4 p-3">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-user-edit me-2"></i>Edit <?= esc($user['role']) ?> Info</h3>
    </div>
    <form action="<?= site_url('admin/students/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="card-body">
        <div class="row">
          <!-- Left: Profile Picture -->
          <div class="col-md-3 text-center">
            <div class="mb-3">
              <img src="<?= base_url('public/assets/img/' . ($user['photo'] ?? 'default-profile-pic.png')) ?>"
                   alt="Profile Photo"
                   class="img-fluid mb-2"
                   style="width:150px; height:200px; object-fit:cover; border-radius:4px;">
            </div>
            <input type="file" name="photo" class="form-control form-control-sm">
          </div>

          <!-- Right: Form Fields -->
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-user-tag me-2"></i>Position</label>
                <input type="text" name="role" value="<?= esc($user['role']) ?>" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-id-card me-2"></i>Index No.</label>
                <input type="text" name="index_number" value="<?= esc($user['index_number']) ?>" class="form-control" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>DOB</label>
                <input type="date" name="dob" value="<?= esc($user['dob']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-user-clock me-2"></i>Joining Date</label>
                <input type="date" name="joining_date" value="<?= esc($user['joining_date']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-user-clock me-2"></i>MPO Date</label>
                <input type="date" name="mpo_date" value="<?= esc($user['mpo_date']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-book me-2"></i>Subject</label>
                <input type="text" name="subject" value="<?= esc($user['subject']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                <select name="gender" class="form-control">
                  <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                  <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                  <option value="Other" <?= $user['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-praying-hands me-2"></i>Religion</label>
                <input type="text" name="religion" value="<?= esc($user['religion']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-phone-alt me-2"></i>Phone</label>
                <input type="text" name="phone" value="<?= esc($user['phone']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                <input type="email" name="email" value="<?= esc($user['email']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-book-reader me-2"></i>Assigned Subject</label>
                <input type="text" name="assagin_sub" value="<?= esc($user['assagin_sub']) ?>" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-user-check me-2"></i>Account Status</label>
                <select name="account_status" class="form-control">
                  <option value="Active" <?= $user['account_status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                  <option value="Inactive" <?= $user['account_status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fas fa-user-shield me-2"></i>Permit By</label>
                <input type="text" name="permit_by" value="<?= esc($user['permit_by']) ?>" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Save Changes</button>
        <a href="<?= site_url('admin/students/profile/' . $user['id']) ?>" class="btn btn-secondary"><i class="fas fa-times me-2"></i>Cancel</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>