<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<div class="fixed-header">
  <?= $this->include("layouts/base-structure/header") ?>
</div>

<div class="page-title text-center py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-primary">Monthly Attendance Report</h2>
    <p class="text-muted mb-0">Select class and month to view full attendance</p>
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
        <input type="month" name="month" class="form-control" value="<?= esc($selectedMonth) ?>">
      </div>

      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Show</button>
      </div>
    </form>

    <?php if (!empty($students)): ?>
      <div class="table-responsive shadow-sm" style="max-height: 70vh; overflow:auto;">
        <table class="table table-bordered align-middle text-center table-sm">
          <thead class="table-dark sticky-top">
            <tr>
              <th>#</th>
              <th>Student Name</th>
              <th>Roll</th>
              <?php foreach ($dates as $d): ?>
                <th><?= date('d', strtotime($d)) ?></th>
              <?php endforeach; ?>
              <th>Total P</th>
              <th>Total A</th>
              <th>Total L</th>
              <th>Total E</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($students as $student): ?>
              <?php
                $p = $a = $l = $e = 0;
              ?>
              <tr>
                <td><?= $i++ ?></td>
                <td class="text-start"><?= esc($student['student_name']) ?></td>
                <td><?= esc($student['roll']) ?></td>

                <?php foreach ($dates as $d): 
                  $st = $student['days'][$d];
                  if ($st == 'P') $p++;
                  elseif ($st == 'A') $a++;
                  elseif ($st == 'L') $l++;
                  elseif ($st == 'E') $e++;
                ?>
                  <td>
                    <?php
                      $badgeClass = match($st) {
                        'P' => 'bg-success text-white',
                        'A' => 'bg-danger text-white',
                        'L' => 'bg-warning text-dark',
                        'E' => 'bg-info text-dark',
                        default => 'bg-secondary text-white'
                      };
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= esc($st) ?></span>
                  </td>
                <?php endforeach; ?>

                <td><strong class="text-success"><?= $p ?></strong></td>
                <td><strong class="text-danger"><?= $a ?></strong></td>
                <td><strong class="text-warning"><?= $l ?></strong></td>
                <td><strong class="text-info"><?= $e ?></strong></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No students found for this month or class.</div>
    <?php endif; ?>

  </div>
</section>

<?= $this->include("layouts/base-structure/footer") ?>
<?= $this->endSection() ?>