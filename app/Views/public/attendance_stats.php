<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="fixed-header">
    <?= $this->include('layouts/base-structure/header') ?>
</div>

<div class="page-title text-center py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-primary">📊 Attendance Statistics</h2>
        <p class="text-muted mb-0">Class & Month-wise presence trends by gender</p>
    </div>
</div>

<section class="py-5">
    <div class="container">

        <!-- Filter Form -->
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
            <!-- Charts -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-center text-secondary mb-3">Daily Present Count (Boys vs Girls)</h5>
                    <canvas id="genderChart" height="100"></canvas>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold text-center text-secondary mb-3">Total Attendance (Present vs Absent)</h5>
                    <canvas id="totalChart" height="100"></canvas>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">No attendance data found for the selected class/month.</div>
        <?php endif; ?>

    </div>
</section>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const daysFull = <?= json_encode($days) ?>; // full dates YYYY-MM-DD
    const boysPresent = <?= json_encode(array_column($stats, 'boys_present')) ?>;
    const girlsPresent = <?= json_encode(array_column($stats, 'girls_present')) ?>;
    const totalPresent = <?= json_encode(array_column($stats, 'total_present')) ?>;
    const totalAbsent = <?= json_encode(array_column($stats, 'total_absent')) ?>;

    // Calculate total students for each day
    const totalStudents = boysPresent.map((b, i) => b + girlsPresent[i] + totalAbsent[i]);

    // Boys vs Girls line chart
    new Chart(document.getElementById('genderChart'), {
        type: 'line',
        data: {
            labels: daysFull.map(d => new Date(d).getDate()), // day number on X-axis
            datasets: [{
                    label: 'Boys Present',
                    data: boysPresent,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.2)',
                    fill: true
                },
                {
                    label: 'Girls Present',
                    data: girlsPresent,
                    borderColor: '#e83e8c',
                    backgroundColor: 'rgba(232,62,140,0.2)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const idx = context[0].dataIndex;
                            const date = daysFull[idx];
                            const dayName = new Date(date).toLocaleDateString('en-US', {
                                weekday: 'short'
                            });
                            return `${date} (${dayName})`;
                        },
                        label: function(context) {
                            const idx = context.dataIndex;
                            const b = boysPresent[idx];
                            const g = girlsPresent[idx];
                            const t = totalPresent[idx];
                            const total = totalStudents[idx];
                            const bPerc = total ? ((b / total) * 100).toFixed(1) : 0;
                            const gPerc = total ? ((g / total) * 100).toFixed(1) : 0;
                            const tPerc = total ? ((t / total) * 100).toFixed(1) : 0;
                            return [
                                `Total Present: ${t} (${tPerc}%)`,
                                `Boys: ${b} (${bPerc}%)`,
                                `Girls: ${g} (${gPerc}%)`
                            ];
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Total Present vs Absent bar chart
    new Chart(document.getElementById('totalChart'), {
        type: 'bar',
        data: {
            labels: daysFull.map(d => new Date(d).getDate()),
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
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const idx = context.dataIndex;
                            const present = totalPresent[idx];
                            const absent = totalAbsent[idx];
                            const total = totalStudents[idx];
                            const presentPerc = total ? ((present / total) * 100).toFixed(1) : 0;
                            const absentPerc = total ? ((absent / total) * 100).toFixed(1) : 0;
                            return [
                                `Present: ${present} (${presentPerc}%)`,
                                `Absent: ${absent} (${absentPerc}%)`,
                                `Total Students: ${total}`
                            ];
                        }
                    }
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