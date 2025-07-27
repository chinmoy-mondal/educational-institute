<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mb-4">Demo Tabulation Sheet</h1>

  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h5 class="mb-0">Class: Nine | Exam: Final | Year: 2025</h5>
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
            <?php
              $students = [
                ['id' => 1, 'roll' => '3', 'student_name' => 'Anika'],
                ['id' => 2, 'roll' => '7', 'student_name' => 'Rafi'],
              ];

              $results = [
                1 => [ // Anika
                  'math' => ['written' => 20, 'mcq' => 5, 'practical' => 5, 'total' => 30],
                  'english' => ['written' => 25, 'mcq' => 10, 'practical' => 0, 'total' => 35],
                ],
                2 => [ // Rafi
                  'math' => ['written' => 18, 'mcq' => 6, 'practical' => 6, 'total' => 30],
                  'english' => ['written' => 22, 'mcq' => 8, 'practical' => 0, 'total' => 30],
                ]
              ];

              foreach ($students as $s):
                $math    = $results[$s['id']]['math'];
                $english = $results[$s['id']]['english'];
                $total = $math['total'] + $english['total'];
            ?>
            <tr class="text-center">
              <td><strong><?= $s['roll'] ?></strong></td>
              <td class="text-start"><?= $s['student_name'] ?></td>

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

              <!-- Final total -->
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
