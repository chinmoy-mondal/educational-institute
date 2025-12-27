<!DOCTYPE html>
<html>

<head>
    <title>Student Marksheet</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 14px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }

    th {
        background-color: #f0f0f0;
    }

    h4 {
        text-align: center;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>

    <?php
    // ---------------- GRADE FUNCTION ----------------
    function getGrade($percent)
    {
        if ($percent >= 80) return ['A+', 5.00];
        if ($percent >= 70) return ['A', 4.00];
        if ($percent >= 60) return ['A-', 3.50];
        if ($percent >= 50) return ['B', 3.00];
        if ($percent >= 40) return ['C', 2.00];
        if ($percent >= 33) return ['D', 1.00];
        return ['F', 0.00];
    }
    ?>

    <h4>Academic Marksheet</h4>

    <table>
        <tr>
            <th rowspan="2">Subject</th>
            <th rowspan="2">Full Mark</th>
            <th colspan="4">Half-Yearly</th>
            <th colspan="4">Annual Exam</th>
            <th colspan="4">Average</th>
            <th rowspan="2">Total Obtain Mark</th>
            <th rowspan="2">Percentage</th>
            <th rowspan="2">Grade</th>
            <th rowspan="2">Grade Point</th>
        </tr>

        <tr>
            <th>Wri</th>
            <th>MCQ</th>
            <th>Prac</th>
            <th>Total</th>

            <th>Wri</th>
            <th>MCQ</th>
            <th>Prac</th>
            <th>Total</th>

            <th>Wri</th>
            <th>MCQ</th>
            <th>Prac</th>
            <th>Total</th>
        </tr>

        <?php foreach ($marksheet as $row):

            $subject   = $row['subject'];
            $fullMark  = $row['full_mark'] ?? 0;

            $h = $row['half'] ?? [];
            $a = $row['annual'] ?? [];
            $avg = $row['average'] ?? [];

            // Half-Yearly
            $hWri  = $h['written'] ?? 0;
            $hMCQ  = $h['mcq'] ?? 0;
            $hPrac = $h['practical'] ?? 0;
            $hTotal = $hWri + $hMCQ + $hPrac;

            // Annual
            $aWri  = $a['written'] ?? 0;
            $aMCQ  = $a['mcq'] ?? 0;
            $aPrac = $a['practical'] ?? 0;
            $aTotal = $aWri + $aMCQ + $aPrac;

            // Average (already calculated in controller)
            $avgWri  = $avg['written'] ?? 0;
            $avgMCQ  = $avg['mcq'] ?? 0;
            $avgPrac = $avg['practical'] ?? 0;
            $avgTotal = $avg['total'] ?? 0;

            // Percentage & Grade
            $percentage = ($fullMark > 0) ? round(($avgTotal / $fullMark) * 100, 2) : 0;
            [$grade, $gradePoint] = getGrade($percentage);
        ?>

        <tr>
            <td><?= esc($subject) ?></td>
            <td><?= $fullMark ?></td>

            <!-- Half-Yearly -->
            <td><?= $hWri ?></td>
            <td><?= $hMCQ ?></td>
            <td><?= $hPrac ?></td>
            <td><?= $hTotal ?></td>

            <!-- Annual -->
            <td><?= $aWri ?></td>
            <td><?= $aMCQ ?></td>
            <td><?= $aPrac ?></td>
            <td><?= $aTotal ?></td>

            <!-- Average -->
            <td><?= $avgWri ?></td>
            <td><?= $avgMCQ ?></td>
            <td><?= $avgPrac ?></td>
            <td><?= $avgTotal ?></td>

            <!-- Final -->
            <td><?= $avgTotal ?></td>
            <td><?= $percentage ?>%</td>
            <td><?= $grade ?></td>
            <td><?= number_format($gradePoint, 2) ?></td>
        </tr>

        <?php endforeach; ?>
    </table>

</body>

</html>