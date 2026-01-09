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
        color: #000;
    }

    .sheet-wrapper {
        border: 4px double #000;
        padding: 15px;
    }

    .school-header {
        text-align: center;
        margin-bottom: 15px;
    }

    .school-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .school-header p {
        margin: 2px 0;
        font-size: 14px;
    }

    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        text-decoration: underline;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
        vertical-align: middle;
    }

    th {
        background: #f0f0f0;
        font-weight: bold;
    }

    .text-left {
        text-align: left;
    }

    .signature-table {
        width: 100%;
        margin-top: 40px;
        border: none;
    }

    .signature-table td {
        border: none;
        text-align: center;
        padding-top: 40px;
        font-weight: bold;
    }

    .footer-note {
        margin-top: 10px;
        font-size: 12px;
        text-align: right;
        font-style: italic;
    }
    </style>
</head>

<body>

    <?php
    // ---------------- HELPER FUNCTION ----------------
    function renderTopSheet($rankings, $class, $sectionTitle = null)
    {
        $totalStudents = count($rankings);
        $totalPass = 0;
        $totalFail = 0;

        $gradeCount = [
            'A+' => 0,
            'A' => 0,
            'A-' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
        ];

        foreach ($rankings as $row) {
            if ((int)$row['fail'] > 0) {
                $totalFail++;
            } else {
                $totalPass++;
            }

            if (isset($gradeCount[$row['grade_letter']])) {
                $gradeCount[$row['grade_letter']]++;
            }
        }

        $passPercentage = $totalStudents ? round(($totalPass / $totalStudents) * 100, 2) : 0;
        $failPercentage = $totalStudents ? round(($totalFail / $totalStudents) * 100, 2) : 0;
    ?>

    <div class="sheet-wrapper">

        <!-- School Header -->
        <div class="school-header">
            <h2>Mulgram Secondary School</h2>
            <p>Keshabpur, Jashore</p>
            <p><strong>Academic Result Summary</strong></p>
        </div>

        <!-- Title -->
        <div class="title">
            Top Sheet – Promotion from Class <?= esc($class) ?> to Class <?= esc($class + 1) ?>
            <?php if ($sectionTitle): ?>
            <br><span style="font-size:14px;">(<?= esc($sectionTitle) ?> Section)</span>
            <?php endif; ?>
        </div>

        <!-- Main Table -->
        <table>
            <thead>
                <tr>
                    <th>New Roll</th>
                    <th>Student Name</th>
                    <th>Past Roll</th>
                    <th>Total</th>
                    <th>Percentage</th>
                    <th>GPA</th>
                    <th>Grade</th>
                    <th>Fail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rankings as $row): ?>
                <tr>
                    <td><?= esc($row['new_roll']) ?></td>
                    <td class="text-left"><?= esc($row['student_name']) ?></td>
                    <td><?= esc($row['past_roll']) ?></td>
                    <td><?= esc($row['total']) ?></td>
                    <td><?= esc($row['percentage']) ?>%</td>
                    <td><?= esc($row['gpa']) ?></td>
                    <td><?= esc($row['grade_letter']) ?></td>
                    <td><?= esc($row['fail']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Result Summary -->
        <table style="margin-top:20px;">
            <tr>
                <td><strong>Total Students</strong></td>
                <td><?= $totalStudents ?></td>
                <td><strong>Total Pass</strong></td>
                <td><?= $totalPass ?></td>
                <td><strong>Pass %</strong></td>
                <td><?= $passPercentage ?>%</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td><strong>Total Fail</strong></td>
                <td><?= $totalFail ?></td>
                <td><strong>Fail %</strong></td>
                <td><?= $failPercentage ?>%</td>
            </tr>
            <tr>
                <td><strong>A+</strong></td>
                <td><?= $gradeCount['A+'] ?></td>
                <td><strong>A</strong></td>
                <td><?= $gradeCount['A'] ?></td>
                <td><strong>A-</strong></td>
                <td><?= $gradeCount['A-'] ?></td>
            </tr>
            <tr>
                <td><strong>B</strong></td>
                <td><?= $gradeCount['B'] ?></td>
                <td><strong>C</strong></td>
                <td><?= $gradeCount['C'] ?></td>
                <td><strong>D</strong></td>
                <td><?= $gradeCount['D'] ?></td>
            </tr>
        </table>

        <!-- Signatures -->
        <table class="signature-table">
            <tr>
                <td>________________________<br>Class Teacher</td>
                <td>________________________<br>Head Teacher</td>
            </tr>
        </table>

        <div class="footer-note">
            Printed on: <?= date('d M Y') ?>
        </div>

    </div>

    <?php
    } // end function
    ?>

    <!-- ---------------------- Render Sheets ---------------------- -->

    <?php if (in_array($class, [9, 10])): ?>

    <?php renderTopSheet($generalRankings ?? [], $class, 'General'); ?>

    <div style="page-break-after: always;"></div>

    <?php renderTopSheet($vocationalRankings ?? [], $class, 'Vocational'); ?>

    <?php else: ?>

    <?php renderTopSheet($rankings ?? [], $class); ?>

    <?php endif; ?>

    <script>
    window.print();
    </script>

</body>

</html>