<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admit Cards</title>
<style>
@media print {
    @page { size: A4; margin: 1mm 15mm; }
    body { margin: 0; }
}
body { font-family: 'Kalpurush', 'Noto Sans Bengali', sans-serif, sans-serif; background-color: #fff; }
.page {
    width: 210mm;
    height: 297mm; /* A4 height */
    padding: 5mm 15mm 5mm 15mm;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 4mm; /* spacing between two cards */
    page-break-after: always;
}

.admit-card {
    border: 1px solid #000;
    padding: 6px;
    height: 48%; /* Two cards fit in one page */
    box-sizing: border-box;
}
.title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin-bottom: 8px; }
.info { font-size: 13px; margin-bottom: 8px; line-height: 1.5; }
.routine-table { font-size: 12px; margin-bottom: 10px; border-collapse: collapse; width: 100%; }
.routine-table th, .routine-table td { padding: 2px 6px; font-size: 12px; text-align: center; border: 1px solid #000; }
.footer-note { font-size: 11px; margin-top: 8px; }
.sign { display: flex; justify-content: space-between; margin-top: 10px; font-size: 12px; }
</style>
</head>
<body>

<?php if(!empty($data)): ?>
    <?php for ($i = 0; $i < count($data); $i += 2): ?>
        <div class="page">
            <?php for ($j = $i; $j < $i + 2 && $j < count($data); $j++): ?>
                <?php $studentData = $data[$j]; ?>
                <?php $student = $studentData['student']; ?>
                <?php $subjects = $studentData['subjects']; ?>
                <?php $routines = $studentData['routines']; ?>

                <div class="admit-card">
                    <table style="width:100%; text-align:center;">
                        <tr>
                            <td style="width:80px;"><img src="<?= base_url('public/assets/img/logo.jpg') ?>" style="width:80px; height:80px;" alt="Logo"></td>
                            <td>
                                <div style="font-size:16px; font-weight:bold; line-height:1.5;">
                                    Mulgram Secondary School<br>
                                    Keshabpur, Jashore<br>
                                    <strong>ADMIT CARD</strong><br>
                                    Half yearly exam - <?= esc($student['year'] ?? date('Y')) ?>
                                </div>
                            </td>
                            <td style="width:80px;"><img src="<?= base_url(esc($student['student_pic'])) ?>" width="60" height="70" alt="Student Photo"></td>
                        </tr>
                    </table>

                    <div class="info">
                        <strong>Name:</strong> <?= esc($student['student_name']) ?>
                        <strong>Roll:</strong> <?= esc($student['roll']) ?>
                        <strong>Class:</strong> <?= esc($student['class']) ?>
                        <strong>Section:</strong> <?= esc($student['section'] ?? 'N/A') ?><br>
                        <strong>Father's Name:</strong> <?= esc($student['father_name']) ?>
                        <strong>Mother's Name:</strong> <?= esc($student['mother_name']) ?>
                    </div>

                    <table class="routine-table">
                        <tr>
                            <th>ক্রমিক</th>
                            <th>তারিখ</th>
                            <th>সময়</th>
                            <th>দিন</th>
                            <th>বিষয়</th>
                        </tr>
                        <?php if(!empty($routines)): $count=1; ?>
                            <?php foreach($routines as $routine): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($routine['start_date'])) ?></td>
                                    <td><?= date('h:i A', strtotime($routine['start_time'])) ?> - <?= date('h:i A', strtotime($routine['end_time'])) ?></td>
                                    <td><?= bangla_day(date('l', strtotime($routine['start_date']))) ?></td>
                                    <td>
                                        <?php
                                        $subjectName = '';
                                        foreach($subjects as $sub) {
                                            if($sub['id'] == $routine['subject']) {
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
                            <tr><td colspan="5">No routine available</td></tr>
                        <?php endif; ?>
                    </table>

                    <div class="footer-note">
                        পরীক্ষার দিন নির্ধারিত সময়ের ৩০ মিনিট পূর্বে কেন্দ্রে উপস্থিত থাকতে হবে।
                    </div>

                    <div class="sign">
                        <span><br><br><br>Class Teacher</span>
                        <span style="text-align:center;">
                            <img src="<?= base_url('public/assets/img/sign.png') ?>" alt="Signature" style="width:100px; display:block; margin:0 auto;">
                            Head Teacher
                        </span>
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