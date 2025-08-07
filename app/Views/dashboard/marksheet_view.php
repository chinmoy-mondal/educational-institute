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
$class    = (int)$student['class'];
$section  = strtolower($student['section']);
$group = (strpos(strtolower($section), 'vocational') !== false) ? 'vocational' : 'general';
$roll     = isset($student['roll']) ? (int)$student['roll'] : null;
$exam     = esc($examName);
$year     = esc($examYear);

if (!is_null($roll)) {
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

  <div class="no-print mb-3 text-center">
    <a href="<?= makeUrl($class, $group, $prevRoll, $exam, $year) ?>" class="btn btn-outline-primary">
      ← Previous
    </a>
    <a href="<?= makeUrl($class, $group, $roll, $exam, $year) ?>" class="btn btn-outline-secondary">
      Current
    </a>
    <a href="<?= makeUrl($class, $group, $nextRoll, $exam, $year) ?>" class="btn btn-outline-primary">
      Next →
    </a>
  </div>

<?php } ?>
<div class="marksheet-wrapper">
  <!-- School Info -->
  <div class="school-header">
    <h2>Mulgram Secondary School</h2>
    <h5>Keshoppur, Jessore</h5>
  </div>

  <div class="row align-items-center">
    <!-- Left: Student Photo -->
    <div class="col-md-3 text-left">
      <?php if (!empty($student['student_pic'])): ?>
        <img src="<?= base_url($student['student_pic']) ?>" alt="Student Photo" width="150">
      <?php else: ?>
        <img src="<?= base_url('public/assets/img/default.png') ?>" alt="No Photo" width="150">
      <?php endif; ?>
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
  <!-- Student + Exam Info -->
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
      $totalMarks = 0;
      $totalGPA = 0;
      $subjectCount = 0;
      $totalFailed = 0;
      $totalFailed = 0;
      $forthGPA = 0;
      $grade = 0;
      $gpa = 0;
      ?>
      <?php foreach ($marksheet as $i => $mark): ?>
        <?php $totalMarks = $totalMarks +  $mark['total']; ?>
        <tr>
          <td>
            <?= esc($mark['subject']) ?>
            <?php
            if (count($marksheet) - 1 == $i && in_array((int)$student['class'], [9, 10])) {
              echo " <b>(4th)</b>";
            }
            ?>
          </td>
          <td><?= esc($mark['full_mark'] ?? 100) ?></td>
          <td><?= esc($mark['obtained'] ?? $mark['total']) ?></td>
          <td><?= esc($mark['written']) ?></td>
          <td><?= esc($mark['mcq']) ?></td>
          <td><?= esc($mark['practical']) ?></td>
          <td><?= esc(round($mark['total'] / $mark['full_mark'] * 100, 2)) ?>%</td>

          <?php
          // Handle 1st Paper (rowspan with empty cells to fill later)
          if (in_array($mark['subject'], ['Bangla 1st Paper', 'English 1st Paper'])):
            $subjectKey = strtolower(str_replace(' ', '_', explode(' ', $mark['subject'])[0]));
          ?>
            <td id="combined_mark_<?= $subjectKey ?>" rowspan="2"></td>
            <td id="combined_grade_<?= $subjectKey ?>" rowspan="2"></td>
            <td id="combined_gpa_<?= $subjectKey ?>" rowspan="2"></td>

          <?php
          // Handle 2nd Paper (inject values into previous IDs)
          elseif (in_array($mark['subject'], ['Bangla 2nd Paper', 'English 2nd Paper'])):
            $subjectKey = strtolower(str_replace(' ', '_', explode(' ', $mark['subject'])[0]));
            $total = $mark['total'] + ($marksheet[$i - 1]['total'] ?? 0); // Combine 1st + 2nd paper total

            $subject = $mark['subject'];

            if (in_array((int)$student['class'], [6, 7, 8])) {
              if (($mark['total'] + ($marksheet[$i - 1]['total'] ?? 0)) < 49) {
                $grade = 'F';
                $gpa = '0.00';
                $totalFailed++;
              } else {
                $fullMark = $mark['full_mark'] + ($marksheet[$i - 1]['full_mark'] ?? 0);
                $percentage = $total / $fullMark * 100;

                if ($percentage >= 80) {
                  $grade = 'A+';
                  $gpa = '5.00';
                } elseif ($percentage >= 70) {
                  $grade = 'A';
                  $gpa = '4.00';
                } elseif ($percentage >= 60) {
                  $grade = 'A-';
                  $gpa = '3.50';
                } elseif ($percentage >= 50) {
                  $grade = 'B';
                  $gpa = '3.00';
                } elseif ($percentage >= 40) {
                  $grade = 'C';
                  $gpa = '2.00';
                } elseif ($percentage >= 33) {
                  $grade = 'D';
                  $gpa = '1.00';
                } else {
                  $grade = 'F';
                  $gpa = '0.00';
                }
              }
            } elseif (
              in_array((int)$student['class'], [9, 10]) &&
              $subject == 'Bangla 2nd Paper'
            ) {

              if (($mark['written'] + $marksheet[$i - 1]['written']) < 40 || ($mark['mcq'] + $marksheet[$i - 1]['mcq']) < 20) {
                $grade = 'F';
                $gpa = '0.00';

                $totalFailed++;
              } else {
                $fullMark = $mark['full_mark'] + ($marksheet[$i - 1]['full_mark'] ?? 0);
                $percentage = $total / $fullMark * 100;

                if ($percentage >= 80) {
                  $grade = 'A+';
                  $gpa = '5.00';
                } elseif ($percentage >= 70) {
                  $grade = 'A';
                  $gpa = '4.00';
                } elseif ($percentage >= 60) {
                  $grade = 'A-';
                  $gpa = '3.50';
                } elseif ($percentage >= 50) {
                  $grade = 'B';
                  $gpa = '3.00';
                } elseif ($percentage >= 40) {
                  $grade = 'C';
                  $gpa = '2.00';
                } elseif ($percentage >= 33) {
                  $grade = 'D';
                  $gpa = '1.00';
                } else {
                  $grade = 'F';
                  $gpa = '0.00';
                }
              }
            } elseif (
              in_array((int)$student['class'], [9, 10]) &&
              $subject == 'English 2nd Paper'
            ) {

              if (($mark['written'] + $marksheet[$i - 1]['written']) < 66) {
                $grade = 'F';
                $gpa = '0.00';

                $totalFailed++;
              } else {
                $fullMark = $mark['full_mark'] + $marksheet[$i - 1]['full_mark'];
                $percentage = $total / $fullMark * 100;

                if ($percentage >= 80) {
                  $grade = 'A+';
                  $gpa = '5.00';
                } elseif ($percentage >= 70) {
                  $grade = 'A';
                  $gpa = '4.00';
                } elseif ($percentage >= 60) {
                  $grade = 'A-';
                  $gpa = '3.50';
                } elseif ($percentage >= 50) {
                  $grade = 'B';
                  $gpa = '3.00';
                } elseif ($percentage >= 40) {
                  $grade = 'C';
                  $gpa = '2.00';
                } elseif ($percentage >= 33) {
                  $grade = 'D';
                  $gpa = '1.00';
                } else {
                  $grade = 'F';
                  $gpa = '0.00';
                }
              }
            }


          ?>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("combined_mark_<?= $subjectKey ?>").textContent = "<?= $total ?>";
                document.getElementById("combined_grade_<?= $subjectKey ?>").textContent = "<?= $grade ?>";
                document.getElementById("combined_gpa_<?= $subjectKey ?>").textContent = "<?= $gpa ?>";
              });
              <?php
              $totalGPA = $totalGPA + $gpa;
              $subjectCount++;
              ?>
            </script>

          <?php
          // All other subjects: print normally
          else:
          ?>
            <?php
            $subject = $mark['subject'];
            $class = (int)$student['class'];
            $total = $mark['total'];
            $fullMark = $mark['full_mark'];
            $percentage = $total / $fullMark * 100;

            if (in_array($class, [6, 7, 8])) {
              if ($subject === 'ICT' && $total < 17) {
                $grade = 'F';
                $gpa = '0.00';

                $totalFailed++;
              } elseif ($subject !== 'ICT' && $total < 33) {
                $grade = 'F';
                $gpa = '0.00';

                $totalFailed++;
              } else {

                if ($percentage >= 80) {
                  $grade = 'A+';
                  $gpa = '5.00';
                } elseif ($percentage >= 70) {
                  $grade = 'A';
                  $gpa = '4.00';
                } elseif ($percentage >= 60) {
                  $grade = 'A-';
                  $gpa = '3.50';
                } elseif ($percentage >= 50) {
                  $grade = 'B';
                  $gpa = '3.00';
                } elseif ($percentage >= 40) {
                  $grade = 'C';
                  $gpa = '2.00';
                } elseif ($percentage >= 33) {
                  $grade = 'D';
                  $gpa = '1.00';
                } else {
                  $grade = 'F';
                  $gpa = '0.00';
                }
              }
            } elseif (in_array($class, [9, 10])) {
              $section = strtolower($student['section']);
              $subject = $mark['subject'];
              $written = $mark['written'];
              $mcq = $mark['mcq'];
              $practical = $mark['practical'];
              $total = $mark['total'];
              $fullMark = $mark['full_mark'];
              $percentage = $total / $fullMark * 100;

              // ✳ Vocational section
              if (strpos($section, 'vocational') !== false) {
                if (
                  strpos($subject, 'Bangla') !== false ||
                  strpos($subject, 'English') !== false ||
                  strpos($subject, 'Islamic Studies') !== false ||
                  strpos($subject, 'Hindu Religion Studies') !== false ||
                  strpos($subject, 'Mathematics') !== false ||
                  strpos($subject, 'IT Support') !== false ||
                  strpos($subject, 'Food Processing and Preservation') !== false
                ) {
                  if ($written < 10) {
                    $grade = 'F';
                    $gpa = '0.00';
                    $totalFailed++;
                  } else {

                    if ($percentage >= 80) {
                      $grade = 'A+';
                      $gpa = '5.00';
                    } elseif ($percentage >= 70) {
                      $grade = 'A';
                      $gpa = '4.00';
                    } elseif ($percentage >= 60) {
                      $grade = 'A-';
                      $gpa = '3.50';
                    } elseif ($percentage >= 50) {
                      $grade = 'B';
                      $gpa = '3.00';
                    } elseif ($percentage >= 40) {
                      $grade = 'C';
                      $gpa = '2.00';
                    } elseif ($percentage >= 33) {
                      $grade = 'D';
                      $gpa = '1.00';
                    } else {
                      $grade = 'N/A';
                      $gpa = '0.00';
                    }
                  }
                } elseif (str_contains($subject, 'Agriculture Studies')) {
                  if ($written < 15) {
                    $grade = 'F';
                    $gpa = '0.00';
                    $totalFailed++;
                  } else {

                    if ($percentage >= 80) {
                      $grade = 'A+';
                      $gpa = '5.00';
                    } elseif ($percentage >= 70) {
                      $grade = 'A';
                      $gpa = '4.00';
                    } elseif ($percentage >= 60) {
                      $grade = 'A-';
                      $gpa = '3.50';
                    } elseif ($percentage >= 50) {
                      $grade = 'B';
                      $gpa = '3.00';
                    } elseif ($percentage >= 40) {
                      $grade = 'C';
                      $gpa = '2.00';
                    } elseif ($percentage >= 33) {
                      $grade = 'D';
                      $gpa = '1.00';
                    } else {
                      $grade = 'N/A';
                      $gpa = '0.00';
                    }
                  }
                }
                if (
                  str_contains($subject, 'Bangla') ||
                  str_contains($subject, 'English') ||
                  str_contains($subject, 'Islamic Studies') ||
                  str_contains($subject, 'Hindu Religion Studies') ||
                  str_contains($subject, 'Mathematics') ||
                  str_contains($subject, 'IT Support') ||
                  str_contains($subject, 'Food Processing and Preservation')
                ) {
                  if ($written < 20) {
                    $grade = 'F';
                    $gpa = '0.00';
                    $totalFailed++;
                  }
                } else {

                  if ($percentage >= 80) {
                    $grade = 'A+';
                    $gpa = '5.00';
                  } elseif ($percentage >= 70) {
                    $grade = 'A';
                    $gpa = '4.00';
                  } elseif ($percentage >= 60) {
                    $grade = 'A-';
                    $gpa = '3.50';
                  } elseif ($percentage >= 50) {
                    $grade = 'B';
                    $gpa = '3.00';
                  } elseif ($percentage >= 40) {
                    $grade = 'C';
                    $gpa = '2.00';
                  } elseif ($percentage >= 33) {
                    $grade = 'D';
                    $gpa = '1.00';
                  } else {
                    $grade = 'N/A';
                    $gpa = '0.00';
                  }
                }
              }
            }

            // ✳ General section
            else {
              if ($subject === 'ICT') {
                if (($written + $mcq) < 7 || $practical < 8) {
                  $grade = 'F';
                  $gpa = '0.00';

                  $totalFailed++;
                } else {

                  if ($percentage >= 80) {
                    $grade = 'A+';
                    $gpa = '5.00';
                  } elseif ($percentage >= 70) {
                    $grade = 'A';
                    $gpa = '4.00';
                  } elseif ($percentage >= 60) {
                    $grade = 'A-';
                    $gpa = '3.50';
                  } elseif ($percentage >= 50) {
                    $grade = 'B';
                    $gpa = '3.00';
                  } elseif ($percentage >= 40) {
                    $grade = 'C';
                    $gpa = '2.00';
                  } elseif ($percentage >= 33) {
                    $grade = 'D';
                    $gpa = '1.00';
                  } else {
                    $grade = 'F';
                    $gpa = '0.00';
                  }
                }
              } elseif (in_array($subject, ['Physics', 'Chemistry', 'Higher Math', 'Biology'])) {
                if ($written < 17 || $mcq < 8 || $practical < 8) {
                  $grade = 'F';
                  $gpa = '0.00';

                  $totalFailed++;
                } else {
                  if ($percentage >= 80) {
                    $grade = 'A+';
                    $gpa = '5.00';
                  } elseif ($percentage >= 70) {
                    $grade = 'A';
                    $gpa = '4.00';
                  } elseif ($percentage >= 60) {
                    $grade = 'A-';
                    $gpa = '3.50';
                  } elseif ($percentage >= 50) {
                    $grade = 'B';
                    $gpa = '3.00';
                  } elseif ($percentage >= 40) {
                    $grade = 'C';
                    $gpa = '2.00';
                  } elseif ($percentage >= 33) {
                    $grade = 'D';
                    $gpa = '1.00';
                  } else {
                    $grade = 'F';
                    $gpa = '0.00';
                  }
                }
              } else {
                if ($written < 23 || $mcq < 10) {
                  $grade = 'F';
                  $gpa = '0.00';

                  $totalFailed++;
                } else {
                  if ($percentage >= 80) {
                    $grade = 'A+';
                    $gpa = '5.00';
                  } elseif ($percentage >= 70) {
                    $grade = 'A';
                    $gpa = '4.00';
                  } elseif ($percentage >= 60) {
                    $grade = 'A-';
                    $gpa = '3.50';
                  } elseif ($percentage >= 50) {
                    $grade = 'B';
                    $gpa = '3.00';
                  } elseif ($percentage >= 40) {
                    $grade = 'C';
                    $gpa = '2.00';
                  } elseif ($percentage >= 33) {
                    $grade = 'D';
                    $gpa = '1.00';
                  } else {
                    $grade = 'F';
                    $gpa = '0.00';
                  }
                }
              }
            }



            ?>

            <td><?= esc($mark['total']) ?></td>
            <td><?= esc($grade) ?></td>
            <td>
              <?= esc($gpa) ?>
              <?php
              if (count($marksheet) - 1 == $i && in_array((int)$student['class'], [9, 10])) {
                $forthGPA =  max(0, $gpa - 2);
              } else {
                $totalGPA = $totalGPA + $gpa;
                $subjectCount++;
              }
              ?>
            </td>
            <!-- <td>
            <?= $subjectCount ?> = <?= $totalGPA + $forthGPA ?> 
            </td> -->
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>

    </tbody>
    <tfoot>
      <tr>
        <th colspan="7">Total Marks</th>

        <th class="text-end"><?= $totalMarks ?></th>
        <th colspan="2">
          <?= $subjectCount > 0 ? (($golden_gpa = ($totalGPA + $forthGPA) / $subjectCount) > 5 ? '5.00*' : number_format($golden_gpa, 2)) : '0.00' ?>
        </th>
      </tr>
    </tfoot>
  </table>
  <div class="row qr-signature">
    <div class="col-md-9">
      <table class="table table-bordered text-center">
        <tbody>
          <tr>
            <!-- Left Block -->
            <td>
              <table class="table table-bordered text-center mb-0">
                <tbody>
                  <tr>
                    <td><strong>Position</strong></td>
                    <td>---</td>
                  </tr>
                  <tr>
                    <td><strong>GPA (Without 4th)</strong></td>
                    <td>
                      <?= $subjectCount > 0 ? number_format($totalGPA / $subjectCount, 2) : '0.00' ?>
                    </td>
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
                </tbody>
              </table>
            </td>

            <!-- Middle Block -->
            <td>
              <table class="table table-bordered text-center mb-0">
                <thead>
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
                    <th>Need Imporovement</th>
                  </tr>
                </thead>
              </table>
            </td>

            <!-- Right Block -->
            <td style="vertical-align: middle;">
              <table class="table table-bordered text-center mb-0">
                <thead>
                  <tr>
                    <th colspan="2">Co-Curricular Activities</th>
                  </tr>
                </thead>
                <tbody>
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
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <?php
    $studentId = 207; // Example: dynamically from DB
    $url = 'https://mulss.edu.bd/student?q=' . $studentId;
    ?>
    <div class="col-md-3 qr-code text-center">
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode($url) ?>" class="qr-img" alt="Student QR">
      <p style="font-size: 12px;">Scan to Verify</p>
    </div>
  </div>
  <div class="row">

    <div class="col-md-6 signature text-left">
      <br><br>
      ____________________<br>
      Head Teacher
    </div>
    <div class="col-md-6 signature text-right">
      <br><br>
      ____________________<br>
      Class Teacher
    </div>
  </div>

  <div class="text-center mt-3 no-print">
    <button onclick="window.print()" class="btn btn-primary">
      <i class="fas fa-print"></i> Print Marksheet
    </button>
  </div>
</div>

<?= $this->endSection() ?>