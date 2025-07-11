<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-3">Edit Student</h1>
    <a href="<?= site_url('admin/students/view/' . $student['id']) ?>" class="btn btn-secondary mb-3">← Back to Profile</a>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <form action="<?= site_url('admin/students/update/' . $student['id']) ?>" method="post">
      <?= csrf_field() ?>
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-md-6">
              <label>Name</label>
              <input type="text" name="student_name" class="form-control" value="<?= esc($student['student_name']) ?>" required>
            </div>
            <div class="col-md-3">
              <label>Roll</label>
              <input type="text" name="roll" class="form-control" value="<?= esc($student['roll']) ?>">
            </div>
            <div class="col-md-3">
              <label>Class</label>
              <input type="text" name="class" class="form-control" value="<?= esc($student['class']) ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-4">
              <label>Section</label>
              <input type="text" name="section" class="form-control" value="<?= esc($student['section']) ?>">
            </div>
            <div class="col-md-4">
              <label>ESIF</label>
              <input type="text" name="esif" class="form-control" value="<?= esc($student['esif']) ?>">
            </div>
            <div class="col-md-4">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" value="<?= esc($student['phone']) ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Father's Name</label>
              <input type="text" name="father_name" class="form-control" value="<?= esc($student['father_name']) ?>">
            </div>
            <div class="col-md-6">
              <label>Father's NID</label>
              <input type="text" name="father_nid_number" class="form-control" value="<?= esc($student['father_nid_number']) ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Mother's Name</label>
              <input type="text" name="mother_name" class="form-control" value="<?= esc($student['mother_name']) ?>">
            </div>
            <div class="col-md-6">
              <label>Mother's NID</label>
              <input type="text" name="mother_nid_number" class="form-control" value="<?= esc($student['mother_nid_number']) ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-4">
              <label>Date of Birth</label>
              <input type="date" name="dob" class="form-control" value="<?= esc($student['dob']) ?>">
            </div>
            <div class="col-md-4">
              <label>Gender</label>
              <select name="gender" class="form-control">
                <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Birth Registration No.</label>
              <input type="text" name="birth_registration_number" class="form-control" value="<?= esc($student['birth_registration_number']) ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
	      <label>Religion</label>
<select name="religion" class="form-control">
  <option value="">Select Religion</option>
  <option value="Islam" <?= $student['religion'] === 'Islam' ? 'selected' : '' ?>>Islam</option>
  <option value="Hinduism" <?= $student['religion'] === 'Hinduism' ? 'selected' : '' ?>>Hinduism</option>
  <option value="Christianity" <?= $student['religion'] === 'Christianity' ? 'selected' : '' ?>>Christianity</option>
  <option value="Buddhism" <?= $student['religion'] === 'Buddhism' ? 'selected' : '' ?>>Buddhism</option>
  <option value="Other" <?= $student['religion'] === 'Other' ? 'selected' : '' ?>>Other</option>
  </select>

            </div>
            <div class="col-md-6">
              <label>Blood Group</label>
		<select name="blood_group" class="form-control">
			  <option value="">Select Blood Group</option>
		  <?php
		    $bloods = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
		    foreach ($bloods as $bg):
		  ?>
		    <option value="<?= $bg ?>" <?= $student['blood_group'] === $bg ? 'selected' : '' ?>><?= $bg ?></option>
		  <?php endforeach; ?>
		</select>


            </div>
          </div>

          <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
          </div>

        </div>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>

