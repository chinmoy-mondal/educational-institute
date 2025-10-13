<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<div class="fixed-header">
  <?= $this->include("layouts/base-structure/header") ?>
</div>

<div class="page-title text-center py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-primary">Daily Attendance</h2>
    <p class="text-muted mb-0">Select class and date to view student attendance</p>
  </div>
</div>

<section class="py-5">
  <div class="container">

    <!-- Filter Form -->
    <form method="get" class="row g-3 mb-4 justify-content-center">
      <div class="col-md-3">
        <select name="class" class="form-select">
          <option value="">Select Class</option>
          <?php foreach ($classes as $c): ?>
            <option value="<?= esc($c['class']) ?>" <?= ($selectedClass == $c['class']) ? 'selected' : '' ?>>
              Class <?= esc($c['class']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <input type="date" name="date" class="form-control" value="<?= esc($selectedDate) ?>">
      </div>

      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Show</button>
      </div>
    </form>

    <!-- Attendance Table -->
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
              <th>Status</th>
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
                <td>
                  <?php
                    $status = $student['status'];
                    $badgeClass = match($status) {
                      'P' => 'bg-success',
                      'A' => 'bg-danger',
                      'Late In' => 'bg-warning text-dark',
                      'Early Leave' => 'bg-info text-dark',
                      default => 'bg-secondary'
                    };
                  ?>
                  <span class="badge <?= $badgeClass ?> px-3 py-2"><?= esc($status) ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No records found for the selected date or class.</div>
    <?php endif; ?>

  </div>
</section>

<?= $this->include("layouts/base-structure/footer") ?>
<?= $this->endSection() ?>