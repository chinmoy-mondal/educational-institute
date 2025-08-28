<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admit Card</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    .admit-card {
      width: 700px;
      margin: 0 auto;
      border: 2px solid #000;
      padding: 20px;
      box-sizing: border-box;
      position: relative;
    }
    .school-header {
      text-align: center;
      margin-bottom: 10px;
    }
    .school-header h2 {
      margin: 0;
    }
    .details {
      margin-bottom: 15px;
    }
    .details table {
      width: 100%;
      border-collapse: collapse;
    }
    .details td {
      padding: 5px;
      font-size: 14px;
    }
    .exam-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    .exam-table th, .exam-table td {
      border: 1px solid #000;
      padding: 6px;
      text-align: center;
      font-size: 13px;
    }
    .signatures {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
      padding: 0 20px;
    }
    .sign-box {
      text-align: center;
      width: 45%;
      border-top: 1px solid #000;
      padding-top: 5px;
      font-size: 13px;
    }
  </style>
</head>
<body>
  <div class="admit-card">
    <!-- School Header -->
    <div class="school-header">
      <h2><?= esc($schoolName ?? 'Your School Name') ?></h2>
      <p><?= esc($examName ?? 'Examination Name') ?> - <?= esc($year ?? date('Y')) ?></p>
    </div>

    <!-- Student Details -->
    <div class="details">
      <table>
        <tr>
          <td><strong>Name:</strong> <?= esc($student['name'] ?? '') ?></td>
          <td><strong>Class:</strong> <?= esc($student['class'] ?? '') ?></td>
        </tr>
        <tr>
          <td><strong>Roll:</strong> <?= esc($student['roll'] ?? '') ?></td>
          <td><strong>Group:</strong> <?= esc($student['group'] ?? '') ?></td>
        </tr>
      </table>
    </div>

    <!-- Exam Routine -->
    <table class="exam-table">
      <thead>
        <tr>
          <th>Subject</th>
          <th>Date</th>
          <th>Start</th>
          <th>End</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($routine)): ?>
          <?php foreach ($routine as $exam): ?>
            <tr>
              <td><?= esc($exam['subject'] ?? '') ?></td>
              <td><?= esc($exam['date'] ?? '') ?></td>
              <td><?= esc($exam['start'] ?? '') ?></td>
              <td><?= esc($exam['end'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4">No routine available</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Signatures (Inside Border) -->
    <div class="signatures">
      <div class="sign-box">Class Teacher</div>
      <div class="sign-box">Head Teacher</div>
    </div>
  </div>
</body>
</html>