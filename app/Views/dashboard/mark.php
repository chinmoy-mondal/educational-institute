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

                $bangla1Total = $bangla2Total = null;
                $english1Total = $english2Total = null;
                $ictTotal = null;
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

                        // Save totals for combined subject logic
                        switch ($subject) {
                            case 'Bangla 1st Paper':
                                $bangla1Total = $total;
                                break;
                            case 'Bangla 2nd Paper':
                                $bangla2Total = $total;
                                break;
                            case 'English 1st Paper':
                                $english1Total = $total;
                                break;
                            case 'English 2nd Paper':
                                $english2Total = $total;
                                break;
                            case 'ICT':
                                $ictTotal = $total;
                                if ($total < 17) $failCount++;
                                break;
                            default:
                                if ($total < 33) $failCount++;
                                break;
                        }
                    } else {
                        $written = $mcq = $practical = $total = '';
                    }

                    // Determine red mark class
                    $markClass = '';
                    if ($subject === 'Bangla 1st Paper' && $bangla1Total !== null && $bangla2Total !== null && ($bangla1Total + $bangla2Total) < 49) {
                        $markClass = 'text-danger fw-bold';
                    } elseif ($subject === 'Bangla 2nd Paper' && $bangla1Total !== null && $bangla2Total !== null && ($bangla1Total + $bangla2Total) < 49) {
                        $markClass = 'text-danger fw-bold';
                    } elseif ($subject === 'English 1st Paper' && $english1Total !== null && $english2Total !== null && ($english1Total + $english2Total) < 49) {
                        $markClass = 'text-danger fw-bold';
                    } elseif ($subject === 'English 2nd Paper' && $english1Total !== null && $english2Total !== null && ($english1Total + $english2Total) < 49) {
                        $markClass = 'text-danger fw-bold';
                    } elseif ($subject === 'ICT' && $ictTotal !== null && $ictTotal < 17) {
                        $markClass = 'text-danger fw-bold';
                    } elseif ($total !== '' && $total < 33) {
                        $markClass = 'text-danger fw-bold';
                    }
                  ?>

                  <td><?= $written ?></td>
                  <td><?= $mcq ?></td>
                  <td><?= $practical ?></td>
                  <td class="<?= $markClass ?>"><?= $total ?></td>
                <?php endforeach; ?>

                <?php
                  // Check Bangla combined fail
                  if ($bangla1Total !== null && $bangla2Total !== null && ($bangla1Total + $bangla2Total) < 49) {
                      $failCount++;
                  }

                  // Check English combined fail
                  if ($english1Total !== null && $english2Total !== null && ($english1Total + $english2Total) < 49) {
                      $failCount++;
                  }
                ?>

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
