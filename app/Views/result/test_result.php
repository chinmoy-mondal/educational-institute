<!DOCTYPE html>
<html>

<head>
    <title>Marksheet</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center
    }

    th {
        background: #eee
    }
    </style>
</head>

<body>

    <h4 style="text-align:center">Academic Marksheet</h4>

    <table>
        <tr>
            <th rowspan="2">Subject</th>
            <th rowspan="2">Full Mark</th>
            <th colspan="4">Half-Yearly</th>
            <th colspan="4">Annual</th>
            <th colspan="4">Average</th>
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
            <th>W</th>
            <th>M</th>
            <th>P</th>
            <th>T</th>
        </tr>

        <?php
        $marksheetNumeric = array_values($marksheet); // reindex array
        $combinedIndexes = [
            [0, 1], // Bangla 1st + 2nd
            [2, 3], // English 1st + 2nd
            // add more pairs if needed
        ];
        ?>

        <?php
        $marksheetNumeric = array_values($marksheet); // reindex array
        $combineTotalFor = [0, 1]; // combine for first 2 serials (Bangla 1st + 2nd)
        $combinedTotal = $marksheetNumeric[0]['final']['total'] + $marksheetNumeric[1]['final']['total'];
        ?>

        <?php foreach ($marksheetNumeric as $sl => $row): ?>
        <tr>
            <td><?= esc($row['subject']) ?></td>
            <td><?= $row['full_mark'] ?></td>

            <td><?= $row['half']['written'] ?? 0 ?></td>
            <td><?= $row['half']['mcq'] ?? 0 ?></td>
            <td><?= $row['half']['practical'] ?? 0 ?></td>
            <td><?= ($row['half']['written'] ?? 0) + ($row['half']['mcq'] ?? 0) + ($row['half']['practical'] ?? 0) ?>
            </td>

            <td><?= $row['annual']['written'] ?? 0 ?></td>
            <td><?= $row['annual']['mcq'] ?? 0 ?></td>
            <td><?= $row['annual']['practical'] ?? 0 ?></td>
            <td><?= ($row['annual']['written'] ?? 0) + ($row['annual']['mcq'] ?? 0) + ($row['annual']['practical'] ?? 0) ?>
            </td>

            <td><?= $row['average']['written'] ?></td>
            <td><?= $row['average']['mcq'] ?></td>
            <td><?= $row['average']['practical'] ?></td>
            <td><?= $row['average']['total'] ?></td>

            <?php if ($sl === 0): ?>
            <td rowspan="2"><?= $combinedTotal ?></td>
            <td rowspan="2">
                <?= round(($combinedTotal / ($marksheetNumeric[0]['full_mark'] + $marksheetNumeric[1]['full_mark'])) * 100, 2) ?>%
            </td>
            <?php elseif ($sl === 1): ?>
            <!-- skip, because already rowspan=2 -->
            <?php else: ?>
            <td><?= $row['final']['total'] ?></td>
            <td><?= $row['final']['percentage'] ?>%</td>
            <?php endif; ?>

            <td></td>
            <td></td>
        </tr>
        <?php endforeach; ?>

    </table>
</body>

</html>