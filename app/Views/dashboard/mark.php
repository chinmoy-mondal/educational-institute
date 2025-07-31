<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<style>
  th, td {
    vertical-align: middle !important;
    text-align: center !important;
  }
</style>
<?php
// Get unique subjects
$subjectList = [];

foreach ($finalData as $student) {
  foreach ($student['results'] as $res) {
    if (!in_array($res['subject'], $subjectList)) {
      $subjectList[] = $res['subject'];
    }
  }
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
                  <th>W</th>
                  <th>MCQ</th>
                  <th>Prac</th>
                  <th>Total</th>
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

                // Pre-check combined subjects
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
                  <td class="text-start"><?= esc($student['name']) ?></td>

                  <?php foreach ($subjectList as $subject): ?>
                    <?php
                    $res = $subjectMap[$subject] ?? null;

                    $written = $res['written'] ?? '';
                    $mcq = $res['mcq'] ?? '';
                    $practical = $res['practical'] ?? '';
                    $total = $res['total'] ?? '';

                    if ($total !== '') $studentTotal += $total;

                    $markClass = '';

                    $groupA = ['Physics', 'Chemistry', 'Higher Math', 'Biology'];

                    if ($subject === 'ICT' && $ictFail) {
                      $markClass = 'text-danger fw-bold';
                    } elseif (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper']) && $banglaFail) {
                      $markClass = 'text-danger fw-bold';
                    } elseif (in_array($subject, ['English 1st Paper', 'English 2nd Paper']) && $englishFail) {
                      $markClass = 'text-danger fw-bold';
                    } else {
                      // Class 9-10 rules
                      $writtenPass = 33;
                      $mcqPass = 0;
                      $pracPass = 0;

                      if (in_array($class, ['9', '10'])) {
                        if (in_array($subject, $groupA)) {
                          $writtenPass = 17;
                          $mcqPass = 8;
                          $pracPass = 8;
                        } else {
                          $writtenPass = 23;
                          $mcqPass = 10;
                        }
                      }

                      $writtenFail = is_numeric($written) && $written < $writtenPass;
                      $mcqFail = is_numeric($mcq) && $mcq < $mcqPass;
                      $pracFail = is_numeric($practical) && $pracPass > 0 && $practical < $pracPass;

                      if ($writtenFail || $mcqFail || $pracFail) {
                        $markClass = 'text-danger fw-bold';
                        $failCount++;
                      } elseif (is_numeric($total) && $total < 33) {
                        $markClass = 'text-danger fw-bold';
                        $failCount++;
                      }
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