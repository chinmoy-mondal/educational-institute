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
            <th>Subject</th>
            <th>Full Mark</th>
            <th>Half W</th>
            <th>Half M</th>
            <th>Half P</th>
            <th>Half T</th>
            <th>Annual W</th>
            <th>Annual M</th>
            <th>Annual P</th>
            <th>Annual T</th>
            <th>Average W</th>
            <th>Average M</th>
            <th>Average P</th>
            <th>Average T</th>
            <th>Total</th>
            <th>%</th>
            <th>Grade</th>
            <th>GP</th>
        </tr>
        <?php foreach ($marksheet as $row): ?>
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

            <?php if (isset($row['final_combined'])): ?>
            <td rowspan="<?= $row['final_combined']['rowspan'] ?>"><?= $row['final_combined']['total'] ?></td>
            <td rowspan="<?= $row['final_combined']['rowspan'] ?>"><?= $row['final_combined']['percentage'] ?>%</td>
            <td rowspan="<?= $row['final_combined']['rowspan'] ?>"><?= $row['final_combined']['grade'] ?></td>
            <td rowspan="<?= $row['final_combined']['rowspan'] ?>"><?= number_format($row['final_combined']['gp'], 2) ?>
            </td>
            <?php else: ?>
            <td><?= $row['final']['total'] ?></td>
            <td><?= $row['final']['percentage'] ?>%</td>
            <td><?= $row['final']['grade'] ?></td>
            <td><?= number_format($row['final']['gp'], 2) ?></td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>