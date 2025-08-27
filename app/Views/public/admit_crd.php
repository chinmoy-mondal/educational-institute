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
    body { font-family: 'Kalpurush', 'Noto Sans Bengali', sans-serif; background-color: #fff; }
    .page { width: 210mm; height: 335mm; padding: 15mm; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; page-break-after: always; }
    .admit-card { border: 1px solid #000; padding: 6px; height: 48%; margin-bottom: 4px; box-sizing: border-box; }
    .title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin-bottom: 8px; }
    .info { font-size: 13px; margin-bottom: 8px; line-height: 1.5; }
    .routine-table { font-size: 12px; margin-bottom: 10px; border-collapse: collapse; width: 100%; }
    .routine-table th, .routine-table td { padding: 2px 6px; font-size: 12px; line-height: 1.2; text-align: center; border: 1px solid #000; }
    .footer-note { font-size: 11px; margin-top: 8px; }
    .sign { display: flex; justify-content: space-between; margin-top: 10px; font-size: 12px; }
  </style>
</head>
<body>

<?php foreach ($data as $d): ?>
  <div class="page">
    <div class="admit-card">
      <table style="width: 100%; text-align: center;">
        <tr>
          <td style="width: 80px;"><img src="<?= base_url('public/assets/img/logo.jpg') ?>" width="80" height="80"></td>
          <td>
            <div style="font-size:16px; font-weight:bold; line-height:1.5;">
              Mulgram Secondary School<br>
              Keshabpur, Jashore<br>
              <strong>ADMIT CARD</strong><br>
              Half yearly exam - 2025
            </div>
          </td>
          <td style="width: 80px;">
            <img src="<?= base_url($d['student']['student_pic']) ?>" width="60" height="70">
          </td>
        </tr>
      </table>

      <div class="info">
        <div>
          <strong>Name:</strong> <?= esc($d['student']['student_name']) ?>  
          <strong>Roll:</strong> <?= esc($d['student']['roll']) ?>  
          <strong>Class:</strong> <?= esc($d['student']['class']) ?>  
          <strong>Section:</strong> <?= esc($d['student']['section'] ?? 'N/A') ?>
        </div>
        <div>
          <strong>Father's Name:</strong> <?= esc($d['student']['father_name']) ?>
          <strong>Mother's Name:</strong> <?= esc($d['student']['mother_name']) ?>
        </div>
      </div>

      <table class="routine-table">
        <tr>
          <th>ক্রমিক</th>
          <th>তারিখ</th>
          <th>সময়</th>
          <th>দিন</th>
          <th>বিষয়</th>
        </tr>

        <?php 
        $count = 1;
        foreach ($d['routines'] as $r):
            $eventDate = date('d/m/Y', strtotime($r['date'] ?? $r['start']));
            $eventDay = date('l', strtotime($r['date'] ?? $r['start']));
        ?>
        <tr>
          <td><?= $count++ ?></td>
          <td><?= $eventDate ?></td>
          <td><?= esc($r['time'] ?? '10:00 AM - 1:00 PM') ?></td>
          <td><?= $eventDay ?></td>
          <td><?= esc($r['subject'] ?? $r['description']) ?></td>
        </tr>
        <?php endforeach; ?>

      </table>

      <div class="footer-note">
        পরীক্ষার দিন নির্ধারিত সময়ের ৩০ মিনিট পূর্বে কেন্দ্রে উপস্থিত থাকতে হবে।
      </div>

      <div class="sign">
        <span><br><br><br>Class Teacher</span>
        <span style="text-align:center;">
          <img src="<?= base_url('public/assets/img/sign.png') ?>" width="100" style="display:block; margin:0 auto;">
          Head Teacher
        </span>
      </div>

    </div>
  </div>
<?php endforeach; ?>

<script>window.onload = () => window.print();</script>
</body>
</html>