<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <h2 class="text-center mb-4">📊 Student Statistics</h2>

    <canvas id="genderChart" height="100"></canvas>
    <canvas id="religionChart" height="100" class="mt-5"></canvas>
    <canvas id="bloodChart" height="100" class="mt-5"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const stats = <?= json_encode($classSummary) ?>;

// Prepare Gender Data
let classes = Object.keys(stats);
let boys = classes.map(cls => stats[cls].gender['Male'] ?? 0);
let girls = classes.map(cls => stats[cls].gender['Female'] ?? 0);

new Chart(document.getElementById('genderChart'), {
    type: 'bar',
    data: {
        labels: classes.map(c => "Class " + c),
        datasets: [
            { label: 'Boys', data: boys, backgroundColor: 'blue' },
            { label: 'Girls', data: girls, backgroundColor: 'pink' }
        ]
    }
});

// Religion Data
let religionCounts = {};
classes.forEach(cls => {
    Object.entries(stats[cls].religion).forEach(([rel, val]) => {
        religionCounts[rel] = (religionCounts[rel] || 0) + val;
    });
});

new Chart(document.getElementById('religionChart'), {
    type: 'pie',
    data: {
        labels: Object.keys(religionCounts),
        datasets: [{
            data: Object.values(religionCounts),
            backgroundColor: ['#4BC0C0','#FF6384','#FFCE56','#9966FF']
        }]
    }
});

// Blood Group Data
let bloodCounts = {};
classes.forEach(cls => {
    Object.entries(stats[cls].blood).forEach(([bg, val]) => {
        bloodCounts[bg || 'Unknown'] = (bloodCounts[bg || 'Unknown'] || 0) + val;
    });
});

new Chart(document.getElementById('bloodChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(bloodCounts),
        datasets: [{
            data: Object.values(bloodCounts),
            backgroundColor: ['#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#E74C3C','#2ECC71']
        }]
    }
});
</script>

<?= $this->endSection() ?>