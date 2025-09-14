<!DOCTYPE html>
<html>
<head>
    <title>Attendance List</title>
    <style>
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .date-row { background: #d9edf7; font-weight: bold; text-align: left; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Attendance List</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Student ID</th>
            <th>Remark</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($attendances)): ?>
            <?php foreach($attendances as $date => $records): ?>
                <!-- Date Header Row -->
                <tr class="date-row">
                    <td colspan="4">Date: <?= $date ?></td>
                </tr>
                <?php foreach($records as $att): ?>
                    <tr>
                        <td><?= $att['id'] ?></td>
                        <td><?= $att['student_id'] ?></td>
                        <td><?= $att['remark'] ?></td>
                        <td><?= $att['time'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No attendance records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>