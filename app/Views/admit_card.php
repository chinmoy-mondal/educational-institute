<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admit Cards</title>
  <style>
    @media print {
      @page {
        size: A4;
        margin: 5mm 15mm;
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
      padding: 15mm;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      page-break-after: always;
    }

    .admit-card {
      border: 1px solid #000;
      padding: 12px;
      height: 48%;
      margin-bottom: 8px;
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
      font-size: 13px;
      margin-bottom: 8px;
      line-height: 1.5;
    }

    .routine-table {
       font-size: 12px;
       margin-bottom: 10px;
    }
    
    .routine-table th, td {
	  padding: 2px 6px;
	  font-size: 12px;
	  line-height: 1.2;
    }

    .footer-note {
      font-size: 11px;
      margin-top: 8px;
    }

    .sign {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
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
          Annual Summative Assessment-2024
        </div>

	<div class="info-two-line">
	  <div>
	    <strong>Name:</strong> <?= esc($students[$j]['student_name']) ?> |
	    <strong>Roll:</strong> <?= esc($students[$j]['roll']) ?> |
	    <strong>Father:</strong> <?= esc($students[$j]['father_name']) ?>
	  </div>
	  <div>
	    <strong>Mother:</strong> <?= esc($students[$j]['mother_name']) ?> |
	    <strong>Class:</strong> <?= esc($students[$j]['class']) ?> |
	    <strong>Section:</strong> <?= esc($students[$j]['section'] ?? 'N/A') ?>
	  </div>
	</div>

        <table class="routine-table">
          <tr>
            <th>ক্রমিক</th>
            <th>তারিখ</th>
            <th>দিন</th>
            <th>বিষয়</th>
          </tr>
          <?php
            $count = 1;
            foreach ($events as $event):
              if ($event['title'] == $students[$j]['class']): // Filter by class
          ?>
            <tr>
              <td><?= $count++ ?></td>
              <td><?= date('d/m/Y', strtotime($event['start_date'])) ?></td>
              <td><?= bangla_day(date('l', strtotime($event['start_date']))) ?></td>
              <td><?= esc($event['description']) ?></td>
            </tr>
          <?php endif; endforeach; ?>
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
