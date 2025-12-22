<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">

        <h4 class="text-center mb-3">
            <?= esc($examName) ?> – <?= esc($examYear) ?>
        </h4>

        <?php
    /**
     * STEP 1: GROUP HALF + ANNUAL BY SUBJECT
     */
    $grouped = [];

    foreach ($marksheet as $row) {
      $sid = $row['subject_id'];

      if (!isset($grouped[$sid])) {
        $grouped[$sid] = [
          'subject'   => $row['subject'],
          'full_mark' => $row['full_mark'],
          'half'      => ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0],
          'annual'    => ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0],
        ];
      }

      if ($row['exam'] === 'Half-Yearly') {
        $grouped[$sid]['half'] = [
          'written'   => (int)$row['written'],
          'mcq'       => (int)$row['mcq'],
          'practical' => (int)$row['practical'],
          'total'     => (int)$row['total'],
        ];
      }

      if ($row['exam'] === 'Annual Exam') {
        $grouped[$sid]['annual'] = [
          'written'   => (int)$row['written'],
          'mcq'       => (int)$row['mcq'],
          'practical' => (int)$row['practical'],
          'total'     => (int)$row['total'],
        ];
      }
    }
    ?>

        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th rowspan="2">Subject</th>
                    <th colspan="4">Half-Yearly</th>
                    <th colspan="4">Annual</th>
                    <th rowspan="2">Average</th>
                    <th rowspan="2">GPA</th>
                </tr>
                <tr>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>T</th>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>T</th>
                </tr>
            </thead>

            <tbody>
                <?php
        $totalGPA = 0;
        $subjectCount = 0;

        foreach ($grouped as $row):

          $half   = $row['half'];
          $annual = $row['annual'];

          $avg = ($half['total'] + $annual['total']) / 2;

          // GPA calculation (simple board style)
          if ($avg >= 80)      $gpa = 5.00;
          elseif ($avg >= 70)  $gpa = 4.00;
          elseif ($avg >= 60)  $gpa = 3.50;
          elseif ($avg >= 50)  $gpa = 3.00;
          elseif ($avg >= 40)  $gpa = 2.00;
          elseif ($avg >= 33)  $gpa = 1.00;
          else                 $gpa = 0.00;

          $totalGPA += $gpa;
          $subjectCount++;
        ?>
                <tr>
                    <td class="text-start"><?= esc($row['subject']) ?></td>

                    <td><?= $half['written'] ?></td>
                    <td><?= $half['mcq'] ?></td>
                    <td><?= $half['practical'] ?></td>
                    <td><?= $half['total'] ?></td>

                    <td><?= $annual['written'] ?></td>
                    <td><?= $annual['mcq'] ?></td>
                    <td><?= $annual['practical'] ?></td>
                    <td><?= $annual['total'] ?></td>

                    <td><?= number_format($avg, 2) ?></td>
                    <td><?= number_format($gpa, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="10" class="text-end">Final GPA</th>
                    <th>
                        <?= $subjectCount
              ? number_format($totalGPA / $subjectCount, 2)
              : '0.00' ?>
                    </th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

<?= $this->endSection() ?>