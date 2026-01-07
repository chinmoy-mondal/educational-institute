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
        background: #fff;
        padding: 24px;
        border: 6px double goldenrod;
        max-width: 850px;
        margin: auto;
        font-size: 14px;
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
    }

    .student-info td {
        border: none;
        text-align: left;
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

        <h2 style="text-align:center;">Academic Transcript</h2>

        <!-- ================= STUDENT INFO ================= -->
        <table class="student-info">
            <tr>
                <td><b>Name:</b> <?= esc($student['student_name']) ?></td>
            </tr>
            <tr>
                <td><b>ID:</b> <?= esc($student['id']) ?></td>
            </tr>
            <tr>
                <td><b>Class:</b> <?= esc($student['class']) ?></td>
            </tr>
            <tr>
                <td><b>Roll:</b> <?= esc($student['roll']) ?></td>
            </tr>
        </table>

        <?php
        $total_marks_sum = 0;
        $total_subject = 0;
        $total_fail = 0;
        $total_grade_point = 0;
        $total_grade_point_without_forth = 0;

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

        <!-- ================= MARKS TABLE ================= -->
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Subject</th>
                    <th rowspan="2">Full</th>
                    <th colspan="4">Marks</th>
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
                </tr>
            </thead>

            <tbody>
                <?php foreach ($marksheet as $id => $row):

                    $exam = $row['exam'];
                    $final_total = $row['final']['total'];
                    $final_percentage = $row['final']['percentage'];
                    $final_grade = $row['final']['grade'];
                    $final_gp = $row['final']['grade_point'];
                ?>

                <tr>
                    <td><?= esc($row['subject']) ?></td>
                    <td><?= $row['full_mark'] ?></td>

                    <td><?= $exam['written'] ?></td>
                    <td><?= $exam['mcq'] ?></td>
                    <td><?= $exam['practical'] ?></td>
                    <td><?= $exam['total'] ?></td>

                    <?php
                        /* ================= TOTAL CALCULATION =================
   Skip Bangla 2nd (1) & English 2nd (3)
*/
                        if ($id == 1 || $id == 3) {
                            // skipped intentionally
                        } else {
                            $total_marks_sum += $final_total;
                            $total_subject++;
                            $total_grade_point += $final_gp;
                            $total_grade_point_without_forth += $final_gp;
                            $total_fail += ($final_gp > 0) ? 0 : 1;
                        }
                        ?>

                    <?php if ($id == 0 || $id == 2): ?>
                    <!-- Bangla 1st & English 1st -->
                    <td rowspan="2"><?= $final_total ?></td>
                    <td rowspan="2"><?= $final_percentage ?>%</td>
                    <td rowspan="2"><?= $final_grade ?></td>
                    <td rowspan="2"><?= $final_gp ?></td>

                    <?php elseif ($id == 1 || $id == 3): ?>
                    <!-- Bangla 2nd & English 2nd: no output -->

                    <?php else: ?>
                    <!-- Normal subjects -->
                    <td><?= $final_total ?></td>
                    <td><?= $final_percentage ?>%</td>
                    <td><?= $final_grade ?></td>
                    <td><?= $final_gp ?></td>
                    <td><?= $total_marks_sum ?></td>
                    <?php endif; ?>

                </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr style="font-weight:bold;background:#f0f0f0;">
                    <td colspan="6">Total / GPA</td>
                    <td><?= $total_marks_sum ?></td>
                    <td>-</td>
                    <td><?= $total_fail ? 'F' : gpToGrade($total_grade_point / $total_subject) ?></td>
                    <td><?= $total_fail ? '0.00' : number_format(min(5, $total_grade_point / $total_subject), 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="no-print" style="margin-top:20px;text-align:center;">
            <button onclick="window.print()">Print</button>
        </div>

    </div>
</body>

</html>