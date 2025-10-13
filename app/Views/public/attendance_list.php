<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

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
        <input type="month" name="month" class="form-control" value="<?= esc($selectedMonth) ?>">
      </div>
      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Show</button>
      </div>
    </form>

    <!-- Legend -->
    <div class="mb-3 text-center">
      <span class="badge bg-success">P = Present</span>
      <span class="badge bg-danger">A = Absent</span>
      <span class="badge bg-warning text-dark">L = Late In</span>
      <span class="badge bg-info text-dark">E = Early Out</span>
      <span class="badge bg-primary">L/E = Late/Early</span>
      <span class="badge bg-secondary">H = Holiday</span>
    </div>

    <!-- Attendance Table -->
    <div class="table-responsive table-wrapper" style="max-height:600px; overflow-y:auto;">
      <table class="table table-bordered align-middle text-center small">
        <thead class="table-dark">
          <tr>
            <th style="min-width:60px;">Roll</th>
            <th style="min-width:150px;">Name</th>
            <?php foreach($daysInMonth as $day): ?>
              <th style="min-width:40px;" title="<?= esc($day['date']) ?>">
                <?= esc($day['day']) ?><br><?= date('d', strtotime($day['date'])) ?>
              </th>
            <?php endforeach; ?>
            <th style="min-width:80px;">% Present</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($students)): ?>
            <?php foreach($students as $student): ?>
              <?php
              $totalDays = 0;
              $presentCount = 0;
              ?>
              <tr>
                <td><?= esc($student['roll']) ?></td>
                <td class="text-start"><?= esc($student['student_name']) ?></td>
                <?php foreach($daysInMonth as $day): ?>
                  <?php
                  $date = $day['date'];
                  $dayName = $day['day'];
                  $attendance = $attendanceMap[$student['id']][$date] ?? null;

                  // Holiday on Friday
                  if($dayName === 'Fri'){
                      $status = 'H';
                      $tooltip = 'Holiday';
                      echo "<td><span class='badge bg-white text-danger' title='$tooltip'>$status</span></td>";
                      continue;
                  }
                  // Holiday on Sat
                  if($dayName === 'Sat'){
                      $status = 'H';
                      $tooltip = 'Holiday';
                      echo "<td><span class='badge bg-white text-danger' title='$tooltip'>$status</span></td>";
                      continue;
                  }

                  $totalDays++;
                  $status = 'A';
                  $tooltip = 'Absent';

                  if($attendance){
                      $inTime  = $attendance['arrival'] ? date('H:i', strtotime($attendance['arrival'])) : null;
                      $outTime = $attendance['leave']   ? date('H:i', strtotime($attendance['leave']))   : null;
                      $tooltip = "In: ".($inTime ?? '--').", Out: ".($outTime ?? '--');

                      $inSec  = $attendance['arrival'] ? strtotime($attendance['arrival']) : null;
                      $outSec = $attendance['leave']   ? strtotime($attendance['leave'])   : null;

                      $tenAM  = strtotime($date.' 10:00:00');
                      $fourPM = strtotime($date.' 16:00:00');

                      if($inSec && $outSec){
                          if($inSec <= $tenAM && $outSec >= $fourPM){
                              $status = 'P';
                              $presentCount++;
                          } elseif($inSec > $tenAM && $outSec < $fourPM){
                              $status = 'L/E';
                          } elseif($inSec > $tenAM){
                              $status = 'L';
                          } elseif($outSec < $fourPM){
                              $status = 'E';
                          }
                      } elseif($inSec && !$outSec){
                          $status = ($inSec > $tenAM) ? 'L' : 'P';
                          $presentCount += ($status === 'P') ? 1 : 0;
                      } elseif(!$inSec && $outSec){
                          $status = ($outSec < $fourPM) ? 'E' : 'P';
                          $presentCount += ($status === 'P') ? 1 : 0;
                      }
                  }

                  $badgeClass = match($status){
                      'P' => 'bg-success',
                      'A' => 'bg-white text-dark',
                      'L' => 'bg-warning text-dark',
                      'E' => 'bg-info text-dark',
                      'L/E' => 'bg-primary',
                      'H' => 'bg-white text-dark',
                      default => 'bg-secondary' 
                  };
                  ?>
                  <td><span class="badge <?= $badgeClass ?>" title="<?= esc($tooltip) ?>"><?= esc($status) ?></span></td>
                <?php endforeach; ?>
                <td><strong><?= $totalDays>0 ? round(($presentCount/$totalDays)*100) : 0 ?>%</strong></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="<?= count($daysInMonth)+3 ?>" class="text-muted">No students found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Fixed Table Header CSS -->
<style>
.table-wrapper thead th {
  position: sticky;
  top: 0;
  z-index: 10;
  background-color: #343a40;
  color: #fff;
}
</style>

<?= $this->include("layouts/base-structure/footer") ?>
<?= $this->endSection() ?>