<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
// Step 1: Get unique subjects from all results
$subjectList = [];

foreach ($finalData as $student) {
    foreach ($student['results'] as $res) {
        $subject = $res['subject'];
        if (!in_array($subject, $subjectList)) {
            $subjectList[] = $subject;
        }
    }
}

// Only highlight subject total if < 33
function redTotal($mark) {
    return ($mark < 33) ? 'text-danger fw-bold' : '';
}
?>

<div class="container-fluid">
  <h1 class="mb-4">Demo Tabulation Sheet</h1>

  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h5 class="mb-0">Class: <?= esc($class) ?> | Exam: <?= esc($exam) ?> | Year: <?= esc($year) ?></h5>
    </div>
    <div class="card-body">

      <?php if (empty($finalData)): ?>
        <div class="alert alert-warning">No results found for this class, exam, and year.</div>
      <?php else: ?>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-primary text-center align-middle">
            <tr>
              <th rowspan="2">Roll</th>
              <th rowspan="2">Name</th>
              <?php foreach ($subjectList as $sub): ?>
                <th colspan="4"><?= esc($sub) ?></th>
              <?php endforeach; ?>
              <th rowspan="2">Total</th>
            </tr>
            <tr>
              <?php foreach ($subjectList as $sub): ?>
                <th>W</th><th>MCQ</th><th>Prac</th><th>Total</th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($finalData as $student): ?>
              <?php
                // Build subject => result map
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
                    $res = $subjectMap[$subject] ?? ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0];
                    $studentTotal += $res['total'];
                    if ($res['total'] < 33) {
                        $failCount++;
                    }
                  ?>
                  <td><?= $res['written'] ?></td>
                  <td><?= $res['mcq'] ?></td>
                  <td><?= $res['practical'] ?></td>
                  <td class="fw-bold <?= redTotal($res['total']) ?>"><?= $res['total'] ?></td>
                <?php endforeach; ?>

                <td class="fw-bold <?= $failCount > 0 ? 'text-danger' : 'text-success' ?>">
                  <?= $studentTotal ?><?= $failCount > 0 ? '<br> (F-' . $failCount . ')' : '' ?>
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
