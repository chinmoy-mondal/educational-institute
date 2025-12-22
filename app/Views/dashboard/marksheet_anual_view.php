<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
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

  th {
    text-align: center;
    vertical-align: middle !important;
  }

  td strong {
    display: inline-block;
    width: 140px;
    font-weight: bold;
  }

  @page {
    size: A4;
    margin: 20mm;
  }

  @media print {
    body {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
      margin-top: 15mm;
    }

    .no-print {
      display: none !important;
    }

    html,
    body {
      width: 210mm;
      height: 297mm;
    }
  }
</style>

<?php
$class   = (int)$student['class'];
$section = strtolower($student['section']);
$group   = (strpos(strtolower($section), 'vocational') !== false) ? 'vocational' : 'general';
$roll    = isset($student['roll']) ? (int)$student['roll'] : null;
$exam    = esc($examName);
$year    = esc($examYear);
$isAnnualCombined = ($exam === 'Annual Exam' && $class >= 6 && $class <= 9);
?>

<?php if (!is_null($roll)): ?>
  <div class="no-print mb-3 text-center">
    <?php
    $prevRoll = $roll - 1;
    $nextRoll = $roll + 1;
    function makeUrl($class, $section, $roll, $exam, $year)
    {
      $params = http_build_query([
        'search_type' => 'roll',
        'student_id'  => '',
        'class'       => $class,
        'section'     => $section,
        'roll'        => $roll,
        'exam'        => $exam,
        'year'        => $year,
      ]);
      return site_url('admin/show-marksheet?' . $params);
    }
    ?>
    <a href="<?= makeUrl($class, $group, $prevRoll, $exam, $year) ?>" class="btn btn-outline-primary">← Previous</a>
    <a href="<?= makeUrl($class, $group, $roll, $exam, $year) ?>" class="btn btn-outline-secondary">Current</a>
    <a href="<?= makeUrl($class, $group, $nextRoll, $exam, $year) ?>" class="btn btn-outline-primary">Next →</a>
  </div>
<?php endif; ?>

<div class="marksheet-wrapper">
  <!-- School Header -->
  <div class="school-header">
    <h2>Mulgram Secondary School</h2>
    <h5>Keshabpur, Jashore</h5>
  </div>

  <!-- Student Photo + Logo + Grade Table -->
  <div class="row align-items-center">
    <div class="col-md-3 text-left">
      <?php if (!empty($student['student_pic'])): ?>
        <img src="<?= base_url($student['student_pic']) ?>" alt="Student Photo" width="150">
      <?php else: ?>
        <img src="<?= base_url('public/assets/img/default.png') ?>" alt="No Photo" width="150">
      <?php endif; ?>
    </div>
    <div class="col-md-6 transcript-title">
      <img src="<?= base_url('public/assets/img/logo.jpg'); ?>" alt="School Logo" width="60">
      <h4 style="margin-top: 10px; border-bottom: 4px solid green; display: inline-block; font-weight: bold;">Academic Transcript</h4>
    </div>
    <div class="col-md-3">
      <div class="grade-box">
        <table class="table table-bordered text-center grade-table">
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
          <tr>
            <td>70 - 79</td>
            <td>A</td>
            <td>4.0</td>
          </tr>
          <tr>
            <td>60 - 69</td>
            <td>A-</td>
            <td>3.5</td>
          </tr>
          <tr>
            <td>50 - 59</td>
            <td>B</td>
            <td>3.0</td>
          </tr>
          <tr>
            <td>40 - 49</td>
            <td>C</td>
            <td>2.0</td>
          </tr>
          <tr>
            <td>33 - 39</td>
            <td>D</td>
            <td>1.0</td>
          </tr>
          <tr>
            <td>0 - 32</td>
            <td>F</td>
            <td>0.0</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <!-- Student Info -->
  <table class="student-info">
    <tr>
      <td><strong>Student's Name</strong>: <?= esc($student['student_name']) ?></td>
    </tr>
    <tr>
      <td><strong>Father's Name</strong>: <?= esc($student['father_name']) ?></td>
    </tr>
    <tr>
      <td><strong>Mother's Name</strong>: <?= esc($student['mother_name']) ?></td>
    </tr>
    <tr>
      <td><strong>Student's ID</strong>: <?= esc($student['id']) ?></td>
      <td><strong>Exam</strong>: <?= ucwords(str_replace(['-', '_'], ' ', esc($examName))) ?></td>
    </tr>
    <tr>
      <td><strong>Class</strong>: <?= esc($student['class']) ?></td>
      <td><strong>Year/Session</strong>: <?= esc($examYear) ?></td>
    </tr>
    <tr>
      <td><strong>Roll No</strong>: <?= esc($student['roll']) ?></td>
      <td><strong>Group</strong>: <?= esc($student['section']) ?></td>
    </tr>
  </table>

  <!-- Marks Table -->
  <?php if ($isAnnualCombined): ?>
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th rowspan="2">Subject</th>
          <th rowspan="2">F.M</th>
          <th colspan="4">Half-Yearly</th>
          <th colspan="4">Annual</th>
          <th rowspan="2">T.M</th>
          <th rowspan="2">Average</th>
          <th rowspan="2">%</th>
          <th rowspan="2">Grade</th>
          <th rowspan="2">GP</th>
        </tr>
        <tr>
          <th>W</th>
          <th>M</th>
          <th>P</th>
          <th>Total</th>
          <th>W</th>
          <th>M</th>
          <th>P</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $totalGPA = 0;
        $subjectCount = 0;
        $totalFailed = 0;
        foreach ($marksheet as $row):
          $half   = $row['half'] ?? ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0];
          $annual = $row['annual'] ?? ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0];
          $fm     = $row['full_mark'] ?? 0;

          // Total & Average
          $tm      = $half['total'] + $annual['total'];
          $avg     = round($tm / 2, 2);
          $percent = ($avg / $fm) * 100;

          // Grade & GPA
          if ($percent >= 80) {
            $grade = 'A+';
            $gpa   = 5;
          } elseif ($percent >= 70) {
            $grade = 'A';
            $gpa   = 4;
          } elseif ($percent >= 60) {
            $grade = 'A-';
            $gpa   = 3.5;
          } elseif ($percent >= 50) {
            $grade = 'B';
            $gpa   = 3;
          } elseif ($percent >= 40) {
            $grade = 'C';
            $gpa   = 2;
          } elseif ($percent >= 33) {
            $grade = 'D';
            $gpa   = 1;
          } else {
            $grade = 'F';
            $gpa   = 0;
            $totalFailed++;
          }

          $totalGPA++;
          $subjectCount++;
        ?>
          <tr>
            <td><?= esc($row['subject']) ?></td>
            <td><?= $fm ?></td>

            <!-- Half-Yearly -->
            <td><?= $half['written'] ?></td>
            <td><?= $half['mcq'] ?></td>
            <td><?= $half['practical'] ?></td>
            <td><?= $half['total'] ?></td>

            <!-- Annual -->
            <td><?= $annual['written'] ?></td>
            <td><?= $annual['mcq'] ?></td>
            <td><?= $annual['practical'] ?></td>
            <td><?= $annual['total'] ?></td>

            <!-- Total & Average -->
            <td><?= $tm ?></td>
            <td><?= $avg ?></td>
            <td><?= round($percent, 2) ?>%</td>
            <td><?= $grade ?></td>
            <td><?= number_format($gpa, 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="14">GPA</th>
          <th colspan="2"><?= $subjectCount ? number_format($totalGPA / $subjectCount, 2) : '0.00' ?></th>
        </tr>
      </tfoot>
    </table>
  <?php endif; ?>

  <!-- QR Code + Signatures -->
  <div class="row qr-signature">
    <div class="col-md-9">
      <table class="table table-bordered text-center">
        <tr>
          <td>
            <table class="table table-bordered text-center mb-0">
              <tr>
                <td><strong>Position</strong></td>
                <td>---</td>
              </tr>
              <tr>
                <td><strong>GPA (Without 4th)</strong></td>
                <td><?= $subjectCount > 0 ? number_format($totalGPA / $subjectCount, 2) : '0.00' ?></td>
              </tr>
              <tr>
                <td><strong>Failed Subject</strong></td>
                <td><?= $totalFailed ?></td>
              </tr>
              <tr>
                <td><strong>Working Days</strong></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Total Present</strong></td>
                <td></td>
              </tr>
            </table>
          </td>
          <td>
            <table class="table table-bordered text-center mb-0">
              <tr>
                <th colspan="2">Moral & Behaviour Evaluation</th>
              </tr>
              <tr>
                <th></th>
                <th>Best</th>
              </tr>
              <tr>
                <th></th>
                <th>Better</th>
              </tr>
              <tr>
                <th></th>
                <th>Good</th>
              </tr>
              <tr>
                <th></th>
                <th>Need Improvement</th>
              </tr>
            </table>
          </td>
          <td>
            <table class="table table-bordered text-center mb-0">
              <tr>
                <th colspan="2">Co-Curricular Activities</th>
              </tr>
              <tr>
                <td></td>
                <th>Sports</th>
              </tr>
              <tr>
                <td></td>
                <th>Cultural Function</th>
              </tr>
              <tr>
                <td></td>
                <th>Scout / BNCC</th>
              </tr>
              <tr>
                <td></td>
                <th>Math Olympiad</th>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
    <div class="col-md-3 qr-code text-center">
      <?php $url = 'https://mulss.edu.bd/student-id?q=' . $student['id']; ?>
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode($url) ?>" class="qr-img" alt="Student QR">
      <p style="font-size: 12px;">Scan to Verify</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 signature text-left">
      <img src="<?= base_url('public/assets/img/sign.png') ?>" alt="Signature" style="height:41px;">
      ____________________<br>Head Teacher
    </div>
    <div class="col-md-6 signature text-right">
      ____________________<br>Class Teacher
    </div>
  </div>

  <div class="text-center mt-3 no-print">
    <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Print Marksheet</button>
  </div>
</div>

<?= $this->endSection() ?>