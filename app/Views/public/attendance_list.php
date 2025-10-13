<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<div class="fixed-header">
  <?= $this->include("layouts/base-structure/header") ?>
</div>

<div class="page-title text-center py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-primary">Class Attendance Overview</h2>
    <p class="text-muted mb-0">Select a class to view student attendance percentage</p>
  </div>
</div>

<section class="py-5">
  <div class="container">

    <!-- Class Filter -->
    <form method="get" class="row g-2 mb-4 justify-content-center">
      <div class="col-md-4">
        <select name="class" class="form-select">
          <option value="">Select Class</option>
          <?php foreach ($classes as $c): ?>
            <option value="<?= esc($c['class']) ?>" <?= ($selectedClass == $c['class']) ? 'selected' : '' ?>>
              Class <?= esc($c['class']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>

    <?php if (!empty($students)): ?>
      <div class="table-responsive shadow-sm">
        <table class="table table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Student Name</th>
              <th>Roll</th>
              <th>Class</th>
              <th>Section</th>
              <th>Total Present</th>
              <th>Total Days</th>
              <th>Attendance %</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($students as $student): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td class="text-start"><?= esc($student['student_name']) ?></td>
                <td><?= esc($student['roll']) ?></td>
                <td><?= esc($student['class']) ?></td>
                <td><?= esc($student['section']) ?></td>
                <td><?= esc($student['total_present']) ?></td>
                <td><?= esc($student['total_days']) ?></td>
                <td>
                  <div class="progress" style="height: 20px;">
                    <div class="progress-bar 
                        <?= ($student['percentage'] >= 75) ? 'bg-success' : (($student['percentage'] >= 50) ? 'bg-warning' : 'bg-danger') ?>"
                        role="progressbar"
                        style="width: <?= $student['percentage'] ?>%;">
                        <?= $student['percentage'] ?>%
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No students found for the selected class.</div>
    <?php endif; ?>
  </div>
</section>

<?= $this->include("layouts/base-structure/footer") ?>
<?= $this->endSection() ?>