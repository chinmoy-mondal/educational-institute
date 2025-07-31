<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
@media print {
  .no-print {
    display: none !important;
  }
}

.marksheet-wrapper {
  background: white;
  padding: 24px;
  border: 6px double goldenrod;
  margin: auto;
  max-width: 850px;
  font-family: 'Arial', sans-serif;
  font-size: 14px;
}

.school-header {
  text-align: center;
  margin-bottom: 20px;
}

.school-header h2 {
  margin: 0;
  font-weight: bold;
  text-transform: uppercase;
}

.school-header h5 {
  margin: 5px 0;
}

.student-info,
.exam-info {
  width: 100%;
  margin-bottom: 15px;
}

.student-info td,
.exam-info td {
  padding: 4px;
}

.table-bordered td,
.table-bordered th {
  border: 1px solid #000 !important;
  padding: 4px !important;
}

.grade-table td, 
.grade-table th {
    font-size: 12px;
    padding: 1px 1px !important;
    line-height: 1.0;
}

.qr-signature {
  margin-top: 30px;
}

.qr-code {
  text-align: center;
}

.qr-code img {
  width: 100px;
  height: 100px;
}

.signature {
  text-align: right;
  margin-top: 30px;
  font-weight: bold;
}

.grade-table td, .grade-table th {
  font-size: 12px;
  padding: 3px 6px !important;
  line-height: 1.2;
}

.transcript-title {
  text-align: center;
}

.transcript-title img {
  display: block;
  margin: 0 auto;
}

.grade-box {
  float: right;
}

.align-items-center {
    align-items: initial !important;
}


td strong {
	display: inline-block;
	width: 140px; /* Adjust as needed */
	font-weight: bold;
}
</style>

<div class="marksheet-wrapper">
  <!-- School Info -->
  <div class="school-header">
    <h2>Mulgram Secondary School</h2>
    <h5>Keshoppur, Jessor</h5>
  </div>

  <div class="row align-items-center">
  <!-- Left: Student Photo -->
  <div class="col-md-3 text-left">
    <img src="<?= base_url('public/assets/img/headsir.jpg'); ?>" alt="Student Photo" width="200">
  </div>

  <!-- Center: School Logo & Transcript Title -->
  <div class="col-md-6 transcript-title">
    <img src="<?= base_url('public/assets/img/logo.jpg'); ?>" alt="School Logo" width="60">
    <h4 style="margin-top: 10px; border-bottom: 4px solid green; display: inline-block; font-weight: bold;">Academic Transcript</h4>
  </div>

  <!-- Right: Grade Chart -->
  <div class="col-md-3">
    <div class="grade-box">
      <table class="table table-bordered text-center grade-table">
        <tr>
          <th>Range</th>
          <th>Grade</th>
          <th>GPA</th>
        </tr>
        <tr><td>80 - 100</td><td>A+</td><td>5.0</td></tr>
        <tr><td>70 - 79</td><td>A</td><td>4.0</td></tr>
        <tr><td>60 - 69</td><td>A-</td><td>3.5</td></tr>
        <tr><td>50 - 59</td><td>B</td><td>3.0</td></tr>
        <tr><td>40 - 49</td><td>C</td><td>2.0</td></tr>
        <tr><td>33 - 39</td><td>D</td><td>1.0</td></tr>
        <tr><td>0 - 32</td><td>F</td><td>0.0</td></tr>
      </table>
    </div>
  </div>
</div>
<!-- Student + Exam Info -->
  <table class="student-info">
    <tr>
      <td><strong>Student's Name</strong>: Kazi Mahmudul Islam</td>
    </tr>
    <tr>
      <td><strong>Father's Name</strong>: Kazi Mahmudul Islam</td>
    </tr>
    <tr>
      <td><strong>Mother's Name</strong>: Kazi Mahmudul Islam</td>
    </tr>
    <tr>
      <td><strong>Student's ID</strong>: Rashida Akter</td>
      <td><strong>Exam</strong>: 202312</td>
    </tr>
    <tr>
      <td><strong>Class</strong>: 202312</td>
      <td><strong>Year/Session</strong>: 9</td>
    </tr>
    <tr>
      <td><strong>Roll No</strong>: 9</td>
      <td><strong>Group</strong>: Half Yearly - 2025</td>
    </tr>
  </table>

  <!-- Mark Table -->
<table class="table table-bordered text-center">
  <thead>
    <tr>
      <th rowspan="2">Subject</th>
      <th rowspan="2">Full Marks</th>
      <th rowspan="2">Obtained Marks</th>
      <th colspan="4">Marks Distribution</th>
      <th rowspan="2">Total Marks</th>
      <th rowspan="2">Letter Grade</th>
      <th rowspan="2">GP</th>
    </tr>
    <tr>
      <th>Wri</th>
      <th>MCQ</th>
      <th>Pra</th>
      <th>%</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $subjects = [
      ['name' => 'Bangla 1st', 'full' => 100, 'mark' => 80],
      ['name' => 'Bangla 2nd', 'full' => 100, 'mark' => 75],
      ['name' => 'English 1st', 'full' => 100, 'mark' => 78],
      ['name' => 'English 2nd', 'full' => 100, 'mark' => 82],
      ['name' => 'Math', 'full' => 100, 'mark' => 90],
      ['name' => 'ICT', 'full' => 100, 'mark' => 70],
      ['name' => 'Religion', 'full' => 100, 'mark' => 88],
    ];

    $totalMarks = 0;
    $totalGPA = 0;

    foreach ($subjects as $s):
      $mark = $s['mark'];
      $totalMarks += $mark;

      $written = round($mark * 0.5);
      $mcq = round($mark * 0.3);
      $practical = round($mark * 0.2);
      $percent = round(($mark / $s['full']) * 100);

      $gpa = ($mark >= 80) ? 5.0 :
            (($mark >= 70) ? 4.0 :
            (($mark >= 60) ? 3.5 :
            (($mark >= 50) ? 3.0 :
            (($mark >= 40) ? 2.0 : 0.0))));

      $grade = ($mark >= 80) ? 'A+' :
              (($mark >= 70) ? 'A' :
              (($mark >= 60) ? 'A-' :
              (($mark >= 50) ? 'B' :
              (($mark >= 40) ? 'C' : 'F'))));

      $totalGPA += $gpa;
    ?>
    <tr>
      <td><?= esc($s['name']) ?></td>
      <td><?= $s['full'] ?></td>
      <td><?= $mark ?></td>
      <td><?= $written ?></td>
      <td><?= $mcq ?></td>
      <td><?= $practical ?></td>
      <td><?= $percent ?>%</td>
      <td><?= $mark ?></td>
      <td><?= $grade ?></td>
      <td><?= number_format($gpa, 2) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="2">Total Marks</th>
      <th><?= $totalMarks ?></th>
      <th colspan="4"></th>
      <th></th>
      <th colspan="2"></th>
    </tr>
    <tr>
      <th colspan="8" class="text-end">GPA:</th>
      <th colspan="2"><?= number_format($totalGPA / count($subjects), 2) ?></th>
    </tr>
  </tfoot>
</table>
  <!-- Grade Chart + QR + Signature -->
  <div class="row qr-signature">
    <div class="col-md-6">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>Mark Range</th>
            <th>Letter</th>
            <th>Point</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>80–100</td><td>A+</td><td>5.00</td></tr>
          <tr><td>70–79</td><td>A</td><td>4.00</td></tr>
          <tr><td>60–69</td><td>A-</td><td>3.50</td></tr>
          <tr><td>50–59</td><td>B</td><td>3.00</td></tr>
          <tr><td>40–49</td><td>C</td><td>2.00</td></tr>
          <tr><td>0–39</td><td>F</td><td>0.00</td></tr>
        </tbody>
      </table>
    </div>

    <div class="col-md-3 qr-code text-center">
      <img src="<?= base_url('public/qr-code.png') ?>" alt="QR Code">
      <p style="font-size: 12px;">Scan to Verify</p>
    </div>

    <div class="col-md-3 signature text-right">
      <br><br>
      ____________________<br>
      Headmaster
    </div>
  </div>

  <div class="text-center mt-3 no-print">
    <button onclick="window.print()" class="btn btn-primary">
      <i class="fas fa-print"></i> Print Marksheet
    </button>
  </div>
</div>

<?= $this->endSection() ?>
