<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="fixed-header">
    <?= $this->include('layouts/base-structure/header') ?>
</div>

<div class="page-title text-center py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-primary">📊 Attendance Statistics</h2>
        <p class="text-muted mb-0">Class-wise and gender-based attendance summary</p>
    </div>
</div>

<section class="py-5">
    <div class="container">

        <!-- Filter -->
        <form method="get" class="row g-2 mb-4 justify-content-center">
            <div class="col-md-3">
                <select name="class" class="form-select">
                    <option value="">All Classes</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?= esc($c['class']) ?>" <?= ($selectedClass == $c['class']) ? 'selected' : '' ?>>
                            <?= esc($c['class']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="month" name="month" class="form-control" value="<?= esc($selectedMonth) ?>">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Show</button>
            </div>
        </form>

        <?php if (!empty($stats)): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-secondary text-center mb-3">Daily Present — Boys vs Girls</h5>
                    <canvas id="genderChart" height="100"></canvas>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-secondary text-center mb-3">Total Present vs Absent (All Students)</h5>
                    <canvas id="totalChart" height="100"></canvas>
                </div>
            </div>

            <div class="table-responsive mt-5">
                <table class="table table-bordered text-center align-middle small">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Total Students</th>
                            <th>Boys Present</th>
                            <th>Girls Present</th>
                            <th>Total Present</th>
                            <th>Total Absent</th>
                            <th>% Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats as $date => $row): ?>
                            <?php
                            $percent = $row['total_students'] > 0
                                ? round(($row['total_present'] / $row['total_students']) * 100, 1)
                                : 0;
                            ?>
                            <tr>
                                <td><?= esc(date('d M, Y', strtotime($date))) ?></td>
                                <td><?= esc($row['total_students']) ?></td>
                                <td class="text-success fw-bold"><?= esc($row['boys_present']) ?></td>
                                <td class="text-danger fw-bold"><?= esc($row['girls_present']) ?></td>
                                <td><?= esc($row['total_present']) ?></td>
                                <td><?= esc($row['absent_total']) ?></td>
                                <td><?= esc($percent) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No attendance data found for this selection.</p>
        <?php endif; ?>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const days = <?= json_encode(array_map(fn($d) => date('d', strtotime($d)), $days)) ?>;
    const boysPresent = <?= json_encode(array_column($stats, 'boys_present')) ?>;
    const girlsPresent = <?= json_encode(array_column($stats, 'girls_present')) ?>;
    const totalPresent = <?= json_encode(array_column($stats, 'total_present')) ?>;
    const totalAbsent = <?= json_encode(array_column($stats, 'absent_total')) ?>;

    // Chart 1: Boys vs Girls Present
    new Chart(document.getElementById('genderChart'), {
        type: 'line',
        data: {
            labels: days,
            datasets: [{
                    label: 'Boys Present',
                    data: boysPresent,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0,0,255,0.2)',
                    fill: true
                },
                {
                    label: 'Girls Present',
                    data: girlsPresent,
                    borderColor: 'deeppink',
                    backgroundColor: 'rgba(255,105,180,0.2)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart 2: Total Present vs Absent
    new Chart(document.getElementById('totalChart'), {
        type: 'bar',
        data: {
            labels: days,
            datasets: [{
                    label: 'Present',
                    data: totalPresent,
                    backgroundColor: 'rgba(40,167,69,0.7)'
                },
                {
                    label: 'Absent',
                    data: totalAbsent,
                    backgroundColor: 'rgba(220,53,69,0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?= $this->include('layouts/base-structure/footer') ?>
<?= $this->endSection() ?>