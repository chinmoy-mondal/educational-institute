<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
@media print {
  .no-print {
    display: none !important;
  }
  .card {
    box-shadow: none !important;
    border: none !important;
  }
}
.marksheet {
  max-width: 800px;
  margin: auto;
  background: white;
  padding: 30px;
  font-size: 16px;
}
.marksheet h4 {
  margin-bottom: 5px;
}
</style>

<div class="card marksheet">
  <div class="card-body">

    <!-- School Info -->
    <div class="text-center mb-4">
      <h2 class="font-weight-bold">Green Valley School</h2>
      <h5>123 Main Street, City, Country</h5>
      <h4 class="mt-3">Marksheet</h4>
      <hr>
    </div>

    <!-- Student Info -->
    <div class="row mb-3">
      <div class="col-sm-6">
        <strong>Name:</strong> Chinmoy Mondal<br>
        <strong>Class:</strong> 9<br>
        <strong>Section:</strong> General
      </div>
      <div class="col-sm-6 text-right">
        <strong>Roll:</strong> 12<br>
        <strong>Student ID:</strong> STU2025001<br>
        <strong>Exam:</strong> Half Yearly - 2025
      </div>
    </div>

    <!-- Marksheet Table -->
    <table class="table table-bordered text-center">
      <thead class="thead-light">
        <tr>
          <th>Subject</th>
          <th>Full Marks</th>
          <th>Obtained Marks</th>
          <th>Grade</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $subjects = [
          ['name' => 'Bangla', 'full' => 100, 'mark' => 78],
          ['name' => 'English', 'full' => 100, 'mark' => 70],
          ['name' => 'Math', 'full' => 100, 'mark' => 92],
          ['name' => 'Science', 'full' => 100, 'mark' => 81],
          ['name' => 'Religion', 'full' => 100, 'mark' => 88],
        ];

        $total = 0;
        foreach ($subjects as $sub):
          $grade = ($sub['mark'] >= 80) ? 'A+' :
                   (($sub['mark'] >= 70) ? 'A' :
                   (($sub['mark'] >= 60) ? 'A-' :
                   (($sub['mark'] >= 50) ? 'B' :
                   (($sub['mark'] >= 40) ? 'C' : 'F'))));
          $total += $sub['mark'];
        ?>
        <tr>
          <td><?= $sub['name'] ?></td>
          <td><?= $sub['full'] ?></td>
          <td><?= $sub['mark'] ?></td>
          <td><?= $grade ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="2">Total</th>
          <th><?= $total ?></th>
          <th>
            <?php
              $avg = $total / count($subjects);
              $gpa = ($avg >= 80) ? '5.00' :
                     (($avg >= 70) ? '4.00' :
                     (($avg >= 60) ? '3.50' :
                     (($avg >= 50) ? '3.00' :
                     (($avg >= 40) ? '2.00' : '0.00'))));
              echo "GPA: $gpa";
            ?>
          </th>
        </tr>
      </tfoot>
    </table>

    <!-- Remarks -->
    <div class="mt-3">
      <strong>Result:</strong>
      <?= ($gpa === '0.00') ? '<span class="text-danger">Failed</span>' : '<span class="text-success">Passed</span>' ?>
    </div>

    <!-- Signature -->
    <div class="row mt-5">
      <div class="col-6 text-left">
        <strong>__________________</strong><br>
        <span>Guardian's Signature</span>
      </div>
      <div class="col-6 text-right">
        <strong>__________________</strong><br>
        <span>Headmaster's Signature</span>
      </div>
    </div>
  </div>

  <!-- Print Button -->
  <div class="card-footer text-center no-print">
    <button onclick="window.print()" class="btn btn-primary">
      <i class="fas fa-print"></i> Print Marksheet
    </button>
  </div>
</div>

<?= $this->endSection() ?>
