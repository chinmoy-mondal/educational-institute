<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
  th, td {
    vertical-align: middle !important;
    text-align: center !important;
    font-size: 10px;
  }
  .text-danger { color: red; font-weight: bold; }
</style>

<?php
// ---------- Pass/Fail Rule for Class 10 ----------
function isSubjectFailedClass10(string $subject, array $allSubjects, string $group = 'general'): bool
{
    if (!isset($allSubjects[$subject])) return false;

    $subjectData = $allSubjects[$subject];
    $written = is_numeric($subjectData['written']) ? $subjectData['written'] : 0;
    $mcq = is_numeric($subjectData['mcq']) ? $subjectData['mcq'] : 0;
    $practical = is_numeric($subjectData['practical']) ? $subjectData['practical'] : 0;

    // -------- Vocational Students --------
    if ($group === 'vocational') {
        if (in_array($subject, ['Physics-1', 'Physics-2', 'Chemistry-1', 'Chemistry-2'])) {
            return $written < 10; // Physics/Chemistry vocational rule
        }
        return $written < 20; // All other vocational subjects
    }

    // -------- General Students --------
    if (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper'])) {
        $b1 = $allSubjects['Bangla 1st Paper'] ?? ['written' => 0, 'mcq' => 0];
        $b2 = $allSubjects['Bangla 2nd Paper'] ?? ['written' => 0, 'mcq' => 0];
        return ($b1['written'] + $b2['written'] < 46) || ($b1['mcq'] + $b2['mcq'] < 20);
    }

    if (in_array($subject, ['English 1st Paper', 'English 2nd Paper'])) {
        $e1 = $allSubjects['English 1st Paper'] ?? ['written' => 0];
        $e2 = $allSubjects['English 2nd Paper'] ?? ['written' => 0];
        return ($e1['written'] + $e2['written']) < 66;
    }

    if ($subject === 'ICT') {
        return ($written + $mcq) < 8 || $practical < 9;
    }

    if (in_array($subject, ['Physics', 'Chemistry', 'Higher Math', 'Biology'])) {
        return $written < 17 || $mcq < 8 || $practical < 8;
    }

    // All other subjects (general)
    return $written < 23 || $mcq < 10;
}
?>

<div class="container-fluid">
  <h1 class="mb-4">Tabulation Sheet (Class 10)</h1>
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
                $banglaFailCounted = false;
                $englishFailCounted = false;
                $group = $student['group'] ?? 'general';
                ?>
                <tr>
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

                      $isFail = isSubjectFailedClass10($subject, $subjectMap, $group);

                      // count fails (Bangla & English once only)
                      if (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper'])) {
                          if (!$banglaFailCounted && $isFail) {
                              $failCount++; $banglaFailCounted = true;
                          }
                      } elseif (in_array($subject, ['English 1st Paper', 'English 2nd Paper'])) {
                          if (!$englishFailCounted && $isFail) {
                              $failCount++; $englishFailCounted = true;
                          }
                      } else {
                          if ($isFail) $failCount++;
                      }

                      // Styling failed parts
                      $writtenClass = $mcqClass = $practicalClass = '';
                      if ($group === 'vocational') {
                          if (in_array($subject, ['Physics-1', 'Physics-2', 'Chemistry-1', 'Chemistry-2'])) {
                              if ($written < 10) $writtenClass = 'text-danger';
                          } else {
                              if ($written < 20) $writtenClass = 'text-danger';
                          }
                      } else {
                          if ($subject === 'ICT') {
                              if (($written + $mcq) < 8) { $writtenClass = $mcqClass = 'text-danger'; }
                              if ($practical < 9) { $practicalClass = 'text-danger'; }
                          } elseif (in_array($subject, ['Physics', 'Chemistry', 'Higher Math', 'Biology'])) {
                              if ($written < 17) $writtenClass = 'text-danger';
                              if ($mcq < 8) $mcqClass = 'text-danger';
                              if ($practical < 8) $practicalClass = 'text-danger';
                          } elseif (!in_array($subject, ['Bangla 1st Paper','Bangla 2nd Paper','English 1st Paper','English 2nd Paper'])) {
                              if ($written < 23) $writtenClass = 'text-danger';
                              if ($mcq < 10) $mcqClass = 'text-danger';
                          }
                      }
                      ?>
                      <td class="<?= $writtenClass ?>"><?= $written ?></td>
                      <td class="<?= $mcqClass ?>"><?= $mcq ?></td>
                      <td class="<?= $practicalClass ?>"><?= $practical ?></td>
                      <td class="<?= $isFail ? 'text-danger' : '' ?>"><?= $total ?></td>
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