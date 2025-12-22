<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="marksheet-wrapper">

    <h4 class="text-center mb-3"><b>Annual Examination Marksheet</b></h4>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Subject</th>
                <th>W</th>
                <th>M</th>
                <th>P</th>
                <th>Total</th>
                <th>Avg</th>
                <th>GPA</th>
            </tr>
        </thead>

        <tbody>
            <?php
      $totalGPA = 0;
      $subjectCount = 0;

      foreach ($marksheet as $i => $mark):

        $subject = trim($mark['subject']);
        $written = $mark['written'];
        $mcq = $mark['mcq'];
        $practical = $mark['practical'];
        $total = $mark['total'];
        $full = $mark['full_mark'];
      ?>
            <tr>
                <td><?= esc($subject) ?></td>
                <td><?= $written ?></td>
                <td><?= $mcq ?></td>
                <td><?= $practical ?></td>

                <?php
          /* ===============================
           1️⃣ Bangla / English – 1st Paper
           =============================== */
          if (in_array($subject, ['Bangla 1st Paper', 'English 1st Paper'])):
          ?>
                <td></td>
                <td></td>
                <td></td>

                <?php
          /* ===============================
           2️⃣ Bangla / English – 2nd Paper
           =============================== */
          elseif (in_array($subject, ['Bangla 2nd Paper', 'English 2nd Paper'])):

            $first = $marksheet[$i - 1];

            $combinedTotal = $first['total'] + $total;
            $combinedFull  = $first['full_mark'] + $full;
            $percentage = ($combinedTotal / $combinedFull) * 100;

            if ($percentage >= 80) {
              $gpa = 5.00;
            } elseif ($percentage >= 70) {
              $gpa = 4.00;
            } elseif ($percentage >= 60) {
              $gpa = 3.50;
            } elseif ($percentage >= 50) {
              $gpa = 3.00;
            } elseif ($percentage >= 40) {
              $gpa = 2.00;
            } elseif ($percentage >= 33) {
              $gpa = 1.00;
            } else {
              $gpa = 0.00;
            }

            $totalGPA += $gpa;
            $subjectCount++;
          ?>
                <td><?= $combinedTotal ?></td>
                <td><?= number_format($combinedTotal / 2, 2) ?></td>
                <td><?= number_format($gpa, 2) ?></td>

                <?php
          /* ===============================
           3️⃣ All Other Subjects
           =============================== */
          else:

            $percentage = ($total / $full) * 100;

            if ($percentage >= 80) {
              $gpa = 5.00;
            } elseif ($percentage >= 70) {
              $gpa = 4.00;
            } elseif ($percentage >= 60) {
              $gpa = 3.50;
            } elseif ($percentage >= 50) {
              $gpa = 3.00;
            } elseif ($percentage >= 40) {
              $gpa = 2.00;
            } elseif ($percentage >= 33) {
              $gpa = 1.00;
            } else {
              $gpa = 0.00;
            }

            $totalGPA += $gpa;
            $subjectCount++;
          ?>
                <td><?= $total ?></td>
                <td><?= number_format($total, 2) ?></td>
                <td><?= number_format($gpa, 2) ?></td>

                <?php endif; ?>

            </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="6" class="text-end">Final GPA</th>
                <th>
                    <?= $subjectCount > 0 ? number_format($totalGPA / $subjectCount, 2) : '0.00' ?>
                </th>
            </tr>
        </tfoot>
    </table>

</div>

<?= $this->endSection() ?>