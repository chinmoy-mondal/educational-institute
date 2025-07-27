<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mb-4">Demo Tabulation Sheet</h1>

  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h5 class="mb-0">Class: <?= esc($class) ?> | Exam: <?= esc($exam) ?> | Year: <?= esc($year) ?></h5>
    </div>
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-primary text-center align-middle">
            <tr>
              <th rowspan="2">Roll</th>
              <th rowspan="2">Name</th>
              <th colspan="4">Math</th>
              <th colspan="4">English</th>
              <th rowspan="2">Total</th>
            </tr>
            <tr>
              <th>W</th><th>MCQ</th><th>Prac</th><th>Total</th>
              <th>W</th><th>MCQ</th><th>Prac</th><th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($finalData as $student): 
              // Build subject lookup by name for easier access
              $subjectMap = [];
              foreach ($student['results'] as $res) {
                $subjectMap[strtolower($res['subject'])] = $res;
              }

              // Try to get math and english results
              $math    = $subjectMap['math'] ?? ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0];
              $english = $subjectMap['english'] ?? ['written' => 0, 'mcq' => 0, 'practical' => 0, 'total' => 0];

              $total = $math['total'] + $english['total'];
            ?>
            <tr class="text-center">
              <td><strong><?= esc($student['roll']) ?></strong></td>
              <td class="text-start"><?= esc($student['name']) ?></td>

              <!-- Math -->
              <td><?= $math['written'] ?></td>
              <td><?= $math['mcq'] ?></td>
              <td><?= $math['practical'] ?></td>
              <td class="fw-bold"><?= $math['total'] ?></td>

              <!-- English -->
              <td><?= $english['written'] ?></td>
              <td><?= $english['mcq'] ?></td>
              <td><?= $english['practical'] ?></td>
              <td class="fw-bold"><?= $english['total'] ?></td>

              <!-- Total -->
              <td class="fw-bold text-success"><?= $total ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
