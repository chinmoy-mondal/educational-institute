<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<!-- Header -->
<div class="fixed-header">
  <?= $this->include("layouts/base-structure/header") ?>
</div>

<div class="page-title text-center py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-primary">Monthly Attendance Report</h2>
    <p class="text-muted mb-0">Select month and class to view attendance summary</p>
  </div>
</div>

<section class="py-5">
  <div class="container">
    <!-- Filter -->
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
        <input type="month" name="month" class="form-control" value="<?= esc($selectedMonth) ?>">
      </div>
      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Show</button>
      </div>
    </form>

    <!-- Attendance Table -->
    <div class="table-responsive shadow-sm">
      <table class="table table-bordered text-center align-middle small">
        <thead class="table-dark sticky-top">
          <tr>
            <th>Roll</th>
            <th>Student Name</th>
            <?php foreach($daysInMonth as $day): ?>
              <th title="<?= esc($day['date']) ?>">
                <?= esc($day['day']) ?><br><?= date('d', strtotime($day['date'])) ?>
              </th>
            <?php endforeach; ?>
            <th>% Present</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($students)): ?>
            <?php foreach($students as $student): ?>
              <?php
                $totalDays = count($daysInMonth);
                $presentCount = 0;
              ?>
              <tr>
                <td><?= esc($student['roll']) ?></td>
                <td class="text-start"><?= esc($student['student_name']) ?></td>
                <?php foreach($daysInMonth as $day): ?>
                  <?php
                    $date = $day['date'];
                    $attendance = $attendanceMap[$student['id']][$date] ?? null;
                    $status = 'A';
                    $tooltip = 'Absent';

                    if ($attendance) {
                        $inTime = date('H:i', strtotime($attendance['created_at']));
                        $outTime = date('H:i', strtotime($attendance['updated_at'] ?? $attendance['created_at']));
                        $tooltip = "In: {$inTime}, Out: {$outTime}";

                        if ($inTime <= '10:00' && $outTime >= '16:00') {
                            $status = 'P';
                            $presentCount++;
                        } elseif ($inTime > '10:00' && $outTime < '16:00') {
                            $status = 'L/E';
                        } elseif ($inTime > '10:00') {
                            $status = 'L';
                        } elseif ($outTime < '16:00') {
                            $status = 'E';
                        }
                    }
                  ?>
                  <td title="<?= esc($tooltip) ?>" 
                      class="<?php 
                        if($status=='P') echo 'bg-success text-white'; 
                        elseif($status=='A') echo 'bg-danger text-white';
                        elseif($status=='L') echo 'bg-warning';
                        elseif($status=='E') echo 'bg-info';
                        else echo 'bg-secondary text-white';
                      ?>">
                    <?= esc($status) ?>
                  </td>
                <?php endforeach; ?>
                <td><strong><?= round(($presentCount / $totalDays) * 100) ?>%</strong></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="<?= count($daysInMonth) + 3 ?>" class="text-muted">No students found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->include("layouts/base-structure/footer") ?>
<?= $this->endSection() ?>