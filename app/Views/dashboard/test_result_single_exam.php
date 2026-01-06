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
                <td><strong>Student Name:</strong> <?= esc($student['student_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Father's Name:</strong> <?= esc($student['father_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Mother's Name:</strong> <?= esc($student['mother_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Student ID:</strong> <?= esc($student['id']) ?></td>
                <td><strong>Exam:</strong> <?= $exam ?></td>
            </tr>
            <tr>
                <td><strong>Class:</strong> <?= esc($student['class']) ?></td>
                <td><strong>Year:</strong> <?= $year ?> </td>
            </tr>
            <tr>
                <td><strong>Roll:</strong> <?= esc($student['roll']) ?></td>
                <td><strong>Group:</strong> <?= esc($student['section']) ?></td>
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
        $total_rows = count($marksheet);
        ?>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Full Mark</th>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>T</th>
                    <th>%</th>
                    <th>Grade</th>
                    <th>GP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($marksheet as $id => $row): ?>
                <tr>
                    <td><?= esc($row['subject'] ?? '-') ?></td>
                    <td><?= $row['full_mark'] ?? 0 ?></td>

                    <?php
                        $final = $row['final'] ?? [];
                        $w = $final['total_written'] ?? 0;
                        $m = $final['total_mcq'] ?? 0;
                        $p = $final['total_practical'] ?? 0;
                        $t = $final['total'] ?? 0;
                        $percentage = $final['percentage'] ?? 0;
                        $grade = $final['grade'] ?? '-';
                        $gp = $final['grade_point'] ?? '-';

                        $full_mark += $row['full_mark'];
                        $total_marks_sum += $t;
                        $total_subject++;
                        $total_grade_point += $gp ?? 0;
                        $total_fail += ($gp == 0) ? 1 : 0;
                        ?>

                    <td><?= $w ?></td>
                    <td><?= $m ?></td>
                    <td><?= $p ?></td>
                    <td><?= $t ?></td>
                    <td><?= $percentage ?>%</td>
                    <td><?= $grade ?></td>
                    <td><?= $gp ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold; background:#f0f0f0;">
                    <td colspan="5">Total / Average</td>
                    <td><?= $total_marks_sum ?></td>
                    <td>
                        <?= round(($total_marks_sum / $full_mark) * 100, 2) ?>%
                    </td>
                    <td>
                        <?php
                        if ($total_fail) {
                            echo 'F';
                        } else {
                            echo gpToGrade(round($total_grade_point / $total_subject, 2));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $total_fail ? '0.00' : number_format(min(5, $total_grade_point / $total_subject), 2);
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
                        echo '0.00';
                    } else {
                        echo number_format(min(5, $total_grade_point_without_forth / $total_subject), 2);
                    }
                    ?>
                </td>
                <td style="text-align:center;">
                    <?php $url = 'https://mulss.edu.bd/student-id?q=' . $student['id']; ?>
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