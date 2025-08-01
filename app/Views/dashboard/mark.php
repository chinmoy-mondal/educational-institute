<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
  th, td {
    vertical-align: middle !important;
    text-align: center !important;
  }
</style>

<?php
// 1. Prepare subject list (unique subjects from all students)
$subjectList = [];
foreach ($finalData as $student) {
  foreach ($student['results'] as $res) {
    if (!in_array($res['subject'], $subjectList)) {
      $subjectList[] = $res['subject'];
    }
  }
}

// 2. Calculate total marks per student for footer (optional)
$studentTotals = [];
foreach ($finalData as $student) {
  $total = 0;
  foreach ($student['results'] as $res) {
    $total += $res['total'] ?? 0;
  }
  $studentTotals[$student['roll']] = $total;
}
?>

<div class="container-fluid">
  <h1 class="mb-4">Tabulation Sheet (Transposed)</h1>

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
                <th rowspan="2">Subject</th>
                <?php foreach ($finalData as $student): ?>
                  <th colspan="4"><?= esc($student['roll']) ?> - <?= esc($student['name']) ?></th>
                <?php endforeach; ?>
              </tr>
              <tr>
                <?php foreach ($finalData as $student): ?>
                  <th>W</th>
                  <th>MCQ</th>
                  <th>Prac</th>
                  <th>Total</th>
                <?php endforeach; ?>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($subjectList as $subject): ?>
                <tr>
                  <td class="fw-bold"><?= esc($subject) ?></td>

                  <?php foreach ($finalData as $student): ?>
                    <?php
                    // Find subject result for this student
                    $found = false;
                    $written = $mcq = $practical = $total = '';
                    foreach ($student['results'] as $res) {
                      if ($res['subject'] === $subject) {
                        $written = $res['written'] ?? '';
                        $mcq = $res['mcq'] ?? '';
                        $practical = $res['practical'] ?? '';
                        $total = $res['total'] ?? '';
                        $found = true;
                        break;
                      }
                    }
                    ?>
                    <td><?= esc($written) ?></td>
                    <td><?= esc($mcq) ?></td>
                    <td><?= esc($practical) ?></td>
                    <td><?= esc($total) ?></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>

            <tfoot class="table-secondary fw-bold text-center">
              <tr>
                <td>Total</td>
                <?php foreach ($finalData as $student): ?>
                  <?php
                    $totalMarks = $studentTotals[$student['roll']] ?? 0;
                  ?>
                  <td colspan="4"><?= esc($totalMarks) ?></td>
                <?php endforeach; ?>
              </tr>
            </tfoot>

          </table>
        </div>

      <?php endif; ?>

    </div>
  </div>
</div>

<?= $this->endSection() ?>