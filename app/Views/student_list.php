<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; }
        img { max-width: 100px; }
    </style>
</head>
<body>
    <h2>Registered Students</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Roll</th>
                <th>Class</th>
                <th>Section</th>
                <th>ESIF</th>
                <th>DOB</th>
                <th>Phone</th>
                <th>Birth Reg.</th>
                <th>Father ID</th>
                <th>Mother ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= esc($student['student_name']) ?></td>
                    <td><?= esc($student['roll']) ?></td>
                    <td><?= esc($student['class']) ?></td>
                    <td><?= esc($student['section']) ?></td>
                    <td><?= esc($student['esif']) ?></td>
                    <td><?= esc($student['dob']) ?></td>
                    <td><?= esc($student['phone']) ?></td>
                    <td><img src="/<?= esc($student['birth_registration_pic']) ?>" alt="Birth Reg"></td>
                    <td><img src="/<?= esc($student['father_id_pic']) ?>" alt="Father ID"></td>
                    <td><img src="/<?= esc($student['mother_id_pic']) ?>" alt="Mother ID"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
