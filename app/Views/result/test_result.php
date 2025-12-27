<!DOCTYPE html>
<html>

<head>
    <title>Student Marks</title>
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
        background-color: #f0f0f0;
    }
    </style>
</head>

<body>

    <h4>Marks Sheet</h4>

    <table>
        <tr>
            <th rowspan="2">Subject</th>
            <th colspan="4">Half-Yearly</th>
            <th colspan="4">Annual Exam</th>
            <th colspan="4">Average</th>
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
            $h = $row['half'];
            $a = $row['annual'];
            $avg = $row['average'];
            $fullMark = $row['full_mark'] ?? 0;

            $hWri = $h['written'] ?? 0;
            $hMCQ = $h['mcq'] ?? 0;
            $hPrac = $h['practical'] ?? 0;

            $aWri = $a['written'] ?? 0;
            $aMCQ = $a['mcq'] ?? 0;
            $aPrac = $a['practical'] ?? 0;

            $hTotal = $fullMark;
            $aTotal = $fullMark;
        ?>
        <tr>
            <td><?= $row['subject'] ?></td>
            <td><?= $hWri ?></td>
            <td><?= $hMCQ ?></td>
            <td><?= $hPrac ?></td>
            <td><?= $hWri + $hMCQ + $hPrac ?></td>
            <td><?= $aWri ?></td>
            <td><?= $aMCQ ?></td>
            <td><?= $aPrac ?></td>
            <td><?= $aWri + $aMCQ + $aPrac ?></td>
            <td><?= $avg['written'] ?></td>
            <td><?= $avg['mcq'] ?></td>
            <td><?= $avg['practical'] ?></td>
            <td><?= $avg['total'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>