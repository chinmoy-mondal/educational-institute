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

        <?php foreach ($marksheet as $sl => $row): ?>
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

            <?php if (isset($combinedTotals[$sl])): ?>
            <td rowspan="2"><?= $combinedTotals[$sl]['total'] ?></td>
            <td rowspan="2"><?= $combinedTotals[$sl]['percentage'] ?>%</td>
            <?php elseif (in_array($sl, [1, 3])): ?>
            <!-- skip, already rowspan for previous row -->
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