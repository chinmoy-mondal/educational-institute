<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<div class="container py-5">
  <h2 class="fw-bold text-center mb-4 text-primary">Attendance Overview</h2>

  <!-- ========== Top Gender Summary ========== -->
  <div class="row justify-content-center mb-5 text-center">
    <div class="col-md-4 col-sm-6 mb-3">
      <h5 class="fw-semibold text-secondary mb-2">Male Attendance</h5>
      <div class="circle-summary">
        <svg viewBox="0 0 36 36" class="circular-chart blue">
          <path class="circle-bg"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
          <path class="circle"
                stroke-dasharray="<?= esc($malePercentage) ?>, 100"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
          <text x="18" y="20.35" class="percentage"><?= esc($malePercentage) ?>%</text>
        </svg>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 mb-3">
      <h5 class="fw-semibold text-secondary mb-2">Female Attendance</h5>
      <div class="circle-summary">
        <svg viewBox="0 0 36 36" class="circular-chart pink">
          <path class="circle-bg"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
          <path class="circle"
                stroke-dasharray="<?= esc($femalePercentage) ?>, 100"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
          <text x="18" y="20.35" class="percentage"><?= esc($femalePercentage) ?>%</text>
        </svg>
      </div>
    </div>
  </div>

  <!-- ========== Detailed Table by Class/Section ========== -->
  <?php if (empty($classes)): ?>
    <div class="alert alert-info text-center">No student or attendance record found.</div>
  <?php else: ?>
    <?php foreach ($classes as $className => $sections): ?>
      <div class="mb-5">
        <h4 class="text-secondary mb-3">Class <?= esc($className) ?></h4>
        <?php foreach ($sections as $sectionName => $students): ?>
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
              <strong>Section: <?= esc($sectionName) ?></strong>
            </div>
            <div class="card-body p-0">
              <table class="table table-bordered table-hover mb-0 align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th>Roll</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Attendance %</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($students as $st): ?>
                    <tr>
                      <td><?= esc($st['roll']) ?></td>
                      <td><?= esc($st['name']) ?></td>
                      <td><?= ucfirst($st['gender']) ?></td>
                      <td>
                        <svg viewBox="0 0 36 36" class="circular-chart <?= ($st['percentage'] >= 75) ? 'green' : (($st['percentage'] >= 40) ? 'orange' : 'red') ?>">
                          <path class="circle-bg"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                          <path class="circle"
                                stroke-dasharray="<?= esc($st['percentage']) ?>, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                          <text x="18" y="20.35" class="percentage"><?= esc($st['percentage']) ?>%</text>
                        </svg>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<style>
.circular-chart {
  display: inline-block;
  max-width: 60px;
  max-height: 60px;
}
.circle-bg {
  fill: none;
  stroke: #eee;
  stroke-width: 3.8;
}
.circle {
  fill: none;
  stroke-width: 2.8;
  stroke-linecap: round;
  animation: progress 1s ease-out forwards;
}
.green .circle { stroke: #4caf50; }
.orange .circle { stroke: #ffc107; }
.red .circle { stroke: #f44336; }
.blue .circle { stroke: #2196f3; }
.pink .circle { stroke: #e91e63; }
.percentage {
  fill: #444;
  font-family: sans-serif;
  font-size: 0.35em;
  text-anchor: middle;
}
@keyframes progress { 0% { stroke-dasharray: 0 100; } }
</style>

<?= $this->endSection() ?>