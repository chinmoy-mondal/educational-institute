<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
        <!-- ✅ Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
    <h1 class="mb-3">Student Profile</h1>
    <a href="<?= site_url('admin/student') ?>" class="btn btn-secondary mb-3">← Back to List</a>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <!-- 🖼️ Student Photo -->
          <div class="col-md-3 text-center">
            <div class="position-relative d-inline-block" style="max-width: 180px;">
              <a href="<?= site_url('admin/students/edit-photo/' . $student['id']) ?>" class="position-absolute top-0 start-0" title="Edit Photo">
                <i class="fas fa-edit"></i>
              </a>
              <?php if (!empty($student['student_pic'])): ?>
                <img src="/<?= esc($student['student_pic']) ?>" alt="Student Photo" class="img-thumbnail w-100">
              <?php else: ?>
                <img src="<?= base_url('public/assets/img/default.png') ?>" alt="No Photo" class="img-thumbnail w-100">
              <?php endif; ?>
            </div>
          </div>

          <!-- 👤 Student Info + Subject + Form -->
          <div class="col-md-9">
            <div class="row">
              <!-- 🧑 Column 1: Student Info -->
              <div class="col-md-8">
                <h4><?= esc($student['student_name']) ?> (Roll: <?= esc($student['roll']) ?>)</h4>
                <p><strong>Class:</strong> <?= esc($student['class']) ?> | <strong>Section:</strong> <?= esc($student['section']) ?></p>
                <p><strong>Board ID:</strong> <?= esc($student['esif']) ?></p>
                <p><strong>Phone:</strong> <?= esc($student['phone']) ?></p>
                <p><strong>Gender:</strong> <?= esc($student['gender']) ?> | <strong>DOB:</strong> <?= esc($student['dob']) ?></p>
                <p><strong>Religion:</strong> <?= esc($student['religion']) ?> | <strong>Blood Group:</strong> <?= esc($student['blood_group']) ?></p>
                <a href="<?= site_url('admin/students/edit/' . $student['id']) ?>" class="btn btn-success btn-sm mt-2">
                  <i class="fas fa-edit"></i> Edit Profile
                </a>
              </div>

              <!-- 📚 Column 2: Assigned Subjects as <select> -->
              <div class="col-md-4">
                <h5>Select Subject</h5>

                <form action="<?= site_url('admin/students/forth/' . $student['id']) ?>" method="post">
                  <?= csrf_field() ?>

                  <select class="form-select" id="subjectSelect" name="selectid" size="10">
                    <option disabled selected>Click a subject to select</option>
                    <?php foreach ($subjects as $subject): ?>
                      <option value="<?= esc($subject['id']) ?>"><?= esc($subject['subject']) ?></option>
                    <?php endforeach; ?>
                  </select>

                  <!-- Hidden input to store selected subject ID -->
                  <input type="hidden" id="subject_id_input" name="subject_id" value="<?= esc($subjectsStr) ?>">

                  <button type="submit" class="btn btn-primary btn-sm mt-3 w-100" id="updateSubjectBtn">
                    <i class="fas fa-edit"></i> 4th subject
                  </button>
                </form>
              </div>

            </div>
          </div>
        </div>

        <hr>

        <!-- 👨‍👩‍👧 Guardian Info -->
        <div class="row mt-3">
          <div class="col-md-6">
            <h5>Father's Information</h5>
            <p><strong>Name:</strong> <?= esc($student['father_name']) ?></p>
            <p><strong>NID:</strong> <?= esc($student['father_nid_number']) ?></p>
          </div>
          <div class="col-md-6">
            <h5>Mother's Information</h5>
            <p><strong>Name:</strong> <?= esc($student['mother_name']) ?></p>
            <p><strong>NID:</strong> <?= esc($student['mother_nid_number']) ?></p>
          </div>
        </div>

        <div class="mt-4">
          <p><strong>Birth Registration No:</strong> <?= esc($student['birth_registration_number']) ?></p>
          <p><small><strong>Created:</strong> <?= esc($student['created_at']) ?> | <strong>Updated:</strong> <?= esc($student['updated_at']) ?></small></p>
        </div>

      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>