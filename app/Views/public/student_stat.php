<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container py-5">

    <!-- Section Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Student Statistics</h2>
        <p class="text-muted fs-5">Overview of Gender, Religion, Groups, Classes and Total Students</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Gender Chart -->
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body text-center">
                    <h5 class="mb-3">Gender Distribution</h5>
                    <canvas id="genderChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Religion Chart -->
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body text-center">
                    <h5 class="mb-3">Religion Distribution</h5>
                    <canvas id="religionChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body text-center">
                    <h5 class="mb-3">Total Students</h5>
                    <div class="display-4 fw-bold text-primary">
                        <?= $totalStudents ?? 0 ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Group + Class Charts -->
    <div class="row g-4 justify-content-center mt-4">
        <!-- Group Distribution -->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body text-center">
                    <h5 class="mb-3">Group Distribution</h5>
                    <canvas id="groupChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Class Distribution -->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body text-center">
                    <h5 class="mb-3">Class-wise Distribution</h5>
                    <canvas id="classChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gender Chart
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [<?= $maleCount ?? 0 ?>, <?= $femaleCount ?? 0 ?>],
                backgroundColor: ['#0d6efd', '#e83e8c']
            }]
        }
    });

    // Religion Chart
    new Chart(document.getElementById('religionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Hindu', 'Muslim'],
            datasets: [{
                data: [<?= $hinduCount ?? 0 ?>, <?= $muslimCount ?? 0 ?>],
                backgroundColor: ['#ffc107', '#198754']
            }]
        }
    });

    // Group Chart
    new Chart(document.getElementById('groupChart'), {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_keys($groupCounts)) ?>,
            datasets: [{
                data: <?= json_encode(array_values($groupCounts)) ?>,
                backgroundColor: ['#0dcaf0', '#fd7e14', '#6f42c1', '#20c997']
            }]
        }
    });

    // Class Chart
    new Chart(document.getElementById('classChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($classCounts)) ?>,
            datasets: [{
                label: 'Students',
                data: <?= json_encode(array_values($classCounts)) ?>,
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }},
            scales: { y: { beginAtZero: true }}
        }
    });
</script>

<?= $this->include("layouts/base-structure/footer"); ?>
<?= $this->endSection(); ?>