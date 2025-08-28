<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admit Cards</title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 2mm 12mm;
            }

            body {
                margin: 0;
            }
        }

        body {
            font-family: 'Kalpurush', 'Noto Sans Bengali', sans-serif;
            background-color: #fff;
        }

        .page {
            width: 210mm;
            height: 297mm;
            /* A4 */
            padding: 12mm 12mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 6mm;
            /* space between 2 cards */
            page-break-after: always;
        }

        .admit-card {
            border: 1px solid #000;
            padding: 2px 12px;
            height: 50%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 8px;
        }

        .info {
            font-size: 13px;
            margin: 8px 0;
            line-height: 1.5;
        }

        .routine-table {
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px;
        }

        .routine-table th,
        .routine-table td {
            padding: 1px 6px;
            font-size: 12px;
            text-align: center;
            border: 1px solid #000;
        }

        .footer-note {
            font-size: 11px;
            margin-top: 6px;
            text-align: center;
        }

        .sign {
            display: flex;
            justify-content: center;
            gap: 60px;
            height: 75px;
            margin-top: auto;
        }

        .sign .block1 {
            text-align: left;
            width: 50%;
        }
        .sign .block2 {
            text-align: right;
            width: 50%;
        }

        .sign .block span {
            display: inline-block;
            border-top: 1px solid #000;
            padding-top: 2px;
        }

        .sign img {
            width: 90px;
            margin-bottom: 4px;
            height: 37px;
        }
    </style>
</head>

<body>

    <?php if (!empty($data)): ?>
        <?php for ($i = 0; $i < count($data); $i += 2): ?>
            <div class="page">
                <?php for ($j = $i; $j < $i + 2 && $j < count($data); $j++): ?>
                    <?php $studentData = $data[$j]; ?>
                    <?php $student = $studentData['student']; ?>
                    <?php $subjects = $studentData['subjects']; ?>
                    <?php $routines = $studentData['routines']; ?>

                    <div class="admit-card">
                        <!-- Header -->
                        <table style="width:100%; text-align:center; margin-bottom: 5px;">
                            <tr>
                                <td style="width:80px;">
                                    <img src="<?= base_url('public/assets/img/logo.jpg') ?>" style="width:70px; height:70px;" alt="Logo">
                                </td>
                                <td>
                                    <div style="font-size:16px; font-weight:bold; line-height:1.5;">
                                        Mulgram Secondary School<br>
                                        Keshabpur, Jashore<br>
                                        <strong>ADMIT CARD</strong><br>
                                        <?= esc($student['exam'] ?? 'Exam') ?> - <?= esc($student['year'] ?? date('Y')) ?>
                                    </div>
                                </td>
                                <td style="width:80px;">
                                    <img src="<?= base_url(esc($student['student_pic'])) ?>" width="65" height="75" alt="Student Photo">
                                </td>
                            </tr>
                        </table>

                        <!-- Info -->
                        <div class="info">
                            <strong>Name:</strong> <?= esc($student['student_name']) ?> &nbsp;
                            <strong>Roll:</strong> <?= esc($student['roll']) ?> &nbsp;
                            <strong>Class:</strong> <?= esc($student['class']) ?> &nbsp;
                            <strong>Section:</strong> <?= esc($student['section'] ?? 'N/A') ?><br>
                            <strong>Father's Name:</strong> <?= esc($student['father_name']) ?> &nbsp;
                            <strong>Mother's Name:</strong> <?= esc($student['mother_name']) ?>
                        </div>

                        <!-- Routine -->
                        <table class="routine-table">
                            <tr>
                                <th>ক্রমিক</th>
                                <th>তারিখ</th>
                                <th>সময়</th>
                                <th>দিন</th>
                                <th>বিষয়</th>
                            </tr>
                            <?php if (!empty($routines)): $count = 1; ?>
                                <?php foreach ($routines as $routine): ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($routine['start_date'])) ?></td>
                                        <td><?= date('h:i A', strtotime($routine['start_time'])) ?> - <?= date('h:i A', strtotime($routine['end_time'])) ?></td>
                                        <td><?= bangla_day(date('l', strtotime($routine['start_date']))) ?></td>
                                        <td>
                                            <?php
                                            $subjectName = '';
                                            foreach ($subjects as $sub) {
                                                if ($sub['id'] == $routine['subject']) {
                                                    $subjectName = $sub['subject'];
                                                    break;
                                                }
                                            }
                                            echo esc($subjectName);
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No routine available</td>
                                </tr>
                            <?php endif; ?>
                        </table>

                        <!-- Footer Note -->
                        <div class="footer-note">
                            পরীক্ষার দিন নির্ধারিত সময়ের ৩০ মিনিট পূর্বে কেন্দ্রে উপস্থিত থাকতে হবে।
                        </div>

                        <!-- Signatures -->
                        <div class="sign">
                            <div class="block1">
                                <br><br>
                                <span>Class Teacher</span>
                            </div>
                            <div class="block2">
                                <img src="<?= base_url('public/assets/img/sign.png') ?>" alt="Signature">
                                <br>
                                <span>Head Teacher</span>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
    <?php else: ?>
        <p>No student data found.</p>
    <?php endif; ?>

    <script>
        window.onload = () => window.print();
    </script>
</body>

</html>