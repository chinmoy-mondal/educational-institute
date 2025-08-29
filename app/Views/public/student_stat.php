<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12 text-center mb-4">
            <h2 class="fw-bold">📊 Student Statistics</h2>
            <p class="text-muted">Overview of all registered students</p>
        </div>
    </div>

    <div class="row text-center mb-4">
        <!-- Total Students -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-primary"><?= $totalStudents ?></h4>
                    <p class="mb-0">Total Students</p>
                </div>
            </div>
        </div>

        <!-- Total Boys -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-info"><?= $totalBoys ?></h4>
                    <p class="mb-0">Boys</p>
                </div>
            </div>
        </div>

        <!-- Total Girls -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-danger"><?= $totalGirls ?></h4>
                    <p class="mb-0">Girls</p>
                </div>
            </div>
        </div>

        <!-- Sections -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-success"><?= $totalSections ?></h4>
                    <p class="mb-0">Sections</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Students by Class -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">Students by Class</div>
                <div class="card-body">
                    <canvas id="classChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Students by Section -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">Students by Section</div>
                <div class="card-body">
                    <canvas id="sectionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gender Distribution -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">Gender Distribution</div>
                <div class="card-body">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Religion Distribution -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">Religion Distribution</div>
                <div class="card-body">
                    <canvas id="religionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data from PHP
    const classData = <?= json_encode($studentsByClass) ?>;
    const sectionData = <?= json_encode($studentsBySection) ?>;
    const genderData = <?= json_encode([
                            ['gender' => 'Male', 'count' => $totalBoys],
                            ['gender' => 'Female', 'count' => $totalGirls]
                        ]) ?>;
    const religionData = <?= json_encode($studentsByReligion ?? []) ?>;

    // Class Chart
    new Chart(document.getElementById('classChart'), {
        type: 'bar',
        data: {
            labels: classData.map(c => 'Class ' + c.class),
            datasets: [{
                label: 'Students',
                data: classData.map(c => c.count),
                backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true
        }
    });

    // Section Chart
    new Chart(document.getElementById('sectionChart'), {
        type: 'bar',
        data: {
            labels: sectionData.map(s => 'Section ' + s.section),
            datasets: [{
                label: 'Students',
                data: sectionData.map(s => s.count),
                backgroundColor: '#28a745'
            }]
        },
        options: {
            responsive: true
        }
    });

    // Gender Chart
    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: genderData.map(g => g.gender),
            datasets: [{
                data: genderData.map(g => g.count),
                backgroundColor: ['#17a2b8', '#dc3545']
            }]
        },
        options: {
            responsive: true
        }
    });

    // Religion Chart
    new Chart(document.getElementById('religionChart'), {
        type: 'pie',
        data: {
            labels: religionData.map(r => r.religion),
            datasets: [{
                data: religionData.map(r => r.count),
                backgroundColor: ['#ffc107', '#6f42c1', '#fd7e14', '#20c997']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<?= $this->endSection() ?>