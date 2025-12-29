<!DOCTYPE html>
<html>

<head>
    <title>Top Sheet - Class <?= esc($class) ?></title>

    <style>
    @page {
        size: A4;
        margin: 15mm;
    }

    body {
        font-family: "Times New Roman", serif;
        font-size: 13px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }

    th {
        background: #f2f2f2;
    }

    .text-left {
        text-align: left;
    }
    </style>
</head>

<body>

    <h3 style="text-align:center;">Top Sheet – Class <?= esc($class) ?> to Class <?= esc($class + 1) ?></h3>

    <table>
        <thead>
            <tr>
                <th>New Roll</th>
                <th>Name</th>
                <th>Past Roll</th>
                <th>Total</th>
                <th>Percentage</th>
                <th>GPA</th>
                <th>Grade</th>
                <th>Number of Fail</th>
            </tr>
        </thead>
        <tbody>
            <?php $merit = 1; ?>
            <?php foreach ($rankings as $row): ?>
            <tr>
                <td><?= $merit++ ?></td>
                <td><?= esc($row['new_roll']) ?></td>
                <td class="text-left"><?= esc($row['student_name']) ?></td>
                <td><?= esc($row['past_roll']) ?></td>
                <td><?= esc($row['total']) ?></td>
                <td><?= esc($row['percentage']) ?> %</td>
                <td><?= esc($row['gpa']) ?></td>
                <td><?= esc($row['grade_letter']) ?></td>
                <td><?= esc($row['fail']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
    window.print();
    </script>

</body>

</html>