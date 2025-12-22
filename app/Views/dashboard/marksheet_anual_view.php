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

  .grade-table td,
  .grade-table th {
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

  th {
    text-align: center;
    vertical-align: middle !important;
  }

  td strong {
    display: inline-block;
    width: 140px;
    /* Adjust as needed */
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
  <!-- School Header + Student Info (keep as-is) -->
  <div class="school-header">
    <h2>Mulgram Secondary School</h2>
    <h5>Keshabpur, Jashore</h5>
  </div>

  <div class="row align-items-center">
    <!-- Student Photo, Logo, Grade Box (keep as-is) -->
  </div>

  <table class="student-info">
    <!-- Student + Exam Info (keep as-is) -->
  </table>

  <!-- Marks Table -->
  <?php if ($isAnnualCombined): ?>
    <!-- Combined Half-Yearly + Annual Table -->
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th rowspan="3">Subject</th>
          <th rowspan="3">F.M</th>
          <th colspan="5">Half-Yearly</th>
          <th colspan="5">Annual</th>
          <th rowspan="3">T.M</th>
          <th rowspan="3">Average</th>
          <th rowspan="3">Grade</th>
          <th rowspan="3">GP</th>
        </tr>
        <tr>
          <th>O.M</th>
          <th>W</th>
          <th>M</th>
          <th>P</th>
          <th>%</th>
          <th>O.M</th>
          <th>W</th>
          <th>M</th>
          <th>P</th>
          <th>%</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $totalGPA = 0;
        $subjectCount = 0;
        $totalFailed = 0;
        foreach ($marksheet as $row):
          $half   = $row['half'];
          $annual = $row['annual'];
          $fm     = $row['full_mark'];
          $tm     = $half['total'] + $annual['total'];
          $avg    = round($tm / 2, 2);
          $percent = ($avg / $fm) * 100;

          if ($percent >= 80) {
            $grade = 'A+';
            $gpa = 5;
          } elseif ($percent >= 70) {
            $grade = 'A';
            $gpa = 4;
          } elseif ($percent >= 60) {
            $grade = 'A-';
            $gpa = 3.5;
          } elseif ($percent >= 50) {
            $grade = 'B';
            $gpa = 3;
          } elseif ($percent >= 40) {
            $grade = 'C';
            $gpa = 2;
          } elseif ($percent >= 33) {
            $grade = 'D';
            $gpa = 1;
          } else {
            $grade = 'F';
            $gpa = 0;
            $totalFailed++;
          }

          $totalGPA += $gpa;
          $subjectCount++;
        ?>
          <tr>
            <td><?= esc($row['subject']) ?></td>
            <td><?= $fm ?></td>
            <!-- Half -->
            <td><?= $half['total'] ?></td>
            <td><?= $half['written'] ?></td>
            <td><?= $half['mcq'] ?></td>
            <td><?= $half['practical'] ?></td>
            <td><?= round($half['total'] / $fm * 100, 2) ?>%</td>
            <!-- Annual -->
            <td><?= $annual['total'] ?></td>
            <td><?= $annual['written'] ?></td>
            <td><?= $annual['mcq'] ?></td>
            <td><?= $annual['practical'] ?></td>
            <td><?= round($annual['total'] / $fm * 100, 2) ?>%</td>
            <td><?= $tm ?></td>
            <td><?= $avg ?></td>
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
  <?php else: ?>
    <!-- Single Exam Table -->
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th>Subject</th>
          <th>F.M</th>
          <th>Written</th>
          <th>MCQ</th>
          <th>Practical</th>
          <th>Total</th>
          <th>%</th>
          <th>Grade</th>
          <th>GP</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $totalGPA = 0;
        $subjectCount = 0;
        $totalFailed = 0;
        foreach ($marksheet as $row):
          $written   = $row['written'];
          $mcq       = $row['mcq'];
          $practical = $row['practical'];
          $tm        = $written + $mcq + $practical;
          $fm        = $row['full_mark'];
          $percent   = ($tm / $fm) * 100;

          if ($percent >= 80) {
            $grade = 'A+';
            $gpa = 5;
          } elseif ($percent >= 70) {
            $grade = 'A';
            $gpa = 4;
          } elseif ($percent >= 60) {
            $grade = 'A-';
            $gpa = 3.5;
          } elseif ($percent >= 50) {
            $grade = 'B';
            $gpa = 3;
          } elseif ($percent >= 40) {
            $grade = 'C';
            $gpa = 2;
          } elseif ($percent >= 33) {
            $grade = 'D';
            $gpa = 1;
          } else {
            $grade = 'F';
            $gpa = 0;
            $totalFailed++;
          }

          $totalGPA += $gpa;
          $subjectCount++;
        ?>
          <tr>
            <td><?= esc($row['subject']) ?></td>
            <td><?= $fm ?></td>
            <td><?= $written ?></td>
            <td><?= $mcq ?></td>
            <td><?= $practical ?></td>
            <td><?= $tm ?></td>
            <td><?= round($percent, 2) ?>%</td>
            <td><?= $grade ?></td>
            <td><?= number_format($gpa, 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="8">GPA</th>
          <th><?= $subjectCount ? number_format($totalGPA / $subjectCount, 2) : '0.00' ?></th>
        </tr>
      </tfoot>
    </table>
  <?php endif; ?>

  <!-- QR Code, Signatures, Print Button (keep as-is) -->
</div>

<?= $this->endSection() ?>