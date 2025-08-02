<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
  th, td {
    vertical-align: middle !important;
    text-align: center !important;
  }
  .text-danger {
    color: red;
    font-weight: bold;
  }

  /* PRINT STYLES */
  @media print {
    @page {
      size: legal landscape;
      margin: 1cm;
    }

    body {
      font-size: 10px;
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }

    .btn, .no-print, nav, script {
      display: none !important;
    }

    .card, .container-fluid {
      box-shadow: none !important;
      margin: 0;
      padding: 0;
    }

    .card-header {
      background: #333 !important;
      color: white !important;
    }

    .text-danger {
      color: red !important;
      font-weight: bold;
    }

    .text-success {
      color: green !important;
    }

    table {
      page-break-inside: avoid;
    }
  }
</style>

<?php
// Your isSubjectFailed function stays here unchanged...
// Your subjectList generation stays here unchanged...
?>

<div class="container-fluid" id="printArea">
  <h1 class="mb-4">Tabulation Sheet</h1>
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h5 class="mb-0">Class: <?= esc($class) ?> | Exam: <?= esc($exam) ?> | Year: <?= esc($year) ?></h5>
    </div>
    <div class="card-body">
      <?php if (empty($finalData)): ?>
        <div class="alert alert-warning">No result data found.</div>
      <?php else: ?>
        <div class="no-print mb-3">
          <button class="btn btn-success" onclick="downloadCSV()">Download CSV</button>
          <button class="btn btn-primary" onclick="printDiv()">Print / Save as PDF</button>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover" id="tabulationTable">
            <thead class="table-primary text-center align-middle">
              <tr>
                <th rowspan="2">Roll</th>
                <th rowspan="2">Name</th>
                <?php foreach ($subjectList as $subject): ?>
                  <th colspan="4"><?= esc($subject) ?></th>
                <?php endforeach; ?>
                <th rowspan="2">Total</th>
              </tr>
              <tr>
                <?php foreach ($subjectList as $subject): ?>
                  <th>W</th><th>MCQ</th><th>Prac</th><th>Total</th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($finalData as $student): ?>
                <?php
                  $subjectMap = [];
                  foreach ($student['results'] as $res) {
                    $subjectMap[$res['subject']] = $res;
                  }

                  $studentTotal = 0;
                  $failCount = 0;
                  $banglaFailCounted = false;
                  $englishFailCounted = false;
                ?>
                <tr class="text-center">
                  <td><strong><?= esc($student['roll']) ?></strong></td>
                  <td class="text-start"><?= esc($student['name']) ?></td>

                  <?php foreach ($subjectList as $subject): ?>
                    <?php if (!isset($subjectMap[$subject])): ?>
                      <td></td><td></td><td></td><td></td>
                    <?php else: ?>
                      <?php
                        $res = $subjectMap[$subject];
                        $written = $res['written'] ?? 0;
                        $mcq = $res['mcq'] ?? 0;
                        $practical = $res['practical'] ?? 0;
                        $total = $res['total'] ?? 0;

                        $studentTotal += is_numeric($total) ? $total : 0;

                        $isFail = isSubjectFailed($class, $subject, $subjectMap, $student['group'] ?? 'general');

                        if (in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper']) && !$banglaFailCounted && $isFail) {
                          $failCount++;
                          $banglaFailCounted = true;
                        } elseif (in_array($subject, ['English 1st Paper', 'English 2nd Paper']) && !$englishFailCounted && $isFail) {
                          $failCount++;
                          $englishFailCounted = true;
                        } elseif (!in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper', 'English 1st Paper', 'English 2nd Paper']) && $isFail) {
                          $failCount++;
                        }

                        $writtenClass = $mcqClass = $practicalClass = '';

                        if ($subject === 'ICT' && in_array($class, ['6','7','8']) && ($written + $mcq + $practical) < 17) {
                          $writtenClass = $mcqClass = $practicalClass = 'text-danger fw-bold';
                        } elseif ($subject === 'ICT' && in_array($class, ['9','10']) && ($written + $mcq) < 8 && $practical < 9) {
                          $writtenClass = $mcqClass = $practicalClass = 'text-danger fw-bold';
                        } elseif (in_array($subject, ['Physics', 'Chemistry', 'Higher Math', 'Biology'])) {
                          if ($written < 17) $writtenClass = 'text-danger fw-bold';
                          if ($mcq < 8) $mcqClass = 'text-danger fw-bold';
                          if ($practical < 8) $practicalClass = 'text-danger fw-bold';
                        } elseif (!in_array($subject, ['Bangla 1st Paper', 'Bangla 2nd Paper', 'English 1st Paper', 'English 2nd Paper'])) {
                          if ($written < 23) $writtenClass = 'text-danger fw-bold';
                          if ($mcq < 10) $mcqClass = 'text-danger fw-bold';
                        }
                      ?>
                      <td class="<?= $writtenClass ?>"><?= $written ?></td>
                      <td class="<?= $mcqClass ?>"><?= $mcq ?></td>
                      <td class="<?= $practicalClass ?>"><?= $practical ?></td>
                      <td class="<?= $isFail ? 'text-danger fw-bold' : '' ?>"><?= $total ?></td>
                    <?php endif; ?>
                  <?php endforeach; ?>

                  <td class="fw-bold <?= $failCount > 0 ? 'text-danger' : 'text-success' ?>">
                    <?= $studentTotal ?><?= $failCount > 0 ? ' <br>F-' . $failCount : '' ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function downloadCSV() {
  const table = document.querySelector("table");
  if (!table) return;

  const firstHeaderRow = table.querySelector("thead tr:first-child");
  const headers = [];
  headers.push("Roll", "Name");

  for (let i = 2; i < firstHeaderRow.cells.length - 1; i++) {
    const subject = firstHeaderRow.cells[i].innerText.trim();
    headers.push(subject + " W");
    headers.push(subject + " MCQ");
    headers.push(subject + " Prac");
    headers.push(subject + " Total");
  }
  headers.push("Total");

  let csv = headers.map(h => `"${h.replace(/"/g, '""')}"`).join(",") + "\n";

  const tbodyRows = table.querySelectorAll("tbody tr");
  tbodyRows.forEach(row => {
    const cells = row.querySelectorAll("td");
    const rowData = [];
    rowData.push(cells[0].innerText.trim());
    rowData.push(cells[1].innerText.trim());

    const subjectCount = (cells.length - 3) / 4;
    for (let i = 0; i < subjectCount; i++) {
      const baseIndex = 2 + i * 4;
      for (let j = 0; j < 4; j++) {
        rowData.push(cells[baseIndex + j].innerText.trim());
      }
    }

    rowData.push(cells[cells.length - 1].innerText.trim());

    csv += rowData.map(d => `"${d.replace(/"/g, '""')}"`).join(",") + "\n";
  });

  const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = "tabulation_sheet.csv";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

function printDiv() {
  window.print();
}
</script>

<?= $this->endSection() ?>

