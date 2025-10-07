<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<div class="container py-5">
  <h3 class="text-center mb-4">Attendance Record</h3>

  <?php if (empty($attendances)): ?>
    <div class="alert alert-warning text-center">No attendance records found.</div>
  <?php else: ?>
    <?php foreach ($attendances as $date => $records): ?>
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <strong><?= date('d M Y', strtotime($date)) ?></strong>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped table-bordered mb-0">
            <thead class="table-light">
              <tr>
                <th>Roll</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Remark</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($records as $r): ?>
                <?php 
                  $sid = $r['student_id'];
                  $s = $students[$sid] ?? ['name' => 'Unknown', 'roll' => '-', 'class' => '-'];
                ?>
                <tr>
                  <td><?= esc($s['roll']) ?></td>
                  <td><?= esc($s['name']) ?></td>
                  <td><?= esc($s['class']) ?></td>
                  <td>
                    <?php if ($r['remark'] == 'P'): ?>
                      <span class="badge bg-success" title="Present">P</span>
                    <?php else: ?>
                      <span class="badge bg-danger" title="Absent">A</span>
                    <?php endif; ?>
                  </td>
                  <td><?= esc($r['time']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>