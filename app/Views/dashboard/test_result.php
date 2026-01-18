<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Academic Transcript</title>

    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .marksheet-wrapper {
        background: white;
        padding: 24px;
        border: 6px double goldenrod;
        margin: auto;
        max-width: 850px;
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

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
        vertical-align: middle;
    }

    .student-info td {
        border: none;
        text-align: left;
    }

    .grade-table th,
    .grade-table td {
        font-size: 12px;
        padding: 3px;
    }

    .signature {
        margin-top: 30px;
        font-weight: bold;
    }

    .qr-img {
        width: 120px;
        height: 120px;
    }

    @page {
        size: A4;
        margin: 20mm;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
    </style>
</head>

<body>

    <div class="marksheet-wrapper">

        <!-- School Info -->
        <div class="school-header">
            <h2>Mulgram Secondary School</h2>
            <h5>Keshabpur, Jashore</h5>
        </div>

        <!-- Header Row -->
        <table style="border:none;">
            <tr>
                <td style="border:none; width:25%;">
                    <?php if (!empty($student['student_pic'])): ?>
                    <img src="<?= base_url($student['student_pic']) ?>" alt="Student Photo" width="150">
                    <?php else: ?>
                    <img src="<?= base_url('public/assets/img/default.png') ?>" alt="No Photo" width="150">
                    <?php endif; ?>
                </td>

                <td style="border:none; text-align:center; width:50%;">
                    <img src="<?= base_url('public/assets/img/logo.jpg'); ?>" alt="School Logo" width="60"><br>
                    <h4 style="border-bottom:4px solid green; display:inline-block;"> Academic Transcript </h4>
                </td>

                <td style="border:none; width:25%;">
                    <table class="grade-table">
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
                </td>
            </tr>
        </table>

        <!-- Student Info -->
        <table class="student-info">
            <tr>
                <td><strong>Student Name:</strong> :<?= esc($student['student_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Father's Name:</strong> :<?= esc($student['father_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Mother's Name:</strong> : <?= esc($student['mother_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Student ID:</strong> : <?= esc($student['id']) ?></td>
                <td><strong>Exam:</strong> : <?= $exam ?>
                </td>
            </tr>
            <tr>
                <td><strong>Class:</strong> : <?= esc($studentBackup['class']) ?></td>
                <td><strong>Year:</strong> : <?= $year ?> </td>
            </tr>
            <tr>
                <td><strong>Roll:</strong> : <?= esc($studentBackup['roll']) ?>
                </td>
                <td><strong>Group:</strong> : <?= esc($studentBackup['section']) ?></td>
            </tr>
        </table>

        <!-- Marks Table -->
        <?php
        $total_fail = 0;
        $gpa = '';
        $full_mark = 0;
        $total_marks_sum = 0;
        $total_subject = 0;
        $total_grade_point = 0;
        $total_grade_point_without_forth = 0;
        $total_percentage_sum = 0;
        $total_rows = count($marksheet);
        ?>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Subject</th>
                    <th rowspan="2">Full Mark</th>
                    <th colspan="4">Half-Yearly</th>
                    <th colspan="4">Annual</th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">%</th>
                    <th rowspan="2">Grade</th>
                    <th rowspan="2">GP</th>
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
                <?php foreach ($marksheet as $id => $row): ?>
                <tr>
                    <td><?= esc($row['subject'] ?? '-') ?>
                        <?php
                            if ($total_rows == $id + 1) {
                                if (in_array($studentBackup['class'], [6, 7, 8])) {
                                } else {
                                    echo "<b>(4th)</b>";
                                }
                            }
                            ?>
                    </td>
                    <td><?= $row['full_mark'] ?? 0 ?></td>

                    <!-- Half-Yearly -->
                    <?php
                        $half = $row['half'] ?? [];
                        $half_written = $half['written'] ?? 0;
                        $half_mcq = $half['mcq'] ?? 0;
                        $half_prac = $half['practical'] ?? 0;
                        $half_total = $half_written + $half_mcq + $half_prac;
                        ?>
                    <td><?= $half_written ?></td>
                    <td><?= $half_mcq ?></td>
                    <td><?= $half_prac ?></td>
                    <td><?= $half_total ?></td>

                    <!-- Annual -->
                    <?php
                        $annual = $row['annual'] ?? [];
                        $annual_written = $annual['written'] ?? 0;
                        $annual_mcq = $annual['mcq'] ?? 0;
                        $annual_prac = $annual['practical'] ?? 0;
                        $annual_total = $annual_written + $annual_mcq + $annual_prac;
                        ?>
                    <td><?= $annual_written ?></td>
                    <td><?= $annual_mcq ?></td>
                    <td><?= $annual_prac ?></td>
                    <td><?= $annual_total ?></td>

                    <!-- Final -->
                    <?php
                        $final = $row['final'] ?? [];
                        $final_total = $final['total'] ?? 0;
                        $final_percentage = $final['percentage'] ?? 0;
                        $final_grade = $final['grade'] ?? '-';
                        $final_gp = $final['grade_point'] ?? '-';

                        $full_mark += $row['full_mark'];
                        // accumulate for summary
                        if ($id == 1 || $id == 3) {
                        } else {
                            $total_marks_sum += $final_total;
                            if ($total_rows == $id + 1) {
                                if (in_array($studentBackup['class'], [6, 7, 8])) {

                                    $total_fail += ($final_gp) ? 0 : 1;
                                    $total_subject++;
                                    $total_grade_point += $final_gp;
                                    $total_grade_point_without_forth += $final_gp;
                                } else {
                                    $total_grade_point += max(0, $final_gp - 2);
                                }
                            } else {
                                $total_fail += ($final_gp) ? 0 : 1;
                                $total_grade_point += $final_gp;
                                $total_grade_point_without_forth += $final_gp;
                                $total_subject++;
                            }
                        }

                        ?>

                    <?php if ($id == 0 || $id == 2): ?>
                    <td rowspan="2"><?= $final_total ?></td>
                    <td rowspan="2"><?= $final_percentage ?>%</td>
                    <td rowspan="2"><?= $final_grade ?></td>
                    <td rowspan="2"><?= $final_gp ?></td>
                    <?php elseif ($id > 3): ?>
                    <td><?= $final_total ?></td>
                    <td><?= $final_percentage ?>%</td>
                    <td><?= $final_grade ?></td>
                    <td><?= $final_gp ?></td>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </tbody>
            <tfoot>
                <!-- Summary Row -->
                <tr style="font-weight:bold; background:#f0f0f0;">
                    <td colspan="10">Total / Average</td>
                    <td>
                        <?= $total_marks_sum ?></td>
                    <?php function gpToGrade(float $gp): string
                    {
                        if ($gp >= 5.00) return 'A+';
                        if ($gp >= 4.00) return 'A';
                        if ($gp >= 3.50) return 'A-';
                        if ($gp >= 3.00) return 'B';
                        if ($gp >= 2.00) return 'C';
                        if ($gp >= 1.00) return 'D';

                        return 'F';
                    } ?>
                    <td>
                        -
                    </td>
                    <td>
                        <?php
                        if ($total_fail) {
                            $grade_letter = 'F';
                            echo $grade_letter;
                        } else {
                            $grade_letter = gpToGrade(round($total_grade_point / $total_subject, 2));
                            echo $grade_letter;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // $percentage = ($total_marks_sum / $full_mark) * 100;

                        $percentage =  $full_mark;
                        if ($total_fail) {
                            $gpa = '0.00';
                            echo '0.00';
                        } else {
                            $gpa = number_format(min(5, $total_grade_point / $total_subject), 2);
                            echo $gpa;
                        }

                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Bottom Section -->
        <table>
            <tr>
                <td>
                    <strong>Failed Subjects:</strong> <?= $total_fail ?><br>
                    <strong>GPA (Without 4th):</strong>
                    <?php
                    if ($total_fail) {
                        $gpa_without_forth = '0.00,';
                        echo $gpa_without_forth;
                    } else {
                        $gpa_without_forth = number_format(min(5, $total_grade_point_without_forth / $total_subject), 2);
                        echo $gpa_without_forth;
                    }
                    ?>

                </td>
                <td style="text-align:center;">
                    <?php
                    $url = 'https://mulss.edu.bd/student-id?q=' . $student['id'];
                    ?>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode($url) ?>"
                        class="qr-img" alt="Student QR">
                    <p style="font-size: 12px;">Scan to Verify</p>
                </td>
            </tr>
        </table>

        <!-- Signatures -->
        <table style="margin-top:40px; border:none;">
            <tr>
                <td style="border:none; text-align:left;">
                    <img src="<?= base_url('public/assets/img/sign.png') ?>" alt="Signature" class="d-block"
                        style="height: 41px;"><br>
                    ____________________<br>
                    Head Teacher
                </td>
                <td style="border:none; text-align:right;">
                    ___________________<br>Class Teacher
                </td>
            </tr>
        </table>

        <div class="no-print" style="text-align:center; margin-top:20px;">
            <button onclick="window.print()">Print Marksheet</button>
        </div>

    </div>

</body>

</html>