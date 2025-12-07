<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-3">Register New Student</h1>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session('errors')): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('admin/students/save') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-md-6">
              <label>Student Name</label>
              <input type="text" name="student_name" class="form-control" value="<?= old('student_name') ?>" required>
            </div>
            <div class="col-md-3">
              <label>Roll</label>
              <input type="text" name="roll" class="form-control" value="<?= old('roll') ?>" required>
            </div>
            <div class="col-md-3">
              <label>Class</label>
              <select name="class" id="class-select" class="form-control" required>
                <option value="">Select Class</option>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                  <option value="<?= $i ?>" <?= old('class') == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Section (optional, only for Class 9 & 10)</label>
              <select name="section" class="form-control">
                <option value="">Select Section</option>
                <option value="n/a" <?= old('section') == 'n/a' ? 'selected' : '' ?>>N/A</option>
                <option value="General - Science" <?= old('section') == 'General - Science' ? 'selected' : '' ?>>General → Science</option>
                <option value="General - Arts" <?= old('section') == 'General - Arts' ? 'selected' : '' ?>>General → Arts</option>
                <option value="Vocational - Food Processing and Preservation" <?= old('section') == 'Vocational - Food Processing and Preservation' ? 'selected' : '' ?>>Vocational → Food Processing and Preservation</option>
                <option value="Vocational - IT Support and IoT Basics" <?= old('section') == 'Vocational - IT Support and IoT Basics' ? 'selected' : '' ?>>Vocational → IT Support and IoT Basics</option>
              </select>
            </div>

            <div class="col-md-6">
              <label>Board ID</label>
              <input type="text" name="esif" class="form-control" value="<?= old('esif') ?>" required>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Father's Name</label>
              <input type="text" name="father_name" class="form-control" value="<?= old('father_name') ?>">
            </div>
            <div class="col-md-6">
              <label>Father NID Number</label>
              <input type="text" name="father_nid_number" class="form-control" value="<?= old('father_nid_number') ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Mother's Name</label>
              <input type="text" name="mother_name" class="form-control" value="<?= old('mother_name') ?>">
            </div>
            <div class="col-md-6">
              <label>Mother NID Number</label>
              <input type="text" name="mother_nid_number" class="form-control" value="<?= old('mother_nid_number') ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-4">
              <label>Date of Birth</label>
              <input type="date" name="dob" class="form-control" value="<?= old('dob') ?>">
            </div>
            <div class="col-md-4">
              <label>Gender</label>
              <select name="gender" class="form-control">
                <option value="">Select Gender</option>
                <option value="Male" <?= old('gender') === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= old('gender') === 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= old('gender') === 'Other' ? 'selected' : '' ?>>Other</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Birth Registration No.</label>
              <input type="text" name="birth_registration_number" class="form-control" value="<?= old('birth_registration_number') ?>">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Religion</label>
              <select name="religion" class="form-control">
                <option value="">Select Religion</option>
                <option value="Islam" <?= old('religion') === 'Islam' ? 'selected' : '' ?>>Islam</option>
                <option value="Hinduism" <?= old('religion') === 'Hinduism' ? 'selected' : '' ?>>Hinduism</option>
                <option value="Christianity" <?= old('religion') === 'Christianity' ? 'selected' : '' ?>>Christianity</option>
                <option value="Buddhism" <?= old('religion') === 'Buddhism' ? 'selected' : '' ?>>Buddhism</option>
                <option value="Other" <?= old('religion') === 'Other' ? 'selected' : '' ?>>Other</option>
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
                  <option value="<?= $bg ?>" <?= old('blood_group') === $bg ? 'selected' : '' ?>><?= $bg ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Phone Number</label>
              <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>">
            </div>
            <div class="col-md-6">
              <label>Student Picture</label>
              <input type="file" name="student_pic" class="form-control">
            </div>
          </div>

          <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
          </div>

        </div>
      </div>
    </form>
  </div>
</div>

<?= $this->section('scripts') ?>
<?= $this->section('scripts') ?>
<script>
  function toggleSection() {
    const classSelect = document.getElementById('class-select');
    const sectionRow = document.getElementById('section-row');
    const selected = classSelect.value;

    if (selected === '9' || selected === '10') {
      sectionRow.style.display = 'flex'; // works better for .row
    } else {
      sectionRow.style.display = 'none';
    }
  }

  document.addEventListener('DOMContentLoaded', toggleSection);
  document.getElementById('class-select').addEventListener('change', toggleSection);
</script>
<?= $this->endSection() ?><?= $this->endSection() ?>

<?= $this->endSection() ?>