<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
// ---------- GROUP DATA ----------
$subjects = [];

foreach ($marksheet as $row) {
  $key = $row['subject'];

  if (!isset($subjects[$key])) {
    $subjects[$key] = [
      'subject' => $row['subject'],
      'full_mark' => $row['full_mark'],
      'half' => ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0],
      'annual' => ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0],
    ];
  }

  if ($row['exam'] === 'Half-Yearly') {
    $subjects[$key]['half'] = [
      'written' => $row['written'],
      'mcq' => $row['mcq'],
      'practical' => $row['practical'],
      'total' => $row['total'],
    ];
  }

  if ($row['exam'] === 'Annual Exam') {
    $subjects[$key]['annual'] = [
      'written' => $row['written'],
      'mcq' => $row['mcq'],
      'practical' => $row['practical'],
      'total' => $row['total'],
    ];
  }
}

// ---------- GPA FUNCTION ----------
function gradePoint($percent)
{
  return match (true) {
    $percent >= 80 => 5,
    $percent >= 70 => 4,
    $percent >= 60 => 3.5,
    $percent >= 50 => 3,
    $percent >= 40 => 2,
    $percent >= 33 => 1,
    default => 0,
  };
}
?>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th rowspan="2">Subject</th>
                    <th colspan="3">Half-Yearly</th>
                    <th colspan="3">Annual</th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">Avg</th>
                    <th rowspan="2">GPA</th>
                </tr>
                <tr>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                </tr>
            </thead>
            <tbody>

                <?php
        $totalGPA = 0;
        $gpaCount = 0;

        // ---------- HANDLE BANGLA + ENGLISH ----------
        $combinedGroups = [
          'Bangla'  => ['Bangla 1st Paper', 'Bangla 2nd Paper'],
          'English' => ['English 1st Paper', 'English 2nd Paper'],
        ];

        $used = [];
        foreach ($combinedGroups as $group => $papers):

          $sumHalf = $sumAnnual = $sumFM = 0;

          foreach ($papers as $paper) {
            if (!isset($subjects[$paper])) continue;
            $used[] = $paper;

            $sumHalf += $subjects[$paper]['half']['total'];
            $sumAnnual += $subjects[$paper]['annual']['total'];
            $sumFM += $subjects[$paper]['full_mark'];
          }

          if ($sumFM == 0) continue;

          $total = $sumHalf + $sumAnnual;
          $avg = round($total / 2, 2);
          $percent = ($avg / $sumFM) * 100;
          $gpa = gradePoint($percent);

          $totalGPA += $gpa;
          $gpaCount++;
        ?>
                <tr>
                    <td><strong><?= $group ?></strong></td>
                    <td colspan="3"><?= $sumHalf ?></td>
                    <td colspan="3"><?= $sumAnnual ?></td>
                    <td><?= $total ?></td>
                    <td><?= $avg ?></td>
                    <td><?= number_format($gpa, 2) ?></td>
                </tr>
                <?php endforeach; ?>

                <?php
        // ---------- OTHER SUBJECTS ----------
        foreach ($subjects as $sub):
          if (in_array($sub['subject'], $used)) continue;

          $tm = $sub['half']['total'] + $sub['annual']['total'];
          $avg = round($tm / 2, 2);
          $percent = ($avg / $sub['full_mark']) * 100;
          $gpa = gradePoint($percent);

          $totalGPA += $gpa;
          $gpaCount++;
        ?>
                <tr>
                    <td><?= esc($sub['subject']) ?></td>
                    <td><?= $sub['half']['written'] ?></td>
                    <td><?= $sub['half']['mcq'] ?></td>
                    <td><?= $sub['half']['practical'] ?></td>

                    <td><?= $sub['annual']['written'] ?></td>
                    <td><?= $sub['annual']['mcq'] ?></td>
                    <td><?= $sub['annual']['practical'] ?></td>

                    <td><?= $tm ?></td>
                    <td><?= $avg ?></td>
                    <td><?= number_format($gpa, 2) ?></td>
                </tr>
                <?php endforeach; ?>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="9">Final GPA</th>
                    <th><?= $gpaCount ? number_format($totalGPA / $gpaCount, 2) : '0.00' ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>