<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admit Cards</title>
  <style>
    @media print {
      @page {
        size: A4 portrait;
        margin: 0;
      }
    }

    body {
      margin: 0;
      font-family: 'Kalpurush', 'Noto Sans Bengali', sans-serif;
    }

    .page {
      width: 210mm;
      height: 297mm;
      padding: 15mm;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      page-break-after: always;
    }

    .admit-card {
      border: 1px solid #000;
      padding: 10px;
      height: 48%;
      box-sizing: border-box;
    }

    .title {
      text-align: center;
      font-size: 16px;
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 8px;
    }

    .info {
      font-size: 12px;
      margin-bottom: 10px;
    }

    .routine-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 11px;
    }

    .routine-table th, .routine-table td {
      border: 1px solid #000;
      text-align: center;
      padding: 4px;
    }

    .footer-note {
      font-size: 10px;
      margin-top: 6px;
    }

    .sign {
      display: flex;
      justify-content: space-between;
      margin-top: 6px;
      font-size: 12px;
    }
  </style>
</head>
<body>

<?php for ($i = 0; $i < count($students); $i += 2): ?>
  <div class="page">
    <?php for ($j = $i; $j < $i + 2 && $j < count($students); $j++): ?>
      <div class="admit-card">
        <div class="title">
          Mulgram Secondary School<br>
          Keshabpur, Jashore<br>
          ADMIT CARD<br>
          Annual Summitive Assessment-2024
        </div>

        <div class="info">
          Name: <?= $students[$j]['name'] ?><br>
          Roll No.: <?= $students[$j]['roll'] ?><br>
          Father's Name: <?= $students[$j]['father_name'] ?><br>
          Mother's Name: <?= $students[$j]['mother_name'] ?><br>
          Class: <?= $students[$j]['class'] ?> | Section: <?= $students[$j]['section'] ?? 'N/A' ?>
        </div>

        <table class="routine-table">
          <tr>
            <th>ক্রমিক</th><th>তারিখ</th><th>দিন</th><th>বিষয়</th>
          </tr>
          <?php $count = 1; ?>
          <?php foreach ($events as $event): ?>
            <tr>
              <td><?= $count++ ?></td>
              <td><?= date('d/m/Y', strtotime($event['start_date'])) ?></td>
              <td><?= date('l', strtotime($event['start_date'])) ?></td>
              <td><?= $event['title'] ?></td>
            </tr>
          <?php endforeach; ?>
        </table>

        <div class="footer-note">
          পরীক্ষার দিন নির্ধারিত সময়ের ৩০ মিনিট পূর্বে কেন্দ্রে উপস্থিত থাকতে হবে।
        </div>

        <div class="sign">
          <span>Class Teacher</span>
          <span>Head Sir</span>
        </div>
      </div>
    <?php endfor; ?>
  </div>
<?php endfor; ?>

<script>
  window.onload = () => window.print();
</script>

</body>
</html>
