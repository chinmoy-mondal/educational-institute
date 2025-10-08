<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content") ?>

<!-- Fixed Header -->
<div class="fixed-header">
  <?= $this->include("layouts/base-structure/header") ?>
</div>

<!-- Page Title -->
<div class="page-title text-center py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-primary">Student Attendance List</h2>
    <p class="text-muted mb-0">Filter students by class and section</p>
  </div>
</div>

<!-- Attendance Table Section -->
<section class="py-5">
  <div class="container">

    <!-- Filter Form -->
    <form method="get" class="row g-2 mb-4 justify-content-center">
      <div class="col-md-3">
        <select name="class" class="form-select">
          <option value="">All Classes</option>
          <?php foreach($classes as $c): ?>
            <option value="<?= esc($c['class']) ?>" <?= ($selectedClass == $c['class']) ? 'selected' : '' ?>>
              <?= esc($c['class']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <select name="section" class="form-select">
          <option value="">All Sections</option>
          <?php foreach($sections as $s): ?>
            <option value="<?= esc($s['section']) ?>" <?= ($selectedSection == $s['section']) ? 'selected' : '' ?>>
              <?= esc($s['section']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
      <div class="col-md-2 d-grid">
        <a href="<?= base_url('attendance') ?>" class="btn btn-secondary">Reset</a>
      </div>
    </form>

    <!-- Attendance Table -->
    <div class="table-responsive shadow-sm">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th width="10%">#</th>
            <th width="40%">Student Name</th>
            <th width="15%">Roll</th>
            <th width="15%">Class</th>
            <th width="15%">Section</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($students)): ?>
            <?php $i = 1; foreach($students as $student): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td class="text-start"><?= esc($student['student_name']) ?></td>
                <td><?= esc($student['roll']) ?></td>
                <td><?= esc($student['class']) ?></td>
                <td><?= esc($student['section']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">No students found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</section>

<!-- Footer -->
<?= $this->include("layouts/base-structure/footer") ?>

<?= $this->endSection() ?>