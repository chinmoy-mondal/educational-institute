<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
// Step 1: Get unique subjects from all students
$subjectList = [];

foreach ($finalData as $student) {
    foreach ($student['results'] as $res) {
        $subject = $res['subject'];
        if (!in_array($subject, $subjectList)) {
            $subjectList[] = $subject;
        }
    }
}

// Helper to highlight failing total
function redTotal($mark) {
    return ($mark !== '' && $mark < 33) ? 'text-danger fw-bold' : '';
}
?>

<div class="container-fluid">
  <h1 class="mb-4">Tabulation Sheet</h1>

  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h5 class="mb-0">Class: <?= esc($class) ?> | Exam: <?= esc($exam) ?> | Year: <?= esc($year) ?></h5>
    </div>
    <div class="card-body">

      <?php if (empty($finalData)): ?>
        <div class="alert alert-warning">No result data found.</div>
      <?php else: ?>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-primary text-center align-middle">
            <tr>
              <th rowspan="2">Roll</th>
              <th rowspan="2">Name</th>
              <?php foreach ($subjectList as $subject): ?>
                <th colspan="4"><?= esc($subject) ?></th>
              <?php endforeach; ?>
              <th rowspan="2">Total</th>
            </tr>
            <tr>
              <?php foreach ($subjectList as $subject): ?>
                <th>W</th><th>MCQ</th><th>Prac</th><th>Total</th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($finalData as $student): ?>
              <?php
                $subjectMap = [];
                foreach ($student['results'] as $res) {
                    $subjectMap[$res['subject']] = $res;
                }

                $studentTotal = 0;
                $failCount = 0;
              ?>
              <tr class="text-center">
                <td><strong><?= esc($student['roll']) ?></strong></td>
                <td class="text-start"><?= esc($student['name']) ?></td>

                <?php foreach ($subjectList as $subject): ?>
                  <?php
                    if (isset($subjectMap[$subject])) {
                        $res = $subjectMap[$subject];
                        $written   = $res['written'] ?? 0;
                        $mcq       = $res['mcq'] ?? 0;
                        $practical = $res['practical'] ?? 0;
                        $total     = $res['total'] ?? 0;
                        $studentTotal += $total;
                        if ($total < 33) $failCount++;
                    } else {
                        $written = $mcq = $practical = $total = '';
                    }
                  ?>
                  <td><?= $written ?></td>
                  <td><?= $mcq ?></td>
                  <td><?= $practical ?></td>
                  <td class="fw-bold <?= redTotal($total) ?>"><?= $total ?></td>
                <?php endforeach; ?>

                <td class="fw-bold <?= $failCount > 0 ? 'text-danger' : 'text-success' ?>">
                  <?= $studentTotal ?><?= $failCount > 0 ? ' <br>F-' . $failCount . '' : '' ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php endif; ?>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
