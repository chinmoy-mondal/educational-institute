<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admit Cards</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
    }

    .page {
      width: 210mm;
      height: 297mm;
      padding: 10mm;
      box-sizing: border-box;
      page-break-after: always;
    }

    .admit-card {
      width: 100%;
      height: 48%;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      padding: 8px;
      box-sizing: border-box;
    }

    .admit-header {
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 6px;
    }

    .student-info-table {
      width: 100%;
      font-size: 12px;
      border-collapse: collapse;
      margin-bottom: 8px;
    }

    .student-info-table th,
    .student-info-table td {
      padding: 4px 6px;
      border: 1px solid #aaa;
      text-align: left;
    }

    .routine-table-horizontal {
      width: 100%;
      border-collapse: collapse;
      font-size: 11px;
      margin-top: 5px;
    }

    .routine-table-horizontal th,
    .routine-table-horizontal td {
      border: 1px solid #999;
      padding: 3px 4px;
      text-align: center;
    }

    @media print {
      body {
        margin: 0;
      }

      .page {
        page-break-after: always;
      }
    }
  </style>
</head>
<body>

<?php for ($i = 0; $i < count($students); $i += 2): ?>
  <div class="page">
    <?php for ($j = $i; $j < $i + 2 && $j < count($students); $j++): ?>
      <div class="admit-card">
        <div class="admit-header">Exam Admit Card</div>

        <table class="student-info-table">
          <tr>
            <th>Name</th>
            <td><?= esc($students[$j]['student_name']) ?></td>
            <th>Roll No.</th>
            <td><?= esc($students[$j]['roll']) ?></td>
          </tr>
          <tr>
            <th>Father's Name</th>
            <td><?= esc($students[$j]['father_name']) ?></td>
            <th>Mother's Name</th>
            <td><?= esc($students[$j]['mother_name']) ?></td>
          </tr>
          <tr>
            <th>Class</th>
            <td><?= esc($students[$j]['class']) ?></td>
            <th>Section</th>
            <td><?= esc($students[$j]['section']) ?></td>
          </tr>
        </table>

        <table class="routine-table-horizontal">
          <thead>
            <tr>
              <th>Time</th>
              <th>Sunday</th>
              <th>Monday</th>
              <th>Tuesday</th>
              <th>Wednesday</th>
              <th>Thursday</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($routineSlots as $slot): ?>
              <tr>
                <td><?= esc($slot['time']) ?></td>
                <td><?= esc($routineData[$j]['Sunday'][$slot['time']] ?? '') ?></td>
                <td><?= esc($routineData[$j]['Monday'][$slot['time']] ?? '') ?></td>
                <td><?= esc($routineData[$j]['Tuesday'][$slot['time']] ?? '') ?></td>
                <td><?= esc($routineData[$j]['Wednesday'][$slot['time']] ?? '') ?></td>
                <td><?= esc($routineData[$j]['Thursday'][$slot['time']] ?? '') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endfor; ?>
  </div>
<?php endfor; ?>

</body>
</html>
