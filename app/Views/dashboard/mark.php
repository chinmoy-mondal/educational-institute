<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
$subjectList = [];

foreach ($finalData as $student) {
    foreach ($student['results'] as $res) {
        if (!in_array($res['subject'], $subjectList)) {
            $subjectList[] = $res['subject'];
        }
    }
}
?>

<style>
.table-container {
  overflow: auto;
  max-height: 600px;
  border: 1px solid #dee2e6;
}

.sticky-table {
  border-collapse: separate;
  border-spacing: 0;
}

.sticky-table th,
.sticky-table td {
  white-space: nowrap;
  border: 1px solid #dee2e6;
  padding: 8px;
  background: white;
  z-index: 1;
}

/* Sticky Header Rows */
.sticky-table thead tr:nth-child(1) th {
  position: sticky;
  top: 0;
  z-index: 5;
  background: #343a40;
  color: white;
}
.sticky-table thead tr:nth-child(2) th {
  position: sticky;
  top: 40px; /* Approx height of the first header row */
  background: #e9ecef;
  z-index: 4;
}

/* Sticky First Column (Roll) */
.sticky-table th:first-child,
.sticky-table td:first-child {
  position: sticky;
  left: 0;
  background: #f8f9fa;
  z-index: 4;
}

/* Sticky Second Column (Name) */
.sticky-table th:nth-child(2),
.sticky-table td:nth-child(2) {
  position: sticky;
  left: 80px; /* Width of the first column (Roll) */
  background: #f8f9fa;
  z-index: 4;
  min-width: 160px;
  text-align: left;
}

/* Higher z-index for corner cells */
.sticky-table thead tr:nth-child(1) th:first-child,
.sticky-table thead tr:nth-child(2) th:first-child,
.sticky-table thead tr:nth-child(1) th:nth-child(2),
.sticky-table thead tr:nth-child(2) th:nth-child(2) {
  z-index: 10;
}
</style>

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

      <div class="table-container">
        <table class="table sticky-table">
          <thead class="text-center align-middle">
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

                $bangla1 = $subjectMap['Bangla 1st Paper']['total'] ?? null;
                $bangla2 = $subjectMap['Bangla 2nd Paper']['total'] ?? null;
                $english1 = $subjectMap['English 1st Paper']['total'] ?? null;
                $english2 = $subjectMap['English 2nd Paper']['total'] ?? null;
                $ictTotal = $subjectMap['ICT']['total'] ?? null;

                $banglaFail = ($bangla1 !== null && $bangla2 !== null && ($bangla1 + $bangla2) < 49);
                $englishFail = ($english1 !== null && $english2 !== null && ($english1 + $english2) < 49);
                $ictFail = ($ictTotal !== null && $ictTotal < 17);

                if ($banglaFail) $failCount++;
                if ($englishFail) $failCount++;
                if ($ictFail) $failCount++;
              ?>
              <tr class="text-center">
                <td><strong><?= esc($student['roll']) ?></strong></td>
                <td><?= esc($student['name']) ?></td>

                <?php foreach ($subjectList as $subject): ?>
                  <?php
                    $res = $subjectMap[$subject] ?? null;
                    $written = $res['written'] ?? '';
                    $mcq = $res['mcq'] ?? '';
                    $practical = $res['practical'] ?? '';
                    $total = $res['total'] ?? '';

                    if (is_numeric($total)) $studentTotal += $total;

                    $markClass = '';
                    if ($subject === 'ICT' && $ictFail) {
                        $markClass = 'text-danger fw-bold';
                    } elseif (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper']) && $banglaFail) {
                        $markClass = 'text-danger fw-bold';
                    } elseif (in_array($subject, ['English 1st Paper', 'English 2nd Paper']) && $englishFail) {
                        $markClass = 'text-danger fw-bold';
                    } elseif (
                        !in_array($subject, ['ICT', 'Bangla 1st Paper', 'Bangla 2nd Paper', 'English 1st Paper', 'English 2nd Paper']) &&
                        is_numeric($total) && $total < 33
                    ) {
                        $markClass = 'text-danger fw-bold';
                        $failCount++;
                    }
                  ?>
                  <td><?= $written ?></td>
                  <td><?= $mcq ?></td>
                  <td><?= $practical ?></td>
                  <td class="<?= $markClass ?>"><?= $total ?></td>
                <?php endforeach; ?>

                <td class="fw-bold <?= $failCount > 0 ? 'text-danger' : 'text-success' ?>">
                  <?= $studentTotal ?><?= $failCount > 0 ? ' <br>F-' . $failCount : '' ?>
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
