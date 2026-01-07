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

        <!-- School Header -->
        <div class="school-header">
            <h2>Mulgram Secondary School</h2>
            <h5>Keshabpur, Jashore</h5>
        </div>

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
                <td><strong>Exam:</strong> <?= esc($exam) ?></td>
            </tr>
            <tr>
                <td><strong>Class:</strong> <?= esc($student['class']) ?></td>
                <td><strong>Year:</strong> <?= esc($year) ?></td>
            </tr>
            <tr>
                <td><strong>Roll:</strong> <?= esc($student['roll']) ?></td>
                <td><strong>Group:</strong> <?= esc($student['section']) ?></td>
            </tr>
        </table>

        <!-- Marks Table -->
        <?php
        $total_marks = 0;
        $total_subject = 0;
        $total_fail = 0;
        $total_grade_point = 0;
        $merged_marks = [];
        function gpToGrade($gp)
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
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Full Mark</th>
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
                <?php foreach ($marksheet as $id => $row):
                    $subject = $row['subject'];
                    $final = $row['final'];
                    $final_total = $final['total'];
                    $final_percentage = $final['percentage'];
                    $final_grade = $final['grade'];
                    $final_gp = $final['grade_point'];

                    // Skip 2nd papers for table (id 1 or 3)
                    if ($id == 1 || $id == 3) {
                        $merged_marks[$subject] = $final_total;
                        continue;
                    }

                    // Merge 2nd paper if needed (id 0 or 2)
                    if ($id == 0 || $id == 2) {
                        $second_id = $id + 1;
                        $final_total += $merged_marks[$marksheet[$second_id]['subject']] ?? 0;
                        $final_percentage = round(($final_total / $row['full_mark']) * 100, 2);
                    }

                    // Accumulate totals
                    $total_marks += $final_total;
                    $total_grade_point += $final_gp;
                    $total_subject++;
                    if ($final_gp < 1) $total_fail++;
                ?>
                <tr>
                    <td><?= esc($subject) ?> <?= ($id == 0 || $id == 2) ? '<b>(Merged)</b>' : '' ?></td>
                    <td><?= $row['full_mark'] ?></td>
                    <td><?= $final['written'] ?></td>
                    <td><?= $final['mcq'] ?></td>
                    <td><?= $final['practical'] ?></td>
                    <td><?= $final_total ?></td>
                    <td><?= $final_percentage ?>%</td>
                    <td><?= $final_grade ?></td>
                    <td><?= $final_gp ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold; background:#f0f0f0;">
                    <td colspan="5">Total / GPA</td>
                    <td><?= $total_marks ?></td>
                    <td>-</td>
                    <td><?= $total_fail ? 'F' : gpToGrade($total_grade_point / $total_subject) ?></td>
                    <td><?= $total_fail ? '0.00' : number_format(min(5, $total_grade_point / $total_subject), 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <table style="margin-top:30px; border:none;">
            <tr>
                <td><strong>Failed Subjects:</strong> <?= $total_fail ?></td>
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
                <td style="border:none; text-align:left;">____________________<br>Head Teacher</td>
                <td style="border:none; text-align:right;">____________________<br>Class Teacher</td>
            </tr>
        </table>

        <div class="no-print" style="text-align:center; margin-top:20px;">
            <button onclick="window.print()">Print Marksheet</button>
        </div>

    </div>
</body>

</html>