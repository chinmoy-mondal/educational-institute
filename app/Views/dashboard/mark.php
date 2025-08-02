<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
  th, td {
    vertical-align: middle !important;
    text-align: center !important;
  }
</style>

<?php
function isSubjectFailed(string $class, string $subject, array $allSubjects, string $group = 'general'): bool
{
    // Skip fail-check if the subject doesn't exist (i.e., not taken)
    if (!isset($allSubjects[$subject])) {
        return false;
    }

    $subjectData = $allSubjects[$subject];
    $written = is_numeric($subjectData['written']) ? $subjectData['written'] : 0;
    $mcq = is_numeric($subjectData['mcq']) ? $subjectData['mcq'] : 0;
    $practical = is_numeric($subjectData['practical']) ? $subjectData['practical'] : 0;

    if (in_array($class, ['6', '7', '8'])) {
        if ($subject === 'ICT') return ($written + $mcq + $practical) < 17;

        if (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper'])) {
            $b1 = $allSubjects['Bangla 1st Paper'] ?? ['written'=>0, 'mcq'=>0];
            $b2 = $allSubjects['Bangla 2nd Paper'] ?? ['written'=>0, 'mcq'=>0];
            return ($b1['written'] + $b1['mcq'] + $b2['written'] + $b2['mcq']) < 49;
        }

        if (in_array($subject, ['English 1st Paper', 'English 2nd Paper'])) {
            $e1 = $allSubjects['English 1st Paper'] ?? ['written'=>0];
            $e2 = $allSubjects['English 2nd Paper'] ?? ['written'=>0];
            return ($e1['written'] + $e2['written']) < 49;
        }

        return ($written + $mcq + $practical) < 33;
    }

    if (in_array($class, ['9', '10'])) {
        if ($group === 'vocational') {
            if (in_array($subject, ['Physics-1', 'Chemistry-1','Physics-2', 'Chemistry-2'])) {
                return $written < 10;
            }
            return $written < 20;
        }

        if (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper'])) {
            $b1 = $allSubjects['Bangla 1st Paper'] ?? ['written'=>0, 'mcq'=>0];
            $b2 = $allSubjects['Bangla 2nd Paper'] ?? ['written'=>0, 'mcq'=>0];
            return ($b1['written'] + $b2['written'] < 46) || ($b1['mcq'] + $b2['mcq'] < 20);
        }

        if (in_array($subject, ['English 1st Paper', 'English 2nd Paper'])) {
            $e1 = $allSubjects['English 1st Paper'] ?? ['written'=>0];
            $e2 = $allSubjects['English 2nd Paper'] ?? ['written'=>0];
            return ($e1['written'] + $e2['written']) < 66;
        }

        if ($subject === 'ICT') {
            return ($written + $mcq) < 8 || $practical < 9;
        }

        if (in_array($subject, ['Physics', 'Chemistry', 'Higher Math', 'Biology'])) {
            return $written < 17 || $mcq < 8 || $practical < 8;
        }

        return $written < 23 || $mcq < 10;
    }

    return false;
}

// Create a full list of all subjects across students
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

                  // Bangla combined
                  $b1 = $subjectMap['Bangla 1st Paper'] ?? ['written'=>0, 'mcq'=>0];
                  $b2 = $subjectMap['Bangla 2nd Paper'] ?? ['written'=>0, 'mcq'=>0];
                  $combinedBanglaWritten = $b1['written'] + $b2['written'];
                  $combinedBanglaMcq = $b1['mcq'] + $b2['mcq'];
                  $banglaWrittenFail = $combinedBanglaWritten < 46;
                  $banglaMcqFail = $combinedBanglaMcq < 20;
                  $banglaFail = $banglaWrittenFail || $banglaMcqFail;

                  // Physics combined fail check
                  $physics = $subjectMap['Physics'] ?? ['written'=>0, 'mcq'=>0, 'practical'=>0];
                  $physicsFail = false;
                  if (in_array($class, ['9', '10'])) {
                    $physicsFail = ($physics['written'] < 17) || ($physics['mcq'] < 8) || ($physics['practical'] < 8);
                  }

                  $studentTotal = 0;
                  $failCount = 0;
                  $countedSubjects = []; // track grouped fail counted
                ?>
                <tr class="text-center">
                  <td><strong><?= esc($student['roll']) ?></strong></td>
                  <td class="text-start"><?= esc($student['name']) ?></td>

                  <?php foreach ($subjectList as $subject): ?>
                    <?php if (!isset($subjectMap[$subject])): ?>
                      <td></td><td></td><td></td><td></td>
                    <?php else: ?>
                      <?php
                        $res = $subjectMap[$subject];
                        $written = $res['written'] ?? 0;
                        $mcq = $res['mcq'] ?? 0;
                        $practical = $res['practical'] ?? 0;
                        $total = $res['total'] ?? 0;

                        $studentTotal += is_numeric($total) ? $total : 0;

                        // Get fail status per subject from function
                        $isFail = isSubjectFailed($class, $subject, $subjectMap, $student['group'] ?? 'general');

                        // Count fail once per group
                        if (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper'])) {
                          if ($banglaFail && !in_array('Bangla', $countedSubjects)) {
                            $failCount++;
                            $countedSubjects[] = 'Bangla';
                          }
                          $isFail = $banglaFail;
                        }
                        else if ($subject === 'Physics') {
                          if ($physicsFail && !in_array('Physics', $countedSubjects)) {
                            $failCount++;
                            $countedSubjects[] = 'Physics';
                          }
                          $isFail = $physicsFail;
                        }
                        else {
                          if ($isFail) {
                            $failCount++;
                          }
                        }

                        // Coloring marks individually
                        $physicsWrittenClass = ($subject === 'Physics' && in_array($class, ['9','10']) && $written < 17) ? 'text-danger fw-bold' : '';
                        $physicsMcqClass = ($subject === 'Physics' && in_array($class, ['9','10']) && $mcq < 8) ? 'text-danger fw-bold' : '';
                        $physicsPracClass = ($subject === 'Physics' && in_array($class, ['9','10']) && $practical < 8) ? 'text-danger fw-bold' : '';

                        $banglaWrittenClass = (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper']) && $banglaWrittenFail) ? 'text-danger fw-bold' : '';
                        $banglaMcqClass = (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper']) && $banglaMcqFail) ? 'text-danger fw-bold' : '';

                        $writtenClass = $physicsWrittenClass ?: $banglaWrittenClass;
                        $mcqClass = $physicsMcqClass ?: $banglaMcqClass;
                        $practicalClass = $physicsPracClass;
                      ?>
                      <td class="<?= $writtenClass ?>"><?= $written ?></td>
                      <td class="<?= $mcqClass ?>"><?= $mcq ?></td>
                      <td class="<?= $practicalClass ?>"><?= $practical ?></td>
                      <td class="<?= $isFail ? 'text-danger fw-bold' : '' ?>"><?= $total ?></td>
                    <?php endif; ?>
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

