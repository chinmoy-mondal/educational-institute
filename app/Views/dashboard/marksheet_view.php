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
  padding: 25px;
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
</style>

<div class="marksheet-wrapper">
  <!-- School Info -->
  <div class="school-header">
    <h2>Tatibari Islamia High School</h2>
    <h5>Khoshalpur, Modhupur, Tangail</h5>
    <h4 style="margin-top: 10px;">Academic Transcript</h4>
  </div>

  <!-- Student + Exam Info -->
  <table class="student-info">
    <tr>
<td>
    <img src="<?= base_url('public/assets/img/default.png'); ?>" alt="School Logo" width="60">
</td>
<td>
    <img src="<?= base_url('public/assets/img/logo.jpg'); ?>" alt="School Logo" width="60">
</td>
<td>
	<table>
		<tr>
			<th>Range</th>
			<th>Grade</th>
			<th>GPA</th>
		</tr>
		<tr>
			<td>80 - 100</td>
			<td>A+</td>
			<td>5.0</td>
		</tr>
	</table>
</td>
    </tr>
    <tr>
      <td><strong>Student's Name:</strong> Kazi Mahmudul Islam</td>
    </tr>
    <tr>
      <td><strong>Student's Name:</strong> Kazi Mahmudul Islam</td>
    </tr>
    <tr>
      <td><strong>Student's Name:</strong> Kazi Mahmudul Islam</td>
    </tr>
    <tr>
      <td><strong>Mother's Name:</strong> Rashida Akter</td>
      <td><strong>Student ID:</strong> 202312</td>
    </tr>
    <tr>
      <td><strong>Class:</strong> 9</td>
      <td><strong>Group:</strong> Science</td>
    </tr>
    <tr>
      <td><strong>Roll No:</strong> 5</td>
      <td><strong>Exam:</strong> Half Yearly - 2025</td>
    </tr>
  </table>

  <!-- Mark Table -->
  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>Subject</th>
        <th>Full Marks</th>
        <th>Obtained Marks</th>
        <th>Grade Point</th>
        <th>Letter Grade</th>
        <th>GPA</th>
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
  <td><?= number_format($gpa, 2) ?></td>
  <td><?= $grade ?></td>
  <td><?= number_format($gpa, 2) ?></td>
</tr>
<?php endforeach; ?></tbody>
    <tfoot>
      <tr>
        <th colspan="2">Total Marks</th>
        <th><?= $totalMarks ?></th>
        <th colspan="3">GPA: <?= number_format($totalGPA / count($subjects), 2) ?></th>
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
