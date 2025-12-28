<!DOCTYPE html>
<html>

<head>
    <title>Marksheet</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }

    th {
        background: #eee;
    }
    </style>
</head>

<body>

    <h4 style="text-align:center">Academic Marksheet</h4>

    <?php
    $total_marks_sum = 0;
    $total_subject = 0;
    $total_grade_point = 0;
    $total_percentage_sum = 0;
    $total_rows = count($marksheet);
    ?>

    <table>
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

        <?php foreach ($marksheet as $id => $row): ?>
        <tr>
            <td><?= esc($row['subject'] ?? '-') ?></td>
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

                // accumulate for summary
                if ($id == 1 || $id == 3) {
                } else {
                    $total_marks_sum += $final_total;
                    if ($total_rows == $id + 1) {
                        if (in_array($student['class'], [6, 8])) {
                            $total_subject++;
                            $total_grade_point += $final_gp;
                        } else {
                            $total_grade_point += max(0, $final_gp - 2);
                        }
                    } else {
                        $total_grade_point += $final_gp;
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
            <td><?= $total_grade_point ?></td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>

        <!-- Summary Row -->
        <tr style="font-weight:bold; background:#f0f0f0;">
            <td colspan="10">Total / Average</td>
            <td><?= $total_marks_sum ?></td>
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
                <?php echo gpToGrade($total_grade_point); ?>
            </td>
            <td><?= round($total_grade_point / $total_subject, 2) ?></td>
            <td>
                <?= $total_grade_point ?>
            </td>
        </tr>
    </table>
    <pre>
<?php print_r($student); ?>
</pre>
    <?php echo $student['class']; ?>
</body>

</html>