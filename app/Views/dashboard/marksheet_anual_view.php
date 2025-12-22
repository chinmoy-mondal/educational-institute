<!-- Marksheet Table -->
<table class="table table-bordered text-center">
    <thead>
        <tr>
            <th rowspan="2">Subject</th>
            <th rowspan="2">F.M</th>
            <th colspan="4">Half-Yearly</th>
            <th colspan="4">Annual</th>
            <th rowspan="2">T.O</th>
            <th rowspan="2">Avg</th>
            <th rowspan="2">LG</th>
            <th rowspan="2">GP</th>
        </tr>
        <tr>
            <th>Wri</th>
            <th>MCQ</th>
            <th>Prac</th>
            <th>Total</th>
            <th>Wri</th>
            <th>MCQ</th>
            <th>Prac</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
    $grandTotal = 0;
    $subjectCount = count($marksheet);
    foreach ($marksheet as $sub):
      $halfTotal = ($sub['half_wri'] ?? 0) + ($sub['half_mcq'] ?? 0) + ($sub['half_prac'] ?? 0);
      $annualTotal = ($sub['annual_wri'] ?? 0) + ($sub['annual_mcq'] ?? 0) + ($sub['annual_prac'] ?? 0);
      $totalObtain = $halfTotal + $annualTotal;
      $average = $totalObtain / 2; // simple avg
      // Letter grade and GP logic
      if ($average >= 80) {
        $lg = 'A+';
        $gp = 5.0;
      } elseif ($average >= 70) {
        $lg = 'A';
        $gp = 4.0;
      } elseif ($average >= 60) {
        $lg = 'A-';
        $gp = 3.5;
      } elseif ($average >= 50) {
        $lg = 'B';
        $gp = 3.0;
      } elseif ($average >= 40) {
        $lg = 'C';
        $gp = 2.0;
      } elseif ($average >= 33) {
        $lg = 'D';
        $gp = 1.0;
      } else {
        $lg = 'F';
        $gp = 0;
      }
      $grandTotal += $totalObtain;
    ?>
        <tr>
            <td><?= $sub['subject'] ?></td>
            <td><?= $sub['full_mark'] ?></td>
            <td><?= $sub['half_wri'] ?? 0 ?></td>
            <td><?= $sub['half_mcq'] ?? 0 ?></td>
            <td><?= $sub['half_prac'] ?? 0 ?></td>
            <td><?= $halfTotal ?></td>
            <td><?= $sub['annual_wri'] ?? 0 ?></td>
            <td><?= $sub['annual_mcq'] ?? 0 ?></td>
            <td><?= $sub['annual_prac'] ?? 0 ?></td>
            <td><?= $annualTotal ?></td>
            <td><?= $totalObtain ?></td>
            <td><?= number_format($average, 2) ?></td>
            <td><?= $lg ?></td>
            <td><?= $gp ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="10">Grand Total</th>
            <th><?= $grandTotal ?></th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th colspan="10">Average</th>
            <th><?= number_format($grandTotal / $subjectCount, 2) ?></th>
            <th colspan="3"></th>
        </tr>
    </tfoot>
</table>