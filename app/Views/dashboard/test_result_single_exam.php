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

        <!-- School Header -->
        <div class="school-header">
            <h2>Mulgram Secondary School</h2>
            <h5>Keshabpur, Jashore</h5>
        </div>

        <!-- Top Row -->
        <table style="border:none;">
            <tr>
                <td style="border:none; width:25%;">
                    <img src="<?= base_url($student['student_pic'] ?? 'public/assets/img/default.png') ?>" width="150">
                </td>

                <td style="border:none; text-align:center; width:50%;">
                    <img src="<?= base_url('public/assets/img/logo.jpg') ?>" width="60"><br>
                    <h4 style="border-bottom:4px solid green; display:inline-block;">
                        Academic Transcript
                    </h4>
                </td>

                <td style="border:none; width:25%;">
                    <table class="grade-table">
                        <tr>
                            <th>Range</th>
                            <th>Grade</th>
                            <th>GPA</th>
                        </tr>
                        <tr>
                            <td>80-100</td>
                            <td>A+</td>
                            <td>5.0</td>
                        </tr>
                        <tr>
                            <td>70-79</td>
                            <td>A</td>
                            <td>4.0</td>
                        </tr>
                        <tr>
                            <td>60-69</td>
                            <td>A-</td>
                            <td>3.5</td>
                        </tr>
                        <tr>
                            <td>50-59</td>
                            <td>B</td>
                            <td>3.0</td>
                        </tr>
                        <tr>
                            <td>40-49</td>
                            <td>C</td>
                            <td>2.0</td>
                        </tr>
                        <tr>
                            <td>33-39</td>
                            <td>D</td>
                            <td>1.0</td>
                        </tr>
                        <tr>
                            <td>0-32</td>
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
                <td><strong>Name:</strong> <?= esc($student['student_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Father:</strong> <?= esc($student['father_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Mother:</strong> <?= esc($student['mother_name']) ?></td>
            </tr>
            <tr>
                <td><strong>ID:</strong> <?= $student['id'] ?></td>
                <td><strong>Exam:</strong> <?= $exam ?></td>
            </tr>
            <tr>
                <td><strong>Class:</strong> <?= $student['class'] ?></td>
                <td><strong>Year:</strong> <?= $year ?></td>
            </tr>
            <tr>
                <td><strong>Roll:</strong> <?= $student['roll'] ?></td>
                <td><strong>Group:</strong> <?= $student['section'] ?></td>
            </tr>
        </table>

        <!-- ================= SINGLE EXAM MARKS ================= -->

        <?php
        $total_fail = 0;
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
                    <th>FM</th>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>Total</th>
                    <th>%</th>
                    <th>Grade</th>
                    <th>GP</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($marksheet as $i => $row): ?>

                <?php
                    $exam = $row['exam'];
                    $final = $row['final'];

                    $isFourth = ($total_rows == $i + 1 && !in_array($student['class'], [6, 7, 8]));

                    if (!$isFourth) {
                        $total_marks_sum += $exam['total'];
                        $total_subject++;
                        $total_grade_point += $final['grade_point'];
                        $total_grade_point_without_forth += $final['grade_point'];
                        $total_fail += ($final['grade_point'] > 0) ? 0 : 1;
                    } else {
                        $total_grade_point += max(0, $final['grade_point'] - 2);
                    }
                    ?>

                <tr>
                    <td>
                        <?= esc($row['subject']) ?>
                        <?= $isFourth ? '<b>(4th)</b>' : '' ?>
                    </td>
                    <td><?= $row['full_mark'] ?></td>
                    <td><?= $exam['written'] ?></td>
                    <td><?= $exam['mcq'] ?></td>
                    <td><?= $exam['practical'] ?></td>
                    <td><?= $exam['total'] ?></td>
                    <td><?= $final['percentage'] ?>%</td>
                    <td><?= $final['grade'] ?></td>
                    <td><?= $final['grade_point'] ?></td>
                </tr>

                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr style="font-weight:bold;background:#f0f0f0;">
                    <td colspan="5">Total / GPA</td>
                    <td><?= $total_marks_sum ?></td>
                    <td>-</td>
                    <td>
                        <?= $total_fail ? 'F' : gpToGrade($total_grade_point / $total_subject) ?>
                    </td>
                    <td>
                        <?= $total_fail ? '0.00' : number_format(min(5, $total_grade_point / $total_subject), 2) ?>
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
                    <?= $total_fail ? '0.00' : number_format(min(5, $total_grade_point_without_forth / $total_subject), 2) ?>
                </td>
                <td style="text-align:center;">
                    <?php $url = 'https://mulss.edu.bd/student-id?q=' . $student['id']; ?>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode($url) ?>"
                        class="qr-img">
                </td>
            </tr>
        </table>

        <!-- Signatures -->
        <table style="margin-top:40px; border:none;">
            <tr>
                <td style="border:none;text-align:left;">
                    ____________________<br>Head Teacher
                </td>
                <td style="border:none;text-align:right;">
                    ____________________<br>Class Teacher
                </td>
            </tr>
        </table>

        <div class="no-print" style="text-align:center;margin-top:20px;">
            <button onclick="window.print()">Print</button>
        </div>

    </div>

</body>

</html>

<?php
function gpToGrade(float $gp): string
{
    if ($gp >= 5) return 'A+';
    if ($gp >= 4) return 'A';
    if ($gp >= 3.5) return 'A-';
    if ($gp >= 3) return 'B';
    if ($gp >= 2) return 'C';
    if ($gp >= 1) return 'D';
    return 'F';
}
?>