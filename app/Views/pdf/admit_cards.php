<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admit Cards</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-after: always;
        }
        .admit-card {
            width: 100%;
            border: 1px solid #000;
            padding: 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        .school-header {
            text-align: center;
            margin-bottom: 10px;
        }
        .school-header h2 {
            margin: 0;
        }
        .student-info {
            margin-bottom: 10px;
        }
        .exam-table {
            width: 100%;
            border-collapse: collapse;
        }
        .exam-table th, .exam-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php for ($i = 0; $i < count($students); $i += 2): ?>
    <div style="margin-bottom: 50px;">
        <?php for ($j = 0; $j < 2; $j++): ?>
            <?php if (isset($students[$i + $j])): 
                $student = $students[$i + $j]; ?>
                <div class="admit-card">
                    <div class="school-header">
                        <h2>Mulgram Secondary School</h2>
                        <p><strong>Exam Admit Card</strong></p>
                    </div>
                    <div class="student-info">
                        <strong>Name:</strong> <?= esc($student['name']) ?><br>
                        <strong>Class:</strong> <?= esc($student['class']) ?><br>
                        <strong>Roll:</strong> <?= esc($student['roll']) ?>
                    </div>
                    <table class="exam-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($student['exams'] as $exam): ?>
                                <tr>
                                    <td><?= esc($exam['subject']) ?></td>
                                    <td><?= esc($exam['date']) ?></td>
                                    <td><?= esc($exam['time']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
    <?php if ($i + 2 < count($students)): ?>
        <div class="page-break"></div>
    <?php endif; ?>
<?php endfor; ?>

</body>
</html>
