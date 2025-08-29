<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>
<div class="container content"> <!-- offset for fixed navbar -->
    <div class="container py-5">
        <h2 class="text-center mb-4">📊 Student Statistics by Class</h2>

        <?php foreach ($classSummary as $class => $data): ?>
            <div class="card mb-5 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        Class <?= esc($class) ?>
                        (Male: <?= esc($data['gender']['Male'] ?? 0) ?>,
                        Female: <?= esc($data['gender']['Female'] ?? 0) ?>,
                        Total: <?= esc(array_sum($data['gender'])) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <canvas id="genderChart<?= $class ?>" style="width:100%; max-height:300px;"></canvas>
                        </div>
                        <div class="col-md-4 mb-3">
                            <canvas id="religionChart<?= $class ?>" style="width:100%; max-height:300px;"></canvas>
                        </div>
                        <div class="col-md-4 mb-3">
                            <canvas id="bloodChart<?= $class ?>" style="width:100%; max-height:300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const stats = <?= json_encode($classSummary) ?>;

    Object.keys(stats).forEach(cls => {
        // Gender Chart
        new Chart(document.getElementById("genderChart" + cls), {
            type: 'bar',
            data: {
                labels: Object.keys(stats[cls].gender),
                datasets: [{
                    label: 'Students',
                    data: Object.values(stats[cls].gender),
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Gender'
                    }
                }
            }
        });

        // Religion Chart
        new Chart(document.getElementById("religionChart" + cls), {
            type: 'pie',
            data: {
                labels: Object.keys(stats[cls].religion),
                datasets: [{
                    data: Object.values(stats[cls].religion),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Religion'
                    }
                }
            }
        });

        // Blood Group Chart
        new Chart(document.getElementById("bloodChart" + cls), {
            type: 'doughnut',
            data: {
                labels: Object.keys(stats[cls].blood).map(bg => bg || 'Unknown'),
                datasets: [{
                    data: Object.values(stats[cls].blood),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#E74C3C', '#2ECC71']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Blood Group'
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>